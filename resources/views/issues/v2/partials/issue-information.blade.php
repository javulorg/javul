<div class="card border">
    <div class="card-header">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
            </div>
            ISSUE INFORMATION
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
    </div>

    <div class="card-body">


        <div class="list-group">


            <div class="list-group-item py-0">
                <div class="row align-items-center border-bottom border-1">
                    <div class="col-7">
                        <h4 class="text-success">{{$issueObj->title}}</h4>
                    </div>

                    <div class="col-md-5 text-end">
                        <div class="row align-items-center justify-content-end">
                            <div class="col-3">
                                <a class="add_to_my_watchlist" data-type="issue" data-id="{{$issueIDHashID->encode($issueObj->id)}}" data-redirect="{{url()->current()}}">
                                    <i class="fa fa-eye" style="margin-right:2px"></i>
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-2">
                                <a title="Edit Issue" href="{!! url('issues/'.$issueIDHashID->encode($issueObj->id).'/edit')!!}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                            <div class="col-7">
                                <a href="{!! route('issues_revison',[$issueIDHashID->encode($issueObj->id)]) !!}"><i class="fa fa-history"></i> REVISION HISTORY</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="min-height: 120px">
                        {!! $issueObj->description !!}
                    </div>

                    <div class="col-md-8 text-end">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="control-label upper d-block">
                                    <span class="fund_icon">STATUS</span>
                                </label>
                            </div>
                            <div class="col-md-4 border-start text-start">
                                <label class="control-label {{$status_class}}">
                                    <?php $verified_by ='';?>
                                    @if($issueObj->status == "verified")
                                        <?php $verified_by = " (by ".App\Models\User::getUserName($issueObj->verified_by).')';?>
                                    @endif
                                    {{ucfirst($issueObj->status. $verified_by )}}
                                </label>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-8">
                                <label class="control-label upper d-block">
                                    <span class="fund_icon">SUPPORT</span>
                                </label>
                            </div>
                            <div class="col-md-4 border-start">

                                <div class="importance-div">
                                    @include('issues.partials.importance_level',['issue_id'=>$issueObj->id])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
