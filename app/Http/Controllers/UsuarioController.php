<?php

namespace App\Http\Controllers;
use App\Http\Models\Usuario;
use App\Http\Models\Professor;
use App\Http\Models\Funcionario;
use App\Http\Models\Administrador;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    private $user;

    public function __construct(Usuario $user){
        $this->middleware('admin');
        $this->user = $user;
    }

    public function home (){
        
        if( auth()->user()->acesso == 1){
            return redirect()->action('FaltaController@create');
        }
        else if(auth()->user()->acesso == 2){
            return redirect()->action('AulaController@show_professor');
        }
        else if(auth()->user()->acesso == 3){
            return redirect()->action('FaltaController@show_coordenador');
        }
        else{
            return view('usuario.administrador');
        }
    }

    public function create(){
        return view('usuario.create');
    }
    
    public function store(UsuarioRequest $request){


        $usuario = Usuario::create([
            'username'      => mb_strtoupper($request->input('username'),'UTF-8'),
            'email'         => mb_strtolower($request->input('email'),'UTF-8'),
            'acesso'        => $request->input('acesso'),
            'password'      => bcrypt($request->input('password')),
            'abreviatura'   => mb_strtoupper($request->input('abreviatura'),'UTF-8')
        ]);

        if ($usuario->acesso == 1) {
            $acesso = $usuario->funcionario()
            ->create([]);
        }
        elseif ($usuario->acesso == 2) {
            $acesso = $usuario->professor()
            ->create([]);
        }
        else{
            $acesso = $usuario->administrador()
            ->create([]);
        }

        if($usuario && $acesso){

            return redirect()->route('usuario.show')
            ->withInput()
            ->with('success','O Usuário: '.$usuario->username.' foi cadastrado com sucesso!');
        }

    }

    public function show(Request $req){
        $filtro     = $req->get('filtro','');
        $tipo       = $this->tipo_user($filtro);
        $pesquisa   = $req->get('pesquisa','');
        $where      = [];
        
        if($pesquisa && $tipo != 0){
            $where[] = ['username','LIKE','%'.$pesquisa.'%'];
            $where[] = ['acesso','=',$tipo]; 
        }
        else if($tipo != 0){
            $where[] = ['acesso','=',$tipo]; 
        }
        else if($pesquisa){
            $where[] = ['username','LIKE','%'.$pesquisa.'%'];
        }

        $usuarios    = self::busca_usuarios($where);

        return view('usuario.show',compact('usuarios','pesquisa','filtro'));
    }

    public static function busca_usuarios($where){
        if(!empty($where)){
            return Usuario::where($where)->orderBy('username','ASC')->paginate(10);
        }
        return Usuario::orderBy('username','ASC')->paginate(10);
    }

    public function edit ($usuario){
        $user = $this->user->find($usuario);
        return view('usuario.edit', compact('user'));
    }

    public function update(Request $req, $usuario){

        $alteracoes = 0;
        $usuario = $this->user->find($usuario);
        $messages = [
            'username.required'                 =>'O nome do usuário é obrigatório',
            'username.string'                   =>'O nome do usuário tem que ser uma palavra',
            'username.min'                      =>'O nome do usuário deve possuir ao menos 8 letras',
            'email.required'                    =>'O E-mail é obrigatório',
            'email.string'                      =>'O E-mail tem que ser texto',
            'email.email'                       =>'O E-mail deve ser um E-mail válido',
            'email.unique'                      =>'O E-mail já está em uso',
            'email.max'                         =>'O E-mail não pode ser maior que 160 letras',
            'password.required'                 =>'A senha é obrigatória',
            'password.string'                   =>'A senha tem que ser uma palavra',
            'password.min'                      =>'A senha deve possuir ao menos 6 caracteres',
            'acesso.required'                   =>'Selecione um tipo de usuário',
            'acesso.integer'                    =>'O tipo de usuário tem que ser um número',
            'acesso.min'                        =>'Selecione um tipo de usuário',
            'abreviatura.required'              =>'A abreviatura é obrigatória',
            'abreviatura.string'                =>'A abreviatura tem que ser uma palavra',
            'abreviatura.unique'                =>'A abreviatura já está em uso',
            'abreviatura.min'                   =>'A abreviatura deve possuir ao menos 2 letras',
            'password_confirmation.required'    =>'A senha de confirmação está vazia',
            'password_confirmation.same'        =>'A senha de confirmação não condiz com a senha digitada'
        ];

        $validador = Validator::make($req->all(),
            [
                'email'                     => 'required|string|email|max:160',
                'acesso'                    => 'required|integer|min:1',
                'username'                  => 'required|string|min:8',
                'abreviatura'               => 'required|string|min:2'
            ], $messages);

        if($validador->fails()){
            return redirect()->route('usuario.edit',$usuario)
                ->withErrors($validador)
                ->withInput();
        }

        if(Hash::check($req->input('password'), $usuario->password) == false  && $req->input('password') != ''){
            $validador = Validator::make($req->all(),
                [
                    'password'              => 'required|string|min:6',
                    'password_confirmation' => 'required|same:password'
                ], $messages);

            if($validador->fails()){
                return redirect()->route('usuario.edit',$usuario)
                    ->withErrors($validador)
                    ->withInput();
            }

            $usuario->password = bcrypt($req->input('password'));
            $alteracoes += 1;
        }

        if($usuario->acesso != $req->input('acesso') ){

            if($this->desassocia($usuario)){
                if($this->associa($usuario, $req->input('acesso'))){
                    $usuario->acesso = $req->input('acesso');
                    $alteracoes += 1;
                }
            }
        }

        if( $usuario->username != mb_strtoupper($req->input('username'),'UTF-8') ){
            $usuario->username  = mb_strtoupper($req->input('username'),'UTF-8');
            $alteracoes += 1;
        }

        if( $usuario->abreviatura != mb_strtoupper($req->input('abreviatura'),'UTF-8') ){
            
            $validador = Validator::make($req->all(), ['abreviatura' => 'unique:usuario'], $messages);

            if($validador->fails()){
                return redirect()->route('usuario.edit',$usuario)
                    ->withErrors($validador)
                    ->withInput();
            }

            $usuario->abreviatura  = mb_strtoupper($req->input('abreviatura'),'UTF-8');
            $alteracoes += 1;
        }

        if( $usuario->email != mb_strtolower($req->input('email'),'UTF-8') ){
            
            $validador = Validator::make($req->all(), ['email' => 'unique:usuario'], $messages);

            if($validador->fails()){
                return redirect()->route('usuario.edit',$usuario)
                    ->withErrors($validador)
                    ->withInput();
            }

            $usuario->email  = mb_strtolower($req->input('email'),'UTF-8');
            $alteracoes += 1;
        }

        if($alteracoes != 0){
            $atualizado = $usuario->save();

            if($atualizado){
                if(auth()->user()->acesso == 4){
                    return redirect()->route('usuario.show')
                    ->withInput()
                    ->with('success','O Usuário: '.$usuario->username.' foi atualizado com sucesso!');
                }
                else{
                    return redirect()->route('usuario.edit',$usuario)
                    ->withInput()
                    ->with('success','Seu perfil foi atualizado com sucesso!');   
                }
            }    
        }
        else{
            return redirect()->route('usuario.edit',$usuario)
            ->withInput()
            ->withErrors(['password'=> 'A senha informada é a senha em uso atualmente']);    
        }   
    }

    public function delete($usuario){

        $usuario    = $this->user->find($usuario);
        $nome       = $usuario->username;
        $removido   = $usuario->delete();

        if($removido){
            return redirect()->route('usuario.show')
            ->withInput()
            ->with('success','O Usuário: '.$nome.' foi removido com sucesso!');
        }
    }

    public function associa(Usuario $usuario, $tipo){

        if ($tipo == 1) {
            $acesso = $usuario->funcionario()
            ->create([]);
        }
        elseif ($tipo == 2) {
            $acesso = $usuario->professor()
            ->create([]);
        }
        else{
            $acesso = $usuario->administrador()
            ->create([]);
        }

        return $acesso; 
    }

    public function desassocia(Usuario $usuario){

        if ($usuario->acesso == 1) {
            $acesso = $usuario->funcionario();
        }
        elseif ($usuario->acesso == 2) {
            $acesso = $usuario->professor();
        }
        else{
            $acesso = $usuario->administrador();  
        }
        
        $removido = $acesso->delete();

        return $removido;
    }

    public function tipo_user($tipoString){
        $tipoInteiro = 0;
        switch ($tipoString) {
            case 'ADMINISTRADOR':
                $tipoInteiro = 4;
                break;
            case 'COORDENADOR':
                $tipoInteiro = 3;
                break;
            case 'PROFESSOR':
                $tipoInteiro = 2;
                break;
            case 'FUNCIONÁRIO':
                $tipoInteiro = 1;
                break;
        }
        return $tipoInteiro;
    }
}