<?php $__env->startSection('titulo','Relatório de Professores'); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row container-fluid">
    <div class="col-xs-12 col-xs-offset-0">
        <div class="row col-xs-12 col-xs-offset-0">

            <div class="row col-xs-8 col-xs-offset-2">
                <div class="titulo"> 
                    <h4 class="text-center text-uppercase" style="font-size: 1.2em">
                        <b>RELATÓRIO DE PROFESSORES</b>
                    </h4>
                </div>
            </div>


            <table class="table table-striped bunitu" style="font-size: 0.85em">
                <thead class="btn-primary">
                    <tr class="row text-uppercase">
                        <th class="text-center" style="vertical-align: middle;">Professor</th>
                        <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                        <th class="text-center" style="vertical-align: middle;">Curso</th>
                        <th class="text-center" style="vertical-align: middle;">Turma</th>
                        <th class="text-center" style="vertical-align: middle;">Presente</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $aulas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="row text-uppercase">

                            <?php if($turno == 'M'): ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->professor_nome); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->disciplina); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->curso); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->turma); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>

                            <?php elseif($turno == 'T'): ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->professor_nome); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->disciplina); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->curso); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->turma); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>

                            <?php elseif($turno == 'N'): ?>

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->professor_nome); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->disciplina); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->curso); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula->turma); ?> </td>
                                    <td class="text-center" style="vertical-align: middle;">  <input type="text" name="option[]" style="width: 2em"></td>
                                </tr>
                            
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('relatorio.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>