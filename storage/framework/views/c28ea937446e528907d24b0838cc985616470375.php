<?php if(!empty($disciplinas) ): ?>                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A DISCIPLINA --- </option>
    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(old('disciplina') == $disc->id): ?>
            <option data-tokens="ketchup mustard" value="<?php echo e($disc->id); ?>" selected> <?php echo e($disc->nome); ?> </option>
        <?php endif; ?>
        <option data-tokens="ketchup mustard" value="<?php echo e($disc->id); ?>"> <?php echo e($disc->nome); ?> </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>