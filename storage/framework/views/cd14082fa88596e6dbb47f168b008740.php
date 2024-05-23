<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Unit</th>
                <th>Section</th>
                <th>Comment</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($topComments) && count($topComments) > 0): ?>
                <?php $__currentLoopData = $topComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php $section = \App\Models\Forum::checkSection($comment->topic_id) ?>
                            <a href="<?php echo $section['unit_url']; ?>">
                                <?php echo e($section['unit_name']); ?>

                            </a>
                        </td>
                        <td>
                            <?php $section = \App\Models\Forum::checkSection($comment->topic_id) ?>
                            <span class="colorLightGreen"><?php echo $section['section']; ?></span>
                        </td>
                        <td>
                            <?php $section = \App\Models\Forum::checkSection($comment->topic_id) ?>
                            <a href="<?php echo $section['url']; ?>">
                                <?php echo e(substr($comment->post, 0, 60)); ?><?php echo e(strlen($comment->post) > 60 ? '...' : ''); ?>

                            </a>
                        </td>

                        <td>
                            <?php if($comment->created_time): ?>
                                <?php echo e(Carbon\Carbon::parse($comment->created_time)->diffForHumans()); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile-partials/top-comments.blade.php ENDPATH**/ ?>