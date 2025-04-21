<div class="content_block mt-3">
    <div class="table_block table_block_issues">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
            </div>
            Issues
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">


            <table id="watchlist-issues-table-id">
                <thead>
                <tr>
                    <th class="title_col">Issue Name</th>
                    <th class="type_col">Description</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $watchedissues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $watchedissue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                        <tr>
                            <td><?php echo e($watchedissue->title); ?></td>
                            <td></td>
                            <td><?php echo e($watchedissue->description); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/watchlist-partials/issues.blade.php ENDPATH**/ ?>