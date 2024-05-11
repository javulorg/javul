<?php $__env->startSection('title', 'Ideas: REVISION HISTORY'); ?>
<?php $__env->startSection('site-name'); ?>
    <?php if(isset($unitData)): ?>
        <h1><?php echo e($unitData->name); ?></h1>
    <?php else: ?>
        <h1>Javul.org</h1>
    <?php endif; ?>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>
    <?php if(isset($unitData)): ?>
        <?php echo $__env->make('layout.navbar', ['unitData' => $unitData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">
            <?php if(isset($unitData)): ?>
                <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php
                    $title = 'Activity Log';
                    ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                    <?php
                    $title = 'Global Activity Log';
                    ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>


        <div class="main_content mt-2">
            <div class="content_block">
                <div class="table_block table_block_ideas">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        View History: <?php echo $idea->title; ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table id="idea-table-id">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="title_col">Rev Link</th>
                                <th class="last_reply_col">Time</th>
                                <th class="last_reply_col">Username</th>
                                <th class="last_reply_col">Edit Comment</th>
                                <th class="last_reply_col">Size</th>
                            </tr>
                            </thead>
                            <?php $__currentLoopData = $revisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $user_id = $userIDHashID->encode($value->user_id); ?>
                                <tr>
                                    <td><input type="checkbox" name="id" value="<?php echo e($value['id']); ?>" class="single-checkbox"></td>
                                    <td class="title_col"><a href="<?php echo route('unit_idea_view',[$idea_id,$value['id']]); ?>">View </a></td>
                                    <td class="title_col"><?php echo e($Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->diffForHumans()); ?></td>
                                    <td class="last_reply_col"><a href="<?php echo e(url('userprofiles/'. $user_id .'/'.strtolower($value->first_name.'_'.$value->last_name))); ?>"><?php echo e($value->first_name ." ".$value->last_name); ?></a></td>
                                    <td class="last_reply_col"><?php echo e($value->comment); ?></td>
                                    <td class="last_reply_col"><?php echo e($value->size); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="text-center mt-3 mb-3">
                            <button class="btn btn-secondary btn-compare">Compare Revisions</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        var limit = 3;
        $('input.single-checkbox').on('change', function(evt) {

            if($('input.single-checkbox:checked').length >= limit) {
                this.checked = false;
            }
            if($('input.single-checkbox:checked').length == 2) {
                $(".btn-compare").addClass("black-btn");
            }
            else
            {
                $(".btn-compare").removeClass("black-btn");
            }
        });
        var loc ='<?php echo url("objectives"); ?>/<?php echo $idea_id; ?>/diff';
        var slug ='';

        $(".btn-compare").click(function(){
            if($('input.single-checkbox:checked').length == 2) {
                var rev = $('input.single-checkbox:checked')[0].value;
                var comp = $('input.single-checkbox:checked')[1].value;
                console.log(loc + "/" + rev + "/" + comp);
                location.href = loc + "/" + rev + "/" + comp ;
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/ideas/revision/view.blade.php ENDPATH**/ ?>