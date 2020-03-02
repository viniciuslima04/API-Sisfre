<?php $__env->startSection('titulo','Controle de Usuários'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Controle de Usuários</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">

                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if($usuarios->count() == 0 && empty($pesquisa) && empty($filtro) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há usuários cadastrados no sistema.
                        </div>

                    <?php elseif($usuarios->count() == 0 && !empty($pesquisa) && !empty($filtro) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhum usuário do tipo: <?php echo e($filtro); ?> foi encontrado para: <br><b class="text-uppercase"> <?php echo e($pesquisa); ?></b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('usuario.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($usuarios->count() == 0 && !empty($pesquisa) && empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhum usuário foi encontrado para: <br> <b class="text-uppercase"> <?php echo e($pesquisa); ?></b> neste curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('usuario.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($usuarios->count() == 0 && empty($pesquisa) && !empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Não há usuários do tipo: <b><?php echo e($filtro); ?></b> cadastrados no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('usuario.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row col-md-12 col-md-offset-0">
                            <form method="GET" action="<?php echo e(route('usuario.show')); ?>">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pelo nome do usuário" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-md-offset-1 <?php echo e($errors->has('filtro') ? ' has-error' : ''); ?>">
                                    <label class="col-md-2 control-label" for="filtro">Filtro:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                            <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO</option>
                                            <?php if(!empty($filtro)): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($filtro); ?>" selected><?php echo e($filtro); ?></option>
                                            <?php endif; ?>
                                            <option data-tokens="ketchup mustard" value="ADMINISTRADOR" > ADMINISTRADOR </option>
                                            <option data-tokens="ketchup mustard" value="COORDENADOR" > COORDENADOR </option>
                                            <option data-tokens="ketchup mustard" value="FUNCIONÁRIO" > FUNCIONÁRIO </option>
                                            <option data-tokens="ketchup mustard" value="PROFESSOR" > PROFESSOR </option>
                                        </select>

                                        <?php if($errors->has('filtro')): ?>
                                            <span class="help-block">
                                                 <strong><?php echo e($errors->first('filtro')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>  
                            </form>
                        </div>

                    <div class="table-responsive col-md-12">
                        <div class="row col-md-12 col-md-offset-0">
                            <div class="form-group pull-right">
                                <a href="<?php echo e(route('usuario.create')); ?>" class="btn btn-primary text-uppercase" >
                                    <span class="glyphicon glyphicon-plus"></span> Usuário
                                </a>
                            </div>  
                        </div>

                        <div class="row col-md-12 col-md-offset-0 align-left">     
                            <div class="col cliente-labels">                                        
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Administrador</span></p>
                                <p><i class="fa fa-square" style="color: #FF00FF;"></i><span>Coordenador</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Funcionário</span></p>
                                <p><i class="fa fa-square" style="color: #87CEEB;"></i><span>Professor</span></p>
                            </div>
                        </div>

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center">Tipo</th> 
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">E-mail</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php if($user->acesso == 4): ?>
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($user->acesso == 3): ?>
                                            <a class="action" style="background-color: #FF00FF; color: #FF00FF;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($user->acesso == 2): ?>
                                            <a class="action" style="background-color: #87CEEB; color: #87CEEB;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php else: ?>
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"><?php echo e($user->username); ?></td>
                                    <td class="text-center text-lowercase" style="vertical-align: middle;"><?php echo e($user->email); ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            <a class='btn btn-info' href="<?php echo e(route('usuario.edit',$user->id)); ?>">
                                                <span class="glyphicon glyphicon-edit"></span> Editar
                                            </a>
                                            <a class="btn"></a>
                                            
                                            <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="usuario" data-url="<?php echo e(route('usuario.delete',$user->id)); ?>">
                                                <span class="glyphicon glyphicon-remove" ></span> Excluir
                                            </a>
                                        </div>
                                    </td> 

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                        <?php echo e($usuarios->appends(['pesquisa' => $pesquisa, 'filtro' => $filtro])->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layout.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>