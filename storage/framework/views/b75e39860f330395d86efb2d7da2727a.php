<?php $__env->startSection('title', 'Unit Adminstration '); ?>
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
                <h1>Unit Adminstration</h1>

                <div class="content_block mt-3 mb-4">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Categories
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Name</th>
                                    <th class="type_col">Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if(count($categories) > 0): ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="title_col">
                                                <a href="<?php echo url('admin/categories/'. $category->id . '/' .$unitIDHashID->encode($category->unit_id)); ?>"
                                                   title="edit">
                                                    <?php echo e($category->title); ?>

                                                </a>
                                            </td>
                                            <td class="type_col">
                                                <?php if($category->status == 1): ?>
                                                    <span class="colorLightGreen">Active</span>
                                                <?php else: ?>
                                                    <span class="colorLightGreen">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No record(s) found.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>
                        <div class="pagination-right">
                            <a href="<?php echo url('admin/categories/create/'.$unitIDHashID->encode($unitObj->id)); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>