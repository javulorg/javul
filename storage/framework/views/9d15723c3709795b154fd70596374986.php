

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
            <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Determine type based on which ID is filled
                    if (!empty($activity->task_id)) {
                        $type = 'task';
                    } elseif (!empty($activity->idea_id)) {
                        $type = 'idea';
                    } elseif (!empty($activity->objective_id)) {
                        $type = 'objective';
                    } elseif (!empty($activity->issue_id)) {
                        $type = 'issue';
                    } else {
                        $type = 'comment';
                    }

                    // Check if completed
                    $isComplete = isset($activity->status) && strtolower($activity->status) === 'complete';
                ?>

                <div class="log_item">
                    <div class="log_icon">
                        <?php if($isComplete): ?>
                            <i class="fa-solid fa-circle-check" style="color: green;"></i> 
                        <?php elseif($type === 'task'): ?>
                        <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                        <?php elseif($type === 'idea'): ?>
                        <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                        <?php elseif($type === 'objective'): ?>
                        <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                        <?php elseif($type === 'issue'): ?>
                        <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                        <?php elseif($type === 'comment'): ?>
                            <i class="fa-solid fa-comment-dots"></i>
                        <?php else: ?>
                            <i class="fa-solid fa-comment"></i> 
                        <?php endif; ?>
                    </div>

                    <div class="log_txt">
                        <a href="#"><?php echo $activity->comment; ?></a>
                        <?php echo \App\Library\Helpers::timetostr($activity->created_at); ?>

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
<?php /**PATH C:\xampp\htdocs\javul-new\javul\resources\views/layout/v2/global-activity-log.blade.php ENDPATH**/ ?>