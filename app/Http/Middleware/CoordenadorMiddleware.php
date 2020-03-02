<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Models\Turma;
use App\Http\Models\Reposicao;
use App\Http\Models\Anteposicao;
use App\Http\Models\Falta;

class CoordenadorMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $acesso = auth()->user()->acesso;

        if($acesso != 3 ){
            return redirect()->route('home');
        }

        /*
            VERIFICA SE EXISTE ALGUM ID DE TURMA,ANTEPOSIÇÃO, REPOSIÇÃO OU FALTA SENDO PASSADO PELA URL
        */
        if(request()->turma){
            $turma = Turma::find(request()->turma);
            
            // CASO O ID PASSADO SEJA INVÁLIDO RETORNA PARA A PÁGINA HOME
            if(empty($turma)){
                return redirect()->route('home');
            }  
        }

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