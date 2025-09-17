<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>


<div class="login-app">
    <div class="login-card">
        <h3 class="text-center mb-4"><?php echo e(__('messages.please_signin')); ?></h3>

        <form method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-3 position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input name="email" type="email" class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                    placeholder="Enter your email" value="<?php echo e(old('email')); ?>" required autofocus>
                <?php if($errors->has('email')): ?>
                <div class="invalid-feedback d-block">
                    <?php echo e($errors->first('email')); ?>

                </div>
                <?php endif; ?>
            </div>

            
            <div class="mb-3 position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input name="password" type="password"
                    class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                    placeholder="Enter your password" required>
                <?php if($errors->has('password')): ?>
                <div class="invalid-feedback d-block">
                    <?php echo e($errors->first('password')); ?>

                </div>
                <?php endif; ?>
            </div>

            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        <?php echo e(__('messages.remember_me')); ?>

                    </label>
                </div>
                <a href="<?php echo e(url('/password/reset')); ?>" class="text-decoration-none"><?php echo e(__('messages.forgot_password')); ?></a>
            </div>

            
            <div class="d-grid mb-3">
                <button type="submit" class="btn login-btn">
                    <i class="fas fa-arrow-right me-2"></i> <?php echo e(__('messages.sign_in')); ?>

                </button>
            </div>

            
            <div class="text-center link-group">
                <span>Don't have an account?</span>
                <a href="<?php echo e(url('/register')); ?>" class="text-decoration-none fw-bold ms-1">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/javul-staging/javul/resources/views/auth/login.blade.php ENDPATH**/ ?>