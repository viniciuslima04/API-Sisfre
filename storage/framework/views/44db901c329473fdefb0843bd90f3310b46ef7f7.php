<?php $__env->startSection('titulo','Montar Horário'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.horario', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.validation-horario', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-12 col-md-offset-0">
    <div class="panel panel-default">
        <div class="panel-heading">Montar Horário</div>
        <div class="panel-body">
            <form class="form-horizontal" id="CadHora" role="form" method="POST" action="<?php echo e(route('horario.store',$turma->id)); ?>">
                <div class="row col-md-12">
                    <div class="form-group col-md-10 <?php echo e($errors->has('turma') ? ' has-error' : ''); ?>">
                        <label for="turma" class="col-md-4 control-label">Turma:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control select-center" name="turma" id="turma" data-status="100" readonly>
                                <option data-tokens="ketchup mustard" value="<?php echo e($turma->id); ?>" selected> <?php echo e($turma->descricao); ?> </option>
                            </select>

                            <?php if($errors->has('turma')): ?>
                                <span class="help-block">
                                     <strong><?php echo e($errors->first('turma')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div id="tabela" class="row col-md-12 col-md-offset-0">

                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>