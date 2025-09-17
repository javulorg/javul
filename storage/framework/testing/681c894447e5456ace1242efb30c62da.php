<?php $__env->startSection('title', 'Finance Activities'); ?>

<?php $__env->startSection('site-name'); ?>
<?php $__env->startSection('navbar'); ?>

<?php echo $__env->make('layout.navbar', ['unitData' => $unitData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content_row">
    <div class="sidebar">
        <?php if(isset($unitData)): ?>
        <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php $title = 'Activity Log'; ?>
        <?php echo $__env->make('layout.v2.global-activity-log', ['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
        <?php $title = 'Global Activity Log'; ?>
        <?php echo $__env->make('layout.v2.global-activity-log', ['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
    <div class="main_content">
        <div class="content_block">
            <div class="table_block table_block_issues">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <i class="fa fa-history" aria-hidden="true"></i>
                    </div>
                    Fund Activities
                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                    </div>
                </div>

                <div class="table_block_body">
                    <table class="">
                        <thead>
                            <tr>
                                <th class="title_col">Activity</th>
                                <th class="type_col">Amount</th>
                                <th class="type_col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="title_col"><?php echo e($activity->comments); ?></td>
                                <td class="type_col">$<?php echo e(number_format($activity->amount, 2)); ?></td>
                                <td class="type_col"><?php echo e($activity->created_at->format('Y-m-d H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
                <div class="content_block_bottom"></div>

                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left"></div>
                    <div class="pagination-right"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/javul-staging/javul/resources/views/funds/activities.blade.php ENDPATH**/ ?>