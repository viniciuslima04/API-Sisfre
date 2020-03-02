@extends('layout.base')

@section('titulo','Montar Horário')

@section('scripts')
    @include('scripts.horario')
    @include('scripts.validation-horario')
@endsection

@section('conteudo')
<div class="col-md-12 col-md-offset-0">
    <div class="panel panel-default">
        <div class="panel-heading">Montar Horário</div>
        <div class="panel-body">
            <form class="form-horizontal" id="CadHora" role="form" method="POST" action="{{route('horario.store',$turma->id)}}">
                <div class="row col-md-12">
                    <div class="form-group col-md-10 {{ $errors->has('turma') ? ' has-error' : '' }}">
                        <label for="turma" class="col-md-4 control-label">Turma:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control select-center" name="turma" id="turma" data-status="100" readonly>
                                <option data-tokens="ketchup mustard" value="{{$turma->id}}" selected> {{$turma->descricao}} </option>
                            </select>

                            @if ($errors->has('turma'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('turma') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

                <div id="tabela" class="row col-md-12 col-md-offset-0">

                </div>
            </form>
        </div>
    </div>
</div>
@endsection