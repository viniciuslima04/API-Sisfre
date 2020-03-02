<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo $__env->yieldContent('titulo'); ?> </title>
    <link href="<?php echo e(asset('img/favicon.png')); ?>" rel="shortcut icon" />
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/bootstrap-theme.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/bootstrap.modif.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/estilo.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <noscript>
      <div class="container"> 
          <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 text-center">
            <span class="glyphicon glyphicon-remove-sign"></span>  O Javascript está desabilitado, o sistema não irá funcionar corretamente. Habilite-o!! 
          </div>
      </div>
   </noscript>

    <script src="<?php echo e(asset('js/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.mask.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-notify.min.js')); ?>"></script>
   
    <?php echo $__env->yieldContent('scripts'); ?>

</head>

<body>
<div class="container">
    <?php if(Route::has('login')): ?>

	      <nav class="navbar navbar-default">
	        <div class="container-fluid">
	          <div class="navbar-header row col-md-3">
	            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	              <span class="sr-only">Toggle navigation</span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	            </button>

                <?php if(Auth::check()): ?>
                    <a class="navbar-brand" href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('/img/sisfre.png')); ?>" class="img-responsive-mod" width="70%" height="70%"></a>
                <?php else: ?>
                    <a class="navbar-brand" href="<?php echo e(route('login')); ?>"><img src="<?php echo e(asset('/img/sisfre.png')); ?>" class="img-responsive-mod" width="70%" height="70%"></a>
                <?php endif; ?>

	          </div>
    	          <div id="navbar" class="navbar-collapse collapse ">
                    
                    <?php if(Auth::check()): ?>
    	            <ul class="nav navbar-nav">
    	              <?php if( Auth::user()->acesso == 4): ?>      	              
                          <li class="dropdown">
        	                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"> Cadastrar <span class="caret"></span></a>
        	                <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo e(route('curso.create')); ?>"> Curso </a></li>
        	                  <li><a href="<?php echo e(route('disciplina.create')); ?>"> Disciplina </a></li>
                            <li><a href="<?php echo e(route('feriado.create')); ?>"> Feriado </a></li>
                            <li><a href="<?php echo e(route('sabado.create')); ?>"> Sábado Letivo </a></li>
        	                  <li><a href="<?php echo e(route('semestre.create')); ?>"> Semestre </a></li>
                            <li><a href="<?php echo e(route('usuario.create')); ?>"> Usuário </a></li>
        	                </ul>
        	              </li>

                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"> Controle <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="<?php echo e(route('curso.show')); ?>"> Curso </a></li>
                              <li><a href="<?php echo e(route('disciplina.show')); ?>"> Disciplina </a></li>
                              <li><a href="<?php echo e(route('feriado.show')); ?>"> Feriado </a></li>
                              <li><a href="<?php echo e(route('sabado.show')); ?>"> Sábado Letivo </a></li>
                              <li><a href="<?php echo e(route('semestre.show')); ?>"> Semestre </a></li>
                              <li><a href="<?php echo e(route('usuario.show')); ?>"> Usuário </a></li>
                            </ul>
                          </li>
                      <?php endif; ?>

                      <?php if(Auth::user()->acesso == 1): ?>
                          
                          <li class="dropdown">
                              <a href="<?php echo e(route('falta.create')); ?>"> Cadastrar Falta </a></li>
                          </li>

                          <li class="dropdown">
                              <a href="<?php echo e(route('falta.show.funcionario')); ?>"> Controle de Faltas </a></li>
                          </li>

                          <li class="dropdown">
                              <a href="<?php echo e(route('relatorio.index.funcionario')); ?>"> Relatórios </a></li>
                          </li>
                      <?php endif; ?>

                      <?php if( Auth::user()->acesso == 3): ?>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"> Coordenador <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="<?php echo e(route('anteposicao.show.coordenador')); ?>"> Anteposições do Curso</a></li>
                              <li><a href="<?php echo e(route('falta.show.coordenador')); ?>"> Faltas do Curso </a></li>
                              <li><a href="<?php echo e(route('grafico.index')); ?>"> Gráficos </a></li>
                              <li><a href="<?php echo e(route('relatorio.index')); ?>"> Relatórios </a></li>
                              <li><a href="<?php echo e(route('reposicao.show.coordenador')); ?>"> Reposições do Curso </a></li>
                              <li><a href="<?php echo e(route('turma.show')); ?>"> Turmas do Curso </a></li>
                            </ul>
                          </li>

                      <?php endif; ?>

                      <?php if( Auth::user()->acesso == 3 or Auth::user()->acesso == 2): ?>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"> Professor <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="<?php echo e(route('horario.professor')); ?>"> Meu Horário  </a></li>
                              <li><a href="<?php echo e(route('falta.show.professor')); ?>"> Minhas Faltas </a></li>
                              <li><a href="<?php echo e(route('reposicao.show.professor')); ?>"> Minhas Reposições </a></li>
                              <li><a href="<?php echo e(route('anteposicao.show.professor')); ?>"> Minhas Anteposições </a></li>
                            </ul>
                          </li>
                      <?php endif; ?>
    	            </ul>
                <?php endif; ?>

                <?php if(Auth::check()): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo e(route('usuario.edit', Auth::user()->id)); ?>"><span class="glyphicon glyphicon-user"></span> <?php echo e(Auth::user()->username); ?> </a></li>
                        <li>
                            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-log-in"></span> Sair
                            </a>

                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo e(route('login')); ?>"><span class="glyphicon glyphicon-user"></span> Logar </a></li>
                    </ul>
                <?php endif; ?>
	          </div><!--/.nav-collapse -->
	        </div><!--/.container-fluid -->
	      </nav>
    <?php endif; ?>

    <div class="row">
        <?php echo $__env->yieldContent('conteudo'); ?>
    </div>

    <footer class="welld navbar navbar-default footer container-fluid" style="color:#000;">
            <div class="text-center"> &reg; copyright Sloth Software 2016-<?php echo e(date('Y')); ?>. </div>
    </footer>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</div>
</body>
</html>