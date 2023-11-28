<?php
$upvote_class="";
$downvote_class="";
$voteClass="";
if(\Auth::check()){
    $voteClass=" vote ";
    $flag = \App\Models\ImportanceLevel::checkImportanceLevel($objective_id,'objective_id');
    if($flag == "1")
        $upvote_class="success-upvote";
    elseif($flag == "-1")
        $downvote_class="success-downvote";
}
?>
<div style="float:left;"><?php echo e($importancePercentage); ?>%</div>
<div style="display: inline-block">
    <div class="<?php echo e($upvote_class); ?>" style="display: inline-block">
        <span class="fa fa-thumbs-up <?php echo e($voteClass); ?> upvote "
            <?php if(\Auth::check()): ?> data-id="<?php echo e($objectiveIDHashID->encode($objective_id)); ?>"
            data-type="up" <?php endif; ?>
            title="upvote"></span><?php echo e($upvotedCnt); ?>

    </div>
    <div class="<?php echo e($downvote_class); ?>" style="display: inline-block">
        <span class="fa fa-thumbs-down <?php echo e($voteClass); ?> downvote "
            <?php if(\Auth::check()): ?> data-id="<?php echo e($objectiveIDHashID->encode($objective_id)); ?>"
            data-type="down" <?php endif; ?>
            title="downvote"></span><?php echo e($downvotedCnt); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/partials/importance_level.blade.php ENDPATH**/ ?>