<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
                <tr>
                    <th>Unit Name</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($mostActiveUnits) && count($mostActiveUnits) > 0): ?>

                    <?php $__currentLoopData = $mostActiveUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($unit->total_points > 0): ?>
                            <tr>
                                <td><?php echo e($unit->unit_name); ?></td> 
                                <td><?php echo e($unit->total_points); ?></td>
                            </tr>
                        <?php endif; ?>
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
<?php /**PATH /var/www/html/javul-staging/javul/resources/views/users/profile-partials/unit-details.blade.php ENDPATH**/ ?>