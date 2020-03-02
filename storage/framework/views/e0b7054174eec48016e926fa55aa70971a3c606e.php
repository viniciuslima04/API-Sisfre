<?php $__env->startSection('titulo','Editar Usuário'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.outros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Atualizar Usuário</div>
                    <div class="panel-body">
                    <form class="form-horizontal editar" role="form" method="POST" action="<?php echo e(route('usuario.update', $user->id)); ?>">
                      
                      <?php if( Auth::user()->acesso == 4): ?> 
                           <div class="form-group <?php echo e($errors->has('acesso') ? ' has-error' : ''); ?>">
                                <label for="acesso" class="col-md-4 control-label" >Tipo:</label>
                                <div class="col-md-6"> 
                                    <select class="form-control" data-live-search="true" id="acesso" name="acesso">
                                        <?php if($user->acesso == 4): ?>
                                            <option data-tokens="ketchup mustard" value=" <?php echo e($user->acesso); ?>" selected> ADMINISTRADOR </option>
                                        <?php elseif($user->acesso == 1): ?>
                                            <option data-tokens="ketchup mustard" value=" <?php echo e($user->acesso); ?>" selected> FUNCIONÁRIO </option>
                                        <?php elseif($user->acesso == 2): ?>
                                            <option data-tokens="ketchup mustard" value=" <?php echo e($user->acesso); ?>" selected> PROFESSOR </option>
                                        <?php else: ?>
                                            <option data-tokens="ketchup mustard" value= "0" selected>SELECIONE...</option>
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
                      <?php else: ?>
                            <input type="hidden" name="acesso" value="<?php echo e($user->acesso); ?>">
                      <?php endif; ?>
                            <div class="form-group <?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                                <label for="username" class="col-md-4 control-label">Usuário: </label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control text-uppercase" name="username" <?php if(!empty(old('username'))): ?> 
                                            value="<?php echo e(old('username')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($user->username); ?>" 
                                        <?php endif; ?>
                                        />

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
                                    <input id="abreviatura" type="text" class="form-control text-uppercase" name="abreviatura" 
                                        <?php if(!empty(old('abreviatura'))): ?> 
                                            value="<?php echo e(old('abreviatura')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($user->abreviatura); ?>" 
                                        <?php endif; ?>
                                        placeholder="Ex: Pedro Carlos = PC"/>

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
                                    <input id="email" type="email" class="form-control text-lowercase" name="email" <?php if(!empty(old('email'))): ?> 
                                            value="<?php echo e(old('email')); ?>"
                                        <?php else: ?> 
                                            value="<?php echo e($user->email); ?>" 
                                        <?php endif; ?>
                                        />

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
                                    <input id="password" type="password" class="form-control" name="password"/>

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
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"/>

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
                                    <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                        Salvar
                                    </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="<?php echo e(route('usuario.show')); ?>" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>
                            
                            <?php echo $__env->make('layout.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <div class="row col-md-8 col-md-offset-2">
                                <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="mensagem"></strong>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                        </form>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>