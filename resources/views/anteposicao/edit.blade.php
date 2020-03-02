@extends('layout.base')

@section('titulo','Editar Anteposição')

@section('scripts')
    @include('scripts.anteposicao')
    @include('scripts.outros')
@endsection

@section('conteudo')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Editar Anteposição</div>
            <div class="panel-body">
                <form class="form-horizontal editar" role="form" method="POST" action="{{route('anteposicao.update', $anteposicao->id)}}" enctype="multipart/form-data">
                
                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-3 control-label">Professor:</label>
                            <div class="col-md-8">
                                <input id="nome" type="text" data-id="{{Auth::user()->professor->id}}" class="text-uppercase text-center form-control" name="nome" value="{{Auth::user()->professor->usuario->abreviatura}} - {{Auth::user()->professor->usuario->username }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 {{ $errors->has('turma') ? ' has-error' : '' }}">
                            <label for="turma" class="col-md-3 control-label">Turma:</label>
                            <div class="col-md-8">
                                <select class="selectpicker form-control text-uppercase select" name="turma" id="turma3">
                                    <option data-tokens="ketchup mustard" value="{{$anteposicao->turma->id}}" selected> {{$anteposicao->turma->descricao}} </option>
                                    @foreach ($turmas as $turma)
                                        @if(old('turma') == $turma->id)
                                            <option data-tokens="ketchup mustard" value="{{$turma->id}}" selected> {{$turma->descricao}} </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="{{$turma->id}}"> {{$turma->descricao}} </option>
                                    @endforeach
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
                        <div class="form-group col-md-12 {{ $errors->has('disciplina') ? ' has-error' : '' }}">
                            <label for="disciplina" class="col-md-3 control-label">Disciplina:</label>
                            <div class="col-md-8">
                                <select class="form-control text-uppercase" data-dependent="" data-live-search="true" id="disciplina3" name="disciplina">
                                    <option data-tokens="ketchup mustard" value="{{$anteposicao->disciplina->id}}" selected> {{$anteposicao->disciplina->nome}} </option>
                                    @foreach ($disciplinas as $disc)
                                        @if(old('disciplina') == $disc->id)
                                            <option data-tokens="ketchup mustard" value="{{$disc->id}}" selected> {{$disc->nome}} </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="{{$disc->id}}"> {{$disc->nome}} </option>
                                    @endforeach
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
                                <textarea style="resize: none" class="form-control text-uppercase" rows="3" data-live-search="true" id="observacao" name="observacao">@if(!empty(old('observacao'))){{old('observacao')}}
                                @else{{$anteposicao->obs }} @endif
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
                                    <option data-tokens="ketchup mustard" value="{{$anteposicao->qtd}}" selected >{{$anteposicao->qtd}}</option>
                                    @for($i = 1; $i <= 8; $i++)
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
                                <input id="dia" type="date" class="form-control" name="dia" 
                                    @if(!empty(old('dia'))) 
                                        value="{{ old('dia') }}"
                                    @else 
                                        value="{{ $anteposicao->dia }}" 
                                    @endif
                                >

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
                            <div class="input-group">
                                <div class="input-group-btn">
                                  <a id="btn-arquivo" class="btn btn-primary" title="Clique aqui para alterar o arquivo">
                                    <i id="icon" class="fa fa-file-pdf-o" style="font-size: 1.98em"></i>
                                  </a>
                                </div>
                                <input type="text" class="form-control text-center text-uppercase" id="arquivo" name="arquivo" value="O Arquivo permanece inalterado" readonly>
                            </div>
                            
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
                            <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                Salvar
                            </button>     
                    </div>

                    <div class="form-group col-md-2" ></div>

                    <div class="form-group col-md-5">
                        <a href="{{route('anteposicao.show.professor')}}" class="btn btn-block btn-lg btn-danger">
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