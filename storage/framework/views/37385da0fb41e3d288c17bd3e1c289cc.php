<?php $__env->startSection('title', 'My Tasks'); ?>

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
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role != 1): ?>
                    <div class="content_block">
                        <div class="table_block table_block_tasks">
                            <div class="table_block_head">
                                <div class="table_block_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                Assigned Tasks (<?php echo e(isset($assignedTasks) ? count($assignedTasks) : 0); ?>)
                                <div class="arrow">
                                    <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                                </div>
                            </div>
                            <div class="table_block_body">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="title_col">Task Name</th>
                                        <th class="type_col">Status</th>
                                        <th class="type_col"></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(count($assignedTasks) > 0): ?>
                                        <?php $__currentLoopData = $assignedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignedTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="title_col">
                                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($assignedTask->id).'/'.$assignedTask->slug); ?>"
                                                       title="edit">
                                                        <?php echo e($assignedTask->name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($assignedTask->status)); ?></span>
                                                </td>

                                                <td class="type_col">
                                                    <a href="<?php echo url('tasks/complete_task/'.$taskIDHashID->encode($assignedTask->id)); ?>"
                                                       class="btn btn-sm m-2" style="background-color: #198754; color: white;" title="Complete Task">
                                                        <i class="bi bi-check2"></i>
                                                    </a>
                                                    <a href="<?php echo url('tasks/cancel_task/'.$taskIDHashID->encode($assignedTask->id)); ?>"
                                                       class="btn btn-sm m-2" style="background-color: #dc3545; color: white;" title="Cancel Task">
                                                        <i class="bi bi-x"></i>
                                                    </a>
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
                        </div>
                    </div>

                    <div class="content_block">
                        <div class="table_block table_block_tasks">
                            <div class="table_block_head">
                                <div class="table_block_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                In Progress Tasks (<?php echo e(isset($inProgressTasks) ? count($inProgressTasks) : 0); ?>)
                                <div class="arrow">
                                    <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                                </div>
                            </div>
                            <div class="table_block_body">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="title_col">Task Name</th>
                                        <th class="type_col">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(count($inProgressTasks) > 0): ?>
                                        <?php $__currentLoopData = $inProgressTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inProgressTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="title_col">
                                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($inProgressTask->id).'/'.$inProgressTask->slug); ?>"
                                                       title="edit">
                                                        <?php echo e($inProgressTask->name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($inProgressTask->status)); ?></span>
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
                        </div>
                    </div>

                    <div class="content_block">
                        <div class="table_block table_block_tasks">
                            <div class="table_block_head">
                                <div class="table_block_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                Completed Tasks (<?php echo e(isset($completedTasks) ? count($completedTasks) : 0); ?>)
                                <div class="arrow">
                                    <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                                </div>
                            </div>
                            <div class="table_block_body">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="title_col">Task Name</th>
                                        <th class="type_col">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(count($completedTasks) > 0): ?>
                                        <?php $__currentLoopData = $completedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $completedTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="title_col">
                                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($completedTask->id).'/'.$completedTask->slug); ?>"
                                                       title="edit">
                                                        <?php echo e($completedTask->name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($completedTask->status)); ?></span>
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
                        </div>
                    </div>

                    <div class="content_block">
                        <div class="table_block table_block_tasks">
                            <div class="table_block_head">
                                <div class="table_block_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                Bids Tasks (<?php echo e(isset($myBids) ? count($myBids) : 0); ?>)
                                <div class="arrow">
                                    <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                                </div>
                            </div>
                            <div class="table_block_body">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="title_col">Task Name</th>
                                        <th class="type_col">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(count($myBids) > 0): ?>
                                        <?php $__currentLoopData = $myBids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myBid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="title_col">
                                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($myBid->task_id).'/'.$myBid->slug); ?>"
                                                       title="edit">
                                                        <?php echo e($myBid->name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($myBid->task_status)); ?></span>
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
                        </div>
                    </div>
                <?php else: ?>
                    <div class="content_block">
                        <div class="table_block table_block_tasks">
                            <div class="table_block_head">
                                <div class="table_block_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                Task Evaluation (<?php echo e(isset($myEvaluationTask) ? count($myEvaluationTask) : 0); ?>)
                                <div class="arrow">
                                    <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                                </div>
                            </div>
                            <div class="table_block_body">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="title_col">Task Name</th>
                                        <th class="type_col">Completed By</th>
                                        <th class="type_col">Status</th>
                                        <th class="type_col"></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(count($myEvaluationTask) > 0): ?>
                                        <?php $__currentLoopData = $myEvaluationTask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valuationTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="title_col">
                                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($valuationTask->task_id).'/'.$valuationTask->slug); ?>"
                                                       title="edit">
                                                        <?php echo e($valuationTask->name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($valuationTask->user_id).'/'.strtolower
                                ($valuationTask->first_name.'_'.$valuationTask->last_name)); ?>"
                                                       title="edit">
                                                        <?php echo e($valuationTask->first_name.' '.$valuationTask->last_name); ?>

                                                    </a>
                                                </td>
                                                <td class="type_col">
                                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($valuationTask->task_status)); ?></span>
                                                </td>

                                                <td class="type_col">
                                                    <a href="<?php echo url('tasks/complete_task/'.$taskIDHashID->encode($valuationTask->task_id)); ?>"
                                                       class="btn btn-xs btn-success mark-complete" >
                                                        Mark as Complete
                                                    </a>
                                                    <a href="<?php echo url('tasks/complete_task/'.$taskIDHashID->encode($valuationTask->task_id)); ?>"
                                                       class="btn btn-xs btn-danger re-assigned" >
                                                        Re Assign
                                                    </a>
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
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/my_tasks.blade.php ENDPATH**/ ?>