<?php $__env->startSection('titulo','Controle de Cursos'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
        <div class="row container-fluid">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row col-md-12 col-md-offset-0">
                            
                            <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php if($cursos->count() == 0 && empty($pesquisa)): ?>
                                <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 danger text-center">
                                    Você não possui nenhum curso cadastrado.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-center text-uppercase">
                                        <a href="<?php echo e(route('semestre.create')); ?>" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-plus"></span> Curso
                                        </a>   
                                    </div>
                                </div>
                            <?php elseif($cursos->count() == 0 && !empty($pesquisa) ): ?>
                                <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                    Nenhum curso foi encontrado para a Pesquisa: <b class="text-uppercase"><?php echo e($pesquisa); ?></b>.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-uppercase text-center">
                                        <a href="<?php echo e(route('curso.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                        </a>   
                                    </div>
                                </div>
                            <?php else: ?>

                            <div class="row col-md-8 col-md-offset-0">
                                  <form method="GET" action="<?php echo e(route('curso.show')); ?>">
                                    <div class="form-group col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pelo nome do curso" />
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                            </div>

                                        </div>
                                    </div>   
                                  </form>
                             </div>

                            <div class="table-responsive col-md-12">
                                <div class="row col-md-12 col-md-offset-0">
                                    <div class="form-group pull-right">
                                        <a href="<?php echo e(route('curso.create')); ?>" class="btn btn-primary text-uppercase" >
                                            <span class="glyphicon glyphicon-plus"></span> Curso
                                        </a>
                                    </div>  
                                </div>
                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center" style="vertical-align: middle;">Nome</th>
                                            <th class="text-center" style="vertical-align: middle;">Sigla</th>
                                            <th class="text-center" style="vertical-align: middle;">Tipo</th>
                                            <th class="text-center" style="vertical-align: middle;">Coordenador</th>
                                            <th class="text-center" style="vertical-align: middle;">Ação</th>
                                        </tr>
                                    </thead>
                                    <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($curso->nome); ?> </td>
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($curso->sigla); ?> </td>
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($curso->tipo); ?> </td>
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e(isset($curso->coordenador->usuario->username) ? $curso->coordenador->usuario->username : '-'); ?> </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <div class="btn-group btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-info' href="<?php echo e(route('curso.edit',$curso->id)); ?>">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a class="btn"></a>
                                                    
                                                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="curso" data-url="<?php echo e(route('curso.delete',$curso->id)); ?>">
                                                        <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                    </a> 
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>

                                <?php echo e($cursos->appends(['pesquisa' => $pesquisa])->links()); ?>

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