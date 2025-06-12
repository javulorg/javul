<div class="content_block mt-3">
    <div class="table_block table_block_issues">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
            </div>
            Issues (<?php echo e($issuesMasterTotal); ?>)
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="type_col">Issue Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($issuesMasterData->count() > 0): ?>
                        <?php $__currentLoopData = $issuesMasterData->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issueData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="type_col">
                                    <a href="<?php echo e(url('issues/' . $issueIDHashID->encode($issueData->id) . '/view')); ?>">
                                        <?php echo e($issueData->title); ?>

                                    </a>
                                </td>
                                <td class="title_col">
                                    <a href="<?php echo e(url('units/' . $unitIDHashID->encode($issueData->unit_id) . '/' . \App\Models\Unit::getSlug($issueData->unit_id))); ?>">
                                        <?php echo e(\App\Models\Unit::getUnitName($issueData->unit_id)); ?>

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
                <?php if($issuesMasterData->count() > 0): ?>
                    <?php $__currentLoopData = $issuesMasterData->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issueData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Issue Name</div>
                                <div class="mob_table_val">
                                    <a href="<?php echo e(url('issues/' . $issueIDHashID->encode($issueData->id) . '/view')); ?>">
                                        <?php echo e($issueData->title); ?>

                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Unit Name</div>
                                <div class="mob_table_val">
                                    <a href="<?php echo e(url('units/' . $unitIDHashID->encode($issueData->unit_id) . '/' . \App\Models\Unit::getSlug($issueData->unit_id))); ?>">
                                        <?php echo e(\App\Models\Unit::getUnitName($issueData->unit_id)); ?>

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
         <a href="<?php echo e(url('issues/'. $unitIDHashID->encode($issueData->unit_id) .'/add')); ?>">Add New</a>
           <div class="separator"></div>
        <a href="<?php echo e(url('issues')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/issues.blade.php ENDPATH**/ ?>