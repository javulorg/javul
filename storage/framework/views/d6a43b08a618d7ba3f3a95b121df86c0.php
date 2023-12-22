<?php $__env->startSection('title', 'Tasks'); ?>

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
            <?php if(isset($unitData)): ?>
                <div class="content_block">
                <div class="table_block table_block_tasks">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Tasks (<?php echo e($tasksTotal); ?>)
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <?php if(isset($unitData)): ?>
                            <input type="hidden" name="unit" value="<?php echo e($unitData->id); ?>" id="unit_id">
                        <?php else: ?>
                            <input type="hidden" name="unit" value="<?php echo e(null); ?>" id="unit_id">
                        <?php endif; ?>
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                                <th class="type_col"><i class="fa fa-trophy"></i></th>
                                <th class="type_col"><i class="fa fa-clock"></i></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if(count($unitTasks) > 0): ?>
                                <?php $__currentLoopData = $unitTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug); ?>"
                                               title="edit">
                                                <?php echo e($obj->name); ?>

                                            </a>
                                        </td>
                                        <td class="type_col">
                                            <?php if($obj->status == "editable"): ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php else: ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="type_col"><?php echo e(\App\Models\Task::getTaskCount('in-progress',$obj->id)); ?></td>
                                        <td class="type_col"><?php echo e(\App\Models\Task::getTaskCount('completed',$obj->id)); ?></td>
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
                        <a href="<?php echo url('tasks/add?unit='.$unitIDHashID->encode($unitData->id)); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
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
                            Tasks (<?php echo e($tasksTotal); ?>)
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <?php if(isset($unitData)): ?>
                                <input type="hidden" name="unit" value="<?php echo e($unitData->id); ?>" id="unit_id">
                            <?php else: ?>
                                <input type="hidden" name="unit" value="<?php echo e(null); ?>" id="unit_id">
                            <?php endif; ?>
                            <table>
                                <thead>
                                <tr>
                                    <th class="type_col">Task Name</th>
                                    <th class="title_col">Unit Name</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if(count($tasksMasterData) > 0 ): ?>
                                    <?php $__currentLoopData = $tasksMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="type_col">
                                                <a href="<?php echo url('tasks/'.$taskIDHashID->encode($task->id) . '/' . $task->slug); ?>">
                                                    <?php echo e($task->name); ?>

                                                </a>
                                            </td>
                                            <td class="title_col">
                                                <a href="<?php echo url('units/'.$unitIDHashID->encode($task->unit_id).'/'.\App\Models\Unit::getSlug($task->unit_id)); ?>">
                                                    <?php echo e(\App\Models\Unit::getUnitName($task->unit_id)); ?>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No record(s) found.</td>
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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/index.blade.php ENDPATH**/ ?>