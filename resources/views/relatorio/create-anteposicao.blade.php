@extends('relatorio.base')

@section('titulo','Relatório de Anteposições')

@php $strSemestre = $semestre->ano.'.'.$semestre->etapa.' ('.$semestre->tipo.')'; @endphp

@section('semestre', $strSemestre)

@section('conteudo')
<div class="row container-fluid">
    <div class="col-xs-12 col-xs-offset-0">
        <div class="row col-xs-12 col-xs-offset-0">

            @if($anteposicoes->where('situacaoAnt','=','CONF')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Anteposições Confirmadas </strong>
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
                            <th class="text-center" style="vertical-align: middle;">Qtd Reposta</th>
                            <th class="text-center" style="vertical-align: middle;">Qtd Gasta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($anteposicoes->where('situacaoAnt','=','CONF') as $anteposicao )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $anteposicao->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->gasta }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($anteposicoes->where('situacaoAnt','=','NEG')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Anteposições Negadas </strong>
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
                            <th class="text-center" style="vertical-align: middle;">Qtd Reposta</th>
                            <th class="text-center" style="vertical-align: middle;">Qtd Gasta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($anteposicoes->where('situacaoAnt','=','NEG') as $anteposicao )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $anteposicao->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->gasta }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if($anteposicoes->where('situacaoAnt','=','VENC')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Anteposições Sem Aulas de Crédito</strong>
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
                            <th class="text-center" style="vertical-align: middle;">Qtd Reposta</th>
                            <th class="text-center" style="vertical-align: middle;">Qtd Gasta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($anteposicoes->where('situacaoAnt','=','VENC') as $anteposicao )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $anteposicao->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->qtd}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->gasta }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>

@endsection