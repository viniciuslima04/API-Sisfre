<?php if(!empty($curso) ): ?>                                
    <div class="titulo" id="titulo" data-duracao="<?php echo e($curso->duracao); ?>"> 
        <h4 class="text-center">Quantidade de Aulas por Periodo:</h4>
    </div>
    <?php for($i = 1; $i<=$curso->duracao;$i++): ?>

        <div class="form-group col-md-4 periodo<?php echo e($curso->id); ?><?php echo e($i); ?>">
            <label for="periodo<?php echo e($curso->id); ?><?php echo e($i); ?>" class="col-md-2 col-md-offset-1 control-label">S<?php echo e($i); ?>:</label>
            <div class="col-md-8">
                <input id="periodo<?php echo e($curso->id); ?><?php echo e($i); ?>" type="text" maxlength="2" class="form-control disciplina-optativa" name="periodo[<?php echo e($curso->id); ?>][<?php echo e($i); ?>]"
                data-periodo="<?php echo e($i); ?>">

                <label><input id="optativa<?php echo e($curso->id); ?><?php echo e($i); ?>" type="checkbox" name="optativa[<?php echo e($curso->id); ?>][<?php echo e($i); ?>]"> Optativa </input></label>
            </div>
        </div>
    <?php endfor; ?>

    <span class="form-group col-md-12 col-md-offset-1">
        <strong id="periodo<?php echo e($curso->id); ?><?php echo e($curso->id); ?><?php echo e($curso->id); ?>"></strong>
    </span>
<?php endif; ?>