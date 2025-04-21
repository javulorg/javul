<div class="content_block mt-3">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
            </div>
            Objectives
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table id="watchlist-objectives-table-id">
                <thead>
                    <tr>
                        <th class="title_col">Objective Name</th>
                        <th class="title_col"><?php echo trans('messages.description'); ?></th>
                    </tr>
                </thead>

                
                <?php $__currentLoopData = $watchedUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $watchedUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($watchedUnit->name); ?></td>
                        <td style="display: none"></td>
                        <!-- Use strip_tags to remove HTML tags from description -->
                        <td><?php echo e(strip_tags($watchedUnit->description)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </table>
        </div>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/watchlist-partials/objectives.blade.php ENDPATH**/ ?>