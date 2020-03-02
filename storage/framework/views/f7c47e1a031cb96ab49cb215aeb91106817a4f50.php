<?php if(!empty($cursos) && !empty($quantidade)): ?>
    <?php for($i=1; $i<=$quantidade; $i++): ?>
        <div class="panel panel-primary">
            <div class="panel-body">
                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso <?php echo e($i + 1); ?> </strong></h3>
                <div class="row col-md-12 col-md-offset-0">                    
                    <div class="form-group col-md-12 curso<?php echo e($i); ?>">
                        <label for="curso" class="col-md-3 control-label">Curso:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control text-uppercase" name="curso[]" id="curso<?php echo e($i); ?>" data-num="<?php echo e($i); ?>" data-periodo="#periodo<?php echo e($i); ?>">
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                                <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('curso.$i') == $curso->id): ?>
                                        <option data-tokens="ketchup mustard" value="<?php echo e($curso->id); ?>" selected> <?php echo e($curso->nome); ?> </option>
                                    <?php endif; ?>
                                    <option data-tokens="ketchup mustard" value="<?php echo e($curso->id); ?>"> <?php echo e($curso->nome); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>


                            <span class="help-block">
                                 <strong id="curso<?php echo e($i); ?><?php echo e($i); ?>"></strong>
                            </span>

                        </div>
                    </div>

                    <div id="periodo<?php echo e($i); ?>" class="row col-md-11 col-md-offset-1">
                        
                    </div>

                    <div id="optativa<?php echo e($i); ?>" class="row col-md-11 col-md-offset-1">
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
<?php endif; ?>