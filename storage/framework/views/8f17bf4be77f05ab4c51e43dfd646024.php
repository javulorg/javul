<div class="content_block">
    <div class="table_block table_block_units">
        <div class="table_block_head">
            <div class="table_block_icon">
                <i class="fa fa-users"></i>
            </div>
            <?php if(isset($users) && $users->count() > 0): ?>
                User Rights (<?php echo e($users->count()); ?>)
            <?php else: ?>
                User Rights (<?php echo e(0); ?>)
            <?php endif; ?>
            <div class="arrow">

            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Full Name</th>
                    <th class="last_reply_col">E-mail</th>
                    <th class="last_reply_col">Role</th>
                    <th class="views_col">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php if($users->count() > 0): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="title_col">
                                <a href="<?php echo e(url('site-admin/users/'.$user->id.'/edit')); ?>"><?php echo e($user->first_name . '  ' . $user->last_name); ?></a>
                            </td>
                            <td class="last_reply_col">
                              <?php echo e($user->email); ?>

                            </td>
                            <td class="last_reply_col">
                              <?php if($user->role == 2): ?>
                                    Unit Admin
                                <?php elseif($user->role == 3): ?>
                                  Task Admin
                                <?php else: ?>

                              <?php endif; ?>
                            </td>
                            <td class="views_col">
                                <?php if($user->status == 1): ?>
                                    Active
                                <?php else: ?>
                                    Inactive
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No record(s) found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="content_block_bottom">
        <a href="<?php echo e(url('site-admin/users/create')); ?>">
            <img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt="">
            Add New
        </a>
        <div class="separator"></div>
        <a href="#" class="see_more">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/site-admins/users/index.blade.php ENDPATH**/ ?>