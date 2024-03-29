<?php $__env->startSection('title', 'Create Issue'); ?>

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

        <div class="panel panel-grey panel-default">
            <div class="panel-heading">
                <h4>Create Issue</h4>
            </div>

            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="<?php echo e(url('issues')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="hidden" name="unit_id" value="<?php echo e($unitIDHashID->encode($unitObj->id)); ?>"/>
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <label class="control-label">Issue Title</label>
                                <input type="text" name="title" value="<?php echo e((!empty($issueObj))? $issueObj->title : old('title')); ?>" class="form-control" placeholder="Issue Name"/>
                                <?php if($errors->has('title')): ?>
                                    <span class="help-block">
                                    <strong><?php echo e($errors->first('title')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="mt-3 form-group">
                                <label class="control-label">Category : </label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="category_id" id="category_id">
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3 form-group">
                                <label class="control-label">Select Objective</label>
                                <select name="objective_id" id="objective_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Select</option>
                                    <?php if(count($objectiveObj) > 0): ?>
                                        <?php $__currentLoopData = $objectiveObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($objectiveIDHashID->encode($objective->id)); ?>" <?php if(!empty($issueObj) && $objective->id == $issueObj->objective_id): ?> selected="selected" <?php endif; ?>><?php echo e($objective->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>


                            <?php if(!empty($issueObj) && $user_can_change_status): ?>
                                <div class="mt-3 form-group">
                                    <label class="control-label">Select Status</label>
                                    <select name="status" id="status" class="form-control selectpicker" data-live-search="true">
                                        <option value="unverified" <?php if(!empty($issueObj) && $issueObj->status == "unverified"): ?> selected="selected" <?php endif; ?>>Unverified</option>
                                        <option value="verified" <?php if(!empty($issueObj) && $issueObj->status == "verified"): ?> selected="selected" <?php endif; ?>>Verified</option>
                                        <option value="resolved" <?php if(!empty($issueObj) && $issueObj->status == "resolved"): ?> selected="selected" <?php endif; ?>>Resolved</option>
                                    </select>
                                </div>
                            <?php endif; ?>


                            <div class="mt-3 form-group">
                                <label class="control-label">Select Task</label>
                                <select name="task_id" id="task_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Select</option>
                                    <?php if(!empty($taskObj)): ?>
                                            <?php $task_ids = explode(",", $issueObj->task_id); ?>
                                        <?php $__currentLoopData = $taskObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($taskIDHashID->encode($task->id)); ?>" <?php if(in_array($task->id, $task_ids)): ?> selected <?php endif; ?>><?php echo e($task->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>


                            <div class="mt-3 form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?php if(!empty($issueObj)): ?> <?php echo e($issueObj->description); ?> <?php endif; ?></textarea>
                            </div>


                            <div class="mt-3 form-group">
                                <label class="control-label">Resolution</label>
                                <textarea class="form-control" id="resolution" name="resolution"><?php if(!empty($issueObj)): ?> <?php echo e($issueObj->resolution); ?> <?php endif; ?></textarea>
                            </div>

                            <div class="mt-3 form-group text-center">
                                <button class="btn btn-secondary" type="submit" id="create_issue">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create Issue</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".datetimepicker").flatpickr({
                enableTime: true,
                position : "above",
                mode : "multiple",
                minuteIncrement : 1,
                enableSeconds : true,
            });

            $(document).off('click','.addMoreDocument').on('click',".addMoreDocument",function(){
                cloneTR();
                return false;
            });

            $(document).on("click","table.documents tbody .remove-row", function(){
                var index_tr = $(".documents").find("tbody").find("tr").index($(this));
                var id = $(this).attr('data-id');
                var task_id = $(this).attr('data-task_id');
                var fromEdit = $(this).attr('data-from_edit');
                $that = $(this);
                if($.trim(id) != "" && $.trim(task_id) != ""){
                    addEditedFieldName("remove_doc");

                    $.ajax({
                        type:'get',
                        url: '<?php echo e(url("/tasks/remove_task_document")); ?>',
                        data:{id:id,task_id:task_id,fromEdit:fromEdit },
                        dataType:'json',
                        success:function(resp){
                            if(resp.success){
                                showToastMessage('DOCUMENT_DELETED');
                                if ($("table.documents tbody tr").length > 1)
                                    $that.parents('tr:eq(0)').remove();
                                if ($("table.documents tbody tr").length < 10)
                                    // cloneTR(true);

                                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                            }
                            else
                                showToastMessage('SOMETHING_GOES_WRONG');
                        }
                    })
                }
                else{

                    if ($("table.documents tbody tr").length > 1)
                        $(this).parents('tr:eq(0)').remove();

                    var addedDocLength = $(".fileinput-new:not(:hidden)").length;
                    if(addedDocLength == 0)
                        $(".changed_items[value='"+field_name+"']").remove();

                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                }

                return false;
            });

            $("#unit_id").on('change',function(){
                var unit_val = $(this).val();
                var token = $('[name="_token"]').val();
                    $("#objective_id").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '<?php echo e(url("/tasks/get_objective")); ?>',
                        dataType:'json',
                        data:{unit_id:unit_val,_token:token },
                        success:function(resp){
                            $("#objective_id").prop('disabled',false);
                            if(resp.success){
                                var html;
                                $.each(resp.objectives,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });
                                $("#objective_id").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                return false
            });

            $("#objective_id").on('change',function(){
                var obj_val = $(this).val();
                var token = $('[name="_token"]').val();
                $("#objective_id").prop('disabled',true);

                $.ajax({
                    type:'POST',
                    url: '<?php echo e(url("/tasks/get_tasks")); ?>',
                    dataType:'json',
                    data:{obj_id:obj_val,_token:token},
                    success:function(resp)
                    {
                        $("#objective_id").prop('disabled',false);
                        if(resp.success)
                        {
                            var html;
                            $.each(resp.tasks,function(index,val)
                            {
                                html+='<option value="'+index+'">'+val+'</option>'
                            });
                            $("#task_id").append(html);
                            $('.selectpicker').selectpicker('refresh');
                        }
                    }
                })
                return false
            });

            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#resolution' ) )
                .catch( error => {
                    console.error( error );
                } );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/create.blade.php ENDPATH**/ ?>