<div class="card border">
    <div class="card-header">
        <h5 class="card-title">IDEA INFORMATION</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            <div class="list-group-item py-0">
                <div class="row align-items-center border-bottom border-1">
                    <div class="col-7">
                        <h4 class="text-success">{{ $idea->title}}</h4>
                    </div>

                    <div class="col-md-5 text-end"> <!-- Updated -->
                        <div class="row align-items-center justify-content-end">
                            <div class="col-auto">
                                <a class="add_to_my_watchlist" data-type="idea" data-id="{{ $ideaHashId }}" data-redirect="{{url()->current()}}">
                                    <i class="fa fa-eye me-2"></i>
                                    <i class="fa fa-plus plus"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a title="Edit Issue" href="{!! url('ideas/'. $ideaHashId .'/edit')!!}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a title="Revision History" href="{!! url('ideas/'. $ideaHashId .'/history')!!}">
                                    <i class="fa fa-history"></i> Revision History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4" style="min-height: 233px">
                        {!! $idea->description !!}
                    </div>

                    <div class="col-md-8 text-end">
                        <div class="row">
                            <!-- Additional content for the second column -->
                        </div>

                        <div class="row lnht30">
                            <div class="col-md-8">
                                <label class="control-label upper d-block">
                                    <span class="fund_icon">STATUS</span>
                                </label>
                            </div>
                            <div class="col-md-4 border-start text-start">
                                <label class="control-label">
                                    @if($idea->status == 1)
                                        Draft
                                    @elseif($idea->status == 2)
                                        Assigned to Task
                                    @else
                                        Implemented
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
