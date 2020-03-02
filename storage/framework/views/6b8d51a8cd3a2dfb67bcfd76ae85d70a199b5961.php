

<?php $__env->startSection('titulo','Cadastrar Usuários'); ?>

<?php $__env->startSection('conteudo'); ?>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Usuário</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('usuario.store')); ?>">
                           
                           <div class="form-group <?php echo e($errors->has('acesso') ? ' has-error' : ''); ?>">
                                <label for="acesso" class="col-md-4 control-label" >Tipo:</label>
                                <div class="col-md-6"> 
                                    <select class="form-control" data-live-search="true" id="acesso" name="acesso">
                                        <?php if(old('acesso') == 4): ?>
                                            <option data-tokens="ketchup mustard" value= "4" selected> ADMINISTRADOR </option>
                                        <?php elseif(old('acesso') == 1): ?>
                                            <option data-tokens="ketchup mustard" value= "1" selected> FUNCIONÁRIO </option>
                                        <?php elseif(old('acesso') == 2): ?>
                                            <option data-tokens="ketchup mustard" value= "2" selected> PROFESSOR </option>
                                        <?php else: ?>
                                            <option data-tokens="ketchup mustard" value= "0" selected> SELECIONE... </option>
                                        <?php endif; ?>
                                            <option data-tokens="ketchup mustard" value= "4" > ADMINISTRADOR </option>
                                            <option data-tokens="ketchup mustard" value= "1" > FUNCIONÁRIO </option>
                                            <option data-tokens="ketchup mustard" value= "2" > PROFESSOR </option>

                                    </select>
                                    <?php if($errors->has('acesso')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('acesso')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <div class="form-group <?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                                <label for="username" class="col-md-4 control-label">Usuário: </label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control text-uppercase" name="username" value="<?php echo e(old('username')); ?>">

                                    <?php if($errors->has('username')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('username')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('abreviatura') ? ' has-error' : ''); ?>">
                                <label for="abreviatura" class="col-md-4 control-label">Abreviatura: </label>

                                <div class="col-md-6">
                                    <input id="abreviatura" type="text" class="form-control text-uppercase" maxlength="10" name="abreviatura" value="<?php echo e(old('abreviatura')); ?>" placeholder="Ex: Pedro Carlos = PC">

                                    <?php if($errors->has('abreviatura')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('abreviatura')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label for="email" class="col-md-4 control-label">E-Mail: </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control text-lowercase" name="email" value="<?php echo e(old('email')); ?>">

                                    <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <label for="password" class="col-md-4 control-label">Senha: </label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" value="<?php echo e(old('password')); ?>">

                                    <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                                <label for="password_confirmation" class="col-md-4 control-label">Confirmar Senha: </label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>">

                                    <?php if($errors->has('password_confirmation')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group col-md-12" ></div>
                            <div class="form-group col-md-12" ></div>

                            <div class="row col-md-7 col-md-offset-3">
                                <div class="form-group col-md-5">
                                        <button type="submit" class="btn btn-block btn-lg btn-success">
                                            Cadastrar
                                        </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        </form>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>