<div class="content_block mt-3">
    <div class="table_block table_block_tasks">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
            </div>
            Tasks (<?php echo e($tasksMasterTotal); ?>)
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="type_col">Task Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($tasksMaster->count() > 0): ?>
                    <?php $__currentLoopData = $tasksMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="type_col">
                            <a href="<?php echo e(url('tasks/' . $taskIDHashID->encode($task->id) . '/' . $task->slug)); ?>">
                                <?php echo e($task->name); ?>

                            </a>
                        </td>
                        <td class="title_col">
                            <a
                                href="<?php echo e(url('units/' . $unitIDHashID->encode($task->unit_id) . '/' . \App\Models\Unit::getSlug($task->unit_id))); ?>">
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

            <!-- Mobile Table -->
            <div class="mob_table d-sm-none d-block">
                <?php if($tasksMaster->count() > 0): ?>
                <?php $__currentLoopData = $tasksMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mob_table_section">
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Task Name</div>
                        <div class="mob_table_val">
                            <a href="<?php echo e(url('tasks/' . $taskIDHashID->encode($task->id) . '/' . $task->slug)); ?>">
                                <?php echo e($task->name); ?>

                            </a>
                        </div>
                    </div>
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Unit Name</div>
                        <div class="mob_table_val">
                            <a
                                href="<?php echo e(url('units/' . $unitIDHashID->encode($task->unit_id) . '/' . \App\Models\Unit::getSlug($task->unit_id))); ?>">
                                <?php echo e(\App\Models\Unit::getUnitName($task->unit_id)); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="mob_table_section">
                    <div class="mob_table_row">
                        <div class="mob_table_val text-center">No record(s) found.</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <div class="content_block_bottom">
        <a href="<?php echo url('tasks/add?unit='.$unitIDHashID->encode($task->objective_id)); ?>">Add New</a>
        <div class="separator"></div>
        <a href="<?php echo e(url('tasks')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/tasks.blade.php ENDPATH**/ ?>