<div class="list-group tab-pane table-responsive" id="objectives_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($mostTopObjectives) && count($mostTopObjectives) > 0): ?>
                <?php $__currentLoopData = $mostTopObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objective->objective->id).'/edit'); ?>">
                                <?php echo e($objective->objective->name); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($objective->objective->unit_id).'/edit'); ?>">
                                <?php echo e(\App\Models\Unit::getUnitName($objective->objective->unit_id)); ?>

                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No record(s) found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/objectives-details.blade.php ENDPATH**/ ?>