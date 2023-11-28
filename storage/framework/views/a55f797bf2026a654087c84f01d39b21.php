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
                <?php if(count($tasksMaster) > 0 ): ?>
                    <?php $__currentLoopData = $tasksMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    <div class="content_block_bottom">
        <a href="<?php echo e(url('tasks')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/tasks.blade.php ENDPATH**/ ?>