@extends('layout.base')

@section('titulo','Cadastrar Falta')

@section('scripts')
    @include('scripts.falta')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Falta</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{route('falta.store')}}">
               
                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-12 {{ $errors->has('curso') ? ' has-error' : '' }}">
                        <label for="curso" class="col-md-3 control-label">Curso:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control text-uppercase select" name="curso" id="curso">
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                                @foreach ($cursos as $curso)
                                    @if(old('curso') == $curso->id)
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
                    <div class="form-group col-md-12 {{ $errors->has('turma') ? ' has-error' : '' }} turma">
                        <label for="turma" class="col-md-3 control-label">Turma:</label>
                        <div class="col-md-8">
                            <select class="form-control text-uppercase" data-dependent="professor" data-live-search="true" id="turma1" name="turma" disabled>
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                            </select>

                            <span class="help-block">
                                 <strong id="erro-turma"></strong>
                            </span>

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
                            <select class="form-control text-uppercase" data-dependent="disciplina" data-live-search="true" id="professor" name="professor" disabled>
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
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
                            <select class="form-control text-uppercase" data-dependent="" data-live-search="true" id="disciplina1" name="disciplina" disabled>
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
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
                        <label for="observacao" class="col-md-3 control-label">Justificativa:</label>
                        <div class="col-md-8">
                            <textarea style="resize: none" class="form-control text-uppercase" rows="3" data-dependent="" data-live-search="true" id="observacao" name="observacao">

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
                            <input id="dia" type="date" class="form-control" name="dia" value="{{ old('dia') or $hoje->format('Y-m-d')}}">

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
    @include('layout.modal')
@endsection