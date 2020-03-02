<?php $__env->startSection('titulo','Horário da Turma'); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="col-md-12 col-md-offset-0">
    <div class="panel panel-default">
        <div class="panel-heading">Horário da Turma</div>
            <div class="panel-body">
                <?php if(isset($aulas) && $aulas->count() != 0): ?>
                    <div class="row col-md-8 col-md-offset-2">
                        <div class="form-group col-md-10 col-md-offset-1 turma <?php echo e($errors->has('turma') ? ' has-error' : ''); ?>">
                            <label for="turma" class="col-md-2 control-label">Turma:</label>
                            <div class="col-md-9">
                                <input id="turma" type="text" class="text-uppercase text-center form-control" name="turma" value="<?php echo e($turma->descricao); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div id="tabela" class="row col-md-12 col-md-offset-0">
                        <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em; margin-bottom: -1em">
                            <div id="titulo" class="titulo" data-qtd_disciplina="<?php echo e($aulas->count()); ?>" data-turno="<?php echo e($turma->turno); ?>"> 
                                <h4 class="text-center text-uppercase">
                                    <strong> HORÁRIO 
                                        <?php if($turma->turno == 'M' || $turma->turno == 'D'): ?> DA MANHÃ:
                                        <?php elseif($turma->turno == 'T'): ?> DA TARDE:
                                        <?php elseif($turma->turno == 'N'): ?> DA NOITE:
                                        <?php endif; ?>
                                    </strong>
                                </h4>
                            </div>
                        </div>

                        <div class="table-responsive col-md-12">
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
                                <?php if($turma->turno == 'M' || $turma->turno == 'D'): ?>
                                    <?php for($aula = 1; $aula <= 4; $aula++ ): ?>
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula); ?>ª AULA </td>
                                            <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                <td class="text-center">
                                                    <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                        <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->sigla); ?> - <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->apelido); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endfor; ?>
                                <?php elseif($turma->turno == 'T'): ?>
                                    <?php for($aula = 5; $aula <= 8; $aula++ ): ?>
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 4); ?>ª AULA </td>
                                            <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                <td class="text-center">
                                                    <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                        <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->sigla); ?> - <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->apelido); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endfor; ?>
                                <?php elseif($turma->turno == 'N'): ?>
                                    <?php for($aula = 9; $aula <= 12; $aula++ ): ?>
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 8); ?>ª AULA </td>
                                            <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                <td class="text-center">
                                                    <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                        <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->sigla); ?> - <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->apelido); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </table>
                        </div>

                        <?php if($turma->turno == 'D'): ?>
                            <div class="row col-md-8 col-md-offset-2" style="margin-top: -0.6em;margin-bottom: -2em">
                                <div class="titulo"> 
                                    <h4 class="text-center text-uppercase">
                                        <strong> HORÁRIO DA TARDE: </strong>
                                    </h4>
                                </div>
                            </div>

                            <div class="table-responsive col-md-12">
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

                                    <?php for($aula = 5; $aula <= 8; $aula++ ): ?>
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 4); ?>ª AULA </td>
                                            <?php for($dia = 1; $dia <= 5; $dia++): ?>
                                                <td class="text-center">
                                                    <?php if($aulas->where('aula','=',$aula)->where('dia','=',$dia)->isNotEmpty()): ?>
                                                        <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->sigla); ?> - <?php echo e($aulas->where('aula','=',$aula)->where('dia','=',$dia)->first()->apelido); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>

                                        </tr>
                                    <?php endfor; ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row col-md-12">

                        <div class="row col-md-8 col-md-offset-2" style="margin-bottom: 2em">
                            <div class="titulo"> 
                                <h4 class="text-center text-uppercase">
                                    <strong> LEGENDAS: </strong>
                                </h4>
                            </div>
                        </div>
                      
                        <?php $__currentLoopData = $aulas->groupBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc_id => $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="row col-md-12">
                                <div class="form-group col-md-6 disciplina<?php echo e($disc_id); ?>">
                                    <div class="col-md-12">
                                        <input id="disciplina<?php echo e($loop->iteration); ?>" name="disciplina[<?php echo e($disc_id); ?>]" maxlength="160" value="<?php echo e($disc[0]->sigla); ?> - <?php echo e($disc[0]->nome); ?>" data-id="<?php echo e($disc_id); ?>" class="form-control input-md" type="text" readonly>
                                    </div>

                                </div>

                                <div class="form-group col-md-6 professor<?php echo e($disc_id); ?>" >
                                    <label class="col-md-3 control-label" for="professor" >Professor:</label>
                                    <div class="col-md-9">
                                        <input id="disciplina<?php echo e($loop->iteration); ?>" name="disciplina[<?php echo e($disc_id); ?>]" maxlength="160" value="<?php echo e($disc[0]->apelido); ?> - <?php echo e($disc[0]->professor_nome); ?>" class="form-control input-md text-uppercase" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="form-group col-md-12" ></div>
                    <div class="form-group col-md-12" ></div>

                    <div class="row col-md-7 col-md-offset-3">
                        <div class="form-group col-md-5">
                            <a class='btn btn-block btn-lg btn-success' href="<?php echo e(route('horario.edit',$turma->id)); ?>">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </a>       
                        </div>

                        <div class="form-group col-md-2" ></div>

                        <div class="form-group col-md-5">
                            <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning btn-lg col-md-6 col-md-offset-3 danger text-center">
                        <span class="glyphicon glyphicon-warning-sign"></span> Não há aulas associadas a essa turma
                    </div>

                    <div class="row col-md-2 col-md-offset-0">
                        <div class="form-group text-center text-uppercase">
                            <a href="<?php echo e(route('turma.create',$turma->id)); ?>" class="btn btn-block btn-lg btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> HORÁRIO
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