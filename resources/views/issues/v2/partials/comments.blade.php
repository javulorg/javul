<div class="row form-group mt-3">
    <div class="col-md-12 order-md-2">
        <div class="card border">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">Comments
                    <?php if(isset($addComments)){ ?>
                    <a class="btn btn-dark" href="<?= $addComments ?>">Add Comment</a>
                    <?php } ?>
                </h4>
            </div>
            <div class="card-body objectiveComment">
                <div class="list-group">
                    <div class="list-group-item py-0">
                        <div class="row">
                            <ul class="posts"></ul>
                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <span class="me-3">Showing last <span class="item-count">0</span> comments.</span>
                                <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>
                            </div>
                            <div class="clearfix"></div>
                            @if(auth()->check())
                                <hr>
                                <div class="form">
                                    <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <h4 class="control-label">Comment</h4>
                                                <textarea class="form-control" id="comment" name="desc"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="unit_id" value="<?=  $unit_id ?>">
                                        <input type="hidden" name="section_id" value="<?=  $section_id ?>">
                                        <input type="hidden" name="object_id" value="<?=  $object_id ?>">
                                        <div class="row">
                                            <div class="col-sm-12 mt-2 form-group">
                                                <button class="btn btn-secondary float-end">Submit Comment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
