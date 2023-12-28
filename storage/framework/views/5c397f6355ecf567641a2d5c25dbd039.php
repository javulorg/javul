<?php $__env->startSection('title', 'Idea: ' . $idea->title); ?>
<?php $__env->startSection('style'); ?>
    <style>
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






                <div class="table_block table_block_ideas active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($idea->title); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>

                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    <?php echo $idea->description; ?>

                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Idea Overview
                                        <div class="arrow">
                                            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php if($idea->status == 1): ?>
                                                    Draft
                                                <?php elseif($idea->status == 2): ?>
                                                    Assigned to Task
                                                <?php else: ?>
                                                    Implemented
                                                <?php endif; ?>
                                                <div class="progress">

                                                </div> <a href="<?php echo url('ideas/'. $ideaHashId .'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="<?php echo url('ideas/'. $ideaHashId .'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo url('ideas/'. $ideaHashId .'/history'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""> Revision History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Related Task
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">
                                        Title
                                    </th>
                                    <th class="status_col">
                                        Status
                                    </th>
                                    <th class="type_col"><i class="fa fa-trophy"></i></th>
                                    <th class="type_col"><i class="fa fa-clock"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="type_col">
                                        <?php if(isset($idea->task)): ?>
                                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($idea->task->id).'/'.$idea->task->name); ?>"
                                               title="edit">
                                                <?php echo e($idea->task->name); ?>

                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="title_col">
                                        <?php if(isset($idea->task)): ?>
                                            <?php if($idea->task->status == "editable"): ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($idea->task->status)); ?></span>
                                            <?php else: ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($idea->task->status)); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="status_col">
                                        <?php if(isset($idea->task)): ?>
                                             <?php echo e(\App\Models\Task::getTaskCount('in-progress',$idea->task->id)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="replies_col">
                                        <?php if(isset($idea->task)): ?>
                                            <?php echo e(\App\Models\Task::getTaskCount('completed',$idea->task->id)); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="content_block_bottom">
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_issues">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Related Issues
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="type_col">
                                        Type
                                    </th>
                                    <th class="title_col">
                                        Title
                                    </th>
                                    <th class="priority_col">
                                        Priority
                                    </th>
                                    <th class="last_reply_col">
                                        Last Reply
                                    </th>
                                    <th class="replies_col">
                                        Replies
                                    </th>
                                    <th class="views_col">
                                        Views
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="type_col">
                                        Driver
                                    </td>
                                    <td class="title_col">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </td>
                                    <td class="priority_col">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </td>
                                    <td class="last_reply_col">
                                        10 minutes ago
                                    </td>
                                    <td class="replies_col">
                                        34
                                    </td>
                                    <td class="views_col">
                                        205
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/ideas/show.blade.php ENDPATH**/ ?>