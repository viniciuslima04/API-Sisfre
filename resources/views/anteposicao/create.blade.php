@extends('layout.base')

@section('titulo','Registrar Anteposição')

@section('scripts')
    @include('scripts.anteposicao')
@endsection

@section('conteudo')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Registrar Anteposição</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{route('anteposicao.store')}}" enctype="multipart/form-data">
                
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
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
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
                                <select class="form-control text-uppercase" data-dependent="" data-live-search="true" id="disciplina3" name="disciplina" disabled>
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
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
                            <a href="{{route('home')}}" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="situacao" value="ESP">   
                </form>
            </div>
        </div>
    </div>
@endsection