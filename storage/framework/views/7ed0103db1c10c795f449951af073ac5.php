<?php $__env->startSection('title', 'Objective: ' . $objectiveObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
        a.modal-link {
            font-size: 13px;
            text-decoration: none; /* Remove underline */
        }
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

        <input type="hidden" id="objective_id" name="objective_id" value="<?php echo e($objectiveObj->id); ?>">
        <input type="hidden" id="unit_id" name="unit_id" value="<?php echo e($unitData->id); ?>">
        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_objectives active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($objectiveObj->name); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                               <p>
                                   <?php echo $objectiveObj->description; ?>

                               </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Objective Overview
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
                                            <?php elseif(isset($ratingResult) && ($ratingResult < 2.5) && ($ratingResult > 2)): ?>
                                                <div class="sidebar_block_right">
                                                    Low
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e(($ratingResult / 5) * 100); ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="sidebar_block_right">
                                                    Medium
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e((2.5 / 5) * 100); ?>%"></div>
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

                                                                            <div class="form-check mt-3">
                                                                                <input type="radio" class="form-check-input" id="rating5" name="rating" value="5">
                                                                                <label class="form-check-label" for="rating5">High</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="radio" class="form-check-input" id="rating4" name="rating" value="4">
                                                                                <label class="form-check-label" for="rating4">Medium-High</label>
                                                                            </div>

                                                                            <div class="form-check">
                                                                                <input type="radio" class="form-check-input" id="rating3" name="rating" value="3">
                                                                                <label class="form-check-label" for="rating3">Medium</label>
                                                                            </div>

                                                                            <div class="form-check">
                                                                                <input type="radio" class="form-check-input" id="rating2" name="rating" value="2">
                                                                                <label class="form-check-label" for="rating2">Medium-Low</label>
                                                                            </div>

                                                                            <div class="form-check">
                                                                                <input type="radio" class="form-check-input" id="rating1" name="rating" value="1">
                                                                                <label class="form-check-label" for="rating1">Low</label>
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
                                                <?php echo e(\App\Models\Objective::objectiveStatus()[$objectiveObj->status]); ?>

                                            </div>
                                        </div>
                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Funds:
                                            </div>
                                            <div class="sidebar_block_right">
                                                Received $2500<br>
                                                Awarded $<?php echo e(number_format($awardedObjFunds,2)); ?><br>
                                                Available $<?php echo e(number_format($availableObjFunds,2)); ?><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo route('objectives_revison',[$objectiveIDHashID->encode($objectiveObj->id)]); ?>" class="edit_icon"> Revision History</a>
                                    <div class="separat"></div>
                                    <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content_block">
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
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">
                                    Title
                                </th>
                                <th class="status_col">
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($objectiveObj->tasks) > 0): ?>
                                <?php $__currentLoopData = $objectiveObj->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug); ?>" title="edit">
                                                <?php echo e($obj->name); ?>

                                            </a>
                                        </td>
                                        <td class="status_col">
                                            <?php if($obj->status == "editable"): ?>
                                                <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php else: ?>
                                                <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No record(s) found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="<?php echo url('objectives/' . $object_hash_id . '/' . $objectiveObj->slug . '/' . $unitData->id . '/tasks'); ?>">
                        <img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt="">
                        Add New
                    </a>
                    <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>

            <div class="content_block">
                <div class="table_block table_block_objective">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/User_Rounded.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Parent Objectives
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>

                    <?php $objSlug = \App\Models\Objective::getSlug($objectiveObj->parent_id); ?>
                    <div class="table_block_txt">
                        <a style="font-weight: normal;" class="no-decoration" href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->parent_id).'/'.$objSlug ); ?>">
                            <?php echo e(\App\Models\Objective::getObjectiveName($objectiveObj->parent_id)); ?>

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
                            <img src="<?php echo e(asset('v2/assets/img/Users_Two_Rounded.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Child Objectives
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_txt">

                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>

            <div class="content_block">
                <div class="table_block table_block_ideas">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Ideas
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Idea Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($objectiveIdeas->ideas)): ?>
                                <?php $__currentLoopData = $objectiveIdeas->ideas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('ideas/'.$ideaHashID->encode($idea->id)); ?>">
                                                <?php echo e($idea->title); ?>

                                            </a>
                                        </td>
                                        <?php if($idea->status == 1): ?>
                                            <td class="type_col"> Draft</td>
                                        <?php elseif($idea->status == 2): ?>
                                            <td class="type_col">Assigned to Task</td>
                                        <?php else: ?>
                                            <td class="type_col">Implemented</td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="<?php echo url('ideas/'.$unitIDHashID->encode($unitData->id).'/add'); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
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

                                        <div class="comment_actions">
                                            <input type="hidden" value="<?php echo e($comment->id); ?>" id="comment_id_<?php echo e($comment->id); ?>">

                                            <button type="button" class="like_button">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span id="like_count" class="badge badge-primary">
                                                <span class="count"> <?php echo e($comment->likes); ?></span>
                                            </span>
                                            </button>
                                            <button type="button" class="dislike_button">
                                                <i class="fas fa-thumbs-down"></i>
                                                <span id="dislike_count" class="badge badge-danger">
                                                 <span class="count"> <?php echo e($comment->dislikes); ?></span>
                                            </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <style>
                                    .comment_actions form {
                                        display: inline-block;
                                        margin-right: 10px;
                                    }
                                    .comment_actions form:last-child {
                                        margin-right: 0;
                                    }
                                    .badge .count {
                                        color: black; /* Adjust color as needed */
                                    }
                                </style>
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
                                    <button id="comment_form"  class="btn">Submit</button>
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
                    var typeId = $('#objective_id').val();
                    $.ajax({
                        url: '<?php echo e(url("priorities")); ?>',
                        type: 'POST',
                        data: {
                            type_value   : 3,
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

            $('.like_button').click(function() {
                var commentId = $(this).closest('.comment_container').find('input[type=hidden]').val();
                $.ajax({
                    url: '<?php echo e(route("like")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        comment_id: commentId
                    },
                    success: function(response) {
                        $('#like_count').text(response.dislike_count);
                        location.reload();
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });

            $('.dislike_button').click(function() {
                var commentId = $(this).closest('.comment_container').find('input[type=hidden]').val();
                $.ajax({
                    url: '<?php echo e(route("dislike")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        comment_id: commentId
                    },
                    success: function(response) {
                        console.log(response)

                        $('#dislike_count').text(response.dislike_count);
                        location.reload();

                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
            });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/view.blade.php ENDPATH**/ ?>