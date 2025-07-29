<?php $__env->startSection('title', 'Issues'); ?>

<?php $__env->startSection('site-name'); ?>
<?php if(isset($unitData)): ?>
<h1><?php echo e($unitData->name); ?></h1>
<?php else: ?>
<h1>Javul.org</h1>
<?php endif; ?>
<div class="banner_desc d-md-block d-none">
    Open-source Society
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>
<?php if(isset($unitData)): ?>
<?php echo $__env->make('layout.navbar', ['unitData' => $unitData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
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
                    Donation History
                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                    </div>
                </div>

                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="type_col">User Name</th>
                                <th class="title_col">Transaction ID</th>
                                <th class="type_col">Amount</th>
                                <th class="title_col">Donated For</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="type_col">
                                    <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($txn->user_id)); ?>">
                                        <?php echo e($txn->donated_by); ?>

                                    </a>
                                </td>

                                <td class="type_col">
                                    <?php echo e($txn->transaction_id); ?>

                                </td>

                                <td class="type_col">
                                    <?php echo e($txn->amount ?? '-'); ?>

                                </td>

                                <td class="type_col">
    <?php if($txn->unit_id > 0): ?>
        <strong>Unit:</strong> <?php echo e($txn->unit_name); ?><br>
    <?php endif; ?>
    <?php if($txn->task_id > 0): ?>
        <strong>Task:</strong> <?php echo e($txn->task_name); ?><br>
    <?php endif; ?>
    <?php if($txn->idea_id > 0): ?>
        <strong>Idea:</strong> <?php echo e($txn->idea_title); ?><br>
    <?php endif; ?>
    <?php if($txn->issues_id > 0): ?>
        <strong>Issue:</strong> <?php echo e($txn->issue_title); ?><br>
    <?php endif; ?>
    <?php if($txn->objective_id > 0): ?>
        <strong>Objective:</strong> <?php echo e($txn->objective_title); ?><br>
    <?php endif; ?>
</td>

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

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/funds/donation_list.blade.php ENDPATH**/ ?>