@extends('layout.base')

@section('titulo','Editar Falta')

@section('scripts')
    @include('scripts.falta')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Editar Falta</div>
        <div class="panel-body">
            <form class="form-horizontal editar" role="form" method="POST" action="{{route('falta.update',$falta->id)}}">
               
                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-12 {{ $errors->has('curso') ? ' has-error' : '' }}">
                        <label for="curso" class="col-md-3 control-label">Curso:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control text-uppercase" name="curso" id="curso">
                                <option data-tokens="ketchup mustard" value="{{$falta->turma->curso->id}}" selected> {{$falta->turma->curso->nome}} </option>
                                @foreach ($cursos as $curso)
                                    @if(old('curso') && old('curso') == $curso->id)
                                        <option data-tokens="ketchup mustard" value="{{$curso->id}}" selected> {{$curso->nome}} </option>
                                    @endif
                                    <option data-tokens="ketchup mustard" value="{{$curso->id}}"> {{$curso->nome}} </option>
                                @endforeach
                            </select>

                            @if ($errors->has('curso'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('curso') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0"> 
                    <div class="form-group col-md-12 {{ $errors->has('turma') ? ' has-error' : '' }}">
                        <label for="turma" class="col-md-3 control-label">Turma:</label>
                        <div class="col-md-8">
                            <select class="form-control text-uppercase" data-dependent="professor" data-live-search="true" id="turma1" name="turma">
                                <option data-tokens="ketchup mustard" value="{{$falta->turma->id}}" selected> {{$falta->turma->descricao}}</option>
                            </select>

                            @if ($errors->has('turma'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('turma') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0"> 
                    <div class="form-group col-md-12 {{ $errors->has('professor') ? ' has-error' : '' }}">
                        <label for="professor" class="col-md-3 control-label">Professor:</label>
                        <div class="col-md-8">
                            <select class="form-control text-uppercase" data-dependent="disciplina" data-live-search="true" id="professor" name="professor">
                                <option data-tokens="ketchup mustard" value="{{$falta->professor->id}}" selected> {{$falta->professor->usuario->username}} </option>
                            </select>

                            @if ($errors->has('professor'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('professor') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0"> 
                    <div class="form-group col-md-12 {{ $errors->has('disciplina') ? ' has-error' : '' }}">
                        <label for="disciplina" class="col-md-3 control-label">Disciplina:</label>
                        <div class="col-md-8">
                            <select class="form-control text-uppercase" data-dependent="" data-live-search="true" id="disciplina1" name="disciplina">
                                <option data-tokens="ketchup mustard" value="{{$falta->disciplina->id}}" selected> {{$falta->disciplina->nome}} </option>
                            </select>

                            @if ($errors->has('disciplina'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('disciplina') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0"> 
                    <div class="form-group col-md-12 {{ $errors->has('observacao') ? ' has-error' : '' }}">
                        <label for="observacao" class="col-md-3 control-label">Observação:</label>
                        <div class="col-md-8">
                            <textarea style="resize: none;" class="form-control text-uppercase" cols="50" rows="3" data-dependent="" data-live-search="true" id="observacao" name="observacao">@if(!empty(old('observacao'))){{old('observacao')}}
                                @else{{$falta->obs }} @endif
                            </textarea>

                            @if ($errors->has('observacao'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('observacao') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-12 {{ $errors->has('qtd') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label" for="qtd">Quantidade:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control" name="qtd" id="qtd">
                                <option data-tokens="ketchup mustard" value="{{$falta->qtd}}" selected >{{$falta->qtd}}</option>
                                @if(old('qtd'))
                                    <option data-tokens="ketchup mustard" value="{{old('qtd')}}" selected >{{old('qtd')}}</option>  
                                @endif
                                <option data-tokens="ketchup mustard" value="1" >1</option>
                                <option data-tokens="ketchup mustard" value="2" >2</option>
                            </select>

                            @if ($errors->has('qtd'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('qtd') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-12 {{ $errors->has('dia') ? ' has-error' : '' }}">
                        <label for="dia" class="col-md-3 control-label">Dia: </label>

                        <div class="col-md-8">
                            <input id="dia" type="date" class="form-control" name="dia"
                                @if(!empty(old('dia'))) 
                                    value="{{ old('dia') }}"
                                @else 
                                    value="{{ $falta->dia }}" 
                                @endif
                            ">

                            @if ($errors->has('dia'))
                                <span class="help-block">
                                <strong>{{ $errors->first('dia') }}</strong>
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
                        <a href="{{route('falta.show')}}" class="btn btn-block btn-lg btn-danger">
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
                <input type="hidden" name="situacao" value="ESP">   
            </form>
        </div>
    </div>
</div>
@endsection