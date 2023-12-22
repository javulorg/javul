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
                    <div class="row form-group">
                        <div class="col-md-12 order-md-2">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title">TASK INFORMATION</h5>
                                </div>
                                <div class="card-body">
                                        <div class="list-group">
                                            <div class="list-group-item py-0">
                                                <div class="row border-bottom border-1">
                                                    <div class="col-7">
                                                        <h4 class="text-success"><?php echo e($taskObj->name); ?></h4>
                                                    </div>

                                                    <div class="col-md-5 text-end">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <a class="add_to_my_watchlist" data-type="task" data-id="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>">
                                                                    <i class="fa fa-eye me-2"></i>
                                                                    <i class="fa fa-plus plus"></i>
                                                                </a>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php if($taskObj->status == "editable"): ?>
                                                                    <a title="Edit Task" href="<?php echo url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit'); ?>">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-7">
                                                                <a href="<?php echo route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]); ?>"><i class="fa fa-history"></i> REVISION HISTORY</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4" style="min-height: 233px">
                                                        <?php echo $taskObj->description; ?>

                                                    </div>

                                                    <div class="col-8 text-end">
                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Status</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($taskObj->status)); ?></label>
                                                                <?php if($taskObj->status == "open_for_bidding" && auth()->check()): ?>
                                                                    <?php if(\App\Models\TaskBidder::checkBid($taskObj->id)): ?>
                                                                        <a title="bid now" href="<?php echo url('tasks/bid_now/'.$taskIDHashID->encode($taskObj->id)).'#bid_now'; ?>" class="btn btn-primary btn-sm" style="color:#fff !important;">
                                                                            Bid now
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a title="applied bid" class="btn btn-warning btn-sm" style="color:#fff !important;">
                                                                            Applied Bid
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Skills</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <?php if(!empty($skill_names) && count($skill_names) > 0): ?>
                                                                    <?php $__currentLoopData = $skill_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <label class="form-label"><?php echo e($skil); ?></label>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <label class="form-label">-</label>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Award</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ <?php echo e($taskObj->compensation); ?></label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Completion</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label"><?php echo e($taskObj->completionTime); ?></label>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Available</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ <?php echo e(number_format($availableFunds,2)); ?></label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Awarded</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ <?php echo e(number_format($availableFunds,2)); ?></label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="p-3 bg-light">
                                        <h4 class="fw-500">Summary:</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="p-3">
                                        <?php echo $taskObj->summary; ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 action_list">
                                    <h4 class="p-3 bg-light fw-500">Action Items</h4>
                                    <div class="list_item_div">
                                        <?php echo $taskObj->task_action; ?>

                                    </div>
                                </div>

                                <div class="col-md-6 file_list">
                                    <h4 class="p-3 bg-light fw-500">File Attachments</h4>
                                    <?php if(!empty($taskObj->task_documents)): ?>
                                        <ul class="list-group list-group-flush" style="padding-left: 30px;">
                                            <?php $__currentLoopData = $taskObj->task_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                                <?php if($extension == "pdf"): ?> <?php $extension="pdf"; ?>
                                                <?php elseif($extension == "doc" || $extension == "docx"): ?> <?php $extension="docx"; ?>
                                                <?php elseif($extension == "jpg" || $extension == "jpeg"): ?> <?php $extension="jpeg"; ?>
                                                <?php elseif($extension == "ppt" || $extension == "pptx"): ?> <?php $extension="pptx"; ?>
                                                <?php else: ?> <?php $extension="file"; ?> <?php endif; ?>
                                                <li class="list-group-item">
                                                    <a class="files_image" href="<?php echo url($document->file_path); ?>" target="_blank">
                                                        <span>
                                                            <?php if(empty($document->file_name)): ?>
                                                                &nbsp;
                                                            <?php else: ?>
                                                                <?php echo e($document->file_name); ?>

                                                            <?php endif; ?>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="p-3 bg-light mt-0">
                                        <h4 class="font-weight-bold">Objective: <span class="custom-orange-text"><?php echo e($taskObj->objective->name); ?></span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>

                <div class="row form-group">
                    <div class="col-md-12 order-md-2">
                        <div class="card border">
                            <div class="card-header">
                                <h4 class="d-flex justify-content-between align-items-center">Comments
                                    <?php if(isset($addComments)){ ?>
                                    <a class="btn btn-dark" href="<?= $addComments ?>">Add Comment</a>
                                    <?php } ?>
                                </h4>
                            </div>
                            <div class="card-body objectiveComment">
                                <div class="list-group">
                                    <div class="list-group-item py-0">
                                        <div class="row">
                                            <ul class="posts"></ul>
                                            <div class="d-flex justify-content-end align-items-center mt-3">
                                                <span class="me-3">Showing last <span class="item-count">0</span> comments.</span>
                                                <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php if(auth()->check()): ?>
                                                <hr>
                                                <div class="form">
                                                    <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="row">
                                                            <div class="col-sm-12 form-group">
                                                                <h4 class="control-label">Comment</h4>
                                                                <textarea class="form-control" id="comment" name="desc"></textarea>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="unit_id" value="<?=  $unit_id ?>">
                                                        <input type="hidden" name="section_id" value="<?=  $section_id ?>">
                                                        <input type="hidden" name="object_id" value="<?=  $object_id ?>">
                                                        <div class="row">
                                                            <div class="col-sm-12 mt-2 form-group">
                                                                <button class="btn btn-dark float-end">Submit Comment</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12 order-md-2">
                        <div class="card border">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <div class="list-group tab-pane" id="task_bidders">
                                    <div class="list-group-item">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Bidder Name</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(count($taskBidders) > 0): ?>
                                                <?php $__currentLoopData = $taskBidders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($bidder->user_id).'/'.
                                        strtolower($bidder->first_name.'_'.$bidder->last_name)); ?>">
                                                                <?php echo e($bidder->first_name.' '.$bidder->last_name); ?>

                                                            </a>
                                                        </td>
                                                        <td><?php echo e($bidder->amount); ?> <span class="badge"><?php echo e($bidder->charge_type); ?></span></td>
                                                        <td>
                                                            <?php if($taskObj->status == "assigned" && $bidder->user_id == $taskObj->assign_to): ?>
                                                                <a class="btn btn-xs btn-warning text-white">Assigned</a>
                                                            <?php elseif($taskObj->status=="completion_evaluation" && $bidder->user_id == $taskObj->assign_to): ?>
                                                                <a class="btn btn-xs btn-success text-white">Completed</a>
                                                            <?php elseif($bidder->status == "offer_rejected"): ?>
                                                                <a class="btn btn-xs btn-danger text-white">Offer Rejected</a>
                                                            <?php elseif($taskObj->status=="in_progress" && $bidder->user_id == $taskObj->assign_to): ?>
                                                                <a class="btn btn-xs btn-info text-white">In Progress</a>
                                                            <?php elseif((empty($taskObj->assign_to) && $isUnitAdminOfTask) || (!empty($taskObj->assign_to) && $isUnitAdminOfTask && $taskObj->status=="open_for_bidding")): ?>
                                                                <a class="btn btn-xs btn-primary assign_now"
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
                                                    <td colspan="3">No bidder found.</td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
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
        ClassicEditor
            .create( document.querySelector('#comment') )
            .catch( error => {
                console.error(error);
            } );
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/view.blade.php ENDPATH**/ ?>