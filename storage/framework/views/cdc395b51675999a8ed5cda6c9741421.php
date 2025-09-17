<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>

<div class="signup-app">
    <div class="signup-card">
        <h3 class="text-center mb-4"><?php echo e(__('messages.please_signup')); ?></h3>

        <form id="register-form" method="POST" action="<?php echo e(url('/register')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-3 position-relative">
                <label class="form-label">User Name</label>
                <input type="text" name="user_name" class="form-control" value="<?php echo e(old('user_name')); ?>"
                    placeholder="Choose a username" required>
                <?php if($errors->has('user_name')): ?>
                <div class="help-block"><?php echo e($errors->first('user_name')); ?></div>
                <?php elseif($errors->has('username_duplicate')): ?>
                <div class="help-block"><?php echo e($errors->first('username_duplicate')); ?></div>
                <?php endif; ?>
                <img id="user_img" src="">
            </div>

            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>"
                        placeholder="Enter your first name" required>
                    <?php if($errors->has('first_name')): ?>
                    <div class="help-block"><?php echo e($errors->first('first_name')); ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>"
                        placeholder="Enter your last name" required>
                    <?php if($errors->has('last_name')): ?>
                    <div class="help-block"><?php echo e($errors->first('last_name')); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="mb-3 position-relative">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>"
                    placeholder="Enter your email" required>
                <?php if($errors->has('email')): ?>
                <div class="help-block"><?php echo e($errors->first('email')); ?></div>
                <?php endif; ?>
                <img id="email_img" src="">
            </div>

            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                    <?php if($errors->has('password')): ?>
                    <div class="help-block"><?php echo e($errors->first('password')); ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm password" required>
                    <?php if($errors->has('password_confirmation')): ?>
                    <div class="help-block"><?php echo e($errors->first('password_confirmation')); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <input type="hidden" name="g-recaptcha-response-name" id="g-recaptcha-response">
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30"
                    data-callback="onSubmit" data-action="register-form" onclick="sendToken(event)"></div>
                <?php if($errors->has('g-recaptcha-response-name')): ?>
                <div class="help-block"><?php echo e($errors->first('g-recaptcha-response-name')); ?></div>
                <?php endif; ?>
            </div>

            
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-signup">
                    <i class="fas fa-user-plus me-2"></i> <?php echo e(__('messages.signup')); ?>

                </button>
            </div>

            <div class="text-center mt-3">
                <span>Already have an account?</span>
                <a href="<?php echo e(url('/login')); ?>" class="text-decoration-none fw-bold ms-1">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function sendToken(e) {
            e.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute('6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30', {action: 'register-form'}).then(function (token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    document.getElementById('register-form').submit();
                });
            });
        }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/javul-staging/javul/resources/views/auth/register.blade.php ENDPATH**/ ?>