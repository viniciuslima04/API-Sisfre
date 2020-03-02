<?php if(!empty($disciplinasOptativas && !empty($quantidade)) ): ?>                                
    <div class="titulo" id="titulo" data-qtdOptativas="<?php echo e($quantidade); ?>"> 
        <h4 class="text-center">Selecione a(s) disciplina(s) optativa(s) ofertada(s):</h4>
    </div>

    <div class="form-group col-md-12"></div>

    <?php for($i = 1; $i<=$quantidade;$i++): ?>
        <div class="form-group col-md-12 optativa<?php echo e($i); ?>">
            <label for="optativa<?php echo e($i); ?>" class="col-md-2 col-md-offset-1 control-label">Optativa <?php echo e($i); ?>:</label>
            <div class="col-md-8">
                <select class="selectpicker form-control text-uppercase" name="optativa[]" id="optativa<?php echo e($i); ?>">
                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A DISCIPLINA --- </option>
                    <?php $__currentLoopData = $disciplinasOptativas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('optativa.$i') == $discOpt->id): ?>
                            <option data-tokens="ketchup mustard" value="<?php echo e($discOpt->id); ?>" selected> <?php echo e($$discOpt->nome); ?> </option>
                        <?php endif; ?>
                        <option data-tokens="ketchup mustard" value="<?php echo e($discOpt->id); ?>"> <?php echo e($discOpt->nome); ?> </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="form-group col-md-12">
                    <strong id="optativa<?php echo e($i); ?><?php echo e($i); ?>"></strong>
                </span>
            </div>
        </div>
    <?php endfor; ?>

<?php endif; ?>