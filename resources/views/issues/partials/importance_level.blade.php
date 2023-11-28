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

<div style="float:left;">{{ $importancePercentage }}%</div>

<div class="vote-buttons">
    <span class="fa fa-thumbs-up {{ $voteClass }} upvote {{ $upvoteClass }}"
          @if (auth()->check()) data-id="{{ $issueIDHashID->encode($issue_id) }}" data-type="up" @endif
          title="Upvote"></span>
    {{ $upvotedCnt }}

    <span class="fa fa-thumbs-down {{ $voteClass }} downvote {{ $downvoteClass }}"
          @if (auth()->check()) data-id="{{ $issueIDHashID->encode($issue_id) }}" data-type="down" @endif
          title="Downvote"></span>
    {{ $downvotedCnt }}
</div>
