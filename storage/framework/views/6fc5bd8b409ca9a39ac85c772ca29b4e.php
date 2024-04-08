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
                        TASK MANAGEMENT / Cancel Task : <?php echo e($taskObj->name); ?>

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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <label class="control-label" style="color: lightgreen;"><?php echo e(\App\Models\SiteConfigs::task_status($taskObj->status)); ?></label>
                                            </div>

                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Skills
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php if(!empty($skill_names) && count($skill_names) > 0): ?>
                                                    <?php echo e($skill_names[0]); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Award
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e($taskObj->compensation); ?>

                                            </div>
                                        </div>


                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Completion
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php echo e($taskObj->completionTime); ?>

                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Available
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e(number_format($availableFunds,2)); ?>

                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Awarded
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e(number_format($availableFunds,2)); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="content_block mt-3">
                <div class="row">
                    <div class="col-sm-12" style="padding:20px 20px 10px 30px;">
                        <form role="form" method="post" action="<?php echo e(url('tasks/cancel_task/' . $taskIDHashID->encode($taskObj->id))); ?>" >
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">Comments</label>
                                        <textarea class="form-control" name="comment" id="comment"></textarea>
                                    </div>
                                </div>
                                <div class="row form-group mt-4">
                                    <div class="col-sm-12 ">
                                        <button type="submit" class="btn reject-btn m-2" style="background-color: #dc3545; color: white;">
                                             Cancel Task
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/partials/cancel_task.blade.php ENDPATH**/ ?>