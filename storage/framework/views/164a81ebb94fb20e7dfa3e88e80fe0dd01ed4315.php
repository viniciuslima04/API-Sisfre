<?php $__env->startSection('titulo','Cadastrar Disciplina'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.disciplina', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.validation-disciplina', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Disciplina</div>
        <div class="panel-body">
            <form id="cadDisc" class="form-horizontal" role="form" method="POST" action="<?php echo e(route('disciplina.store')); ?>">

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-8 disciplina <?php echo e($errors->has('disciplina') ? ' has-error' : ''); ?>">
                        <label for="disciplina" class="col-md-3 control-label">Nome:</label>
                        <div class="col-md-8">
                            <input id="disciplina" type="text" class="text-uppercase form-control"  name="disciplina" value="<?php echo e(old('disciplina')); ?>">

                            <?php if($errors->has('disciplina')): ?>
                                <span class="help-block">
                                     <strong ><?php echo e($errors->first('disciplina')); ?></strong>
                                </span> 
                            <?php endif; ?>
                            <span class="help-block">
                                 <strong id="disciplina1"></strong>
                            </span> 

                        </div>
                    </div>

                    <div class="form-group col-md-4 sigla <?php echo e($errors->has('sigla') ? ' has-error' : ''); ?>">
                        <label for="sigla" class="col-md-3 control-label">Sigla:</label>
                        <div class="col-md-8">
                            <input id="sigla" type="text" class="text-uppercase form-control" maxlength="8" name="sigla" value="<?php echo e(old('sigla')); ?>">

                            <span class="help-block">
                                <strong id="sigla1"></strong>
                            </span>

                            <?php if($errors->has('sigla')): ?>
                                <span class="help-block">
                                     <strong ><?php echo e($errors->first('sigla')); ?></strong>
                                </span> 
                            <?php endif; ?>
                        </div>
                    </div>
                </div>  
                <div class="row col-md-12 col-md-offset-0">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso 1 </strong></h3>
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-12 curso0">
                                    <label for="curso" class="col-md-3 control-label">Curso:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="curso[]" id="curso0" data-num="0" data-periodo="#periodo0" data-cursos="<?php echo e($cursos->count()); ?>">
                                            <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                                            <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($curso->id); ?>"> <?php echo e($curso->nome); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>


                                        <span class="help-block">
                                             <strong id="curso00"></strong>
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <div id="periodo0" class="row col-md-11 col-md-offset-1">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-8 <?php echo e($errors->has('option') ? ' has-error' : ''); ?>">

                        <div class="col-md-10 col-md-offset-3">
                            <label class="checkbox-inline"><input type="checkbox" id="option" name="option" value="1" <?php if(old('option') == "1"): ?> checked <?php endif; ?>> <b>Deseja adicionar mais cursos?</b> </label>    

                        </div>

                        <?php if($errors->has('option')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('option')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div id="esconder" class="form-group col-md-4 qtd" style="display: none">
                        <label for="qtd" class="col-md-6 control-label">Quantidade:</label>
                        <div class="col-md-5">
                            <input id="qtd" type="text" class="form-control" value="<?php echo e(old('qtd')); ?>" maxlength="2" name="qtd">

                            <span class="help-block">
                                <strong id="qtd1"></strong>
                            </span>
                        </div>
                    </div>  
                </div>

                <div id='addCursos' class="row col-md-12 col-md-offset-0"></div>

                <div class="form-group col-md-12" ></div>
                <div class="form-group col-md-12" ></div>
                
                <div class="row col-md-7 col-md-offset-3">

                        <div class="form-group col-md-5">
                                <button name="cadastrarDisciplina" id="CadDisc" type="submit" class="btn btn-block btn-lg btn-success">
                                    Cadastrar
                                </button>     
                        </div>

                        <div class="form-group col-md-2" ></div>

                        <div class="form-group col-md-5">
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>

                </div>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>