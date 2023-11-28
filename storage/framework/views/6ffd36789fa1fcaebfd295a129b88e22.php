<div class="content_block">
    <div class="table_block table_block_units">
        <div class="table_block_head">
            <div class="table_block_icon">
                <i class="fa-brands fa-stack-overflow"></i>
            </div>
            Units (<?php echo e($unitsTotal); ?>)
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col"><?php echo e(__('messages.unit_name')); ?></th>
                    <th class="last_reply_col"><?php echo e(__('messages.unit_category')); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if($unitsMaster->count() > 0): ?>
                <?php $__currentLoopData = $unitsMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $category_ids = $unit->category_id;
                        $category_names = App\Models\UnitCategory::getName($category_ids);
                        $category_ids = explode(",", $category_ids);
                        $category_names = explode(",", $category_names);
                    ?>
                    <tr>

                        <td class="title_col">
                            <a href="<?php echo url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug); ?>"><?php echo e($unit->name); ?></a>
                        </td>
                        <td class="last_reply_col">
                            <?php if(count($category_ids) > 0): ?>
                                <?php $__currentLoopData = $category_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo url('units/category='.strtolower($category_names[$index])); ?>"><?php echo e($category_names[$index]); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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
        <a href="<?php echo e(url('units')); ?>">See more</a>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/master/units.blade.php ENDPATH**/ ?>