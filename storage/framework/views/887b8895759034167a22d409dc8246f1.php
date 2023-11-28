<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        <?php if(isset($title)): ?>
            <?php echo e($title); ?>

        <?php else: ?>
            Global Activity Log
        <?php endif; ?>
        <div class="arrow">
            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <?php if(count($site_activity) > 0): ?>
            <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="log_item">
            <div class="log_icon">
                <img src="<?php echo e(asset('v2/assets/img/commen.svg')); ?>" alt="">
            </div>
            <div class="log_txt">
                <a href="#"><?php echo $activity->comment; ?></a> <?php echo \App\Library\Helpers::timetostr($activity->created_at); ?>

            </div>
        </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="log_item">
                No activity found.
            </div>
        <?php endif; ?>

            <div class="sidebar_block_content_bottom">
                <a href="#">Top Contributors</a>
                <div class="separator"></div>
                <?php if(isset($unit) && $unit != null): ?>
                    <a href="<?php echo e(url('activities?unit=' . $unit)); ?>">More Activity</a>
                <?php else: ?>
                    <a href="<?php echo e(url('activities')); ?>">More Activity</a>
                <?php endif; ?>
            </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/global-activity-log.blade.php ENDPATH**/ ?>