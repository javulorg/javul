<?php $__env->startSection('title', 'Objective: ' . $objectiveObj->name); ?>
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

                        <?php echo $__env->make('objectives.v2.partials.objectives-information', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="mt-2">
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
                                    <table id="tasks-table-id">
                                        <thead>
                                        <tr>
                                            <th class="title_col">Task Name</th>
                                            <th class="type_col">Status</th>
                                            <th class="type_col"><i class="fa fa-trophy"></i></th>
                                            <th class="type_col"><i class="fa fa-clock"></i></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php if(count($objectiveObj->tasks) > 0): ?>
                                            <?php $__currentLoopData = $objectiveObj->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug); ?>" title="edit">
                                                            <?php echo e($obj->name); ?>

                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($obj->status == "editable"): ?>
                                                            <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center"><?php echo e(\App\Models\Task::getTaskCount('in-progress',$obj->id)); ?></td>
                                                    <td class="text-center"><?php echo e(\App\Models\Task::getTaskCount('completed',$obj->id)); ?></td>
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
                            <div class="d-flex justify-content-between mt-2">
                                <div class="pagination-left">
                                </div>
                                <div class="pagination-right">
                                    <a href="<?php echo e(url('tasks/create')); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                                </div>
                            </div>

                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">RELATION TO OTHER OBJECTIVES</h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">
                                                    Parent Objective
                                                </label>
                                                <label class="form-control label-value">
                                                    <?php $objSlug = \App\Models\Objective::getSlug($objectiveObj->parent_id); ?>
                                                    <a style="font-weight: normal;" class="no-decoration" href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->parent_id).'/'.$objSlug ); ?>">
                                                        <?php echo e(\App\Models\Objective::getObjectiveName($objectiveObj->parent_id)); ?>

                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">
                                                    Child Objective
                                                </label>
                                                <label class="form-control label-value">
                                                    -
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Comments
                                    <?php if(isset($addComments)){ ?>
                                    <a class="btn black-btn float-end" href="<?= $addComments ?>">Add Comment</a>
                                    <?php } ?>
                                </h4>
                            </div>
                            <div class="card-body list-group objectiveComment">
                                <div class="list-group-item">
                                    <div class="row">
                                        <ul class="posts"></ul>
                                        <div class="pagingnation-forum float-end">Showing last <span class="item-count"> 0 </span> comments.
                                            <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php if(auth()->check()): ?>
                                            <hr>
                                            <div class="form">
                                                <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                                    <div class="col-sm-12 form-group">
                                                        <h4 class="form-label">Comment</h4>
                                                        <textarea class="form-control" id="comment" name="desc"></textarea>
                                                    </div>
                                                    <input type="hidden" name="unit_id" id="comment_unit_id" value="<?=  $unit_id ?>">
                                                    <input type="hidden" name="section_id" id="comment_section_id" value="<?=  $section_id ?>">
                                                    <input type="hidden" name="object_id" id="comment_object_id" value="<?=  $object_id ?>">
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
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $(".objectiveComment #form_topic_form").submit(function(e)
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
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    },
                });
            })


            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            

            
            
            

            

            
            
            
            
            
        });



    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/view.blade.php ENDPATH**/ ?>