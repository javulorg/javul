<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Comment</th>
                <th>Likes</th>
                <th>Dislikes</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($mostRecentComments) && count($mostRecentComments) > 0): ?>
                <?php $__currentLoopData = $mostRecentComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php $section = \App\Models\Forum::checkSection($comment->topic_id) ?>
                            <a href="<?php echo $section; ?>">
                                <?php echo e($comment->post); ?>

                            </a>
                        </td>
                        <td>
                            <span class="colorLightGreen"><?php echo e($comment->likes); ?></span>
                        </td>
                        <td>
                            <span class="colorLightGreen"><?php echo e($comment->dislikes); ?></span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No record(s) found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/most-recent-comments.blade.php ENDPATH**/ ?>