

<?php $__env->startSection('titulo','Minhas Reposições'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.update-tables', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Minhas Reposições</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if($reposicoes->count() == 0 && empty($pesquisa) && empty($filtro) ): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há reposições marcadas por você.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($reposicoes->count() == 0 && !empty($pesquisa) && !empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você na disciplina: <b class="text-uppercase"> <?php echo e($pesquisa); ?></b>
                            utilizando o filtro: 
                            <b>
                                <?php if($filtro == "ESP"): ?>
                                    Esperando confirmação
                                <?php elseif($filtro == "CONF"): ?>
                                    Confirmada
                                <?php elseif($filtro == "NEG"): ?>
                                    Negada
                                <?php endif; ?>  
                            </b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('reposicao.show.professor')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($reposicoes->count() == 0 && !empty($pesquisa) && empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você na disciplina: <b class="text-uppercase"> <?php echo e($pesquisa); ?></b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('reposicao.show.professor')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php elseif($reposicoes->count() == 0 && empty($pesquisa) && !empty($filtro)): ?>
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você no filtro: 
                            <b>
                                <?php if($filtro == "ESP"): ?>
                                    Esperando confirmação
                                <?php elseif($filtro == "CONF"): ?>
                                    Confirmada
                                <?php elseif($filtro == "NEG"): ?>
                                    Negada
                                <?php endif; ?>  
                            </b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="<?php echo e(route('reposicao.show.professor')); ?>" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    <?php else: ?>

                    <div class="row col-md-12 col-md-offset-0">
                          <form method="GET" action="<?php echo e(route('reposicao.show.professor')); ?>">
                            <div class="form-group col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pela disciplina" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-6 col-md-offset-1 <?php echo e($errors->has('filtro') ? ' has-error' : ''); ?>">
                                <label class="col-md-2 control-label" for="filtro">Filtro:</label>
                                <div class="col-md-8">
                                    <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                        <option data-tokens="ketchup mustard" value="" selected >SEM FILTRO</option>
                                        <?php if(!empty($filtro)): ?>
                                            <option data-tokens="ketchup mustard" value="<?php echo e($filtro); ?>" selected>
                                                <?php if($filtro == "ESP"): ?>
                                                    Esperando confirmação
                                                <?php elseif($filtro == "CONF"): ?>
                                                    Confirmada
                                                <?php elseif($filtro == "NEG"): ?>
                                                    Negada
                                                <?php endif; ?> 
                                            </option>
                                        <?php endif; ?>
                                        <option data-tokens="ketchup mustard" value="ESP" >Esperando confirmação</option>
                                        <option data-tokens="ketchup mustard" value="CONF" >Confirmada</option>
                                        <option data-tokens="ketchup mustard" value="NEG" >Negada</option>
                                    </select>

                                    <?php if($errors->has('filtro')): ?>
                                        <span class="help-block">
                                             <strong><?php echo e($errors->first('filtro')); ?></strong>
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
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Confirmada</span></p>
                                <p><i class="fa fa-square" style="color: #FF6347;"></i><span>Negada</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Esperando confirmação</span></p>
                            </div>
                        </div>

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center">Situação</th>
                                    <th class="text-center">Disciplina</th>
                                    <th class="text-center">Turma</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Dia</th>
                                    <th class="text-center">Observações</th>
                                    <th class="text-center">Folha de Reposição</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            <?php $__currentLoopData = $reposicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reposicao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;">

                                        <?php if($reposicao->situacao == 'CONF'): ?>
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($reposicao->situacao == 'NEG'): ?>
                                            <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php elseif($reposicao->situacao == 'ESP'): ?>
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($reposicao->disciplina); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($reposicao->turma); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($reposicao->qtd); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e(implode("/", array_reverse(explode("-", $reposicao->dia)))); ?> </td>

                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e(isset($reposicao->obs) ? $reposicao->obs : '-'); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                            <a target=_blank class='btn' href="<?php echo e(route('reposicao.download',$reposicao->id)); ?>" style="background: #008000;color: #fff">
                                                <span class="glyphicon glyphicon-download"></span> Download
                                            </a>  

                                            <a class="btn"></a>
                                            
                                            <a target=_blank class='btn' href="<?php echo e(route('reposicao.visualizar',$reposicao->id)); ?>" style="background: #4682B4;color: #fff">
                                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="btn-group-xs btn-group-vertical btn-block text-center">
                                        <?php if($reposicao->situacao == 'ESP' && $reposicao->usuario == 'PROFESSOR'): ?>
                                            <a class='btn btn-info' href="<?php echo e(route('reposicao.edit',['professor', $reposicao->id])); ?>">
                                                <span class="glyphicon glyphicon-edit"></span> Editar
                                            </a>
                                            <a class="btn"></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>

                        <?php echo e($reposicoes->appends(['pesquisa' => $pesquisa, 'filtro' => $filtro])->links()); ?>


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