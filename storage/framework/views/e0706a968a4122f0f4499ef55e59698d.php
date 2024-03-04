<?php $__env->startSection('title', $taskObj->name); ?>
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
                                        Task Information
                                        <div class="arrow">
                                            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total Tasks :
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php echo e($totalTasks); ?>

                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total funds available :
                                            </div>
                                            <div class="sidebar_block_right">
                                                XXX $
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total funds rewarded :
                                            </div>
                                            <div class="sidebar_block_right">
                                                XXXX $
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="content_block">
                    <div class="row">
                        <?php
                            $active = $errors->has('amount') || $errors->has('comment') ? 'bid_now' : 'task_details';
                        ?>

                        <div class="col-12">
                            <ul class="nav nav-tabs" id="taskTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($active == 'task_details' ? 'active' : ''); ?>" id="task-details-tab" data-toggle="tab" href="#task_details" role="tab" aria-controls="task_details" aria-selected="<?php echo e($active == 'task_details' ? 'true' : 'false'); ?>">Task Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="task-actions-tab" data-toggle="tab" href="#task_actions" role="tab" aria-controls="task_actions" aria-selected="false">Task Actions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($active == 'bid_now' ? 'active' : ''); ?>" id="bid-now-tab" data-toggle="tab" href="#bid_now" role="tab" aria-controls="bid_now" aria-selected="<?php echo e($active == 'bid_now' ? 'true' : 'false'); ?>">
                                        <?php echo e(!empty($taskBidder) ? 'Bid Details' : 'Bid Now'); ?>

                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade <?php echo e($active == 'task_details' ? 'show active' : ''); ?>" id="task_details" role="tabpanel" aria-labelledby="task-details-tab">
                                    <!-- Task Details Content Here -->
                                    <div class="list-group-item">
                                        <h4 class="text-orange"><?php echo strtoupper(trans('messages.task_status')); ?></h4>
                                        <?php if(empty($taskObj->assigned_to)): ?>
                                            <div>Unassigned</div>
                                        <?php elseif($taskObj->status == "completed"): ?>
                                            <div>Completed</div>
                                            <div>Completed On: date 23/05/2016</div>
                                        <?php else: ?>
                                            <div>assigned to user X</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="list-group-item">
                                        <h4 class="text-orange"><?php echo strtoupper(trans('messages.task_award')); ?></h4>
                                        <div>xx $</div>
                                    </div>
                                    <div class="list-group-item">
                                        <h4 class="text-orange"><?php echo strtoupper(trans('messages.task_summary')); ?></h4>
                                        <div><?php echo $taskObj->summary; ?></div>
                                    </div>
                                    <div class="list-group-item">
                                        <h4 class="text-orange"><?php echo strtoupper(trans('messages.long_description')); ?></h4>
                                        <div><?php echo $taskObj->description; ?></div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-orange">Task Documents</h4>
                                                <?php if(!empty($taskObj->task_documents)): ?>
                                                    <?php $__currentLoopData = $taskObj->task_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                                        <?php if($extension == "pdf"): ?> <?php $extension="pdf"; ?>
                                                        <?php elseif($extension == "doc" || $extension == "docx"): ?> <?php $extension="docx"; ?>
                                                        <?php elseif($extension == "jpg" || $extension == "jpeg"): ?> <?php $extension="jpeg"; ?>
                                                        <?php elseif($extension == "ppt" || $extension == "pptx"): ?> <?php $extension="pptx"; ?>
                                                        <?php else: ?> <?php $extension="file"; ?> <?php endif; ?>
                                                        <div class="file_documents">
                                                            <a class="files_image" href="<?php echo url($document->file_path); ?>" target="_blank">
                                                                <img src="<?php echo url('assets/images/file_types/'.$extension.'.png'); ?>" style="height:50px;">
                                                                <span style="display:block">
                                        <?php if(empty($document->file_name)): ?>
                                                                        &nbsp;
                                                                    <?php else: ?>
                                                                        <?php echo e($document->file_name); ?>

                                                                    <?php endif; ?>
                                    </span>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Use Bootstrap components and utilities as needed -->
                                </div>
                                <div class="tab-pane fade" id="task_actions" role="tabpanel" aria-labelledby="task-actions-tab">
                                    <!-- Task Actions Content Here -->
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-orange">TASK ACTIONS</h4>
                                                <div><?php echo $taskObj->task_action; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Use Bootstrap components and utilities as needed -->
                                </div>
                                <div class="tab-pane fade <?php echo e($active == 'bid_now' ? 'show active' : ''); ?>" id="bid_now" role="tabpanel" aria-labelledby="bid-now-tab">
                                    <!-- Bid Now Content Here -->
                                    <div class="list-group-item">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label" style="margin-bottom:0px">Task Completion Ratings: Quality of works :<span
                                                                class="stars" style="display:inline-block"><?php echo e($quality_of_work); ?></span>
                                                            (<?php echo e($quality_of_work); ?>/5)
                                                            Timeliness :<span class="stars"
                                                                              style="display:inline-block"><?php echo e($timeliness); ?></span>(<?php echo e($timeliness); ?>/5)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-xs-6 col-sm-4  <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                                                <div class="input-icon right">
                                                    <label for="amount" class="control-label">Amount</label>
                                                    <input name="amount" type="text" required id="amount" class="form-control"
                                                           <?php if(!empty($taskBidder)): ?> value="<?php echo e($taskBidder->amount); ?>" <?php else: ?> value="<?php echo e(old('amount')); ?>" <?php endif; ?>
                                                           <?php if(!empty($taskBidder)): ?> disabled <?php endif; ?>/>
                                                    <?php if($errors->has('amount')): ?>
                                                        <span class="help-block">
                                                <strong><?php echo e($errors->first('amount')); ?></strong>
                                            </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <div class="input-icon right">
                                                    <label for="amount" class="control-label">&nbsp;</label>
                                                    <input class="toggle" <?php if(!empty($taskBidder) && $taskBidder->charge_type == "amount"): ?> checked
                                                           disabled
                                                           <?php endif; ?>
                                                           data-on="Amount"
                                                           data-off="Points"
                                                           type="checkbox" name="charge_type">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12 <?php echo e($errors->has('comment') ? ' has-error' : ''); ?>">
                                                <div class="input-icon right">
                                                    <label for="amount" class="control-label">Comment</label>
                                                    <?php if(!empty($taskBidder)): ?>
                                                        <span class="bid_comment"><?php echo $taskBidder->comment; ?></span>
                                                    <?php else: ?>
                                                        <textarea class="form-control summernote" id="comment" name="comment"><?php echo e(old('comment')); ?></textarea>
                                                        <?php if($errors->has('comment')): ?>
                                                            <span class="help-block">
                                                        <strong><?php echo e($errors->first('comment')); ?></strong>
                                                    </span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(empty($taskBidder)): ?>
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn usermenu-btns orange-bg">Bid</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Use Bootstrap components and utilities as needed -->
                                </div>
                            </div>
                        </div>
                    </div>

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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/bid_now.blade.php ENDPATH**/ ?>