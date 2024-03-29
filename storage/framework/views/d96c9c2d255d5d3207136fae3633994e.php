<?php $__env->startSection('title', 'Create Objective'); ?>

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
                <h4>Create Objective</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="<?php echo e(url('objectives')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                                <input type="hidden" name="unit" value="<?php echo e($unitIDHashID->encode($unitData->id)); ?>">
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Objective Name</label>
                                    <div class="input-icon right">
                                        <input type="text" name="objective_name"
                                               value="<?php echo e(old('objective_name')); ?>"
                                               class="form-control"
                                               placeholder="Objective Name" required/>
                                    </div>
                                </div>



                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Parent objective</label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="parent_objective" id="parent_objective">
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                        <?php if(count($parentObjectivesObj) > 0): ?>
                                            <?php $__currentLoopData = $parentObjectivesObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective_id=>$parentObjective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($objectiveIDHashID->encode($objective_id)); ?>" <?php if(!empty($objectiveObj) &&
                                                                $objectiveObj->parent_id == $objective_id): ?> selected=selected <?php endif; ?>><?php echo e($parentObjective); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Objective Description</label>
                                <textarea class="form-control" id="description" name="description">
                                    <?php if(!empty($objectiveObj)): ?> <?php echo e($objectiveObj->description); ?> <?php endif; ?>
                                </textarea>
                            </div>


                            <div class="col-sm-12 mt-3 form-group">
                                    <label class="control-label mb-1">Idea</label>
                                    <select class="form-select"  name="idea_id[]" id="idea_id" multiple>
                                        <?php $__currentLoopData = $ideas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($idea->id); ?>"><?php echo e($idea->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create Objective</span>
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
            $("#idea_id").select2({
                theme: "bootstrap-5",
                containerCssClass: "select2--small",
                dropdownCssClass: "select2--small",
            });

            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .catch( error => {
                    console.error( error );
                } );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/create.blade.php ENDPATH**/ ?>