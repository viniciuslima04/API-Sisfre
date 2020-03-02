<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Usuario;
use App\Http\Models\Curso;
use App\Http\Models\Semestre;
use App\Http\Models\Disciplina;
use App\Http\Models\SabadoLetivo;
use App\Http\Models\Feriado;

class AdministradorMiddleware
{
    private $user;
    private $disciplina;
    private $curso;
    private $semestre;
    private $sabado;
    private $feriado;

    public function __construct(Usuario $user, Disciplina $disciplina, Curso $curso, Semestre $semestre, Feriado $feriado, SabadoLetivo $sabado){
        $this->user         = $user;
        $this->disciplina   = $disciplina;
        $this->semestre     = $semestre;
        $this->curso        = $curso;
        $this->sabado       = $sabado;
        $this->feriado      = $feriado;
    }

    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $url = explode('/', request()->url());


        if(request()->usuario){

            //Permite que outros usuários que não o Administrador possam editar seus próprios perfis
            if(auth()->user()->acesso != 4){
                if(auth()->user()->id == request()->usuario) {
                    return $next($request); 
                }
                else{
                    return redirect()->route('usuario.edit', auth()->user()->id);      
                }

            }
            // Caso seja Administrador verificar se o usuário com aquele ID existe no banco
            //Senão encontrar redireciona para a home ou para a página 404 NOT FOUND
            $usuario = $this->user->find(request()->usuario);
        
            if(empty($usuario)){
                return redirect()->route('home');
            }

        }
        
        /* 
            Garante que somente os administradores terão acesso as rotas de semestre, curso e disciplina
        */
        if(isset($url[4]) && isset($url[5])){

            if($url[4] == "cadastrar" || $url[4] == "controle" || $url[4] == "editar"|| $url[4] == "deletar"){

                if($url[5] == "usuario" || $url[5] == "semestre" || $url[5] == "disciplina" || $url[5] == "curso" || $url[5] == "feriado" || $url[5] == "sabado" ){
                    if(auth()->user()->acesso != 4){
                        return redirect()->route('home');
                    }

                }
            }
            
            // Verificar se o id de um curso , disciplina, semestre, sábado letivo ou feriado é válido
            if(request()->semestre){
                $semestre = $this->semestre->find(request()->semestre);
            
                if(empty($semestre)){
                    return redirect()->route('home');
                }  
            }

            if(request()->curso){
                $curso = $this->curso->find(request()->curso);
            
                if(empty($curso)){
                    return redirect()->route('home');
                }  
            }    

            if(request()->discipli){
                $disciplina = $this->disciplina->find(request()->discipli);
                if(empty($disciplina)){
                    return redirect()->route('home');
                }  
            }

            if(request()->sabado){
                $sabado = $this->sabado->find(request()->sabado);
                if(empty($sabado)){
                    return redirect()->route('home');
                }  
            }

            if(request()->feriado){
                $feriado = $this->feriado->find(request()->feriado);
                if(empty($feriado)){
                    return redirect()->route('home');
                }  
            }

        }   

        return $next($request); 

    }
}