<?php $__env->startSection('title', 'Task: ' . $taskObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .custom-orange-text {
            color: orange;
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
        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_tasks active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($taskObj->name); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    <?php echo $taskObj->description; ?>

                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Task Overview
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <label class="control-label" style="color: lightgreen;"><?php echo e(\App\Models\SiteConfigs::task_status($taskObj->status)); ?></label>
                                                <?php if($taskObj->status == "open_for_bidding" && auth()->check()): ?>
                                                    <?php if(\App\Models\TaskBidder::checkBid($taskObj->id)): ?>
                                                        <a title="Bid Now" href="<?php echo url('tasks/bid_now/'.$taskIDHashID->encode($taskObj->id)).'#bid_now'; ?>" class="btn btn-success btn-sm" style="color:#fff !important;">
                                                            Bid Now
                                                        </a>
                                                    <?php else: ?>
                                                        <a title="Applied Bid" class="btn btn-warning btn-sm disabled" style="color:#fff !important;">
                                                            Applied Bid
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>

                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Skills
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php if(!empty($skill_names) && count($skill_names) > 0): ?>
                                                      <?php echo e($skill_names[0]); ?>

                                                <?php else: ?>
                                                   -
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Award
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e($taskObj->compensation); ?>

                                            </div>
                                        </div>


                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Completion
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php echo e($taskObj->completionTime); ?>

                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Available
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e(number_format($availableFunds,2)); ?>

                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Awarded
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ <?php echo e(number_format($availableFunds,2)); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a class="add_to_my_watchlist edit_icon" data-type="task" data-id="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>" data-redirect="<?php echo e(url()->current()); ?>"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]); ?>" class="edit_icon"> Revision History</a>
                                    <div class="separat"></div>
                                    <a href="<?php echo url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_block mt-4">
                <div class="table_block table_block_objectives active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Objectives
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>

                    <?php $objSlug = \App\Models\Objective::getSlug($taskObj->objective->id); ?>
                    <div class="table_block_txt">
                        <a style="font-weight: normal;" class="no-decoration" href="<?php echo url('objectives/'.$objectiveIDHashID->encode($taskObj->objective->id).'/'.$objSlug ); ?>">
                            <?php echo e($taskObj->objective->name); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="content_block_comments mt-4">
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
                                <button id="comment_form"  class="btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>


            <div class="content_block mt-4">
                <div class="table_block table_block_tasks">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/auction.png')); ?>" alt="" class="img-fluid">
                        </div>
                        Bidders
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">

                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Bidder Name</th>
                                <th class="type_col">Amount</th>
                                <th class="type_col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if(count($taskBidders) > 0): ?>
                                <?php $__currentLoopData = $taskBidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($bidder->user_id).'/'.
                                                strtolower($bidder->first_name.'_'.$bidder->last_name)); ?>">
                                                <?php echo e($bidder->first_name.' '
                                                .$bidder->last_name); ?>

                                            </a>
                                        </td>
                                        <td class="type_col"><?php echo e($bidder->amount); ?> <span class="badge" style="color: #0d1217; font-size:12px;"><?php echo e($bidder->charge_type); ?></span></td>
                                        <td class="type_col">
                                            <?php if($taskObj->status == "assigned" && $bidder->user_id == $taskObj->assign_to): ?>
                                                <a class="btn btn-sm btn-warning" style="color:#fff;">Assigned</a>
                                            <?php elseif($taskObj->status=="completion_evaluation" && $bidder->user_id == $taskObj->assign_to): ?>
                                                <a class="btn btn-sm btn-success" style="color:#fff;">Completed</a>
                                            <?php elseif($bidder->status == "offer_rejected"): ?>
                                                <a class="btn btn-sm btn-danger" style="color:#fff;">Offer Rejected</a>
                                            <?php elseif($taskObj->status=="in_progress" && $bidder->user_id == $taskObj->assign_to): ?>
                                                <a class="btn btn-sm btn-info" style="color:#fff;">In Progress</a>
                                            <?php elseif((empty($taskObj->assign_to) && ($isUnitAdminOfTask || auth()->user()->role == 1 || auth()->user()->role == 3)) || (!empty($taskObj->assign_to) && ($isUnitAdminOfTask || auth()->user()->role == 1 || auth()->user()->role == 3) && $taskObj->status=="open_for_bidding")): ?>

                                                <a class="btn btn-sm btn-primary assign_now"
                                                   data-uid="<?php echo e($userIDHashID->encode($bidder->user_id)); ?>"
                                                   data-tid="<?php echo e($taskIDHashID->encode($bidder->task_id)); ?>"
                                                   style="color:#fff;">Assign now</a>
                                            <?php else: ?>
                                                -
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
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $("#comment_form").click(function(e){
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

            $(".assign_now").click(function (e) {
                var uid = $(this).attr('data-uid');
                var tid = $(this).attr('data-tid');
                if($.trim(uid) != "" && $.trim(tid) != ""){
                    $.ajax({
                        type:'GET',
                        url: '<?php echo e(url("/tasks/assign")); ?>',
                        data:{uid:uid,tid:tid },
                        dataType:'json',
                        success:function(resp){
                            if (resp.success) {
                                // Show SweetAlert notification
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Task assigned successfully!',
                                    timer: 2000, // Set a timer for auto-close
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reload the page
                                    window.location.reload(true);
                                });
                            }
                        }
                    })
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/view.blade.php ENDPATH**/ ?>