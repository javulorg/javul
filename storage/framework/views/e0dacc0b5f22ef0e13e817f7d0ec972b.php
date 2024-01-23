<?php $__env->startSection('title', 'Update Issue'); ?>

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
                <h4>Update Issue</h4>

                <div class="panel-body list-group">
                    <div class="list-group-item">
                        <form role="form" method="post" action="<?php echo e(url('issues/'. $issueHashId)); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>

                            <div class="row">

                                <input type="hidden" name="unit_id" value="<?php echo e($unitIDHashID->encode($unitData->id)); ?>">

                                <div class="form-group <?php echo e($errors->has('issue_title') ? ' has-error' : ''); ?>">
                                    <label class="control-label">Issue Title</label>
                                    <div class="input-icon right">
                                        <input type="text" name="title" value="<?php echo e((!empty($issueObj))? $issueObj->title : old('title')); ?>"
                                               class="form-control"
                                               placeholder="Issue Name"/>
                                        <?php if($errors->has('title')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('title')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>



                                <div class="mt-3 form-group">
                                    <label class="control-label">Select Objective</label>
                                    <div class="input-icon right">
                                        <select name="objective_id" id="objective_id" class="form-control selectpicker" data-live-search="true">
                                            <option value="">Select</option>
                                            <?php if(count($objectiveObj) > 0): ?>
                                                <?php $__currentLoopData = $objectiveObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($objectiveIDHashID->encode($objective->id)); ?>"
                                                            <?php if(!empty($issueObj) && $objective->id == $issueObj->objective_id): ?>
                                                                selected=selected
                                                        <?php endif; ?>><?php echo e($objective->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>


















                                <div class="mt-3 form-group">
                                    <label class="control-label">Verified</label>
                                    <div class="input-icon right">
                                        <select name="verified" id="verified" class="form-control" data-live-search="true">
                                            <option disabled selected>Select Verified Status</option>
                                            <option value="1" <?php echo e($issueObj->verified == 1 ? 'selected' : ''); ?>>Yes</option>
                                            <option value="0" <?php echo e($issueObj->verified == 0 ? 'selected' : ''); ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <?php if(!empty($issueObj) && $user_can_change_status): ?>
                                    <div class="mt-3 form-group">
                                        <label class="control-label">Select Status</label>
                                        <div class="input-icon right">
                                            <select name="status" id="status" class="form-control selectpicker" data-live-search="true">
                                                <option disabled selected>Select Status</option>
                                                <option value="1" <?php echo e($issueObj->status == 1 ? 'selected' : ''); ?>>Resolved</option>
                                                <option value="2" <?php echo e($issueObj->status == 2 ? 'selected' : ''); ?>>Assigned to Task</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="mt-3 form-group">
                                    <label class="control-label">Select Task</label>
                                    <div class="input-icon right">
                                        <select name="task_id" id="task_id" class="form-control selectpicker" data-live-search="true">
                                            <option value="">Select</option>
                                            <?php if(!empty($taskObj)): ?>
                                                    <?php $task_ids = explode(",",$issueObj->task_id); ?>
                                                <?php $__currentLoopData = $taskObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($taskIDHashID->encode($task->id)); ?>" <?php if(in_array($task->id,
                                                        $task_ids)): ?> selected <?php endif; ?>><?php echo e($task->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-3 form-group">
                                    <div class="document_listing_div">
                                        <div class="table-responsive">
                                            <table class="documents table table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="border:0px;font-weight:normal;">Documents</th>
                                                    <th style="border:0px;"></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php if(!empty($issueDocumentsObj)): ?>
                                                        <?php $i=1; ?>
                                                    <?php $__currentLoopData = $issueDocumentsObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo $__env->make('issues.partials.issue_document_listing',['document'=>$document,'issueObj'=>$issueObj,'fromEdit'=>'no'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($issueObj->status != "resolved"): ?>
                                                        <?php echo $__env->make('tasks.partials.document_upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php echo $__env->make('tasks.partials.document_upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 form-group">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control" id="description"  name="description"><?php if(!empty($issueObj)): ?> <?php echo e($issueObj->description); ?> <?php endif; ?></textarea>
                                </div>

                                <div class="mt-3 form-group">
                                    <label class="control-label">Resolution</label>
                                    <textarea class="form-control" id="resolution" name="resolution"><?php if(!empty($issueObj)): ?>
                                            <?php echo e($issueObj->resolution); ?> <?php endif; ?></textarea>
                                </div>

                                <div class="mt-3 form-group">
                                    <label class="control-label">Comment</label>
                                    <input class="form-control" name="comment" value="<?php echo e($issueObj->comment); ?>">
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-md-6 col-lg-4">
                                    <button class="btn btn-secondary btn-block" type="submit">
                                        <i class="fa fa-plus"></i> <span class="plus_text">Update Issue</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function () {

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

            function cloneTR(){
                var last = $("table.documents tbody tr:last").clone();
                last.find(".remove-row").attr('data-id','').removeClass('hide');
                $("table.documents tbody tr:last").find(".addMoreDocument").addClass("hide");
                $("table.documents tbody tr:last").after("<tr>" + last.html() + "</tr>");
                console.log($("table.documents tbody tr:last").html());
                $("table.documents tbody tr:last").find("[name='documents[]']").find("a.input-group-addon").trigger('click');
                $("table.documents tbody tr:last").find("[name='documents[]']").fileinput();
                // reset all values
                $("table.documents tbody tr:last :input:not(:checked)").val("").removeAttr('selected');
                return false;
            }
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
        });



    </script>

    <script>
        $(function(){
            $(".file_input").fileinput({
                'theme': 'explorer-fa',
                validateInitialCount: true,
                overwriteInitial: false,
                showClose: true,
                showCaption: true,
                showBrowse: true,
                browseOnZoneClick: true,
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                showRemove:false,
                showUpload:false,
                removeTitle: 'Cancel or reset changes',
                elErrorContainer: '#kv-error-2',
                msgErrorClass: 'alert alert-block alert-danger',
                uploadAsync: false,
                uploadUrl: window.location.href, // your upload server url
                uploadExtraData:{_token:'<?php echo e(csrf_token()); ?>'},
                fileActionSettings : {'showUpload':false},
                allowedFileExtensions: ["doc","docx","pdf","txt","jpg","png","ppt","pptx","jpeg","doc","xls","xlsx"],
                dropZoneEnabled: false,
            });


        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/edit.blade.php ENDPATH**/ ?>