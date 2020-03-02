<?php $__env->startSection('titulo','Relatório'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.relatorioFuncionario', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Relatório</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div id="container-pesquisar" class="row col-md-10 col-md-offset-1">

                        <div class="form-group col-md-6 <?php echo e($errors->has('dia') ? ' has-error' : ''); ?>">
                            <label for="dia" class="col-md-2 control-label">Dia: </label>

                            <div class="col-md-8">
                                <select class="selectpicker form-control text-uppercase" name="dia" id="dia">
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O DIA --- </option>

                                        <?php if(old('dia')): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e(old('dia')); ?>" selected> 
                                                <?php if(old('dia') == 1): ?>
                                                    SEGUNDA-FEIRA
                                                <?php elseif(old('dia') == 2): ?>
                                                    TERÇA-FEIRA
                                                <?php elseif(old('dia') == 3): ?>
                                                    QUARTA-FEIRA
                                                <?php elseif(old('dia') == 4): ?>
                                                    QUINTA-FEIRA
                                                <?php elseif(old('dia') == 5): ?>
                                                    SEXTA-FEIRA
                                                <?php endif; ?>
                                             </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="1"> SEGUNDA-FEIRA </option>
                                        <option data-tokens="ketchup mustard" value="2"> TERÇA-FEIRA </option>
                                        <option data-tokens="ketchup mustard" value="3"> QUARTA-FEIRA </option>
                                        <option data-tokens="ketchup mustard" value="4"> QUINTA-FEIRA </option>
                                        <option data-tokens="ketchup mustard" value="5"> SEXTA-FEIRA </option>                                       
                                </select>

                                <?php if($errors->has('dia')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('dia')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 <?php echo e($errors->has('turno') ? ' has-error' : ''); ?>">
                            <label for="turno" class="col-md-3 control-label">Semestre: </label>

                            <div class="col-md-9">
                                <select class="form-control text-uppercase" data-live-search="true" id="turno" name="turno" disabled>
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O TURNO --- </option>

                                        <?php if(old('turno')): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e(old('turno')); ?>" selected> 
                                                <?php if(old('turno') == 'M'): ?>
                                                    MANHÃ
                                                <?php elseif(old('turno') == 'N'): ?>
                                                    NOITE
                                                <?php elseif(old('turno') == 'T'): ?>
                                                    TARDE
                                                <?php endif; ?>
                                             </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="M"> MANHÃ </option>
                                        <option data-tokens="ketchup mustard" value="N"> NOITE </option>
                                        <option data-tokens="ketchup mustard" value="T"> TARDE </option>
                                </select>

                                <?php if($errors->has('turno')): ?>
                                    <span class="help-block">
                                         <strong><?php echo e($errors->first('turno')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div id="table-relatorio" class="col-md-8 col-md-offset-2" style="display: none">
                        
                        <a href="#" id="visualizar-professor" data-url="<?php echo e(route('relatorio.professor')); ?>" style="text-decoration: none; font-weight: bold;" >
                            <div class="col-md-6">
                                <div class="panel panel-default" align="center">
                                    <div class="panel-heading"> VISUALIZAR RELATÓRIO </div>
                                    <div class="panel-body" style="text-align: center;">
                                        <i class="glyphicon glyphicon-eye-open" style = "font-size: 50px"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                     
                        <a href="#" id="download-professor" data-url="<?php echo e(route('relatorio.professor',['download' => 'download'])); ?>" style="text-decoration: none; font-weight: bold;">
                            <div class="col-md-6">
                                <div class="panel panel-default" align="center">
                                    <div class="panel-heading">DOWNLOAD RELATÓRIO</div>
                                    <div class="panel-body" style="text-align: center;">
                                        <i class="glyphicon glyphicon-download" style = "font-size: 50px"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>