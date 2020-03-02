

<?php $__env->startSection('titulo','Registrar Anteposição'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.anteposicao', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Registrar Anteposição</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('anteposicao.store')); ?>" enctype="multipart/form-data">
                
                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 <?php echo e($errors->has('nome') ? ' has-error' : ''); ?>">
                            <label for="nome" class="col-md-3 control-label">Professor:</label>
                            <div class="col-md-8">
                                <input id="nome" type="text" data-id="<?php echo e(Auth::user()->professor->id); ?>" class="text-uppercase text-center form-control" name="nome" value="<?php echo e(Auth::user()->professor->usuario->abreviatura); ?> - <?php echo e(Auth::user()->professor->usuario->username); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 <?php echo e($errors->has('turma') ? ' has-error' : ''); ?>">
                            <label for="turma" class="col-md-3 control-label">Turma:</label>
                            <div class="col-md-8">
                                <select class="selectpicker form-control text-uppercase select" name="turma" id="turma3">
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
                                    <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('turma') == $turma->id): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($turma->id); ?>" selected> <?php echo e($turma->descricao); ?> </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e($turma->id); ?>"> <?php echo e($turma->descricao); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('turma')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('turma')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 <?php echo e($errors->has('disciplina') ? ' has-error' : ''); ?>">
                            <label for="disciplina" class="col-md-3 control-label">Disciplina:</label>
                            <div class="col-md-8">
                                <select class="form-control text-uppercase" data-dependent="" data-live-search="true" id="disciplina3" name="disciplina" disabled>
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
                                </select>

                                <?php if($errors->has('disciplina')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('disciplina')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0"> 
                        <div class="form-group col-md-12 <?php echo e($errors->has('observacao') ? ' has-error' : ''); ?>">
                            <label for="observacao" class="col-md-3 control-label">Observação:</label>
                            <div class="col-md-8">
                                <textarea style="resize: none" class="form-control text-uppercase" rows="3" data-live-search="true" id="observacao" name="observacao"><?php if(!empty(old('observacao'))): ?><?php echo e(old('observacao')); ?><?php endif; ?>
                                </textarea>

                                <?php if($errors->has('observacao')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('observacao')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 <?php echo e($errors->has('qtd') ? ' has-error' : ''); ?>">
                            <label class="col-md-3 control-label" for="qtd">Quantidade:</label>
                            <div class="col-md-8">
                                <select class="selectpicker form-control" name="qtd" id="qtd">
                                    <option data-tokens="ketchup mustard" value="0" selected >SELECIONE A QUANTIDADE</option>
                                    <?php for($i = 1; $i <= 8; $i++): ?>
                                        <?php if(old('qtd') == $i): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e($i); ?>" ><?php echo e($i); ?></option>
                                    <?php endfor; ?>
                                </select>

                                <?php if($errors->has('qtd')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('qtd')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 col-md-offset-0">
                        <div class="form-group col-md-12 <?php echo e($errors->has('dia') ? ' has-error' : ''); ?>">
                            <label for="dia" class="col-md-3 control-label">Dia: </label>

                            <div class="col-md-8">
                                <input id="dia" type="date" class="form-control" name="dia" value="<?php echo e(old('dia')); ?>">

                                <?php if($errors->has('dia')): ?>
                                    <span class="help-block">
                                    <strong><?php echo e($errors->first('dia')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>

                      <div class="form-group col-md-12 <?php echo e($errors->has('arquivo') ? ' has-error' : ''); ?>">
                        <label for="arquivo" class="col-md-3 control-label">Anexar Folha: </label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file" id="arquivo" name="arquivo" value="<?php echo e(old('arquivo')); ?>">
                            
                            <?php if($errors->has('arquivo')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('arquivo')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

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
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="situacao" value="ESP">   
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>