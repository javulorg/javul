<?php $__env->startSection('title', 'Task: ' . $taskObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .custom-orange-text {
            color: orange;
        }
    </style>
<?php $__env->stopSection(); ?>
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
                    <?php
                    $title = 'Activity Log';
                    ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                    <?php
                    $title = 'Global Activity Log';
                    ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_tasks active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($taskObj->name); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    <?php echo $taskObj->description; ?>

                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Task Overview
                                        <div class="arrow">
                                            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                            </div>
                                            <div class="sidebar_block_right">

                                                <div class="progress">
                                                    <div class="progress-bar" style="width:75%"></div>
                                                </div> <a href="<?php echo url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                
                                                
                                                
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Support
                                            </div>
                                            <div class="sidebar_block_right">
                                                
                                                
                                                
                                                

                                                
                                                
                                                

                                                
                                                
                                                
                                                
                                                
                                                
                                                

                                                

                                                
                                                
                                                
                                                
                                                

                                                
                                                
                                                
                                                
                                                

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a class="add_to_my_watchlist edit_icon" data-type="task" data-id="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>"" data-redirect="<?php echo e(url()->current()); ?>"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""> Revision History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>








































































































































































































































































































































































<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/view.blade.php ENDPATH**/ ?>