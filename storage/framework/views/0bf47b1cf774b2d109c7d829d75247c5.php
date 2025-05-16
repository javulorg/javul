<?php if(!empty($taskEditors) && count($taskEditors) > 0): ?>
<div class="row reward-panel" style="display: none;">
    <div class="col-sm-12">
        <div class="panel panel-default panel-dark-grey">
            <div class="panel-heading">
                <h4>Reward Assignment</h4>
                <span class="text-right">( 10% of task reward among all task editor and task creator)</span>
            </div>

            <div class="panel-body reward-assignment-body">
                <?php if(!$rewardAssigned): ?>
                <div class="row form-group <?php echo e($errors->has('split_error') ? ' has-error' : ''); ?>

                        <?php echo e($errors->has('amount_percentage['.$taskObj->user_id.']')? ' has-error' : ''); ?>">
                    <div class="col-sm-4 col-xs-8">
                        <?php echo e(\App\Models\User::getUserName($taskObj->user_id)); ?> (<b>task creator</b>)
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <input type="text" name="amount_percentage[<?php echo e($taskObj->user_id); ?>]"
                               value="<?php echo e(old('amount_percentage['.$taskObj->user_id.']')); ?>"
                               class="form-control onlyDigits amount_percentage"
                               style="display:inline-block;float:left;width:50px"/>
                        <span style="line-height:35px;padding-left:2px">%</span>
                    </div>
                </div>
                <?php endif; ?>
                <?php $__currentLoopData = $taskEditors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($editor->user_id != $taskObj->user_id): ?>
                        <div class="row form-group <?php echo e($errors->has('split_error') ? ' has-error' : ''); ?>

                        <?php echo e($errors->has('amount_percentage['.$editor->user_id.']')? ' has-error' : ''); ?>">
                            <div class="col-sm-4 col-xs-8">
                                <?php echo e(\App\Models\User::getUserName($editor->user_id)); ?>

                                <?php if($rewardAssigned && $editor->user_id == $taskObj->user_id): ?>
                                    (<b>task creator</b>)
                                <?php else: ?>
                                (<b>task editor</b>)
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-2 col-xs-4">
                                <input type="text" name="amount_percentage[<?php echo e($editor->user_id); ?>]"
                                       <?php if($rewardAssigned): ?> value="<?php echo e($editor->reward_percentage); ?>" <?php else: ?>
                                       value="<?php echo e(old('amount_percentage['.$editor->user_id.']')); ?>" <?php endif; ?>
                                class="form-control onlyDigits amount_percentage"
                                style="display:inline-block;float:left;width:50px"/>
                                <span style="line-height:35px;padding-left:2px">%</span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($errors->has('split_error')): ?>
                    <span class="has-error error-not-100">
                        <span class="control-label"><?php echo e($errors->first('split_error')); ?></span>
                    </span>
                <?php elseif($errors->has('amount_percentage['.$taskObj->user_id.']')): ?>
                    <span class="has-error error-not-100">
                        <span class="control-label">Please enter percentage</span>
                    </span>
                <?php elseif(count($errors) > 0 && !$error->has('comment')): ?>
                    <span class="has-error error-not-100">
                        <span class="control-label">Please enter percentage</span>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-group" >
        <button id="ok_complete" type="button"  class="btn btn-success" data-tid="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>">
            <span class="glyphicon glyphicon-check"></span> Ok
        </button>
        <button type="button"  class="btn btn-danger cancel_btn">
            <span class="glyphicon glyphicon-new-window"></span> Cancel
        </button>
    </div>
</div>

<?php endif; ?>
<div class="row comment_block" style="display: none;">
    <div class="col-sm-12 form-group">
        <label class="control-label">Comments</label>
        <textarea class="form-control summernote" name="comment" id="comment"></textarea>
    </div>
    <div class="col-sm-12 form-group">
        <button id="ok_reassign" type="button"  class="btn btn-success" data-tid="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>">
            <span class="glyphicon glyphicon-check"></span> Ok
        </button>
        <button type="button"  class="btn btn-danger cancel_btn">
            <span class="glyphicon glyphicon-new-window"></span> Cancel
        </button>
    </div>
</div>
<?php if($taskObj->status == "completion_evaluation"): ?>
<div class="row form-group">
    <div class="col-sm-12 complete_assign_btn">
        <?php if(!empty($taskEditors) && count($taskEditors) > 0): ?>
            <button id="mark_as_complete" type="button"  class="btn btn-success" >
                <span class="glyphicon glyphicon-check"></span> Mark as Complete
            </button>
        <?php else: ?>
            <button id="ok_complete" type="button"  class="btn btn-success" data-tid="<?php echo e($taskIDHashID->encode($taskObj->id)); ?>">
                <span class="glyphicon glyphicon-check"></span> Mark as Complete
            </button>
        <?php endif; ?>
        <button id="reassign_task_btn" type="button"  class="btn orange-bg">
            <span class="glyphicon glyphicon-new-window"></span> Re Assign
        </button>
    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/partials/complete_evaluation.blade.php ENDPATH**/ ?>