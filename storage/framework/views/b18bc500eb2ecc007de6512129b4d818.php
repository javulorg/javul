<div class="content_block mt-3">
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
            <table id="watchlist-tasks-table-id">
                <thead>
                <tr>
                    <th class="title_col">Task Name</th>
                    <th class="type_col">Description</th>
                </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $watchedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $watchedTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($watchedTask->name); ?></td>
                            <td></td>
                            <td><?php echo e($watchedTask->description); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>
        </div>
    </div>


</div>
<?php /**PATH C:\xampp\htdocs\javul-new\javul\resources\views/users/watchlist-partials/tasks.blade.php ENDPATH**/ ?>