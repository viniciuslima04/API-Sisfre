

<?php $__env->startSection('titulo','Faltas do Curso'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.update-tables', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Faltas do Curso</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if($faltasVerificadas->count() == 0 && empty($pesquisa) && empty($situacao) && empty($semestre) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há faltas cadastradas para o curso: <br><b> <?php echo e(auth()->user()->professor->curso->nome); ?></b>.
                        </div>

                    <?php elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && !empty($situacao) && !empty($semestre) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                <?php if($situacao == "ESP"): ?>
                                    Aguardando Confirmação
                                <?php elseif($situacao == "CONF"): ?>
                                    Aguardando reposição
                                <?php elseif($situacao == "PAGA_P"): ?>
                                    Reposta parcialmente
                                <?php elseif($situacao == "PAGA_T"): ?>
                                    Totalmente reposta
                                <?php elseif($situacao == "VENC"): ?>
                                    Não Reposta
                                <?php elseif($situacao == "NEG"): ?>
                                    Cancelada
                                <?php endif; ?> 
                            </b> foi encontrada para o/a professor(a): <br><b class="text-uppercase"> <?php echo e($pesquisa); ?> </b> no semestre dado, para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    <?php elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && empty($semestre) && empty($situacao) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para o/a professor(a): <br> <b class="text-uppercase"> <?php echo e($pesquisa); ?></b> neste curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    <?php elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && !empty($semestre) && empty($situacao)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para o/a professor(a): <br> <b class="text-uppercase"> <?php echo e($pesquisa); ?></b> no semestre dado, para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    <?php elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && empty($semestre) && !empty($situacao)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                <?php if($situacao == "ESP"): ?>
                                    Aguardando Confirmação
                                <?php elseif($situacao == "CONF"): ?>
                                    Aguardando reposição
                                <?php elseif($situacao == "PAGA_P"): ?>
                                    Reposta parcialmente
                                <?php elseif($situacao == "PAGA_T"): ?>
                                    Totalmente reposta
                                <?php elseif($situacao == "VENC"): ?>
                                    Não Reposta
                                <?php elseif($situacao == "NEG"): ?>
                                    Cancelada
                                <?php endif; ?>
                            </b> foi encontrada para o/a professor(a): <br> <b class="text-uppercase"> <?php echo e($pesquisa); ?> </b> neste curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    <?php elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && !empty($semestre) && !empty($situacao)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                <?php if($situacao == "ESP"): ?>
                                    Aguardando Confirmação
                                <?php elseif($situacao == "CONF"): ?>
                                    Aguardando reposição
                                <?php elseif($situacao == "PAGA_P"): ?>
                                    Reposta parcialmente
                                <?php elseif($situacao == "PAGA_T"): ?>
                                    Totalmente reposta
                                <?php elseif($situacao == "VENC"): ?>
                                    Não Reposta
                                <?php elseif($situacao == "NEG"): ?>
                                    Cancelada
                                <?php endif; ?>
                            </b> foi encontrada no semestre dado, para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    <?php elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && empty($semestre) && !empty($situacao)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                <?php if($situacao == "ESP"): ?>
                                    Aguardando Confirmação
                                <?php elseif($situacao == "CONF"): ?>
                                    Aguardando reposição
                                <?php elseif($situacao == "PAGA_P"): ?>
                                    Reposta parcialmente
                                <?php elseif($situacao == "PAGA_T"): ?>
                                    Totalmente reposta
                                <?php elseif($situacao == "VENC"): ?>
                                    Não Reposta
                                <?php elseif($situacao == "NEG"): ?>
                                    Cancelada
                                <?php endif; ?>
                            </b> foi encontrada para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    <?php elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && !empty($semestre) && empty($situacao)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada no semestre dado, para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('falta.show.coordenador')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    <?php else: ?>

                    <div id="container-pesquisar" class="row col-md-10 col-md-offset-1">
                          <form method="GET" action="<?php echo e(route('falta.show.coordenador')); ?>">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pelo nome do professor" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-6 <?php echo e($errors->has('situacao') ? ' has-error' : ''); ?>">
                                <label class="col-md-3 control-label" for="filtro">Situação:</label>
                                <div class="col-md-9">
                                    <select class="selectpicker form-control text-uppercase" name="situacao" id="situacao">
                                        <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO</option>
                                        <?php if(!empty($situacao)): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($situacao); ?>" selected>
                                                <?php if($situacao == "ESP"): ?>
                                                    Aguardando Confirmação
                                                <?php elseif($situacao == "CONF"): ?>
                                                    Aguardando reposição
                                                <?php elseif($situacao == "PAGA_P"): ?>
                                                    Reposta parcialmente
                                                <?php elseif($situacao == "PAGA_T"): ?>
                                                    Totalmente reposta
                                                <?php elseif($situacao == "VENC"): ?>
                                                    Não Reposta
                                                <?php elseif($situacao == "NEG"): ?>
                                                    Cancelada
                                                <?php endif; ?>
                                            </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="ESP" >Aguardando confirmação</option>
                                        <option data-tokens="ketchup mustard" value="CONF" >Aguardando reposição</option>
                                        <option data-tokens="ketchup mustard" value="PAGA_P" >Reposta parcialmente</option>
                                        <option data-tokens="ketchup mustard" value="PAGA_T" >Totalmente reposta</option>
                                        <option data-tokens="ketchup mustard" value="VENC" >Não Reposta</option>
                                        <option data-tokens="ketchup mustard" value="NEG" >Cancelada</option>
                                    </select>

                                    <?php if($errors->has('situacao')): ?>
                                        <span class="help-block">
                                             <strong><?php echo e($errors->first('situacao')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-md-offset-6 <?php echo e($errors->has('semestre') ? ' has-error' : ''); ?>">
                                <label class="col-md-3 control-label" for="semestre">Semestre:</label>
                                <div class="col-md-9">
                                    <select class="selectpicker form-control text-uppercase" name="semestre" id="semestre">
                                        <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO </option>

                                        <?php $__currentLoopData = $semAtivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestreAtivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if(old('semestre') == $semestreAtivo->id): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($semestreAtivo->id); ?>" selected> <?php echo e($semestreAtivo->ano); ?>.<?php echo e($semestreAtivo->etapa); ?> (<?php echo e($semestreAtivo->tipo); ?>) </option>   
                                            <?php endif; ?>

                                            <?php if($semestre == $semestreAtivo->id): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($semestreAtivo->id); ?>" selected> <?php echo e($semestreAtivo->ano); ?>.<?php echo e($semestreAtivo->etapa); ?> (<?php echo e($semestreAtivo->tipo); ?>) </option>   
                                            <?php endif; ?>

                                            <option data-tokens="ketchup mustard" value="<?php echo e($semestreAtivo->id); ?>"> <?php echo e($semestreAtivo->ano); ?>.<?php echo e($semestreAtivo->etapa); ?> (<?php echo e($semestreAtivo->tipo); ?>) </option>   
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>

                                    <?php if($errors->has('semestre')): ?>
                                        <span class="help-block">
                                             <strong><?php echo e($errors->first('semestre')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>  
                          </form>
                    </div>


                    <div class="table-responsive col-md-12" id="tabela-update">
                        <div class="row col-md-12 col-md-offset-0">
                            <div class="form-group pull-right">
                            </div>  
                        </div>

                        <div class="row col-md-12 col-md-offset-0 align-left">     
                            <div class="col cliente-labels">                                        
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Totalmente Paga</span></p>
                                <p><i class="fa fa-square" style="color: #98FB98;"></i><span>Parcialmente Paga</span></p>
                                <p><i class="fa fa-square" style="color: #FF6347;"></i><span>Não Reposta</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Aguardando Reposição</span></p>
                                <p><i class="fa fa-square" style="color: #87CEEB;"></i><span>Aguardando Confirmação</span></p>
                                <p><i class="fa fa-square" style="color: #FF00FF;"></i><span>Cancelada</span></p>
                            </div>
                        </div>
                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center" style="vertical-align: middle;">SITUAÇÃO</th>
                                    <th class="text-center" style="vertical-align: middle;">Professor</th>
                                    <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                                    <th class="text-center" style="vertical-align: middle;">Turma</th>
                                    <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                                    <th class="text-center" style="vertical-align: middle;">Dia</th>
                                    <th class="text-center" style="vertical-align: middle;">Repôr até</th>
                                    <th class="text-center" style="vertical-align: middle;">Justificativa</th>
                                    <th class="text-center" style="vertical-align: middle;">Ação</th>
                                </tr>
                            </thead>
                            <?php $__currentLoopData = $faltasVerificadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $falta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php if($falta->situacao == 'CONF'): ?>
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($falta->situacao == 'PAGA_P'): ?>
                                            <a class="action" style="background-color: #98FB98; color: #98FB98;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($falta->situacao == 'PAGA_T'): ?>
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($falta->situacao == 'VENC'): ?>
                                            <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($falta->situacao == 'ESP'): ?>
                                            <a class="action" style="background-color: #87CEEB; color: #87CEEB;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($falta->situacao == 'NEG'): ?>
                                            <a class="action" style="background-color: #FF00FF; color: #FF00FF;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($falta->professor); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($falta->disciplina); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($falta->turma); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($falta->qtd); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e(implode("/", array_reverse(explode("-", $falta->dia)))); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e(implode("/", array_reverse(explode("-", $falta->validade)))); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e(isset($falta->obs) ? $falta->obs : '-'); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            <?php if($falta->situacao == 'ESP' || $falta->situacao == 'NEG'): ?>
                                                <a class="btn btn-success" data-toggle="modal" data-target="#modal_confirmar_remover" data-entidade="falta" data-url="<?php echo e(route('falta.confirmar',$falta->id)); ?>" data-modo="confirmar"> 
                                                    <span class="glyphicon glyphicon-ok"></span> Confirmar
                                                </a>

                                                <a class="btn"></a>
                                            <?php endif; ?>
                                            <?php if($falta->situacao != 'NEG' && $falta->situacao != 'VENC'): ?>
                                                <a class="btn btn-danger" data-toggle="modal" data-target="#modal_confirmar_remover" data-entidade="falta" data-url="<?php echo e(route('falta.cancelar',$falta->id)); ?>" data-modo="remover">
                                                    <span class="glyphicon glyphicon-remove" ></span> Cancelar
                                                </a>

                                                <a class="btn"></a>
                                            <?php endif; ?>
                                            <?php if($falta->situacao == 'VENC'): ?>
                                                <?php if($falta->anteposicoes->isEmpty()): ?>
                                                    <?php if($falta->reposicoes->where('situacao','=','ESP')->isEmpty() || $falta->reposicoes->where('situacao','=','ESP')->where('qtd','<',$falta->qtd)->count() == 1 || $falta->reposicoes->where('situacao','=','CONF')->where('qtd','<',$falta->qtd)->count() == 1 && $falta->reposicoes->where('situacao','=','ESP')->isEmpty()): ?>
                                                        <a class='btn btn-info' href="<?php echo e(route('reposicao.create',['coordenador', $falta->id])); ?>">
                                                            <span class="glyphicon glyphicon-plus"></span> Reposição
                                                        </a>

                                                        <a class="btn"></a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if($falta->reposicoes->where('situacao','=','ESP')->isEmpty()): ?>
                                                        <a class='btn btn-info' href="<?php echo e(route('reposicao.create',['coordenador', $falta->id])); ?>">
                                                            <span class="glyphicon glyphicon-plus"></span> Reposição
                                                        </a>

                                                        <a class="btn"></a>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>

                        <?php echo e($faltasVerificadas->appends(['pesquisa' => $pesquisa, 'situacao' => $situacao, 'semestre' => $semestre])->links()); ?>


                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
    <?php echo $__env->make('layout.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>