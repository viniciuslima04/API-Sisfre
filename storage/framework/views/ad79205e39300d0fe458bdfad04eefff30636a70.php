<?php if(!empty($semestres) ): ?>                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O SEMESTRE --- </option>
    <?php $__currentLoopData = $semestres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(old('semestre1') == $semestr->id): ?>
            <option data-tokens="ketchup mustard" value="<?php echo e($semestr->id); ?>" selected> <?php echo e($semestr->ano); ?>.<?php echo e($semestr->etapa); ?> (<?php echo e($semestr->tipo); ?>) </option>
        <?php endif; ?>
        <option data-tokens="ketchup mustard" value="<?php echo e($semestr->id); ?>"> <?php echo e($semestr->ano); ?>.<?php echo e($semestr->etapa); ?> (<?php echo e($semestr->tipo); ?>) </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>