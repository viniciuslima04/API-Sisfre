@extends('relatorio.base')

@section('titulo','Relatório de Reposições')

@php $strSemestre = $semestre->ano.'.'.$semestre->etapa.' ('.$semestre->tipo.')'; @endphp

@section('semestre', $strSemestre)

@section('conteudo')
<div class="row container-fluid">
    <div class="col-xs-12 col-xs-offset-0">
        <div class="row col-xs-12 col-xs-offset-0">

            @if($reposicoes->where('situacaoRep','=','CONF')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Reposições Confirmadas </strong>
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
                        @foreach($reposicoes->where('situacaoRep','=','CONF') as $reposicao )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $reposicao->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->qtd}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($reposicoes->where('situacaoRep','=','NEG')->count() > 0)
                <div class="row col-xs-8 col-xs-offset-2">
                    <div class="titulo"> 
                        <h4 class="text-center text-uppercase">
                            <strong> Reposições Negadas</strong>
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
                        @foreach($reposicoes->where('situacaoRep','=','NEG') as $reposicao )
                            <tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->turma}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $reposicao->dia))) }}</td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->professor}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->disciplina}} </td>
                                <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->qtd}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection