<?php $__env->startSection('title', 'Issue: ' . $issueObj->title); ?>
<?php $__env->startSection('style'); ?>


<?php $__env->stopSection(); ?>
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

    <div class="main_content">
        <div class="content_block">
            <div class="table_block table_block_issues active">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                    </div>
                    <?php echo e($issueObj->title); ?>

                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                    </div>
                </div>
                <div class="objective_content">
                    <div class="objective_content_row d-sm-flex d-none">
                        <div>
                            <p>
                                <?php echo $issueObj->description; ?>

                            </p>
                        </div>
                        <div class="objective_content_info">
                            <div class="sidebar_block">
                                <div class="sidebar_block_ttl">
                                    Issue Overview
                                    <div class="arrow">
                                        <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                    </div>
                                </div>
                                <div class="sidebar_block_content">
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                        </div>
                                        <div class="sidebar_block_right">

                                            <div class="progress">
                                                <div class="progress-bar" style="width:75%"></div>
                                            </div> <a href="<?php echo url('issues/'.$issueIDHashID->encode($issueObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Status:
                                        </div>
                                        <div class="sidebar_block_right">
                                            <?php $verified_by ='';?>
                                            <?php if($issueObj->status == "verified"): ?>
                                                    <?php $verified_by = " (by ".App\Models\User::getUserName($issueObj->verified_by).')';?>
                                            <?php endif; ?>
                                            <?php echo e(ucfirst($issueObj->status. $verified_by )); ?>

                                        </div>
                                    </div>
                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Support
                                        </div>
                                        <div class="sidebar_block_right">
                                            <?php
                                            $voteClass = "";
                                            $upvoteClass = "";
                                            $downvoteClass = "";

                                            if (auth()->check()) {
                                                $voteClass = "vote";
                                                $flag = \App\Models\ImportanceLevel::checkImportanceLevel($issueObj->id, 'issue_id');

                                                if ($flag == "1") {
                                                    $upvoteClass = "success-upvote";
                                                } elseif ($flag == "-1") {
                                                    $downvoteClass = "success-downvote";
                                                }
                                            }
                                            ?>

                                            <div style="float:left;"><?php echo e($importancePercentage); ?>%</div>

                                            <div class="vote-buttons">
                                                <span class="fa fa-thumbs-up <?php echo e($voteClass); ?> upvote <?php echo e($upvoteClass); ?>"
                                                      <?php if(auth()->check()): ?> data-id="<?php echo e($issueIDHashID->encode($issueObj->id)); ?>" data-type="up" <?php endif; ?>
                                                      title="Upvote"></span>
                                                <?php echo e($upvotedCnt); ?>


                                                <span class="fa fa-thumbs-down <?php echo e($voteClass); ?> downvote <?php echo e($downvoteClass); ?>"
                                                      <?php if(auth()->check()): ?> data-id="<?php echo e($issueIDHashID->encode($issueObj->id)); ?>" data-type="down" <?php endif; ?>
                                                      title="Downvote"></span>
                                                <?php echo e($downvotedCnt); ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="objective_content_info_links">
                                <a class="add_to_my_watchlist edit_icon" data-type="issue" data-id="<?php echo e($issueIDHashID->encode($issueObj->id)); ?>" data-redirect="<?php echo e(url()->current()); ?>"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                <div class="separat"></div>
                                <a href="<?php echo route('issues_revison',[$issueIDHashID->encode($issueObj->id)]); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""> Revision History</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content_block">
            <div class="table_block table_block_objective">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="<?php echo e(asset('v2/assets/img/User_Rounded.svg')); ?>" alt="" class="img-fluid">
                    </div>
                    Associated Objective
                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                    </div>
                </div>

                <?php
                    $objectiveID = $issueObj->objective_id;
                    $objSlug = \App\Models\Objective::getSlug($objectiveID);
                    $objectiveUrl = url('objectives/'.$objectiveIDHashID->encode($objectiveID).'/'.$objSlug);
                    $objectiveName = \App\Models\Objective::getObjectiveName($objectiveID);
                ?>

                <div class="table_block_txt">
                    <a style="font-weight: normal;" class="no-decoration" href="<?php echo e($objectiveUrl); ?>">
                        <?php echo e($objectiveName); ?>

                    </a>
                </div>
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>

        <div class="content_block">
            <div class="table_block table_block_objective">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="<?php echo e(asset('v2/assets/img/User_Rounded.svg')); ?>" alt="" class="img-fluid">
                    </div>
                    Associated Tasks
                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                    </div>
                </div>

                <?php
                    $taskIDs = explode(",", $issueObj->task_id);
                ?>
                <?php if(count($taskIDs) > 0): ?>
                    <?php $__currentLoopData = $taskIDs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskID): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $taskSlug = \App\Models\Task::getSlug($taskID);
                            $taskUrl = url('tasks/'.$taskIDHashID->encode($taskID).'/'.$taskSlug);
                            $taskName = \App\Models\Task::getName($taskID);
                        ?>
                        <div class="table_block_txt">
                            <a style="font-weight: normal;" class="no-decoration" href="<?php echo e($taskUrl); ?>">
                                <?php echo e($taskName); ?>

                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>


        <div class="content_block_comments">
            <div class="table_block table_block_comments">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="<?php echo e(asset('v2/assets/img/Dialog.svg')); ?>" alt="" class="img-fluid">
                    </div>
                    Comments
                </div>
                <div class="comments_content">
                    <div class="comment_stat">
                        <b></b> <a href="#">Write a review</a>
                    </div>

                    <?php if(isset($comments)): ?>
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="comment_container">
                                <div class="comment_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/User_Circle.svg')); ?>" alt="" class="img-fluid">
                                </div>
                                <div class="comment_content">
                                    <div class="comment_info">
                                        <div class="comment_autor">
                                            <?php
                                                $user = \App\Models\User::where('id', $comment->user_id)->select('first_name','last_name')->first();
                                            ?>
                                            <?php echo e($user->first_name . ' ' . $user->last_name); ?>

                                        </div>
                                        <div class="comment_time">
                                            <?php echo e(Carbon\Carbon::parse($comment->created_time)->diffForHumans()); ?>


                                        </div>
                                    </div>
                                    <div class="comment_txt">
                                        <?php echo e($comment->post); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>



                    <div class="comment_container">
                        <div class="comment_icon">
                            <img src="<?php echo e(asset('v2/assets/img/User_Circle.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <input type="hidden" name="unit_id" id="comment_unit_id" value="<?=  $unit_id ?>">
                        <input type="hidden" name="section_id" id="comment_section_id" value="<?=  $section_id ?>">
                        <input type="hidden" name="object_id" id="comment_object_id" value="<?=  $object_id ?>">
                        <div class="comment_content">
                            <textarea cols="30" id="comment" rows="10" placeholder="White a message..."></textarea>
                            <button id="comment_form"  class="btn">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>

    </div>






</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $("#comment_form").click(function(e)
            {
                var unitId = $('#comment_unit_id').val();
                var sectionId = $('#comment_section_id').val();
                var objectId = $('#comment_object_id').val();
                var desc = $('#comment').val();

                $.ajax({
                    type: "POST",
                    url: '<?php echo e(url("/forum/submitauto")); ?>',
                    data: {
                        unit_id : unitId,
                        section_id : sectionId,
                        object_id : objectId,
                        desc : desc,
                        _token: $('input[name="_token"]').val(),
                    },
                    success: function (response, xhr, textStatus) {
                        if (response.status === 201) {
                            location.reload();
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    },
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>









































































































































<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/view.blade.php ENDPATH**/ ?>