<div class="content_block mt-3">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
            </div>
            Objectives (<?php echo e($objectivesTotal); ?>)
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="title_col">Objective Name</th>
                        <th class="last_reply_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($objectivesMaster->count() > 0): ?>
                    <?php $__currentLoopData = $objectivesMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="title_col">
                            <a
                                href="<?php echo e(url('objectives/' . $objectiveIDHashID->encode($objective->id) . '/' . $objective->slug)); ?>">
                                <?php echo e($objective->name); ?>

                            </a>
                        </td>
                        <td class="last_reply_col">
                            <a
                                href="<?php echo e(url('units/' . $unitIDHashID->encode($objective->unit_id) . '/' . \App\Models\Unit::getSlug($objective->unit_id))); ?>">
                                <?php echo e($objective->unit->name); ?>

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
                <?php if($objectivesMaster->count() > 0): ?>
                <?php $__currentLoopData = $objectivesMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mob_table_section">
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Objective Name</div>
                        <div class="mob_table_val">
                            <a
                                href="<?php echo e(url('objectives/' . $objectiveIDHashID->encode($objective->id) . '/' . $objective->slug)); ?>">
                                <?php echo e($objective->name); ?>

                            </a>
                        </div>
                    </div>
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Unit Name</div>
                        <div class="mob_table_val">
                            <a
                                href="<?php echo e(url('units/' . $unitIDHashID->encode($objective->unit_id) . '/' . \App\Models\Unit::getSlug($objective->unit_id))); ?>">
                                <?php echo e($objective->unit->name); ?>

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
        <a href="<?php echo e(url('objectives')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/objectives.blade.php ENDPATH**/ ?>