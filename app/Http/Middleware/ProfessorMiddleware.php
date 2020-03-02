<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Reposicao;
use App\Http\Models\Anteposicao;
use App\Http\Models\Falta;

class ProfessorMiddleware
{

    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $url = explode('/', request()->url());
        $acesso = auth()->user()->acesso;
        $professor = auth()->user()->professor->id;



        // SE QUEM FOR ACESSA AS ROTAS DE PROFESSOR NÃO FOR UM, ENTRA

        if($acesso != 2){

            // SE QUEM FOR ACESSAR FOR UM COORDENADOR, QUE TAMBÉM É UM PROFESSOR, ENTRA
            if( $acesso == 3 ){
                // VERIFICA SE A URL ESTÃO PRESENTES VALORES APÓS A 5 E 6 BARRA /, SE EXISTIR ENTRA
                if(isset($url[4]) && isset($url[5])){

                    //VERIFICA SE ESTÁ NUMA AREA DE EDIÇÃO OU DE CADASTRO. SE FOR ENTRA
                    switch ($url[4]) {
                        case 'cadastrar':
                            // VERIFICA SE É UMA EDIÇÃO/CADASTRO DE UMA REPOSIÇÃO. SE FOR ENTRA
                            if($url[5] == 'reposicao'){
                                if( isset($url[6]) ){

                                    $valor = $url[6];

                                    if(request()->falta){
                                        $falta = Falta::find(request()->falta);
                                        // CASO O ID PASSADO SEJA INVÁLIDO PARA O USUÁRIO RETORNA PARA A PÁGINA HOME
                                        if(empty($falta) ){
                                            return redirect()->route('home');
                                        }

                                    }

                                    if($valor == 'professor' && $falta->professor_id != $professor){
                                        return redirect()->route('home');
                                    }
                                }
                            }
                            break;
                        
                        case 'editar':
                            // VERIFICA SE É UMA EDIÇÃO/CADASTRO DE UMA REPOSIÇÃO. SE FOR ENTRA
                            if($url[5] == 'reposicao'){

                                if( isset($url[6]) ){

                                    $valor = $url[6];

                                    if(request()->reposicao){
                                        $reposicao = Reposicao::find(request()->reposicao);
                                        // CASO O ID PASSADO SEJA INVÁLIDO PARA O USUÁRIO RETORNA PARA A PÁGINA HOME
                                        if(empty($reposicao) ){
                                            return redirect()->route('home');
                                        }

                                    }

                                    if($valor == 'professor' && $reposicao->falta->professor_id != $professor){
                                        return redirect()->route('home');
                                    }
                                }  
                            }
                            break;
                    }
                }

                // CASO A CONDIÇÃO ACIMA FOR RESPEITADA, O COORDENADOR PODE ACESSAR TODAS AS ROTAS DE PROFESSOR RESTANTES.
                return $next($request);
            }

            //TODOS OS USUÁRIOS QUE NÃO PROFESSOR/COORDENADOR RETORNA A SUA HOME
            return redirect()->route('home'); 
        }
        
        // SE QUEM FOR ACESSA AS ROTAS DE PROFESSOR  FOR UM FAZ O PROCEDIMENTO ABAIXO
        if(isset($url[4]) && isset($url[5])){
            //VERIFICA SE ESTÁ NUMA AREA DE EDIÇÃO OU DE CADASTRO. SE FOR ENTRA
            switch ($url[4]) {
                case 'cadastrar':
          
                    // VERIFICA SE É UMA EDIÇÃO/CADASTRO DE UMA REPOSIÇÃO. SE FOR ENTRA
                    if($url[5] == 'reposicao'){
                            
                        if( isset($url[6]) ){

                            $valor = $url[6];
                              
                            if(request()->falta){
                                $falta = Falta::find(request()->falta);
                                
                                // CASO O ID PASSADO SEJA INVÁLIDO PARA O USUÁRIO RETORNA PARA A PÁGINA HOME
                                
                                if(empty($falta) ){
                                    return redirect()->route('home');
                                }

                            }
                            
                            if( ($valor == 'coordenador' || $valor == 'professor') && $falta->professor_id != $professor){
                                return redirect()->route('home');
                            }
                        }
                    }
                    break;
                
                case 'editar':
                    // VERIFICA SE É UMA EDIÇÃO/CADASTRO DE UMA REPOSIÇÃO. SE FOR ENTRA
                    if($url[5] == 'reposicao'){

                        if( isset($url[6]) ){

                            $valor = $url[6];

                            if(request()->reposicao){
                                $reposicao = Reposicao::find(request()->reposicao);
                                // CASO O ID PASSADO SEJA INVÁLIDO PARA O USUÁRIO RETORNA PARA A PÁGINA HOME
                                if(empty($reposicao) ){
                                    return redirect()->route('home');
                                }

                            }

                            if($valor == 'coordenador' || $valor == 'professor' && $reposicao->falta->professor_id != $professor){
                                return redirect()->route('home');
                            }
                        }  
                    }
                    break;
            }
        }

        /*
            VERIFICA SE EXISTE ALGUM ID DE FALTA SENDO PASSADA PELA URL
        */
        if(request()->falta){
            $falta = Falta::find(request()->falta);
        
            // CASO O ID PASSADO SEJA INVÁLIDO RETORNA PARA A PÁGINA HOME
            if(empty($falta)){
                return redirect()->route('home');
            }  
        }

        if(request()->reposicao){
            $reposicao = Reposicao::find(request()->reposicao);
        
            // CASO O ID PASSADO SEJA INVÁLIDO RETORNA PARA A PÁGINA HOME
            if(empty($reposicao)){
                return redirect()->route('home');
            }  
        }

        if(request()->anteposicao){
            $anteposicao = Anteposicao::find(request()->anteposicao);
        
            // CASO O ID PASSADO SEJA INVÁLIDO RETORNA PARA A PÁGINA HOME
            if(empty($anteposicao)){
                return redirect()->route('home');
            }  
        }

        return $next($request);

    }
}