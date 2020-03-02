<?php if(!empty($turmas) ): ?>                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
    <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(old('turma') == $turma->id): ?>
            <option data-tokens="ketchup mustard" value="<?php echo e($turma->id); ?>" selected> <?php echo e($turma->descricao); ?> </option>
        <?php endif; ?>
        <option data-tokens="ketchup mustard" value="<?php echo e($turma->id); ?>"> <?php echo e($turma->descricao); ?> </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>