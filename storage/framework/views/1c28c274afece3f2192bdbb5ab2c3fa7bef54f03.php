<?php if(!empty($professores) ): ?>                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O PROFESSOR --- </option>
    <?php $__currentLoopData = $professores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $professor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(old('professor') == $professor->professor_id): ?>
            <option data-tokens="ketchup mustard" value="<?php echo e($professor->professor_id); ?>" selected> <?php echo e($professor->username); ?>) </option>
        <?php endif; ?>
        <option data-tokens="ketchup mustard" value="<?php echo e($professor->professor_id); ?>"> <?php echo e($professor->username); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>