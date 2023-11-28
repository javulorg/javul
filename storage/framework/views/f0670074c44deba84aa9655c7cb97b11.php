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

                <?php if(count($issuesMasterData) > 0 ): ?>
                    <?php $__currentLoopData = $issuesMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issueData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="type_col">
                                <a href="<?php echo url('issues/'.$issueIDHashID->encode($issueData->id).'/view'); ?>">
                                    <?php echo e($issueData->title); ?>

                                </a>
                            </td>
                            <td class="title_col">
                                <a href="<?php echo url('units/'.$unitIDHashID->encode($issueData->unit_id).'/'.\App\Models\Unit::getSlug($issueData->unit_id)); ?>">
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
            <div class="mob_table d-sm-none d-block">
            </div>
        </div>
    </div>
    <div class="content_block_bottom">
        <a href="<?php echo e(url('issues')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/issues.blade.php ENDPATH**/ ?>