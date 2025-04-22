<div class="main_content">
<div class="content_block mt-3">
    <div class="table_block table_block_wiki_pages">
        <div class="table_block_head">
            <div class="table_block_icon">
                <i class="fa fa-comments"></i>
            </div>
            Other Discussions
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Thread title </th>
                    <th class="last_reply_col">Created By</th>
                    <th class="last_reply_col">Replies</th>
                </tr>
                </thead>

                <tbody>
                <?php if(isset($topics[4])): ?>
                    <?php $__currentLoopData = $topics[4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="title_col">
                                <a href="<?php echo url('forum/post').'/'.$topic['topic_id'].'/'.$topic['slug']; ?>"> <?= $topic['title'] ?> </a>
                            </td>

                            <td class="last_reply_col">
                                <a href="<?php echo $topic['link_user']; ?>"> <?= $topic['first_name'] ." ". $topic['last_name'] ?> </a>
                            </td>

                            <td class="last_reply_col">
                                <?= $topic['post'] ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No record(s) found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>

                <div class="mob_table d-sm-none d-block">
                    <?php if(isset($topics[4]) && count($topics[4]) > 0): ?>
                        <?php $__currentLoopData = $topics[4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Thread Title</div>
                                    <div class="mob_table_val">
                                        <a href="<?php echo e(url('forum/post/'.$topic['topic_id'].'/'.$topic['slug'])); ?>">
                                            <?php echo e($topic['title']); ?>

                                        </a>
                                    </div>
                                </div>
                
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Created By</div>
                                    <div class="mob_table_val">
                                        <a href="<?php echo e($topic['link_user']); ?>">
                                            <?php echo e($topic['first_name'] . ' ' . $topic['last_name']); ?>

                                        </a>
                                    </div>
                                </div>
                
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Replies</div>
                                    <div class="mob_table_val">
                                        <?php echo e($topic['post']); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_val text-center">No record(s) found.</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                

            </table>

        </div>
    </div>
    <div class="content_block_bottom">
            <a href="<?php echo url('forum/create').'/'.$unit_id.'/'.'other_discussions'; ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
        </div>
</div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/forum/forum-partials/other-discussions.blade.php ENDPATH**/ ?>