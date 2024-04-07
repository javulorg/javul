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
                        TASK MANAGEMENT / Complete Task : <?php echo e($taskObj->name); ?>

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

            <div class="content_block mt-3">
                <div class="row">
                    <div class="col-sm-6 action_list" style="padding-right: 0px;">
                        <h4 style="padding:10px 15px;background-color: #f9f9f9;margin-top:0px;font-weight: 500;">Action Items</h4>
                        <div class="list_item_div">
                            <?php echo $taskObj->task_action; ?>

                        </div>
                    </div>
                    <div class="col-sm-6 file_list" style="padding-left: 0px;">
                        <h4 style="padding:10px 15px;background-color: #f9f9f9;margin-top:0px;font-weight: 500;">File Attachments</h4>
                        <?php if(!empty($taskObj->task_documents) && count($taskObj->task_documents) > 0): ?>
                            <?php echo e(count($taskObj->task_documents)); ?>

                            <ul style="list-style-type: decimal; padding-left:30px;">
                                <?php $__currentLoopData = $taskObj->task_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                    <?php if($extension == "pdf"): ?> <?php $extension="pdf"; ?>
                                    <?php elseif($extension == "doc" || $extension == "docx"): ?> <?php $extension="docx"; ?>
                                    <?php elseif($extension == "jpg" || $extension == "jpeg"): ?> <?php $extension="jpeg"; ?>
                                    <?php elseif($extension == "ppt" || $extension == "pptx"): ?> <?php $extension="pptx"; ?>
                                    <?php else: ?> <?php $extension="file"; ?> <?php endif; ?>
                                    <li>
                                        <a class="files_image" href="<?php echo url($document->file_path); ?>" target="_blank">
                                            <span style="display:block">
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
                        <?php else: ?>
                            <ul style="list-style-type: none; padding-left:20px;">
                                <li>No file(s) found.</li>
                            </ul>
                        <?php endif; ?>
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

            <div class="content_block mt-3">
                <div class="row">
                    <div class="col-sm-12" style="padding:20px 20px 10px 30px;">
                        <form role="form" method="post" action="<?php echo e(url('tasks/complete_task/' . $taskIDHashID->encode($taskObj->id))); ?>"  novalidate="novalidate" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <?php if(!empty($taskCompleteObj) && count($taskCompleteObj) > 0): ?>
                                    <?php $i=1; ?>
                                <?php $__currentLoopData = $taskCompleteObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $completeObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <img src="<?php echo url('assets/images/user.png'); ?>" style="border: 1px solid;height:50px;vertical-align: top;"/>
                                            <div style="display: inline-block;padding-left: 10px;">
                                                <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($completeObj->user_id).'/'.
                                                        strtolower($completeObj->first_name.'_'.$completeObj->last_name)); ?>">
                                                    <?php echo e($completeObj->first_name.' '.$completeObj->last_name); ?>

                                                </a>
                                                <span>
                                                    comments on task
                                                </span>
                                                <br/>
                                                <span class="smallText">&nbsp;(<?php echo \App\Library\Helpers::timetostr($completeObj->created_at); ?>)</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <?php echo $completeObj->comments; ?>

                                        </div>
                                            <?php $taskCompleteDocs = $completeObj->attachments;
                                            if(!empty($taskCompleteDocs))
                                                $taskCompleteDocs = json_decode($taskCompleteDocs);
                                            ?>

                                        <?php if(!empty($taskCompleteDocs) && count($taskCompleteDocs) > 0): ?>
                                            <div class="col-sm-12" >
                                                <?php $__currentLoopData = $taskCompleteDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span>
                                                        <a href="<?php echo url($doc->file_path); ?>" target="_blank">
                                                            <?php echo e($doc->file_name); ?>

                                                        </a>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($i <= (count($taskCompleteObj) - 1)): ?>
                                        <hr/>
                                    <?php endif; ?>
                                        <?php $i++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <hr/>
                            <?php if($authUserObj->role == 1): ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label" style="margin-bottom:0px">Quality of Work</label>
                                        <div><input value="0" name="quality_of_work" type="number" class="rating_user" min=0 max=5 step=0.5
                                                    data-size="xs"></div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label" style="margin-bottom:0px">Timeliness</label>
                                        <div><input value="0" type="number" name="timeliness"  class="rating_user" min=0 max=5 step=0.5
                                                    data-size="xs" ></div>
                                    </div>
                                </div>
                                <?php echo $__env->make('tasks.partials.complete_evaluation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <div class="attachment_listing_div">
                                            <div class="table-responsive">
                                                <table class="complete_task_attachment table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Documents</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td style="width:90%;">
                                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                <div class="form-control" data-trigger="fileinput">
                                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                    <span class="fileinput-filename"></span>
                                                                </div>
                                                                <span class="input-group-addon btn btn-default btn-file">
                                                                    <span class="fileinput-new">Select file</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="attachments[]">
                                                                </span>
                                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span>
                                                                <a href="#" class="remove-row text-danger hide" >
                                                                    <i class="fa fa-remove"></i>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="#" class="addMoreDocument">
                                                                    <i class="fa fa-plus plus"></i>
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">Comments</label>
                                        <textarea class="form-control" name="comment" id="comment"></textarea>
                                    </div>
                                </div>
                                <div class="row form-group mt-4">
                                    <div class="col-sm-12 ">
                                        <button id="create_objective" type="submit"  class="btn orange-bg">
                                            <span class="glyphicon glyphicon-ok"></span> Complete Task
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/partials/complete_task.blade.php ENDPATH**/ ?>