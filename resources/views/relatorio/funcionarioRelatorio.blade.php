@extends('relatorio.base')

@section('titulo','Relatório de Professores')

@section('conteudo')
<div class="row container-fluid">
    <div class="col-xs-12 col-xs-offset-0">
        <div class="row col-xs-12 col-xs-offset-0">

            <div class="row col-xs-8 col-xs-offset-2">
                <div class="titulo"> 
                    <h4 class="text-center text-uppercase" style="font-size: 1.2em">
                        <b>RELATÓRIO DE PROFESSORES</b>
                    </h4>
                </div>
            </div>


            <table class="table table-striped bunitu" style="font-size: 0.85em">
                <thead class="btn-primary">
                    <tr class="row text-uppercase">
                        <th class="text-center" style="vertical-align: middle;">Professor</th>
                        <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                        <th class="text-center" style="vertical-align: middle;">Curso</th>
                        <th class="text-center" style="vertical-align: middle;">Turma</th>
                        <th class="text-center" style="vertical-align: middle;">Presente</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($aulas as $aula)
                        <tr class="row text-uppercase">

                            @if($turno == 'M')

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->professor_nome}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->disciplina}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->curso}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->turma}} </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>

                            @elseif($turno == 'T')

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->professor_nome}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->disciplina}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->curso}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->turma}} </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>

                            @elseif($turno == 'N')

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->professor_nome}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->disciplina}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->curso}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{$aula->turma}} </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>
                            
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection