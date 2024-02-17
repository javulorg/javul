<?php $__env->startSection('title', 'Unit: ' . $unitObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1><?php echo e($unitObj->name); ?></h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
    <?php echo $__env->make('layout.navbar', ['unitData' => $unitObj], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php
            $title = 'Activity Log';
            ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitObj->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-finances', ['availableFunds' => $availableFunds, 'awardedFunds' => $awardedFunds], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="main_content">
            <div class="content_block">


            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>