<div class="card border">
    <div class="card-header">
        <h5 class="card-title">OBJECTIVE INFORMATION</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            <div class="list-group-item py-0">
                <div class="row align-items-center border-bottom border-1">
                    <div class="col-7">
                        <h4 class="text-success">{{ $objectiveObj->name}}</h4>
                    </div>

                    <div class="col-md-5 text-end">
                        <div class="row">
                            <div class="col-3">
                                <a class="add_to_my_watchlist" data-type="objective" data-id="{{$objectiveIDHashID->encode($objectiveObj->id)}}" data-redirect="{{url()->current()}}">
                                    <i class="fa fa-eye me-2"></i>
                                    <i class="fa fa-plus plus"></i>
                                </a>
                            </div>
                            <div class="col-2">
                                <a title="Edit Objective" href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit')!!}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                            <div class="col-7">
                                <a href="{!! route('objectives_revison',[$objectiveIDHashID->encode($objectiveObj->id)]) !!}"><i class="fa fa-history"></i> REVISION HISTORY</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4" style="min-height: 233px">
                        {!! $objectiveObj->description !!}
                    </div>

                    <div class="col-md-8 text-end">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="control-label upper d-block">
                                    <span class="fund_icon">FUNDS</span>
                                    <span class="text-right float-end">
                                                                <a href="{!! url('funds/donate/objective/'.$objectiveIDHashID->encode($objectiveObj->id))!!}">
                                                                    <div class="fund_paid">
                                                                        <i class="fa fa-plus plus"></i>
                                                                    </div>
                                                                </a>
                                                             </span>
                                </label>
                            </div>
                            <div class="col-md-4 border-start" style="padding-top: 3px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label label-value float-end" style="margin-left: 15px;">{{number_format($availableObjFunds,2)}} $</label>
                                        <label class="control-label d-block" style="margin-bottom: 5px;">
                                            Available
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="control-label label-value float-end" style="margin-left: 15px;">{{number_format($awardedObjFunds,2)}} $</label>
                                        <label class="control-label d-block" style="margin-bottom: 5px;">
                                            Awarded
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row lnht30">
                            <div class="col-md-8">
                                <label class="control-label upper d-block">
                                    <span class="fund_icon">STATUS</span>
                                </label>
                            </div>
                            <div class="col-md-4 border-start text-start">
                                <label class="control-label">
                                    {{ \App\Models\Objective::objectiveStatus()[$objectiveObj->status] }}
                                </label>
                            </div>
                        </div>

                        @if(auth()->check())
                            <div class="row lnht30">
                                <div class="col-md-8">
                                    <label class="control-label upper d-block">
                                        <span class="fund_icon">SUPPORT</span>
                                    </label>
                                </div>
                                <div class="col-md-4 border-start">
                                    <div class="importance-div">
                                        @include('objectives.partials.importance_level',['objective_id'=>$objectiveObj->id])
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
