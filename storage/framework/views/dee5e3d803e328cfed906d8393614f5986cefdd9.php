<?php $__env->startSection('titulo','Cadastrar Turma'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.turma', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.validation-turma', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Turma</div>
        <div class="panel-body">
            <?php if($errorSemestre && isset($errorSemestre)): ?>
                <div class="alert alert-warning btn-lg col-md-8 col-md-offset-2 danger text-center">
                    <?php echo e($errorSemestre); ?>

                </div>

                <div class="row col-md-2 col-md-offset-5">
                    <div class="form-group text-center text-uppercase">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-primary">
                            <span class="glyphicon glyphicon-home"></span> Home
                        </a>   
                    </div>
                </div>
            <?php else: ?>
                <form id="CadTurma" class="form-horizontal" role="form" method="POST" action="<?php echo e(route('turma.store')); ?>">
                   
                   <div class="row col-md-12">

                        <div class="form-group col-md-6 <?php echo e($errors->has('periodo') ? ' has-error' : ''); ?> periodo1">
                            <label class="col-md-4 control-label" for="periodo">Periodo:</label>
                            <div class="col-md-8">

                                    <select class="selectpicker form-control" name="periodo" id="periodo" data-curso="<?php echo e(Auth::user()->professor->curso->id); ?>" data-optativa="0">
                                        <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O PERIODO --</option>
                                        <?php if(old('periodo')): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e(old('periodo')); ?>" selected> <?php echo e(old('periodo')); ?> </option>
                                        <?php endif; ?>
                                        <?php for($i = 1; $i <= auth()->user()->professor->curso->duracao; $i++): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($i); ?>" > <?php echo e($i); ?> </option>
                                        <?php endfor; ?>
                                    </select>
                                    
                                <?php if($errors->has('periodo')): ?>
                                    <span class="help-block text-center">
                                         <strong><?php echo e($errors->first('periodo')); ?></strong>
                                    </span>
                                <?php endif; ?>

                                <span id="error-periodo" class="help-block text-center" style="display: none;">
                                     <strong id="periodo1"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 <?php echo e($errors->has('turno') ? ' has-error' : ''); ?> turno1">
                            <label for="turno" class="col-md-4 control-label">Turno: </label>

                            <div class="col-md-8">
                                <select class="selectpicker form-control" name="turno" id="turno">
                                    <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O TURNO --</option>
                                        <?php $__currentLoopData = $turnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turAbr => $turno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('turno')== $turAbr): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e(old('turno')); ?>" selected> <?php echo e($turno); ?> </option>
                                            <?php endif; ?>

                                            <option data-tokens="ketchup mustard" value="<?php echo e($turAbr); ?>"> <?php echo e($turno); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('turno')): ?>
                                    <span class="help-block text-center">
                                         <strong><?php echo e($errors->first('turno')); ?></strong>
                                    </span>
                                <?php endif; ?>

                                <span id="error-turno" class="help-block text-center" style="display: none;">
                                     <strong id="turno1"></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group col-md-6 <?php echo e($errors->has('semestre') ? ' has-error' : ''); ?> semestre1">
                            <label for="semestre" class="col-md-4 control-label">Semestre: </label>
                            <div class="col-md-8">
                                <select class="selectpicker form-control" name="semestre" id="semestre">
                                    <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O SEMESTRE --</option>
                                        <?php $__currentLoopData = $semestresAtivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('semestre')== $semestre->id): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e(old('semestre')); ?>" selected> <?php echo e($semestre->ano); ?>.<?php echo e($semestre->etapa); ?> - <?php echo e($semestre->tipo); ?> </option>
                                            <?php endif; ?>

                                            <option data-tokens="ketchup mustard" value="<?php echo e($semestre->id); ?>"> <?php echo e($semestre->ano); ?>.<?php echo e($semestre->etapa); ?> - <?php echo e($semestre->tipo); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('semestre')): ?>
                                    <span class="help-block text-center">
                                         <strong><?php echo e($errors->first('semestre')); ?></strong>
                                    </span>
                                <?php endif; ?>

                                <span id="error-semestre" class="help-block text-center" style="display: none;">
                                     <strong id="semestre1"></strong>
                                </span>
                            </div>
                        </div>

                        <div id="esconder" class="form-group col-md-6 qtd" style="display: none">
                            <label for="qtd" class="col-md-4 control-label">Optativas:</label>
                            <div class="col-md-8">
                                <input id="qtd" type="text" class="form-control" value="<?php echo e(old('qtd')); ?>" maxlength="2" name="qtd" placeholder="N° de Optativas desse periodo">

                                <span class="help-block">
                                    <strong id="qtd1"></strong>
                                </span>
                            </div>
                        </div>  
                    </div>

                    <div class="form-group col-md-12" ></div>
                    <div class="form-group col-md-12" ></div>

                    <div id="disciplinasOptativas" class="row col-md-12" style="display: none">
                        
                    </div>

                    <div class="form-group col-md-12" ></div>
                    <div class="form-group col-md-12" ></div>

                    <div class="row col-md-7 col-md-offset-3">
                        <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-block btn-lg btn-success">
                                    Cadastrar
                                </button>     
                        </div>

                        <div class="form-group col-md-2" ></div>

                        <div class="form-group col-md-5">
                            <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"> 
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>