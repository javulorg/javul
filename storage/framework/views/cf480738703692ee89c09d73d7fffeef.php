<?php $__env->startSection('title', 'Update Idea'); ?>

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

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Update Idea</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" action="<?php echo e(url('ideas/' . $ideaHashId)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">

                            <input type="hidden" name="unit_id" value="<?php echo e($unitData->id); ?>">
                            <input type="hidden" name="idea_id" value="<?php echo e($idea->id); ?>">

                            <div class="col-md-12 form-group">
                                <label class="control-label">Idea Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="title" class="form-control" value="<?php echo e($idea->title); ?>" />
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Type</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="category_id" id="category_id">
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>" <?php echo e($type->id == $idea->category_id ? 'selected' : ''); ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Status</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="status" id="status">
                                        <option selected disabled>Select Idea Status</option>
                                        <option value="1" <?php echo e($idea->status == 1 ? 'selected' : ''); ?>>Draft</option>
                                        <option value="2" <?php echo e($idea->status == 2 ? 'selected' : ''); ?>> Assigned to Task</option>
                                        <option value="3" <?php echo e($idea->status == 3 ? 'selected' : ''); ?>> Implemented</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Task</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="task_id" id="task_id">
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($task->id); ?>" <?php echo e($task->id == $idea->task_id ? 'selected' : ''); ?>><?php echo e($task->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Issue</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="issue_id" id="issue_id">
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                        <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($issue->id); ?>" <?php echo e($issue->id == $idea->issue_id ? 'selected' : ''); ?>><?php echo e($issue->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="description" name="description">
                                    <?php echo e($idea->description); ?>

                                </textarea>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Comment</label>
                                <input class="form-control" type="text" name="comment" value="<?php echo e($idea->comment); ?>">
                            </div>
                            <div class="col-sm-12 mt-3 form-group">
                                <input class="form-control" type="file" name="file">
                            </div>
                        </div>


                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update Idea</span>
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
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/ideas/edit.blade.php ENDPATH**/ ?>