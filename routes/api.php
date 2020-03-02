<?php

use Illuminate\Http\Request;

//Route::apiResource('teste','api\ApiController');


//TRAZER ROTA PRA CÁ

Route::get('relatorio/professor', 'RelatorioController@professores')->name('relatorio.professor');




//Route::get('Api', 'RelatorioController@professores')->name('relatorio.professor');

//CONSULTAS QUE VAMOS PRECISAR 
// $aulas = DB::select('select distinct(d.id), d.nome as disciplina,
//c.nome as curso, t.descricao as turma, p.id as professor_id, u.username as professor_nome  
//FROM aula a
//INNER JOIN disciplina d ON d.id = a.disciplina_id
//INNER JOIN turma t ON t.id = a.turma_id
//INNER JOIN semestre s ON s.id = t.semestre_id
//INNER JOIN curso c ON c.id = t.curso_id
//INNER JOIN disciplina_professor dp ON dp.disciplina_id = d.id
//INNER JOIN professor p ON p.id = dp.professor_id
//INNER JOIN usuario u ON u.id = p.usuario_id 
//WHERE t.id = dp.turma_id and a.dia = :dia and 
//a.posicao BETWEEN :min and :max and s.status = 1 ORDER BY u.username, d.nome ASC', 
//['dia' => $dia, 'min' => $between[0], 'max' => $between[1]]);