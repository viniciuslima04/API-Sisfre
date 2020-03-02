<!DOCTYPE html>
<html lang="pt-br">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> <?php echo $__env->yieldContent('titulo'); ?> </title>
        <link href="<?php echo e(public_path()); ?>/img/favicon.png" rel="shortcut icon" />
        <link href="<?php echo e(public_path()); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo e(public_path()); ?>/css/print.css" rel="stylesheet" type="text/css">
        <link href="<?php echo e(public_path()); ?>/css/estilo.css" rel="stylesheet" type="text/css">

	</head>
	<body>

        <div class="container">
            <header class="row">
                <?php if(Auth::user()->acesso == 4): ?>
                    <nav class="navbar nav-justified center well-sm">
                        <div class="container-fluid col-md-4 col-xs-offset-4" >
                           <a><img src="<?php echo e(public_path()); ?>/img/sisfre.png" class="img-responsive"></a>
                        </div>
                    </nav>
                
                    <div class="container-fluid col-md-5 col-xs-offset-4 text-uppercase" style="vertical-align: center;padding-bottom: 1.0em">

                            <p>
                                 <b> Curso: </b> <?php echo e(Auth::user()->professor->curso->nome); ?><br>
                                 <b>Coordenador: </b> <?php echo e(Auth::user()->professor->usuario->username); ?><br>
                                 <b>Semestre: </b> <?php echo $__env->yieldContent('semestre'); ?>
                            </p>
                    </div>

                <?php else: ?>
                    <nav class="navbar nav-justified">
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-2">
                               <a><img src="<?php echo e(public_path()); ?>/img/sisfre.png" class="img-responsive" style="width: 10em"></a>
                            </div>
                            <div class="col-xs-4" style="vertical-align: middle;">
                                <b>    
                                    <?php if($dia == 1): ?>
                                        SEGUNDA-FEIRA
                                    <?php elseif($dia == 2): ?>
                                        TERÇA-FEIRA
                                    <?php elseif($dia == 3): ?>
                                        QUARTA-FEIRA
                                    <?php elseif($dia == 4): ?>
                                        QUINTA-FEIRA
                                    <?php elseif($dia == 5): ?>
                                        SEXTA-FEIRA
                                    <?php endif; ?>
                                    |
                                    <?php if($turno == 'M'): ?>
                                        MANHÃ
                                    <?php elseif($turno == 'T'): ?>
                                        TARDE
                                    <?php elseif($turno == 'N'): ?>
                                        NOITE
                                    <?php endif; ?>
                                    | <?php echo e($hoje->format('d/m/Y')); ?>

                                </b> 
                            </div>
                    </div>
                    </nav>
                <?php endif; ?>
            </header>

            <div class="row">
                <?php echo $__env->yieldContent('conteudo'); ?>
            </div>
            
        </div>

	</body>
</html>