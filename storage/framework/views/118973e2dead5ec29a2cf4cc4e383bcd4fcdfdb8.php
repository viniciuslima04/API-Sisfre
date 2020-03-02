<?php if(!empty($professores) ): ?>                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O PROFESSOR --- </option>
    <?php $__currentLoopData = $professores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(old('professor') == $prof->id): ?>
            <option data-tokens="ketchup mustard" value="<?php echo e($prof->id); ?>" selected> <?php echo e($prof->username); ?> </option>
        <?php endif; ?>
        <option data-tokens="ketchup mustard" value="<?php echo e($prof->id); ?>"> <?php echo e($prof->username); ?> </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>