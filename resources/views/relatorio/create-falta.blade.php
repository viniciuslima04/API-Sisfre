@extends('relatorio.base')

@section('titulo','Relatório de Faltas')

@php $strSemestre = $semestre->ano.'.'.$semestre->etapa.' ('.$semestre->tipo.')'; @endphp

@section('semestre', $strSemestre)

@section('conteudo')
<div class="row container-fluid">
    <div class="col-xs-12 col-xs-offset-0">
        <div class="row col-xs-12 col-xs-offset-0">

            @if($faltas->where('situacao','=','CONF')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Faltas Confirmadas </strong>
                        </h4>
                    </div>
                </div>

                <table class="table table-striped bunitu">
                    <thead class="btn-primary">
                        <tr class="row text-uppercase">
                            <th class="text-center" style="vertical-align: middle;">Turma</th>
                            <th class="text-center" style="vertical-align: middle;">Dia</th>
                            <th class="text-center" style="vertical-align: middle;">Professor</th>
                            <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                            <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                            <th class="text-center" style="vertical-align: middle;">Repôr até</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($faltas->where('situacao','=','CONF') as $falta )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->validade))) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($faltas->where('situacao','=','PAGA_T')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Faltas Totalmente Pagas</strong>
                        </h4>
                    </div>
                </div>

                <table class="table table-striped bunitu">
                    <thead class="btn-primary">
                        <tr class="row text-uppercase">
                            <th class="text-center" style="vertical-align: middle;">Turma</th>
                            <th class="text-center" style="vertical-align: middle;">Dia</th>
                            <th class="text-center" style="vertical-align: middle;">Professor</th>
                            <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                            <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                            <th class="text-center" style="vertical-align: middle;">Repôr até</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($faltas->where('situacao','=','PAGA_T') as $falta )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->validade))) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($faltas->where('situacao','=','PAGA_P')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Faltas Parcialmente Pagas</strong>
                        </h4>
                    </div>
                </div>

                <table class="table table-striped bunitu">
                    <thead class="btn-primary">
                        <tr class="row text-uppercase">
                            <th class="text-center" style="vertical-align: middle;">Turma</th>
                            <th class="text-center" style="vertical-align: middle;">Dia</th>
                            <th class="text-center" style="vertical-align: middle;">Professor</th>
                            <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                            <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                            <th class="text-center" style="vertical-align: middle;">Repôr até</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($faltas->where('situacao','=','PAGA_P') as $falta )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->validade))) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($faltas->where('situacao','=','VENC')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Faltas Não Pagas</strong>
                        </h4>
                    </div>
                </div>

                <table class="table table-striped bunitu">
                    <thead class="btn-primary">
                        <tr class="row text-uppercase">
                            <th class="text-center" style="vertical-align: middle;">Turma</th>
                            <th class="text-center" style="vertical-align: middle;">Dia</th>
                            <th class="text-center" style="vertical-align: middle;">Professor</th>
                            <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                            <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($faltas->where('situacao','=','VENC') as $falta )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>

@endsection