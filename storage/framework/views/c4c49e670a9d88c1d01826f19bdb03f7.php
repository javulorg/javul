<?php
$voteClass = "";
$upvoteClass = "";
$downvoteClass = "";

if (auth()->check()) {
    $voteClass = "vote";
    $flag = \App\Models\ImportanceLevel::checkImportanceLevel($issue_id, 'issue_id');

    if ($flag == "1") {
        $upvoteClass = "success-upvote";
    } elseif ($flag == "-1") {
        $downvoteClass = "success-downvote";
    }
}
?>

<div style="float:left;"><?php echo e($importancePercentage); ?>%</div>

<div class="vote-buttons">
    <span class="fa fa-thumbs-up <?php echo e($voteClass); ?> upvote <?php echo e($upvoteClass); ?>"
          <?php if(auth()->check()): ?> data-id="<?php echo e($issueIDHashID->encode($issue_id)); ?>" data-type="up" <?php endif; ?>
          title="Upvote"></span>
    <?php echo e($upvotedCnt); ?>


    <span class="fa fa-thumbs-down <?php echo e($voteClass); ?> downvote <?php echo e($downvoteClass); ?>"
          <?php if(auth()->check()): ?> data-id="<?php echo e($issueIDHashID->encode($issue_id)); ?>" data-type="down" <?php endif; ?>
          title="Downvote"></span>
    <?php echo e($downvotedCnt); ?>

</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/partials/importance_level.blade.php ENDPATH**/ ?>