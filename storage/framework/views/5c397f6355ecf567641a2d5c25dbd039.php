<?php $__env->startSection('title', 'Idea: ' . $idea->title); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
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

        <input type="hidden" id="idea_id" name="idea_id" value="<?php echo e($idea->id); ?>">
        <input type="hidden" id="unit_id" name="unit_id" value="<?php echo e($unitData->id); ?>">

        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_ideas active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($idea->title); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>

                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    <?php echo $idea->description; ?>

                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Idea Overview
                                        <div class="arrow">
                                            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Priority:
                                            </div>
                                            <?php if(isset($ratingResult) && $ratingResult >= 3.5): ?>
                                                <div class="sidebar_block_right">
                                                    High
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e(($ratingResult / 5) * 100); ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php elseif(isset($ratingResult) && ($ratingResult < 3.5 && $ratingResult > 2.5)): ?>
                                                <div class="sidebar_block_right">
                                                    Medium
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e(($ratingResult / 5) * 100); ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php elseif(isset($ratingResult) && ($ratingResult < 2.5)): ?>
                                                <div class="sidebar_block_right">
                                                    Low
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e(($ratingResult / 5) * 100); ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="sidebar_block_right">
                                                    Low
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e(($ratingResult / 5) * 100); ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <?php if(auth()->guard()->check()): ?>
                                                <div class="sidebar_block_right">
                                                    <a href="#" class="modal-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rate</a>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Priority</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="ratingForm">
                                                                        <div class="form-group">
                                                                            <label for="rating">Select rating:</label><br>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input" id="rating1" name="rating" value="1">
                                                                                <label class="form-check-label" for="rating1">Low</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input" id="rating2" name="rating" value="2">
                                                                                <label class="form-check-label" for="rating2">Medium-Low</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input" id="rating3" name="rating" value="3">
                                                                                <label class="form-check-label" for="rating3">Medium</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input" id="rating4" name="rating" value="4">
                                                                                <label class="form-check-label" for="rating4">Medium-High</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input" id="rating5" name="rating" value="5">
                                                                                <label class="form-check-label" for="rating5">High</label>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" id="submitRating" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php if($idea->status == 1): ?>
                                                    Draft
                                                <?php elseif($idea->status == 2): ?>
                                                    Assigned to Task
                                                <?php else: ?>
                                                    Implemented
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="<?php echo url('ideas/'. $ideaHashId .'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo url('ideas/'. $ideaHashId .'/history'); ?>" class="edit_icon"> Revision History</a>
                                    <div class="separat"></div>
                                    <a href="<?php echo url('ideas/'. $ideaHashId .'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Related Task
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">
                                        Title
                                    </th>
                                    <th class="status_col">
                                        Status
                                    </th>
                                    <th class="type_col"><i class="fa fa-trophy"></i></th>
                                    <th class="type_col"><i class="fa fa-clock"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="type_col">
                                        <?php if(isset($idea->task)): ?>
                                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($idea->task->id).'/'.$idea->task->name); ?>"
                                               title="edit">
                                                <?php echo e($idea->task->name); ?>

                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="title_col">
                                        <?php if(isset($idea->task)): ?>
                                            <?php if($idea->task->status == "editable"): ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($idea->task->status)); ?></span>
                                            <?php else: ?>
                                                <span class="colorLightGreen"><?php echo e(\App\Models\SiteConfigs::task_status($idea->task->status)); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="status_col">
                                        <?php if(isset($idea->task)): ?>
                                             <?php echo e(\App\Models\Task::getTaskCount('in-progress',$idea->task->id)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="replies_col">
                                        <?php if(isset($idea->task)): ?>
                                            <?php echo e(\App\Models\Task::getTaskCount('completed',$idea->task->id)); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="content_block_bottom">
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_issues">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Related Issues
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Issue Name</th>
                                    <th class="type_col">Status</th>
                                    <th class="type_col">Created By</th>
                                    <th class="type_col">Created Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php if(isset($idea->issue)): ?>
                                        <td class="title_col">
                                            <a href="<?php echo url('issues/'.$issueIDHashID->encode($idea->issue->id).'/view'); ?>"
                                               title="edit">
                                                <?php echo e($idea->issue->title); ?>

                                            </a>
                                        </td>
                                        <td class="type_col">
                                                <?php $status_class=''; $verified_by =''; $resolved_by ='';
                                                if($idea->issue->status=="unverified")
                                                    $status_class="text-danger";
                                                elseif($idea->issue->status=="verified"){
                                                    $status_class="text-info";
                                                    $verified_by = " (by ".App\Models\User::getUserName($idea->issue->verified_by).')';
                                                }
                                                elseif($idea->issue->status == "resolved"){
                                                    $status_class = "text-success";
                                                    $resolved_by = " (by ".App\Models\User::getUserName($idea->issue->resolved_by).')';
                                                }
                                                ?>
                                            <span class="<?php echo e($status_class); ?>"><?php echo e(ucfirst($idea->issue->status).$verified_by. $resolved_by); ?></span>
                                        </td>
                                        <td class="type_col">
                                            <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($idea->issue->user_id).'/'.strtolower(str_replace(" ","_",App\Models\User::getUserName($idea->issue->user_id)))); ?>">
                                                <?php echo e(App\Models\User::getUserName($idea->issue->user_id)); ?>

                                            </a>
                                        </td>
                                        <td class="type_col"><?php echo e($idea->issue->created_at); ?></td>
                                    <?php endif; ?>

                                </tr>
                                </tbody>
                            </table>
                        </div>
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
                    $('.modal-link').click(function() {
                        var modalId = $(this).data('modal-id');
                        $('#modalIdSpan').text(modalId);
                    });

                    $('#submitRating').click(function() {
                        var selectedRating = $("input[name='rating']:checked").val();
                        if (selectedRating !== undefined) {

                            var unitId = $('#unit_id').val();
                            var typeId = $('#idea_id').val();
                            $.ajax({
                                url: '<?php echo e(url("priorities")); ?>',
                                type: 'POST',
                                data: {
                                    type_value   : 2,
                                    rating :selectedRating,
                                    unit_id : unitId,
                                    type_id : typeId,
                                    _token: $('input[name="_token"]').val(),
                                },
                                success: function (response, xhr, textStatus) {
                                    if (response.status === 201) {
                                        $('#exampleModal').modal('hide');
                                        location.reload();
                                    }
                                },
                                error: function (xhr, textStatus, errorThrown) {
                                    console.log(xhr.responseText);
                                },
                            });
                        }else {
                            alert("Please select a rating.");
                        }

                    });
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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/ideas/show.blade.php ENDPATH**/ ?>