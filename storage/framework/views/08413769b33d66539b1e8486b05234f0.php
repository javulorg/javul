<?php $__env->startSection('title', 'Forgot Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="reset-container">
    <div class="reset-box">
        <h4 class="mb-4 fw-semibold">Forgot Your Password?</h4>
        <p class="mb-4 text-muted small">
            Enter your registered email address and we’ll send you a link to reset your password.
        </p>

        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(url('/password/email')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                    value="<?php echo e(old('email')); ?>" placeholder="Email address" required autofocus />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback text-start">
                    <?php echo e($message); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <button type="submit" class="btn btn-reset w-100">
                <i class="fas fa-envelope me-2"></i> Send Password Reset Link
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>