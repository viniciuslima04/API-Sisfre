<?php $__env->startSection('titulo','Editar Curso'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.outros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Atualizar Curso</div>
                    <div class="panel-body">
                        <form class="form-horizontal editar" role="form" method="POST" action="<?php echo e(route('curso.update',$curso->id)); ?>">
                           
                           <div class="row col-md-12">
                                <div class="form-group col-md-8 <?php echo e($errors->has('nome') ? ' has-error' : ''); ?>">
                                    <label class="col-md-3 control-label" for="ano">Nome:</label>
                                    <div class="col-md-8">
                                        <input id="nome" name="nome" maxlength="160"
                                         <?php if(!empty(old('nome'))): ?> 
                                            value="<?php echo e(old('nome')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($curso->nome); ?>" 
                                        <?php endif; ?>
                                         class="form-control input-md text-uppercase" type="text">
                                    </div>

                                    <?php if($errors->has('nome')): ?>
                                        <span class="help-block">
                                             <strong><?php echo e($errors->first('nome')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>



                                <div class="form-group col-md-4 <?php echo e($errors->has('sigla') ? ' has-error' : ''); ?>">
                                    <label class="col-md-4 control-label" for="sigla">Sigla:</label>
                                    <div class="col-md-8">
                                        <input id="sigla" name="sigla" maxlength="10"
                                         <?php if(!empty(old('sigla'))): ?> 
                                            value="<?php echo e(old('sigla')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($curso->sigla); ?>" 
                                        <?php endif; ?>
                                         class="form-control input-md text-uppercase" type="text">


                                        <?php if($errors->has('sigla')): ?>
                                            <span class="help-block text-center">
                                                 <strong><?php echo e($errors->first('sigla')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>


                                </div>
                            </div>

                            <div class="row col-md-12">

                                <div class="form-group col-md-8 <?php echo e($errors->has('tipo') ? ' has-error' : ''); ?>">
                                    <label for="tipo" class="col-md-3 control-label">Tipo: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            <?php if($curso->tipo == "GRADUAÇÃO"): ?>
                                                <option data-tokens="ketchup mustard" value="1" selected> GRADUAÇÃO </option>
                                            <?php elseif($curso->tipo == "INTEGRADO"): ?>
                                                <option data-tokens="ketchup mustard" value="2" selected> INTEGRADO </option>
                                            <?php elseif($curso->tipo == "TÉCNICO"): ?>
                                                <option data-tokens="ketchup mustard" value="3" selected> TÉCNICO </option>
                                            <?php else: ?>
                                                <option data-tokens="ketchup mustard" value="" selected> SELECIONE..</option>
                                            <?php endif; ?>
                                            <option data-tokens="ketchup mustard" value="1" > GRADUAÇÃO </option>
                                            <option data-tokens="ketchup mustard" value="2" > INTEGRADO </option>
                                            <option data-tokens="ketchup mustard" value="3" > TÉCNICO </option>
                                        </select>

                                        <?php if($errors->has('tipo')): ?>
                                            <span class="help-block">
                                                 <strong><?php echo e($errors->first('tipo')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 <?php echo e($errors->has('duracao') ? ' has-error' : ''); ?>">
                                    <label class="col-md-4 control-label" for="duracao">Duração:</label>
                                    <div class="col-md-8">
                                        <input id="duracao" name="duracao" maxlength="10"
                                         <?php if(!empty(old('duracao'))): ?> 
                                            value="<?php echo e(old('duracao')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($curso->duracao); ?>" 
                                        <?php endif; ?> class="form-control input-md" type="text">


                                        <?php if($errors->has('duracao')): ?>
                                            <span class="help-block text-center">
                                                 <strong><?php echo e($errors->first('duracao')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group col-md-8 <?php echo e($errors->has('coord') ? ' has-error' : ''); ?>">
                                    <label for="coord" class="col-md-3 control-label">Coordenador: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="coord" id="coord">
                                            <?php if(empty($curso->coordenador)): ?>
                                                <option data-tokens="ketchup mustard" value="" selected> SELECIONE... </option>
                                            <?php else: ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($curso->coordenador->id); ?>" selected> <?php echo e($curso->coordenador->usuario->username); ?> </option>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $professores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($prof->id); ?>"><?php echo e($prof->usuario->username); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <?php if($errors->has('coord')): ?>
                                            <span class="help-block">
                                                 <strong><?php echo e($errors->first('coord')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
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
                                    <a href="<?php echo e(route('curso.show')); ?>" class="btn btn-block btn-lg btn-danger">
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