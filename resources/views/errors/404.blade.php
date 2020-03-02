@extends('layout.base')
@section('titulo','Erro 404')
@section('conteudo')
    <div class="alert alert-info btn-lg col-md-9 col-md-offset-1 text-center">
     <b class="text-uppercase"> erro 404: </b>. Nenhuma página foi encontrada
    </div>
    <div class="row col-md-2 col-md-offset-0">
        <div class="form-group">
            <a href="{{route('home')}}" class="btn btn-block btn-lg btn-primary">
                <span class="glyphicon glyphicon-arrow-left text-center"></span> Voltar
            </a>   
        </div>
    </div>
@endsection