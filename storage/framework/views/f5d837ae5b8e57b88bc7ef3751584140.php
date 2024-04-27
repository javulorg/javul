<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Issue Name</th>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($mostTopIssues) && count($mostTopIssues) > 0): ?>
                <?php $__currentLoopData = $mostTopIssues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('issues/'.$issueIDHashID->encode($issue->issue->id).'/edit'); ?>">
                                <?php echo e($issue->issue->title); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($issue->issue->objective_id).'/edit'); ?>">
                                <?php echo e(\App\Models\Objective::getObjectiveName($issue->issue->objective_id)); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($issue->issue->unit_id).'/edit'); ?>">
                                <?php echo e(\App\Models\Unit::getUnitName($issue->issue->unit_id)); ?>

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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/issues-details.blade.php ENDPATH**/ ?>