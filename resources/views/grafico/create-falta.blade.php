@extends('grafico.base')

@section('titulo','Gráfico de Faltas')

@php $strSemestre = $semestre->ano.'.'.$semestre->etapa.' ('.$semestre->tipo.')'; @endphp

@section('semestre', $strSemestre)

@section('conteudo')

	<div id="print-grafico" data-download="{{$download}}">
	    <div id="faltas_gerais" class="col-md-12 col-xs-offset-0" style="height: 30em"></div>
	    <div id="12" class="col-md-12 col-xs-offset-0" style="height: 50em"></div>
        @foreach ($faltasIndividuais as $professor => $faltas)
	    	<div id="{{$professor}}" class="col-md-12 col-xs-offset-0" style="max-height: 60em;height: 50em"></div>
        @endforeach

	</div>

	@include('scripts.grafico-geral')	

@endsection