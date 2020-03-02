@extends('layout.base')

@section('titulo','Cadastrar Disciplina')

@section('scripts')
    @include('scripts.disciplina')
    @include('scripts.validation-disciplina')
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Disciplina</div>
        <div class="panel-body">
            <form id="cadDisc" class="form-horizontal" role="form" method="POST" action="{{route('disciplina.store')}}">

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-8 disciplina {{ $errors->has('disciplina') ? ' has-error' : '' }}">
                        <label for="disciplina" class="col-md-3 control-label">Nome:</label>
                        <div class="col-md-8">
                            <input id="disciplina" type="text" class="text-uppercase form-control"  name="disciplina" value="{{ old('disciplina') }}">

                            @if ($errors->has('disciplina'))
                                <span class="help-block">
                                     <strong >{{ $errors->first('disciplina') }}</strong>
                                </span> 
                            @endif
                            <span class="help-block">
                                 <strong id="disciplina1"></strong>
                            </span> 

                        </div>
                    </div>

                    <div class="form-group col-md-4 sigla {{ $errors->has('sigla') ? ' has-error' : '' }}">
                        <label for="sigla" class="col-md-3 control-label">Sigla:</label>
                        <div class="col-md-8">
                            <input id="sigla" type="text" class="text-uppercase form-control" maxlength="8" name="sigla" value="{{ old('sigla') }}">

                            <span class="help-block">
                                <strong id="sigla1"></strong>
                            </span>

                            @if ($errors->has('sigla'))
                                <span class="help-block">
                                     <strong >{{ $errors->first('sigla') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                </div>  
                <div class="row col-md-12 col-md-offset-0">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso 1 </strong></h3>
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-12 curso0">
                                    <label for="curso" class="col-md-3 control-label">Curso:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="curso[]" id="curso0" data-num="0" data-periodo="#periodo0" data-cursos="{{$cursos->count()}}">
                                            <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                                            @foreach ($cursos as $curso)
                                                <option data-tokens="ketchup mustard" value="{{$curso->id}}"> {{$curso->nome}} </option>
                                            @endforeach
                                        </select>


                                        <span class="help-block">
                                             <strong id="curso00"></strong>
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <div id="periodo0" class="row col-md-11 col-md-offset-1">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-8 {{ $errors->has('option') ? ' has-error' : '' }}">

                        <div class="col-md-10 col-md-offset-3">
                            <label class="checkbox-inline"><input type="checkbox" id="option" name="option" value="1" @if(old('option') == "1") checked @endif> <b>Deseja adicionar mais cursos?</b> </label>    

                        </div>

                        @if ($errors->has('option'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div id="esconder" class="form-group col-md-4 qtd" style="display: none">
                        <label for="qtd" class="col-md-6 control-label">Quantidade:</label>
                        <div class="col-md-5">
                            <input id="qtd" type="text" class="form-control" value="{{old('qtd')}}" maxlength="2" name="qtd">

                            <span class="help-block">
                                <strong id="qtd1"></strong>
                            </span>
                        </div>
                    </div>  
                </div>

                <div id='addCursos' class="row col-md-12 col-md-offset-0"></div>

                <div class="form-group col-md-12" ></div>
                <div class="form-group col-md-12" ></div>
                
                <div class="row col-md-7 col-md-offset-3">

                        <div class="form-group col-md-5">
                                <button name="cadastrarDisciplina" id="CadDisc" type="submit" class="btn btn-block btn-lg btn-success">
                                    Cadastrar
                                </button>     
                        </div>

                        <div class="form-group col-md-2" ></div>

                        <div class="form-group col-md-5">
                            <a href="{{route('home')}}" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>

                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>
</div>
@endsection