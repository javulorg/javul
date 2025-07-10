<div class="content_block mt-3 mb-4">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
            </div>
            <?php echo e(__('messages.objectives')); ?>

            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="title_col">Objective Name</th>
                        <th class="type_col text-center">Support</th>
                        <th class="type_col text-center">In Progress</th>
                        <th class="type_col text-center">Available</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($objectives) > 0): ?>
                        <?php $__currentLoopData = $objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo url('objectives/' . $objectiveIDHashID->encode($obj->id) . '/' . $obj->slug); ?>" title="edit">
                                        <?php echo e($obj->name); ?>

                                    </a>
                                </td>
                                <td class="text-center"><?php echo e(\App\Models\Task::getTaskCount('available', $obj->id)); ?></td>
                                <td class="text-center"><?php echo e(\App\Models\Task::getTaskCount('in-progress', $obj->id)); ?></td>
                                <td class="text-center"><?php echo e(\App\Models\Task::getTaskCount('completed', $obj->id)); ?></td>
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
                <?php if(count($objectives) > 0): ?>
                    <?php $__currentLoopData = $objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Objective Name</div>
                                <div class="mob_table_val">
                                    <a href="<?php echo url('objectives/' . $objectiveIDHashID->encode($obj->id) . '/' . $obj->slug); ?>" title="edit">
                                        <?php echo e($obj->name); ?>

                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Support</div>
                                <div class="mob_table_val"><?php echo e(\App\Models\Task::getTaskCount('available', $obj->id)); ?></div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">In Progress</div>
                                <div class="mob_table_val"><?php echo e(\App\Models\Task::getTaskCount('in-progress', $obj->id)); ?></div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Available</div>
                                <div class="mob_table_val"><?php echo e(\App\Models\Task::getTaskCount('completed', $obj->id)); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="mob_table_section">
                        <div class="mob_table_row">
                            <div class="mob_table_val text-center w-100">
                                No record(s) found.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-between mt-2">
        <div class="pagination-left">
        </div>
        <div class="pagination-right">
            <a href="<?php echo url('objectives/'.$unitIDHashID->encode($unitObj->id).'/add'); ?>">
                <img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/units/view-unit-partials/objectives.blade.php ENDPATH**/ ?>