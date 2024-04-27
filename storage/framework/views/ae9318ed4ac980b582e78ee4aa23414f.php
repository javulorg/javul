<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Idea Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($mostTopIdeas) && count($mostTopIdeas) > 0): ?>
                <?php $__currentLoopData = $mostTopIdeas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('ideas/'.$ideaHashID->encode($idea->idea->id).'/edit'); ?>">
                                <?php echo e($idea->idea->title); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($idea->idea->unit_id).'/edit'); ?>">
                                <?php echo e(\App\Models\Unit::getUnitName($idea->idea->unit_id)); ?>

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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/ideas-details.blade.php ENDPATH**/ ?>