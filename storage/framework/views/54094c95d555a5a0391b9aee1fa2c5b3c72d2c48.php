<?php $__env->startSection('titulo','Relatórios'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.relatorio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Relatórios</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div id="container-pesquisar" class="row col-md-10 col-md-offset-1" data-curso="<?php echo e(Auth::user()->professor->curso->id); ?>">

                        <div class="form-group col-md-6 <?php echo e($errors->has('ano') ? ' has-error' : ''); ?>">
                            <label for="ano" class="col-md-2 control-label">Ano: </label>

                            <div class="col-md-8">
                                <select class="selectpicker form-control text-uppercase" name="ano" id="ano">
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O ANO --- </option>
                                    <?php $__currentLoopData = $anos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anoAbr => $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('ano') == $anos[$anoAbr]->ano): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($anos[$anoAbr]->ano); ?>" selected> <?php echo e($anos[$anoAbr]->ano); ?> </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e($anos[$anoAbr]->ano); ?>"><?php echo e($anos[$anoAbr]->ano); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('ano')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('ano')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 <?php echo e($errors->has('semestre') ? ' has-error' : ''); ?>">
                            <label for="semestre" class="col-md-3 control-label">Semestre: </label>

                            <div class="col-md-9">
                                <select class="form-control text-uppercase" data-dependent="professor" data-live-search="true" id="semestre" name="semestre" disabled>
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O SEMESTRE --- </option>
                                </select>

                                <?php if($errors->has('semestre')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('semestre')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-md-offset-6 <?php echo e($errors->has('professor') ? ' has-error' : ''); ?>">
                            <label for="professor" class="col-md-3 control-label">Professor: </label>

                            <div class="col-md-9">
                                <select class="form-control text-uppercase" data-live-search="true" id="professor" name="professor" disabled>
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O SEMESTRE --- </option>
                                </select>

                                <?php if($errors->has('professor')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('professor')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div id="table-relatorio" class="table-responsive col-md-12" style="display: none;">

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center">Faltas</th>
                                    <th class="text-center">Anteposições</th>
                                    <th class="text-center">Reposições</th>
                                </tr>
                            </thead>

                        	<tr class="row text-uppercase">
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                        <a id="download-falta" target=_blank class='btn' data-url="<?php echo e(route('relatorio.falta',['download' => 'download'])); ?>" href="#" style="background: #008000;color: #fff">
                                            <span class="glyphicon glyphicon-download"></span> Download
                                        </a>  

                                        <a class="btn"></a>
                                        
                                        <a id="visualizar-falta" target=_blank class='btn' data-url="<?php echo e(route('relatorio.falta')); ?>" href="#" style="background: #4682B4;color: #fff">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                        </a>
                                    </div>
                                </td>

                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                        <a id="download-anteposicao" target=_blank class='btn' data-url="<?php echo e(route('relatorio.anteposicao','download')); ?>" href="#" style="background: #008000;color: #fff">
                                            <span class="glyphicon glyphicon-download"></span> Download
                                        </a>  

                                        <a class="btn"></a>
                                        
                                        <a id="visualizar-anteposicao" target=_blank class='btn' data-url="<?php echo e(route('relatorio.anteposicao')); ?>" href="#" style="background: #4682B4;color: #fff">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                        </a>
                                    </div>
                                </td>

                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                        <a id="download-reposicao" target=_blank class='btn' data-url="<?php echo e(route('relatorio.reposicao','download')); ?>" href="#" style="background: #008000;color: #fff">
                                            <span class="glyphicon glyphicon-download"></span> Download
                                        </a>  

                                        <a class="btn"></a>
                                        
                                        <a id="visualizar-reposicao" target=_blank class='btn' data-url="<?php echo e(route('relatorio.reposicao')); ?>" href="#" style="background: #4682B4;color: #fff">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>