<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .password-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }
        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding-right: 40px; /* Make space for the eye icon */
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">
            <?php $title = 'Global Activity Log'; ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Update User</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post"  action="<?php echo e(url('site-admin/users/'.$user->id.'/update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('post'); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="control-label">First Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="first_name" class="form-control" value="<?php echo e($user->first_name); ?>" placeholder="Enter First Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Last Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="last_name" class="form-control" value="<?php echo e($user->last_name); ?>" placeholder="Enter the Last Name" required/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">E-mail</label>
                                <div class="input-icon right">
                                    <input type="email" name="email" value="<?php echo e($user->email); ?>" class="form-control" placeholder="Enter the E-mail" required/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label for="phone" class="control-label">Phone</label>
                                <div class="input-icon right">
                                    <input type="text" id="phone" value="<?php echo e($user->phone); ?>" name="phone" class="form-control" placeholder="Phone"/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">Role : </label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="role">
                                        <option selected disabled>Select Role</option>
                                        <option value="2" <?php echo e($user->role == 2 ? 'selected' : ''); ?>>Unit Administration</option>
                                        <option value="3" <?php echo e($user->role == 3 ? 'selected' : ''); ?>>Task Administration</option>
                                        <option value="3" <?php echo e($user->role == 4 ? 'selected' : ''); ?>>Normal User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">Status : </label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="status">
                                        <option selected disabled>Select Status</option>
                                        <option value="1" <?php echo e($user->status == 1 ? 'selected' : ''); ?>>Active</option>
                                        <option value="0" <?php echo e($user->status == 0 ? 'selected' : ''); ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update User</span>
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            const isPassword = passwordInput.type === 'password';

            if (isPassword) {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/site-admins/users/edit.blade.php ENDPATH**/ ?>