<?php $__env->startSection('content'); ?>
    <h3>Hi <?php if($userObj->first_name && $userObj->last_name): ?><?php echo e($userObj->first_name.' '.$userObj->last_name.','); ?><?php else: ?><?php echo e($userObj->username.','); ?><?php endif; ?></h3>
    <p><?php echo $content; ?></p>
    <br/>
    <p style="display: inline-block;text-align: center;width:100%;font-size: 13px;">
        <a href="<?php echo url('account#account_settings'); ?>" style="display:inline-block">Manage Notification Settings</a>&nbsp;|&nbsp;
        <a href="<?php echo url('my_watchlist'); ?>" style="display:inline-block">Edit Watchlist</a>
    </p>
    <p>Regards,</p>
    <p>info@javul.org</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/emails/alerts_email.blade.php ENDPATH**/ ?>