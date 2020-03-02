@extends('layout.base')

@section('titulo','Editar Curso')

@section('scripts')
    @include('scripts.outros')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Atualizar Curso</div>
                    <div class="panel-body">
                        <form class="form-horizontal editar" role="form" method="POST" action="{{route('curso.update',$curso->id)}}">
                           
                           <div class="row col-md-12">
                                <div class="form-group col-md-8 {{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="ano">Nome:</label>
                                    <div class="col-md-8">
                                        <input id="nome" name="nome" maxlength="160"
                                         @if(!empty(old('nome'))) 
                                            value="{{ old('nome') }}"
                                        @else 
                                            value="{{ $curso->nome }}" 
                                        @endif
                                         class="form-control input-md text-uppercase" type="text">
                                    </div>

                                    @if ($errors->has('nome'))
                                        <span class="help-block">
                                             <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group col-md-4 {{ $errors->has('sigla') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="sigla">Sigla:</label>
                                    <div class="col-md-8">
                                        <input id="sigla" name="sigla" maxlength="10"
                                         @if(!empty(old('sigla'))) 
                                            value="{{ old('sigla') }}"
                                        @else 
                                            value="{{ $curso->sigla }}" 
                                        @endif
                                         class="form-control input-md text-uppercase" type="text">


                                        @if ($errors->has('sigla'))
                                            <span class="help-block text-center">
                                                 <strong>{{ $errors->first('sigla') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                </div>
                            </div>

                            <div class="row col-md-12">

                                <div class="form-group col-md-8 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                                    <label for="tipo" class="col-md-3 control-label">Tipo: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            @if($curso->tipo == "GRADUAÇÃO")
                                                <option data-tokens="ketchup mustard" value="1" selected> GRADUAÇÃO </option>
                                            @elseif($curso->tipo == "INTEGRADO")
                                                <option data-tokens="ketchup mustard" value="2" selected> INTEGRADO </option>
                                            @elseif($curso->tipo == "TÉCNICO")
                                                <option data-tokens="ketchup mustard" value="3" selected> TÉCNICO </option>
                                            @else
                                                <option data-tokens="ketchup mustard" value="" selected> SELECIONE..</option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="1" > GRADUAÇÃO </option>
                                            <option data-tokens="ketchup mustard" value="2" > INTEGRADO </option>
                                            <option data-tokens="ketchup mustard" value="3" > TÉCNICO </option>
                                        </select>

                                        @if ($errors->has('tipo'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('tipo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-4 {{ $errors->has('duracao') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="duracao">Duração:</label>
                                    <div class="col-md-8">
                                        <input id="duracao" name="duracao" maxlength="10"
                                         @if(!empty(old('duracao'))) 
                                            value="{{ old('duracao') }}"
                                        @else 
                                            value="{{ $curso->duracao }}" 
                                        @endif class="form-control input-md" type="text">


                                        @if ($errors->has('duracao'))
                                            <span class="help-block text-center">
                                                 <strong>{{ $errors->first('duracao') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-8 {{ $errors->has('coord') ? ' has-error' : '' }}">
                                    <label for="coord" class="col-md-3 control-label">Coordenador: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="coord" id="coord">
                                            @if(empty($curso->coordenador))
                                                <option data-tokens="ketchup mustard" value="" selected> SELECIONE... </option>
                                            @else
                                                <option data-tokens="ketchup mustard" value="{{$curso->coordenador->id}}" selected> {{ $curso->coordenador->usuario->username }} </option>
                                            @endif
                                            @foreach($professores as $prof)
                                                <option data-tokens="ketchup mustard" value="{{$prof->id}}">{{ $prof->usuario->username }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('coord'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('coord') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12" ></div>
                            <div class="form-group col-md-12" ></div>

                            <div class="row col-md-7 col-md-offset-3">
                                <div class="form-group col-md-5">
                                        <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                            Salvar
                                        </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('curso.show')}}" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>

                            <div class="row col-md-8 col-md-offset-2">
                                <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="mensagem"></strong>
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="put"> 
                        </form>
                    </div>
                </div>
            </div>
@endsection