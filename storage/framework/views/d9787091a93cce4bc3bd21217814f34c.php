<div class="card">
    <div class="card-body">
        <h4 class="card-title">Relation to objective and task</h4>
        <div class="list-group">
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label">
                            Associated Objective
                        </label>
                        <label class="control-label colorLightBlue form-control label-value">
                            <?php
                                $objectiveID = $issueObj->objective_id;
                                $objSlug = \App\Models\Objective::getSlug($objectiveID);
                                $objectiveUrl = url('objectives/'.$objectiveIDHashID->encode($objectiveID).'/'.$objSlug);
                                $objectiveName = \App\Models\Objective::getObjectiveName($objectiveID);
                            ?>
                            <a style="font-weight: normal;" class="no-decoration" href="<?php echo e($objectiveUrl); ?>">
                                <span class="badge"><?php echo e($objectiveName); ?></span>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">
                            Associated Tasks
                        </label>
                        <label class="control-label colorLightGreen form-control label-value">
                            <?php
                                $taskIDs = explode(",", $issueObj->task_id);
                            ?>
                            <?php if(count($taskIDs) > 0): ?>
                                <?php $__currentLoopData = $taskIDs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskID): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $taskSlug = \App\Models\Task::getSlug($taskID);
                                        $taskUrl = url('tasks/'.$taskIDHashID->encode($taskID).'/'.$taskSlug);
                                        $taskName = \App\Models\Task::getName($taskID);
                                    ?>
                                    <a style="font-weight: normal;" class="no-decoration" href="<?php echo e($taskUrl); ?>">
                                        <span class="badge"><?php echo e($taskName); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/v2/partials/relation-objectives-tasks.blade.php ENDPATH**/ ?>