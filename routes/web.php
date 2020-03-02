<?php


// Rota raiz do sistema, o middleware guest, garante que só usuários que não estão logados vejam a tela de login 
Route::get('/', function () {
    return view('usuario.login');
})->middleware('guest');

    // Rota principal do sistema, no construtor da classe UsuarioController está sendo usado o middleware de admin
    // que garante que só usuários logados e que sejam Semestrees tenham acesso, exceto editar usuário que é comum a 
    // todos, porém só e possível editar seu próprio perfil nesse caso.

Route::get('home', 'UsuarioController@home')->name('home')->middleware('auth');

Auth::routes();

    // ROTAS DO ADMINISTRADOR
Route::group(['prefix'=>'administrador'],function(){

    // ROTAS DE CADASTRO DE REGISTROS
    Route::group(['prefix'=>'cadastrar'],function(){

        Route::get('disciplina', 'DisciplinaController@create')->name('disciplina.create');
        Route::post('disciplina', 'DisciplinaController@store')->name('disciplina.store');

        Route::get('usuario', 'UsuarioController@create')->name('usuario.create');
        Route::post('usuario', 'UsuarioController@store')->name('usuario.store');

        Route::get('semestre', 'SemestreController@create')->name('semestre.create');
        Route::post('semestre', 'SemestreController@store')->name('semestre.store');

        Route::get('curso', 'CursoController@create')->name('curso.create');
        Route::post('curso', 'CursoController@store')->name('curso.store');

        Route::get('feriado', 'FeriadoController@create')->name('feriado.create');
        Route::post('feriado', 'FeriadoController@store')->name('feriado.store');

        Route::get('sabado', 'SabadoLetivoController@create')->name('sabado.create');
        Route::post('sabado', 'SabadoLetivoController@store')->name('sabado.store');
    });

    // ROTAS DE LISTAGEM DE REGISTROS
    Route::group(['prefix'=>'controle'],function(){

        Route::get('usuario', 'UsuarioController@show')->name('usuario.show');

        Route::get('semestre', 'SemestreController@show')->name('semestre.show');

        Route::get('curso', 'CursoController@show')->name('curso.show');

        Route::get('disciplina', 'DisciplinaController@show')->name('disciplina.show');

        Route::get('feriado', 'FeriadoController@show')->name('feriado.show');

        Route::get('sabado', 'SabadoLetivoController@show')->name('sabado.show');
    });

    // ROTAS DE EDIÇÃO DE REGISTROS
    Route::group(['prefix'=>'editar'],function(){

        Route::get('disciplina/{discipli}', 'DisciplinaController@edit')->name('disciplina.edit')->where('discipli','[0-9]+');
        Route::put('disciplina/{discipli}', 'DisciplinaController@update')->name('disciplina.update')->where('discipli','[0-9]+');

        Route::get('usuario/{usuario}','UsuarioController@edit')->name('usuario.edit')->where('usuario','[0-9]+');
        Route::put('usuario/{usuario}', 'UsuarioController@update')->name('usuario.update')->where('usuario','[0-9]+');

        Route::get('semestre/{semestre}', 'SemestreController@edit')->name('semestre.edit')->where('semestre','[0-9]+');
        Route::put('semestre/{semestre}', 'SemestreController@update')->name('semestre.update')->where('semestre','[0-9]+');

        Route::get('curso/{curso}', 'CursoController@edit')->name('curso.edit')->where('curso','[0-9]+');
        Route::put('curso/{curso}', 'CursoController@update')->name('curso.update')->where('curso','[0-9]+');

        Route::get('feriado/{feriado}', 'FeriadoController@edit')->name('feriado.edit')->where('feriado','[0-9]+');
        Route::put('feriado/{feriado}', 'FeriadoController@update')->name('feriado.update')->where('feriado','[0-9]+');

        Route::get('sabado/{sabado}', 'SabadoLetivoController@edit')->name('sabado.edit')->where('sabado','[0-9]+');
        Route::put('sabado/{sabado}', 'SabadoLetivoController@update')->name('sabado.update')->where('sabado','[0-9]+');
    });

    // ROTAS DE LISTAGEM DE REMOÇÃO DE REGISTROS
    Route::group(['prefix'=>'deletar'],function(){

        Route::get('disciplina/{disciplina}', 'DisciplinaController@delete')->name('disciplina.delete')->where('disciplina','[0-9]+');

        Route::get('usuario/{usuario}', 'UsuarioController@delete')->name('usuario.delete')->where('usuario','[0-9]+');

        Route::get('semestre/{semestre}', 'SemestreController@delete')->name('semestre.delete')->where('semestre','[0-9]+');

        Route::get('curso/{curso}', 'CursoController@delete')->name('curso.delete')->where('curso','[0-9]+');

        Route::get('feriado/{feriado}', 'FeriadoController@delete')->name('feriado.delete')->where('feriado','[0-9]+');

        Route::get('sabado/{sabado}', 'SabadoLetivoController@delete')->name('sabado.delete')->where('sabado','[0-9]+');
    });


    // ROTAS DE REQUISIÇÃO AJAX
    Route::group(['prefix'=>'ajax'],function(){

        Route::match(['get', 'post'],'pegar/semestre', 'AjaxController@getSemestres')->name('ajax.semestre');
        Route::match(['get', 'post'],'associar/curso', 'AjaxController@associaCurso')->name('ajax.associaCurso');
    });
});

    // ROTAS DO FUNCIONÁRIO
Route::group(['prefix'=>'funcionario'],function(){

    // ROTAS DE CADASTROS DE REGISTROS
    Route::group(['prefix'=>'cadastrar'],function(){

        Route::get('falta', 'FaltaController@create')->name('falta.create');
        Route::post('falta', 'FaltaController@store')->name('falta.store');
    });

    // ROTAS DE LISTAGEM DE REGISTROS
    Route::group(['prefix'=>'controle'],function(){

        Route::get('falta', 'FaltaController@show_funcionario')->name('falta.show.funcionario');
    });

    // ROTAS DE REQUISIÇÃO AJAX
    Route::group(['prefix'=>'ajax'],function(){

        Route::match(['get', 'post'],'pegar/turma', 'AjaxController@getTurmas')->name('ajax.turma');
        Route::match(['get', 'post'],'pegar/professor', 'AjaxController@getProfessores')->name('ajax.professor');
        Route::match(['get', 'post'],'pegar/disciplina', 'AjaxController@getDisciplinasProfessores')->name('ajax.disciplina.professor');
    });

    // ROTAS DE RELATÓRIOS
    Route::group(['prefix'=>'gerar'],function(){
        Route::get('relatorio', 'RelatorioController@indexFuncionario')->name('relatorio.index.funcionario');
        Route::get('relatorio/professor', 'RelatorioController@professores')->name('relatorio.professor');
    });
});

    // ROTAS DO COORDENADOR
Route::group(['prefix'=>'coordenador'],function(){

    // ROTAS DE CADASTRO DE REGISTROS
    Route::group(['prefix'=>'cadastrar'],function(){

        Route::get('turma', 'TurmaController@create')->name('turma.create');
        Route::post('turma', 'TurmaController@store')->name('turma.store');

        Route::get('horario/{turma}', 'AulaController@create')->name('horario.create')->where('turma','[0-9]+');
        Route::post('horario/{turma}', 'AulaController@store')->name('horario.store')->where('turma','[0-9]+');
    });

    // ROTAS DE LISTAGEM DE REGISTROS
    Route::group(['prefix'=>'controle'],function(){

        Route::get('turma', 'TurmaController@show')->name('turma.show');

        Route::get('horario/{turma}', 'AulaController@show')->name('horario.show')->where('turma','[0-9]+');

        Route::get('falta', 'FaltaController@show_coordenador')->name('falta.show.coordenador');

        Route::get('reposicao', 'ReposicaoController@show_coordenador')->name('reposicao.show.coordenador');
        
        Route::get('anteposicao', 'AnteposicaoController@show_coordenador')->name('anteposicao.show.coordenador');        
    });

    // ROTAS DE EDIÇÃO DE REGISTROS
    Route::group(['prefix'=>'editar'],function(){

        Route::get('turma/{turma}', 'TurmaController@edit')->name('turma.edit')->where('turma','[0-9]+');
        Route::put('turma/{turma}', 'TurmaController@update')->name('turma.update')->where('turma','[0-9]+');

        Route::get('horario/{turma}', 'AulaController@edit')->name('horario.edit')->where('turma','[0-9]+');
        Route::put('horario/{turma}', 'AulaController@update')->name('horario.update')->where('turma','[0-9]+');
    });

    // ROTAS DE REMOÇÃO DE REGISTROS
    Route::group(['prefix'=>'deletar'],function(){

        Route::get('turma/{turma}', 'TurmaController@delete')->name('turma.delete')->where('turma','[0-9]+');
    });

    // ROTAS DE MUDANÇAS DO ESTADO DOS REGISTROS PARA NEGADOS/CANCELADOS
    Route::group(['prefix'=>'cancelar'],function(){

        Route::get('falta/{falta}', 'FaltaController@cancelar')->name('falta.cancelar')->where('falta','[0-9]+');

        Route::get('reposicao/{reposicao}', 'ReposicaoController@cancelar')->name('reposicao.cancelar')->where('reposicao','[0-9]+');

        Route::get('anteposicao/{anteposicao}', 'AnteposicaoController@cancelar')->name('anteposicao.cancelar')->where('anteposicao','[0-9]+');
    });

    // ROTAS DE MUDANÇAS DO ESTADO DOS REGISTROS PARA CONFIRMADOS
    Route::group(['prefix'=>'confirmar'],function(){
        
        Route::get('falta/{falta}', 'FaltaController@confirmar')->name('falta.confirmar')->where('falta','[0-9]+');

        Route::get('reposicao/{reposicao}', 'ReposicaoController@confirmar')->name('reposicao.confirmar')->where('reposicao','[0-9]+');

        Route::get('anteposicao/{anteposicao}', 'AnteposicaoController@confirmar')->name('anteposicao.confirmar')->where('anteposicao','[0-9]+');
    });

    // ROTAS DE REQUISIÇÃO AJAX
    Route::group(['prefix'=>'ajax'],function(){

        Route::match(['get', 'post'],'pegar/disciplina', 'AjaxController@getDisciplinas')->name('ajax.disciplina');

        Route::match(['get', 'post'],'pegar/semestre/ano', 'AjaxController@getSemestresAno')->name('ajax.semestre.ano');

        Route::match(['get', 'post'],'pegar/disciplinas/optativas', 'AjaxController@getDisciplinasOptativas')->name('ajax.disciplina.optativa');

        Route::match(['get', 'post'],'pegar/professores/semestre', 'AjaxController@getProfessoresSemestre')->name('ajax.professor.semestre');
    });

    // ROTAS DE GRÁFICOS E RELATÓRIOS
    Route::group(['prefix'=>'gerar'],function(){
        Route::get('relatorio', 'RelatorioController@index')->name('relatorio.index');
        Route::get('relatorio/falta', 'RelatorioController@faltas')->name('relatorio.falta');
        Route::get('relatorio/reposicao', 'RelatorioController@reposicoes')->name('relatorio.reposicao');
        Route::get('relatorio/anteposicao', 'RelatorioController@anteposicoes')->name('relatorio.anteposicao');

        Route::get('grafico', 'GraficoController@index')->name('grafico.index');
        Route::get('grafico/falta', 'GraficoController@faltas')->name('grafico.falta');
    });
});

    // ROTAS DO PROFESSOR
Route::group(['prefix'=>'professor'],function(){

    // ROTAS DE CADASTROS DE REGISTROS
    Route::group(['prefix'=>'cadastrar'],function(){

        Route::get('anteposicao', 'AnteposicaoController@create')->name('anteposicao.create')->where('anteposicao', '[0-9]+');
        Route::post('anteposicao', 'AnteposicaoController@store')->name('anteposicao.store')->where('anteposicao', '[0-9]+');

        Route::get('reposicao/{usuario}/{falta}', 'ReposicaoController@create')->name('reposicao.create')->where(['falta' => '[0-9]+', 'usuario' => '[A-Za-z]+']);
        Route::post('reposicao/{usuario}/{falta}', 'ReposicaoController@store')->name('reposicao.store')->where(['falta' => '[0-9]+', 'usuario' => '[A-Za-z]+']);
    });

    // ROTAS DE LISTAGEM DE REGISTROS
    Route::group(['prefix'=>'controle'],function(){

        Route::get('horario', 'AulaController@show_professor')->name('horario.professor');

        Route::get('falta', 'FaltaController@show_professor')->name('falta.show.professor');

        Route::get('anteposicao', 'AnteposicaoController@show_professor')->name('anteposicao.show.professor');

        Route::get('reposicao', 'ReposicaoController@show_professor')->name('reposicao.show.professor');
    });

    // ROTAS DE EDIÇÃO DE REGISTROS
    Route::group(['prefix'=>'editar'],function(){

        Route::get('anteposicao/{anteposicao}', 'AnteposicaoController@edit')->name('anteposicao.edit')->where('anteposicao', '[0-9]+');
        Route::put('anteposicao/{anteposicao}', 'AnteposicaoController@update')->name('anteposicao.update')->where('anteposicao', '[0-9]+');

        Route::get('reposicao/{usuario}/{reposicao}', 'ReposicaoController@edit')->name('reposicao.edit')->where(['reposicao'=> '[0-9]+', 'usuario' => '[A-Za-z]+']);
        Route::put('reposicao/{usuario}/{reposicao}', 'ReposicaoController@update')->name('reposicao.update')->where(['reposicao'=> '[0-9]+', 'usuario' => '[A-Za-z]+']);
    });

    // ROTAS DE DOWNLOAD DE ARQUIVOS
    Route::group(['prefix'=>'download'],function(){

        Route::get('reposicao/{reposicao}', 'ReposicaoController@download')->name('reposicao.download')->where('reposicao','[0-9]+');

        Route::get('anteposicao/{anteposicao}', 'AnteposicaoController@download')->name('anteposicao.download')->where('anteposicao','[0-9]+');
    });

    // ROTAS DE VISUALIZAÇÕES DE ARQUIVOS
    Route::group(['prefix'=>'visualizar'],function(){

        Route::get('reposicao/{reposicao}', 'ReposicaoController@visualizar')->name('reposicao.visualizar')->where('reposicao','[0-9]+');

        Route::get('anteposicao/{anteposicao}', 'AnteposicaoController@visualizar')->name('anteposicao.visualizar')->where('anteposicao','[0-9]+');
    });
});

// ROTAS NÃO USADAS - EDIÇÃO E REMOÇÃO TOTAL DAS FALTAS
/*
    Route::get('editar/falta/{falta}', 'FaltaController@edit')->name('falta.edit')->where('falta','[0-9]+');
    Route::put('editar/falta/{falta}', 'FaltaController@update')->name('falta.update')->where('falta','[0-9]+');
    Route::get('deletar/falta/{falta}', 'FaltaController@delete')->name('falta.delete')->where('falta','[0-9]+');
*/