@extends('layout.default')
@section('page-css')
    <style>.related_para{margin:0 0 10px;}</style>
@endsection
@section('content')

    <div class="container">
        <div class="row form-group" style="margin-bottom:15px">
            @include('elements.user-menu',['page'=>'objectives'])
        </div>
        <div class="row form-group">
            <div class="col-md-4">
                <div class="left" style="position: relative;">
                    <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="site_activity_list">
                        @include('elements.site_activities',['ajax'=>false])
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-grey panel-default" style="margin-bottom: 30px;">
                    <div class="panel-heading current_issue_heading featured_unit_heading">
                        <div class="featured_unit current_issue">
                            <i class="fa fa-bug" style="font-size:18px"></i>
                        </div>
                        <h4>UNIT CATEGORY NAme</h4>
                    </div>
                    <div style="padding: 0px;" class="panel-body current_unit_body list-group">
                        <div class="list-group-item" style="padding-top:0px;padding-bottom:0px;">
                            <div class="row" style="border-bottom:1px solid #ddd;">
                                <div class="col-sm-7 featured_heading">
                                    <h4 class="colorIssue">{{$categoryObj->name}}</h4>
                                </div>
                                <div class="col-sm-5 featured_heading text-right colorLightBlue">
                                    <div class="row">
                                        <div class="col-xs-3 text-center">
                                            <a href="{!! url('category/'.$unitCategoryIDHashID->encode($categoryObj->id).'/edit')!!}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </div>
                                        <div class=" col-xs-9 text-center">
                                            <i class="fa fa-history"></i> REVISION HISTORY
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-7 featured_heading" style="min-height: 150px">
                                    {!! $categoryObj->description !!}
                                </div>
                                <div class="col-xs-5 featured_heading text-right obj_info_div">
                                    <div class="row borderBTM ">
                                        <div class="col-xs-4 text-left">
                                            <label class="control-label upper">Status</label>
                                        </div>
                                        <div class="col-xs-8 borderLFT text-left" style="line-height: 40px;">
                                            <label class="control-label  ">
                                                @if($categoryObj->status == "approved")
                                                    <span class="colorLightGreen">{{ucfirst($categoryObj->status)}}</span>
                                                @else
                                                    <span class="text-danger">{{ucfirst($categoryObj->status)}}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-grey panel-default">
                    <div class="panel-heading">
                        <h4>Parent category</h4>
                    </div>
                    <div class="panel-body list-group">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label colorLightBlue form-control label-value">
                                        @if(!empty($categoryObj->parent_id))
                                        <a style="font-weight: normal;" class="no-decoration" href="{!! url('category/'.$unitCategoryIDHashID->encode
                                    ($categoryObj->parent_id)) !!}">
                                            <span class="badge">{{\App\Models\UnitCategory::getName($categoryObj->parent_id)}}</span>
                                        </a>
                                        @else
                                            -
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
    @include('elements.footer')
@endsection
