<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center align-items-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center"><?php echo e(__('messages.please_signin')); ?></h2>
                    <form class="mt-4" method="POST" action="<?php echo e(url('/login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email">Email</label>
                            <input name="email" type="email" id="email" class="form-control" placeholder="Enter your email" required value="<?php echo e(old('email')); ?>">
                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="mt-2 form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password">Password</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Enter your password" required>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group form-check mt-1">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label"><?php echo e(__('messages.remember_me')); ?></label>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                <?php echo e(__('messages.sign_in')); ?>

                            </button>
                        </div>

                        <div class="form-group text-center">
                            <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>"><?php echo e(__('messages.forgot_password')); ?></a>
                        </div>

                        <div class="form-group text-center">
                            <a class="btn btn-link" href="<?php echo e(url('/register')); ?>">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                <strong>Don't have an account? Sign Up</strong>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/auth/login.blade.php ENDPATH**/ ?>