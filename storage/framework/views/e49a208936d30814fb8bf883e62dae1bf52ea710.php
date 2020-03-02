<?php $__env->startSection('titulo','Controle de Turmas'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Controle de Turmas</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if($turmas->count() == 0 && empty($pesquisa) && empty($filtro) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há nenhuma turma cadastrada no curso:<br> <b class="text-uppercase"> <?php echo e(Auth::user()->professor->curso->nome); ?></b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('turma.create')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-plus"></span> Turma
                                </a>   
                            </div>
                        </div>
                    <?php elseif($turmas->count() == 0 && !empty($pesquisa) && !empty($filtro) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma Turma foi encontrada para o nome: <br><b class="text-uppercase"> <?php echo e($pesquisa); ?></b> no semestre <?php echo e($filtro); ?> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($turmas->count() == 0 && !empty($pesquisa) && empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma turma foi encontrada com o nome: <br> <b class="text-uppercase"> <?php echo e($pesquisa); ?></b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($turmas->count() == 0 && empty($pesquisa) && !empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma turma cadastrada no semestre <b class="text-uppercase"><?php echo e($filtro); ?></b> ativo.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row col-md-12 col-md-offset-0">
                            <form method="GET" action="<?php echo e(route('turma.show')); ?>">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pelo nome da turma." />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-5 col-md-offset-1 <?php echo e($errors->has('filtro') ? ' has-error' : ''); ?>">
                                    <label class="col-md-2 control-label" for="filtro">Filtro:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                        <option data-tokens="ketchup mustard" value="" selected >SEM FILTRO</option>
                                            <?php if(!empty($filtro)): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($filtro); ?>" selected>
                                                    <?php echo e($filtro); ?>

                                                </option>
                                            <?php endif; ?>
                                            <option data-tokens="ketchup mustard" value="CONVENCIONAL" >CONVENCIONAL</option>
                                            <option data-tokens="ketchup mustard" value="REGULAR" >REGULAR</option>
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
                                    <a href="<?php echo e(route('turma.create')); ?>" class="btn btn-primary text-uppercase" >
                                        <span class="glyphicon glyphicon-plus"></span> turma
                                    </a>
                                </div>  
                            </div>

                            <div class="row col-md-12 col-md-offset-0 align-left">     
                                <div class="col cliente-labels">                                        
                                    <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>SEMESTRE CONVENCIONAL</span></p>
                                    <p><i class="fa fa-square" style="color: #FF6347;"></i><span>SEMESTRE REGULAR</span></p>
                                </div>
                            </div>

                            <table class="table table-striped bunitu">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center" style="vertical-align: middle;">Semestre</th>
                                        <th class="text-center" style="vertical-align: middle;">Nome</th>
                                        <th class="text-center" style="vertical-align: middle;">Turno</th>
                                        <th class="text-center" style="vertical-align: middle;">Periodo</th>
                                        <th class="text-center" style="vertical-align: middle;">Horário</th>
                                        <th class="text-center" style="vertical-align: middle;">Ação</th>
                                    </tr>
                                </thead>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr class="row text-uppercase">

                                        <td class="text-center" style="vertical-align: middle;">
                                            <?php if($turma->semestre_tipo == "CONVENCIONAL"): ?>
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                            <?php elseif($turma->semestre_tipo == "REGULAR"): ?>
                                                <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                    <span class="fa fa-square"></span>
                                                </a>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($turma->descricao); ?> </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <?php if($turma->turno == 'M'): ?>
                                                MANHÃ
                                            <?php elseif($turma->turno == 'T'): ?>
                                                TARDE
                                            <?php elseif($turma->turno == 'N'): ?>
                                                NOITE
                                            <?php elseif($turma->turno == 'D'): ?>
                                                DIURNO
                                            <?php endif; ?> 
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($turma->periodo); ?> </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <?php if($turma->aulas->count() > 0 ): ?>
                                                <div class="btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-info' href="<?php echo e(route('horario.edit',$turma->id)); ?>">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>  

                                                    <a class="btn"></a>
                                                    
                                                    <a class='btn btn-success' href="<?php echo e(route('horario.show',$turma->id)); ?>">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <div class="btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-primary' href="<?php echo e(route('horario.create',$turma->id)); ?>">
                                                        <span class="glyphicon glyphicon-plus-sign"></span> Montar
                                                    </a>
                                                </div>
                                            <?php endif; ?> 
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group-xs btn-group-vertical btn-block">
                                                <a class='btn btn-info' href="<?php echo e(route('turma.edit',$turma->id)); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>

                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger " data-toggle="modal" data-target="#modal" data-entidade="turma" data-url="<?php echo e(route('turma.delete',$turma->id)); ?>">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                            <?php echo e($turmas->appends(['pesquisa' => $pesquisa])->links()); ?>

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