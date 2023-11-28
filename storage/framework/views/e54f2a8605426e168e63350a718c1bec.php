<?php $__env->startSection('title', 'Task: ' . $taskObj->name); ?>
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
                <h4>Update Task</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="<?php echo e(url('tasks/'. $taskHashId)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="control-label">Task Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="task_name" id="task_name"
                                           value="<?php echo e((!empty($taskObj))? $taskObj->name : old('task_name')); ?>"
                                           class="form-control" placeholder="Task Name">
                                </div>
                                <?php if($errors->has('task_name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('task_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <input type="hidden" name="unit" value="<?php echo e($unitIDHashID->encode($unitData->id)); ?>">

                            <div class="col-sm-12 form-group">
                                <label class="control-label">Objective <span
                                        class="text-danger">*</span></label>
                                <select <?php if(!empty($unitInfo) && !empty($task_objective_id)): ?> name="objective_disabled"
                                        <?php else: ?> name="objective" <?php endif; ?> id="objective"
                                        class="form-control selectpicker" data-live-search="true">
                                    <?php if(count($objectiveObj) > 0): ?>
                                        <?php $__currentLoopData = $objectiveObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($objectiveIDHashID->encode($objective->id)); ?>"
                                                    <?php if(!empty($taskObj) && $objective->id == $taskObj->objective_id): ?>
                                                    selected=selected
                                                    <?php elseif(empty($taskObj) && $objective->id == $task_objective_id): ?>
                                                    selected=selected
                                                <?php endif; ?>><?php echo e($objective->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php if(!empty($unitInfo) && !empty($task_objective_id)): ?>
                                    <input type="hidden" name="objective"
                                           value="<?php echo e($objectiveIDHashID->encode($task_objective_id)); ?>"/>
                                <?php endif; ?>
                                <span class="objective_loader location_loader" style="display: none">
                                            <img src="<?php echo url('assets/images/small_loader.gif'); ?>"/>
                                        </span>
                                <?php if($errors->has('objective')): ?>
                                    <span class="help-block">
                                                <strong><?php echo e($errors->first('objective')); ?></strong>
                                            </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4  form-group <?php echo e($errors->has('task_skills') ? ' has-error' : ''); ?>">
                                <label class="control-label">Task Skills <span
                                        class="text-danger">*</span></label>
                                <select name="task_skills[]" class="form-control selectpicker" data-live-search="true"
                                        id="task_skills" multiple>
                                    <option value="">Select</option>
                                    <?php if(!empty($task_skills)): ?>
                                        <?php $__currentLoopData = $task_skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill_id=>$skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($skill_id); ?>" <?php if(!empty($exploded_task_list) && in_array($skill_id,
                                                                                            $exploded_task_list)): ?> selected=selected <?php endif; ?>><?php echo e($skill); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php if($errors->has('task_skills')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('task_skills')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-4 mt-1 mb-2 form-group <?php echo e($errors->has('estimated_completion_time_start') ? ' has-error' : ''); ?>">
                                <label class="control-label">Estimated Completion Time From</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="estimated_completion_time_start"
                                           name="estimated_completion_time_start" value="<?php echo e((!empty($taskObj))?
                                                                                    $taskObj->estimated_completion_time_start :
                                                                                    old('estimated_completion_time_start')); ?>"
                                           class="form-control datetimepicker"
                                           placeholder="Estimated Completion Time From">
                                    <span class="input-group-text" id="calendar-icon-from"><i
                                            class="bi bi-calendar"></i></span>
                                </div>
                                <?php if($errors->has('estimated_completion_time_start')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('estimated_completion_time_start')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-4 mt-1 mb-2 form-group <?php echo e($errors->has('estimated_completion_time_end') ? ' has-error' : ''); ?>">
                                <label class="control-label">Estimated Completion Time To</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="estimated_completion_time_end"
                                           name="estimated_completion_time_end" value="<?php echo e((!empty($taskObj))?
                                                                                $taskObj->estimated_completion_time_end :
                                                                                old('estimated_completion_time_end')); ?>"
                                           class="form-control datetimepicker"
                                           placeholder="Estimated Completion Time To"/>
                                    <span class="input-group-text" id="calendar-icon-to"><i class="bi bi-calendar"></i></span>
                                </div>
                                <?php if($errors->has('estimated_completion_time_end')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('estimated_completion_time_end')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4 form-group">
                                <label class="control-label">Compensation <span
                                        class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="text" id="compensation" name="compensation"
                                           value="<?php echo e((!empty($taskObj))? $taskObj->compensation : old('compensation')); ?>"
                                           class="form-control border-radius-0 onlyDigits"
                                           placeholder="Compensation"/>
                                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <?php if(!empty($taskObj)): ?>
                                    <div class="col-sm-4 mt-1 mb-2 form-group">
                                        <label class="control-label">Status</label>
                                        <div class="input-icon right">
                                            <?php if(!empty($change_task_status) || \App\Models\Task::isUnitAdminOfTask($taskObj->id)): ?>
                                                <select name="task_status" class="form-control selectpicker"
                                                        data-live-search="true" id="task_status">
                                                    <?php $__currentLoopData = \App\Models\SiteConfigs::task_status(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if($taskObj->status == $index): ?> selected=selected
                                                                <?php endif; ?> value="<?php echo e($index); ?>"><?php echo e($status); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php else: ?>
                                                <span>
                                                <?php echo e(\App\Models\SiteConfigs::task_status($taskObj->status)); ?>


                                                    <?php if($taskObj->status == "editable" && !empty($taskEditor) && $taskEditor->submit_for_approval == "not_submitted"): ?>
                                                        <?php if(count($otherEditorsDone) > 0): ?>
                                                            (<?php echo e(count($otherEditorsDone).' task editor submitted this task for Approval'); ?>

                                                            <?php if(!empty($availableDays)): ?>
                                                                <?php echo e("Time left for editing: ".$availableDays." days."); ?>)
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <a href="#" class="submit_for_approval" data-task_id="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>">Submit for Approval</a><?php elseif($taskObj->status == "editable" && count($taskEditor) > 0 && $taskEditor->submit_for_approval == "submitted"): ?>
                                                                                    ( You changed this task status to
                                                                                    "Awaiting Approval". Waiting
                                                                                    for <?php echo e(count($otherRemainEditors)); ?>

                                                                                    other editors to do the same)
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label">Summary</label>
                                <textarea class="form-control" id="task-summary"
                                          name="summary"><?php if(!empty($taskObj)): ?> <?php echo e($taskObj->summary); ?> <?php endif; ?></textarea>
                            </div>

                            <div class="col-sm-12 mt-1 mb-2 form-group">
                                <label class="control-label">Description <span id="desc-error"></span></label>
                                <textarea class="form-control" id="description-summernote"
                                          name="description"><?php if(!empty($taskObj)): ?> <?php echo e($taskObj->description); ?> <?php endif; ?></textarea>
                            </div>

                            <div class="col-sm-12 mt-1 mb-2 form-group">
                                <label class="control-label">Action Items</label>
                                <textarea class="form-control" name="action_items" id="action_items">
                                    <?php if(!empty($taskObj)): ?>
                                        <?php echo $taskObj->task_action; ?>

                                    <?php endif; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <div class="document_listing_div">
                                    <div class="table-responsive overflow-hidden">
                                        <table class="documents table table-striped">
                                            <thead>
                                            <tr>
                                                <th style="border:0px;font-weight:normal;">Documents</th>
                                                <th style="border:0px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php if(!empty($taskDocumentsObj)): ?>
                                                <?php $i = 1; ?>
                                                <?php $__currentLoopData = $taskDocumentsObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo $__env->make('tasks.partials.task_document_listing',['document'=>$document,'taskObj'=>$taskObj,'taskDocumentIDHashID'=>$taskDocumentIDHashID,'fromEdit'=>'no'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(empty($taskObj) || ($taskObj->status == "editable")): ?>
                                                    <?php echo $__env->make('tasks.partials.document_upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if(empty($taskObj) || ($taskObj->status == "editable")): ?>
                                                    <?php echo $__env->make('tasks.partials.document_upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label">Comment</label>
                                <input class="form-control" name="comment" value="<?php echo e($taskObj->comment); ?>">
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit" id="create_unit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update Task</span>
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
            $(".selectpicker").selectpicker('refresh');

            $(".datetimepicker").flatpickr({
                enableTime: true,
                position: "above",
                mode: "multiple",
                minuteIncrement: 1,
                enableSeconds: true,
            });

            $("#calendar-icon-from").on("click", function () {
                $(this).closest(".input-group").find("input").focus();
            });
            $("#calendar-icon-to").on("click", function () {
                $(this).closest(".input-group").find("input").focus();
            });

            $('#description-summernote').summernote({
                tabsize: 0,
                height: 100,
                focus: true
            });


            $(document).off('click', '.addMoreDocument').on('click', ".addMoreDocument", function () {
                cloneTR();
                return false;
            });

            $(document).on("click", "table.documents tbody .remove-row", function () {
                var index_tr = $(".documents").find("tbody").find("tr").index($(this));
                var id = $(this).attr('data-id');
                var task_id = $(this).attr('data-task_id');
                var fromEdit = $(this).attr('data-from_edit');
                $that = $(this);
                if ($.trim(id) != "" && $.trim(task_id) != "") {
                    addEditedFieldName("remove_doc");

                    $.ajax({
                        type: 'get',
                        url: '<?php echo e(url("/tasks/remove_task_document")); ?>',
                        data: {id: id, task_id: task_id, fromEdit: fromEdit},
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.success) {
                                showToastMessage('DOCUMENT_DELETED');
                                if ($("table.documents tbody tr").length > 1)
                                    $that.parents('tr:eq(0)').remove();
                                if ($("table.documents tbody tr").length < 10)
                                    // cloneTR(true);

                                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                            } else
                                showToastMessage('SOMETHING_GOES_WRONG');
                        }
                    })
                } else {

                    if ($("table.documents tbody tr").length > 1)
                        $(this).parents('tr:eq(0)').remove();

                    var addedDocLength = $(".fileinput-new:not(:hidden)").length;
                    if (addedDocLength == 0)
                        $(".changed_items[value='" + field_name + "']").remove();

                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                }

                return false;
            });

            $("#unit").on('change', function () {
                var unit_val = $(this).val();
                var token = $('[name="_token"]').val();
                if ($.trim(unit_val) == "") {
                    $("#objective").html('<option value="">Select</option>');
                    return false;
                } else {
                    $(".objective_loader.location_loader").show();
                    $("#objective").prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(url("/tasks/get_objective")); ?>',
                        dataType: 'json',
                        data: {unit_id: unit_val, _token: token},
                        success: function (resp) {
                            $(".objective_loader.location_loader").hide();
                            $("#objective").prop('disabled', false);
                            if (resp.success) {
                                var html = '<option value="">Select</option>';
                                $.each(resp.objectives, function (index, val) {
                                    html += '<option value="' + index + '">' + val + '</option>'
                                });
                                $("#objective").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                }
                return false
            });
        });
        ClassicEditor
            .create(document.querySelector('#task-summary'))
            .catch(error => {
                console.error(error);
            });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/edit.blade.php ENDPATH**/ ?>