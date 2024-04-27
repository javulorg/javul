<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Unit Name</th>
                <th>Status</th>

            </tr>
            </thead>
            <tbody>
            <?php if(!empty($mostActiveUnits) && count($mostActiveUnits) > 0): ?>
                <?php $__currentLoopData = $mostActiveUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($unit->unit->id).'/edit'); ?>">
                                <?php echo e($unit->unit->name); ?>

                            </a>
                        </td>
                        <td>
                            <span class="colorLightGreen"><?php echo e($unit->unit->status); ?></span>
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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/unit-details.blade.php ENDPATH**/ ?>