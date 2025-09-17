<div class="content_block mt-3">
    <div class="table_block table_block_ideas">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
            </div>
            Idea
            <div class="arrow">
                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
            </div>
        </div>
        <div class="table_block_body">


            <table id="watchlist-idea-table-id">
                <thead>
                    <tr>
                        <th class="title_col">Idea Name</th>
                        <th class="type_col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $__currentLoopData = $watchedIdea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $watchedIdeas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo url('ideas/'.$ideaHashID->encode($watchedIdeas->id)); ?>">
                                <?php echo e($watchedIdeas->title); ?>

                            </a>
                        </td>
                        
                        <td style="display: none"></td>
                        <td><?php echo e(strip_tags($watchedIdeas->description)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /var/www/html/javul-staging/javul/resources/views/users/watchlist-partials/idea.blade.php ENDPATH**/ ?>