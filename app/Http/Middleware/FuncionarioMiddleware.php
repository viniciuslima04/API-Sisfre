<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Models\Falta;

class FuncionarioMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $url = explode('/', request()->url());
        $acesso = auth()->user()->acesso;

        if($acesso != 1 ){
            if($acesso == 3 || $acesso == 2 ){
                if(isset($url[5]) && isset($url[6])){
                    if($url[5] == 'pegar' && $url[6] == 'disciplina'){
                        return $next($request);
                    }
                }
            }
            return redirect()->route('home');
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

        return $next($request);
    }
}