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
                    <th class="type_col">Support</th>
                    <th class="type_col">In progress</th>
                    <th class="type_col">Available</th>
                </tr>
                </thead>

                <tbody>
                <?php if(count($objectives) > 0): ?>
                    <?php $__currentLoopData = $objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug); ?>" title="edit">
                                    <?php echo e($obj->name); ?>

                                </a>
                            </td>
                            <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('available',$obj->id)); ?></td>
                            <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('in-progress',$obj->id)); ?></td>
                            <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('completed',$obj->id)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No record(s) found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

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