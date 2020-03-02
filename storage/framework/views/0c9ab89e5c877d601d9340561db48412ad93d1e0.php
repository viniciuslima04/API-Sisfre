

<?php $__env->startSection('titulo','Login'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('scripts.suporte-broswer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>
        <div class="wrapper container-fluid">
            <form action=<?php echo e(route('login')); ?> method="POST" class="form-signin">

                <h2 class="form-login-heading"> <img src="/img/logo.png"> </h2>
                <hr class="colorgraph"><br>
                <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <label for="email" class="control-label">E-mail: </label>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login" type="email" class="form-control" name="email" placeholder='Ex:admin@gmail.com' autofocus>
                    </div>

                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                    <?php endif; ?>
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <label for="password" class="control-label">Senha: </label>

                    <div class="input-group ">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>

                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                    <?php endif; ?>
                </div>
                <?php echo e(csrf_field()); ?>

                <button id="entrar" type="submit" class="btn btn-lg btn-primary btn-block "> Entrar </button>
                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                    Esqueceu sua senha?
                </a>
            </form>
        </div>
    <?php echo $__env->make('layout.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>