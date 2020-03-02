<?php $__env->startSection('titulo','Controle de Disciplinas'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('scripts.disciplina-show', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="row container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row col-md-12 col-md-offset-0">
                        
                        <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <?php if($disciplinas->count() == 0 && empty($pesquisa) && empty($curso) && empty($periodo) ): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                                Não há disciplinas cadastradas no sistema.
                            </div>

                            <div class="row col-md-2 col-md-offset-5">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.create')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-plus"></span> Disciplina


                                    </a>   
                                </div>
                            </div>
                        
                        <?php elseif($disciplinas->count() == 0 && !empty($pesquisa) && !empty($curso) && !empty($periodo) ): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina: <b class="text-uppercase"><?php echo e($pesquisa); ?></b> encontrada para o curso:<br> 
                                <b class="text-uppercase"> <?php echo e($curso->nome); ?></b> no semestre: <b class="text-uppercase"> <?php echo e($periodo); ?> </b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        <?php elseif($disciplinas->count() == 0 && !empty($pesquisa) && empty($curso) && empty($periodo) ): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina: <b class="text-uppercase"><?php echo e($pesquisa); ?></b> foi encontrada no sistema.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        <?php elseif($disciplinas->count() == 0 && !empty($pesquisa) && !empty($curso) && empty($periodo)): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                 Nenhuma disciplina: <b class="text-uppercase"><?php echo e($pesquisa); ?></b> foi encontrada para o curso: <b class="text-uppercase"><?php echo e($curso->nome); ?></b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        <?php elseif($disciplinas->count() == 0 && !empty($pesquisa) && empty($curso) && !empty($periodo)): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                 Nenhuma disciplina: <b class="text-uppercase"><?php echo e($pesquisa); ?></b> foi encontrada para o semestre: <b class="text-uppercase"><?php echo e($periodo); ?></b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        <?php elseif($disciplinas->count() == 0 && empty($pesquisa) && !empty($curso) && !empty($periodo)): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina encontrada para o curso:<br> <b class="text-uppercase"> <?php echo e($curso->nome); ?></b> no semestre: <b class="text-uppercase"> <?php echo e($periodo); ?> </b>.
                            </div>
                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        <?php elseif($disciplinas->count() == 0 && empty($pesquisa) && empty($curso) && !empty($periodo)): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina foi encontrada para o semestre: <b class="text-uppercase"><?php echo e($etapa); ?> </b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        <?php elseif($disciplinas->count() == 0 && empty($pesquisa) && !empty($curso) && empty($periodo)): ?>
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina foi encontrada para o curso: <b class="text-uppercase"><?php echo e($curso->nome); ?></b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="<?php echo e(route('disciplina.show')); ?>" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        <?php else: ?>

                        <div id="container-pesquisar" class="row col-md-10 col-md-offset-1">
                              <form method="GET" action="<?php echo e(route('disciplina.show')); ?>">
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="<?php echo e(old('pesquisa','')); ?>" id="pesquisa" placeholder="Pesquise pelo nome da disciplina" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-6 <?php echo e($errors->has('curso') ? ' has-error' : ''); ?>">
                                    <label class="col-md-3 control-label" for="filtro">Curso:</label>
                                    <div class="col-md-9">
                                        <select class="selectpicker form-control text-uppercase" name="curso" id="curso">
                                            <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO</option>
                                            <?php if(!empty($curso)): ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($curso->id); ?>" data-semestres="<?php echo e($curso->duracao); ?>" selected>
                                                    <?php echo e($curso->nome); ?>

                                                </option>
                                            <?php endif; ?>

                                            <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(old('curso') == $curs->id): ?>
                                                    <option data-tokens="ketchup mustard" value="<?php echo e($curs->id); ?>" data-semestres="<?php echo e($curs->duracao); ?>" selected><?php echo e($curs->nome); ?></option> 
                                                <?php endif; ?>
                                                <option data-tokens="ketchup mustard" value="<?php echo e($curs->id); ?>" data-semestres="<?php echo e($curs->duracao); ?>"><?php echo e($curs->nome); ?></option> 
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <?php if($errors->has('curso')): ?>
                                            <span class="help-block">
                                                 <strong><?php echo e($errors->first('curso')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-md-offset-6 <?php echo e($errors->has('periodo') ? ' has-error' : ''); ?>">
                                    <label class="col-md-3 control-label" for="periodo">Semestre:</label>
                                    <div class="col-md-9">
                                        <select class="selectpicker form-control text-uppercase" name="periodo" id="periodo" disabled>
                                            <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO </option>

                                        </select>

                                        <?php if($errors->has('periodo')): ?>
                                            <span class="help-block">
                                                 <strong><?php echo e($errors->first('periodo')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>  
                              </form>
                        </div>

                        <div class="table-responsive col-md-12">
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group pull-right">
                                    <a href="<?php echo e(route('disciplina.create')); ?>" class="btn btn-primary text-uppercase" >
                                        <span class="glyphicon glyphicon-plus"></span> Disciplina
                                    </a>
                                </div>  
                            </div>
                            <table class="table table-striped bunitu">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center" style="vertical-align: middle;">Nome</th>
                                        <th class="text-center" style="vertical-align: middle;">Sigla</th>
                                        <th class="text-center" style="vertical-align: middle;">Cursos</th>
                                        <th class="text-center" style="vertical-align: middle;">Ação</th>
                                    </tr>
                                </thead>
                                <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <tr class="row text-uppercase">
                                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($disciplina->nome); ?> </td>
                                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($disciplina->sigla); ?> </td>
                                        <td class="text-center" style="vertical-align: middle;">

                                            <?php $__currentLoopData = $disciplina->cursos->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($curs->nome); ?> <br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group-xs btn-group-vertical btn-block">
                                                <a class='btn btn-info' href="<?php echo e(route('disciplina.edit',$disciplina->id)); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="disciplina" data-url="<?php echo e(route('disciplina.delete',$disciplina->id)); ?>">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>

                            <?php if(empty($curso)): ?>
                                <?php $cursoSelecionado = ''; ?>
                            <?php else: ?>
                                <?php $cursoSelecionado = $curso->id; ?>
                            <?php endif; ?>

                            <?php echo e($disciplinas->appends(['pesquisa' => $pesquisa, 'curso' => $cursoSelecionado, 'periodo' => $periodo])->links()); ?>

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