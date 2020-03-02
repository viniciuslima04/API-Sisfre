<?php $__env->startSection('titulo','Editar Turma'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.turma', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.validation-turma', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
    <?php echo $__env->make('scripts.outros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Editar Turma</div>
        <div class="panel-body">
            <form id="CadTurma" class="form-horizontal editar" role="form" method="POST" action="<?php echo e(route('turma.update',$turmaEdit->id)); ?>">
               
               <div class="row col-md-12">

                    <div class="form-group col-md-6 <?php echo e($errors->has('periodo') ? ' has-error' : ''); ?> periodo1">
                        <label class="col-md-4 control-label" for="periodo">Periodo:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control" name="periodo" id="periodo" data-curso="<?php echo e(Auth::user()->professor->curso->id); ?>" data-optativa="0">
                                <option data-tokens="ketchup mustard" value="<?php echo e($turmaEdit->periodo); ?>" selected> <?php echo e($turmaEdit->periodo); ?> </option>

                                <?php for($i = 1; $i <= auth()->user()->professor->curso->duracao; $i++): ?>

                                    <?php if(old('periodo')): ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e(old('periodo')); ?>" selected> <?php echo e(old('periodo')); ?> </option>
                                    <?php endif; ?>

                                    <option data-tokens="ketchup mustard" value="<?php echo e($i); ?>" > <?php echo e($i); ?> </option>
                                <?php endfor; ?>
                            </select>
                                
                            <?php if($errors->has('periodo')): ?>
                                <span class="help-block">
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
                                
                                <option data-tokens="ketchup mustard" value="<?php echo e($turmaEdit->turno); ?>" selected>
                                    <?php if($turmaEdit->turno == 'M'): ?>
                                        MANHÃ
                                    <?php elseif($turmaEdit->turno == 'T'): ?>
                                        TARDE
                                    <?php elseif($turmaEdit->turno == 'N'): ?>
                                        NOITE
                                    <?php elseif($turmaEdit->turno == 'D'): ?>
                                        DIURNO
                                    <?php endif; ?>
                                </option>

                                <?php $__currentLoopData = $turnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turAbr => $turno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('turno') == $turAbr): ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e($turAbr); ?>" selected> <?php echo e($turno); ?> </option>
                                    <?php endif; ?>

                                    <option data-tokens="ketchup mustard" value="<?php echo e($turAbr); ?>"> <?php echo e($turno); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <?php if($errors->has('turno')): ?>
                                <span class="help-block">
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
                                <option data-tokens="ketchup mustard" value="<?php echo e($turmaEdit->semestre->id); ?>" selected> <?php echo e($turmaEdit->semestre->ano); ?>.<?php echo e($turmaEdit->semestre->etapa); ?> - <?php echo e($turmaEdit->semestre->tipo); ?></option>
                                    <?php $__currentLoopData = $semestresAtivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('semestre') == $semestre->id): ?>
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

                    <div id="esconder" class="form-group col-md-6 qtd" style="display: none;">
                        <label for="qtd" class="col-md-4 control-label">Optativas:</label>
                        <div class="col-md-8">
                            <input id="qtd" type="text" class="form-control" maxlength="2" name="qtd" placeholder="N° de Optativas desse periodo"                                   
                                <?php if(!empty(old('qtd'))): ?> 
                                    value="<?php echo e(old('qtd')); ?>"
                                <?php else: ?> 
                                    value="<?php echo e($turmaEdit->optativas->count()); ?>" 
                                <?php endif; ?>
                            />

                            <span class="help-block">
                                <strong id="qtd1"></strong>
                            </span>
                        </div>
                    </div> 
                </div>

                <div class="form-group col-md-12" ></div>
                <div class="form-group col-md-12" ></div>

                <div id="disciplinasOptativas" class="row col-md-12" style="display: none">
                    <?php if(!empty($disciplinasOptativas) ): ?>                                
                        <div class="titulo" id="titulo" data-qtdOptativas="<?php echo e($disciplinasOptativas->count()); ?>"> 
                            <h4 class="text-center">Selecione a(s) disciplina(s) optativa(s) ofertada(s):</h4>
                        </div>

                        <div class="form-group col-md-12"></div>

                        <?php $__currentLoopData = $turmaEdit->optativas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group col-md-12 optativa<?php echo e($loop->iteration); ?>">
                                <label for="optativa<?php echo e($loop->iteration); ?>" class="col-md-2 col-md-offset-1 control-label">Optativa <?php echo e($loop->iteration); ?>:</label>
                                <div class="col-md-8">
                                    <select class="selectpicker form-control text-uppercase" name="optativa[]" id="optativa<?php echo e($loop->iteration); ?>">
                                        <?php $__currentLoopData = $disciplinasOptativas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplinaOptativa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($disciplinaOptativa->id == $discOpt->disciplina->id): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($discOpt->disciplina->id); ?>" selected> <?php echo e($discOpt->disciplina->nome); ?> </option>
                                            <?php endif; ?>

                                            <?php if(old('optativa.$i') == $discOpt->id): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($discOpt->disciplina->id); ?>" selected> <?php echo e($discOpt->disciplina->nome); ?> </option>
                                            <?php endif; ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($disciplinaOptativa->id); ?>"> <?php echo e($disciplinaOptativa->nome); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <span class="form-group col-md-12">
                                        <strong id="optativa<?php echo e($loop->iteration); ?><?php echo e($loop->iteration); ?>"></strong>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endif; ?>
                </div>

                <div class="form-group col-md-12" ></div>
                <div class="form-group col-md-12" ></div>

                <div class="row col-md-7 col-md-offset-3">
                    <div class="form-group col-md-5">
                        <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                            Salvar
                        </button>     
                    </div>

                    <div class="form-group col-md-2" ></div>

                    <div class="form-group col-md-5">
                        <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-danger">
                            Cancelar
                        </a>   
                    </div>
                </div>

                <div class="row col-md-8 col-md-offset-2">
                    <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong id="mensagem"></strong>
                    </div>
                </div>
                
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="_method" value="put"> 
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>