<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Task Name</th>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($tasksObj) && count($tasksObj) > 0): ?>
                <?php $__currentLoopData = $tasksObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($task->id).'/edit'); ?>">
                                <?php echo e($task->name); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($task->objective_id).'/edit'); ?>">
                                <?php echo e(\App\Models\Objective::getObjectiveName($task->objective_id)); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($task->unit_id).'/edit'); ?>">
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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/tasks-details.blade.php ENDPATH**/ ?>