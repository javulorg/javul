<div class="row comment_block" style="display: none;">
    <div class="col-sm-12 form-group">
        <label class="control-label">Comments</label>
        <textarea class="form-control summernote" name="comment" id="comment"></textarea>
    </div>
</div>
@if($taskObj->status == "completion_evaluation")
<div class="row form-group">
    <div class="col-sm-12 ">
        <button id="mark_as_complete" type="button"  class="btn btn-success" data-tid="{{$taskIDHashID->encode($taskObj->id)}}">
            <span class="glyphicon glyphicon-check"></span> Mark as Complete
        </button>
        <button id="reassign_task" type="button"  class="btn orange-bg" data-tid="{{$taskIDHashID->encode($taskObj->id)}}">
            <span class="glyphicon glyphicon-new-window"></span> Re Assign
        </button>
    </div>
</div>
@endif