@extends('layout.base')

@section('titulo','Registrar Reposição')

@section('conteudo')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Registrar Reposição</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{route('reposicao.store',['usuario' => $usuario, 'falta' => $falta->id])}}" enctype="multipart/form-data">
                
                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-3 control-label">Professor:</label>
                            <div class="col-md-8">
                                <input id="nome" type="text" class="text-uppercase text-center form-control" name="nome" value="{{$falta->professor->usuario->abreviatura}} - {{$falta->professor->usuario->username }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('discipli') ? ' has-error' : '' }}">
                            <label for="discipli" class="col-md-3 control-label">Disciplina:</label>
                            <div class="col-md-8">
                                <input id="discipli" type="text" class="text-uppercase text-center form-control" name="discipli" value="{{$falta->disciplina->sigla}} - {{$falta->disciplina->nome}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('turma') ? ' has-error' : '' }}">
                            <label for="turma" class="col-md-3 control-label">Turma:</label>
                            <div class="col-md-8">
                                <input id="turma" type="text" class="text-uppercase text-center form-control" name="turma" value="{{$falta->turma->descricao}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('dia_falta') ? ' has-error' : '' }}">
                            <label for="dia_falta" class="col-md-3 control-label">Dia da Falta:</label>
                            <div class="col-md-8">
                                <input id="dia_falta" type="text" class="text-uppercase text-center form-control" name="dia_falta" value="{{ implode("/", array_reverse(explode("-", $falta->dia))) }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('validade_falta') ? ' has-error' : '' }}">
                            <label for="validade_falta" class="col-md-3 control-label">Repor Até:</label>
                            <div class="col-md-8">
                                <input id="validade_falta" type="text" class="text-uppercase text-center form-control" name="validade_falta" value="{{ implode("/", array_reverse(explode("-", $falta->validade))) }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0"> 
                        <div class="form-group col-md-12 {{ $errors->has('observacao') ? ' has-error' : '' }}">
                            <label for="observacao" class="col-md-3 control-label">Observação:</label>
                            <div class="col-md-8">
                                <textarea style="resize: none" class="form-control text-uppercase" rows="3" data-live-search="true" id="observacao" name="observacao">@if(!empty(old('observacao'))){{old('observacao')}}@endif
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
                                    <option data-tokens="ketchup mustard" value="0" selected >SELECIONE A QUANTIDADE</option>
                                    @for($i = 1; $i <= $qtd_repor; $i++)
                                        @if(old('qtd') == $i)
                                            <option data-tokens="ketchup mustard" value="{{$i}}" selected>{{$i}}</option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="{{$i}}" >{{$i}}</option>
                                    @endfor
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
                                <input id="dia" type="date" class="form-control" name="dia" value="{{ old('dia') }}">

                                @if ($errors->has('dia'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('dia') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                      <div class="form-group col-md-12 {{ $errors->has('arquivo') ? ' has-error' : '' }}">
                        <label for="arquivo" class="col-md-3 control-label">Anexar Folha: </label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file" id="arquivo" name="arquivo" value="{{old('arquivo')}}">
                            
                            @if ($errors->has('arquivo'))
                                <span class="help-block">
                                <strong>{{ $errors->first('arquivo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                  </div>

                    <div class="form-group col-md-12" ></div>
                    <div class="form-group col-md-12" ></div>

                    <div class="row col-md-7 col-md-offset-3">
                        <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-block btn-lg btn-success">
                                    Cadastrar
                                </button>     
                        </div>

                        <div class="form-group col-md-2" ></div>

                        <div class="form-group col-md-5">
                            <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="falta_dia" value="{{$falta->dia}}">
                    <input type="hidden" name="validade" value="{{$validade}}">
                    <input type="hidden" name="usuario" value="{{$usuario}}"> 
                    <input type="hidden" name="situacao" value="ESP">   
                </form>
            </div>
        </div>
    </div>
@endsection