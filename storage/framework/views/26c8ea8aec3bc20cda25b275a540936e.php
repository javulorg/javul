<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>






























































































<div class="row justify-content-center align-items-center">
    <div class="col-sm-6">
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-center"><?php echo e(__('messages.please_signup')); ?></h2>
        <form class="mt-4" id="register-form" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
            <?php echo csrf_field(); ?>

            <div class="row justify-content-center">
                <div class="form-group mb-2">
                    <label for="uname" class="form-label">User Name</label>
                    <input type="text" id="uname" class="form-control" required name="user_name" value="<?php echo e(old('user_name')); ?>" placeholder="Enter user name">
                    <?php if($errors->has('user_name')): ?>
                        <span class="help-block">
                        <strong><?php echo e($errors->first('user_name')); ?></strong>
                    </span><?php elseif($errors->has('username_duplicate')): ?>
                                <span class="help-block">
                      <strong><?php echo e($errors->first('username_duplicate')); ?></strong>
                    </span>
                    <?php endif; ?>
                    <img id="user_img" src="" style="float: right;position: absolute;margin-top: 7px">
                </div>

                <div class="form-group mb-2">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name')); ?>" placeholder="Enter your first name" required>
                    <?php if($errors->has('first_name')): ?>
                        <span class="help-block">
              <strong><?php echo e($errors->first('first_name')); ?></strong>
            </span>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-2">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input name="last_name" type="text" id="last_name" value="<?php echo e(old('last_name')); ?>" placeholder="Enter your last name" class="form-control" required>
                    <?php if($errors->has('last_name')): ?>
                        <span class="help-block">
              <strong><?php echo e($errors->first('last_name')); ?></strong>
            </span>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" value="<?php echo e(old('email')); ?>" id="email" placeholder="Enter your Email" class="form-control" required>
                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
              <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
                    <?php endif; ?>
                    <img id="email_img" src="" style="float: right;position: absolute;margin-top: 7px">
                </div>

                <div class="form-group mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" id="password" placeholder="Enter your password" class="form-control" required>
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
              <strong><?php echo e($errors->first('password')); ?></strong>
            </span>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-2">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input name="password_confirmation" type="password" id="password_confirmation" placeholder="Password confirmation" class="form-control" required>
                    <?php if($errors->has('password_confirmation')): ?>
                        <span class="help-block">
              <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
            </span>
                    <?php endif; ?>
                </div>

                <input type="hidden" name="g-recaptcha-response-name" id="g-recaptcha-response">
                <div class="form-group mb-2">
                    <div class="g-recaptcha" data-sitekey="6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30" data-callback="onSubmit" data-action="register-form" onclick="sendToken(event)"></div>
                    <?php if($errors->has('g-recaptcha-response-name')): ?>
                        <span style="color:#a94442"><?php echo e($errors->first('g-recaptcha-response-name')); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><?php echo e(__('messages.signup')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function sendToken(e) {
            e.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute('6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30', {action: 'register-form'}).then(function (token) {
                    console.log(token);
                    document.getElementById('g-recaptcha-response').value = token;
                    document.getElementById('register-form').submit();
                });
            });
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/auth/register.blade.php ENDPATH**/ ?>