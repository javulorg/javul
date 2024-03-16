<div class="content_block mt-3 mb-4">
    <div class="table_block table_block_tasks">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
            </div>
            Tasks
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Task Name</th>
                    <th class="type_col">Status</th>
                    <th class="type_col"><i class="fa fa-trophy"></i></th>
                    <th class="type_col"><i class="fa fa-clock"></i></th>
                </tr>
                </thead>

                <tbody>
                <?php if(count($tasks) > 0): ?>
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="title_col">
                                <a href="<?php echo url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug); ?>"
                                   title="edit">
                                    <?php echo e($obj->name); ?>

                                </a>
                            </td>
                            <td class="type_col">
                                <?php if($obj->status == "draft"): ?>
                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                <?php else: ?>
                                    <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="type_col"><?php echo e(\App\Models\Task::getTaskCount('in-progress',$obj->id)); ?></td>
                            <td class="type_col"><?php echo e(\App\Models\Task::getTaskCount('completed',$obj->id)); ?></td>
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
            <a href="<?php echo url('tasks/add?unit='.$unitIDHashID->encode($unitObj->id)); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/units/view-unit-partials/tasks.blade.php ENDPATH**/ ?>