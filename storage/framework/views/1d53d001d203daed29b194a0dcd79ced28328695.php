

<?php $__env->startSection('titulo','Meu Horário'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.horarioProfessor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-12 col-md-offset-0">
    <div class="panel panel-default">
        <div class="panel-heading">Meu Horário</div>
            <div class="panel-body">
                <?php if(isset($aulas) && $aulas->count() != 0): ?>
                    <div class="row col-md-8 col-md-offset-2">
                        <div class="form-group col-md-10 col-md-offset-1 nome <?php echo e($errors->has('nome') ? ' has-error' : ''); ?>">
                            <label for="nome" class="col-md-2 control-label">Professor:</label>
                            <div class="col-md-9">
                                <input id="nome" type="text" class="text-uppercase text-center form-control" name="nome" value="<?php echo e(Auth::user()->abreviatura); ?> - <?php echo e(Auth::user()->username); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div id="tabela1" class="row col-md-12 col-md-offset-0">


                            <div class="table-responsive col-md-12">
                                
                                <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em;">
                                    <div class="titulo"> 
                                        <h4 class="text-center text-uppercase">
                                            <strong> HORÁRIO DA MANHÃ: </strong>
                                        </h4>
                                    </div>
                                </div>

                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center">AULA</th>
                                            <th class="text-center">SEGUNDA</th>
                                            <th class="text-center">TERÇA</th>
                                            <th class="text-center">QUARTA</th>
                                            <th class="text-center">QUINTA</th>
                                            <th class="text-center">SEXTA</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for($aula = 1; $aula <= 4; $aula++ ): ?>
                                            <tr class="row text-uppercase">
                                                <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula); ?>ª AULA </td>
                                                <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                    <td id="aula<?php echo e($aula); ?><?php echo e($dia); ?>" class="text-center" data-qtd="<?php echo e($aulas->where('dia','=',$dia)->where('aula','=',$aula)->count()); ?>" style="vertical-align: middle;">
                                                        <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                            <?php $__currentLoopData = $aulas->where('aula','=',$aula)->where('dia','=',$dia); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aul): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php echo e($aul->sigla); ?> - S<?php echo e($aul->turma_semestre); ?> <?php echo e($aul->curso); ?>

                                                                <?php if($loop->iteration != $loop->last): ?>
                                                                    <br>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>        
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>

                                <div class="row col-md-10 col-md-offset-1">
                                    <div id="alert1" class="text-center alert alert-danger alert-block" style="display: none">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong id="table1"></strong>
                                    </div>
                                </div>

                            </div>

                            <div class="table-responsive col-md-12">

                                <div class="row col-md-8 col-md-offset-2">
                                    <div class="titulo"> 
                                        <h4 class="text-center text-uppercase">
                                            <strong> HORÁRIO DA TARDE: </strong>
                                        </h4>
                                    </div>
                                </div>

                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center">AULA</th>
                                            <th class="text-center">SEGUNDA</th>
                                            <th class="text-center">TERÇA</th>
                                            <th class="text-center">QUARTA</th>
                                            <th class="text-center">QUINTA</th>
                                            <th class="text-center">SEXTA</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for($aula = 5; $aula <= 8; $aula++ ): ?>
                                            <tr class="row text-uppercase">
                                                <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 4); ?>ª AULA </td>
                                                <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                    <td id="aula<?php echo e($aula); ?><?php echo e($dia); ?>" class="text-center" data-qtd="<?php echo e($aulas->where('dia','=',$dia)->where('aula','=',$aula)->count()); ?>" style="vertical-align: middle;">
                                                        <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                            <?php $__currentLoopData = $aulas->where('aula','=',$aula)->where('dia','=',$dia); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aul): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php echo e($aul->sigla); ?> - S<?php echo e($aul->turma_semestre); ?> <?php echo e($aul->curso); ?>

                                                                <?php if($loop->iteration != $loop->last): ?>
                                                                    <br>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>        
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>

                                <div class="row col-md-10 col-md-offset-1">
                                    <div id="alert2" class="text-center alert alert-danger alert-block" style="display: none">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong id="table2"></strong>
                                    </div>
                                </div>

                            </div>

                            <div class="table-responsive col-md-12">

                                <div class="row col-md-8 col-md-offset-2">
                                    <div class="titulo"> 
                                        <h4 class="text-center text-uppercase">
                                            <strong> HORÁRIO DA NOITE: </strong>
                                        </h4>
                                    </div>
                                </div>

                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center">AULA</th>
                                            <th class="text-center">SEGUNDA</th>
                                            <th class="text-center">TERÇA</th>
                                            <th class="text-center">QUARTA</th>
                                            <th class="text-center">QUINTA</th>
                                            <th class="text-center">SEXTA</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for($aula = 9; $aula <= 12; $aula++ ): ?>
                                            <tr class="row text-uppercase">
                                                <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 8); ?>ª AULA </td>
                                                <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                    <td id="aula<?php echo e($aula); ?><?php echo e($dia); ?>" class="text-center" data-qtd="<?php echo e($aulas->where('dia','=',$dia)->where('aula','=',$aula)->count()); ?>" style="vertical-align: middle;">
                                                        <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                            <?php $__currentLoopData = $aulas->where('aula','=',$aula)->where('dia','=',$dia); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aul): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php echo e($aul->sigla); ?> - S<?php echo e($aul->turma_semestre); ?> <?php echo e($aul->curso); ?>

                                                                <?php if($loop->iteration != $loop->last): ?>
                                                                    <br>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>        
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>

                                <div class="row col-md-10 col-md-offset-1">
                                    <div id="alert3" class="text-center alert alert-danger alert-block" style="display: none">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong id="table3"></strong>
                                    </div>
                                </div>
                            </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning btn-lg col-md-6 col-md-offset-3 danger text-center">
                        <span class="glyphicon glyphicon-warning-sign"></span> Não há aulas associadas a você!!
                    </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-home"></span> home
                                </a>   
                            </div>
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>