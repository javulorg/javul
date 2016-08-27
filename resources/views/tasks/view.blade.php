@extends('layout.default')
@section('page-css')
<style>
    hr, p{margin:0 0 10px !important;}
    .files_image:hover{text-decoration: none;}
    .file_documents{display: inline-block;padding: 10px;}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row form-group" style="margin-bottom:15px">
        @include('elements.user-menu',['page'=>'tasks'])
    </div>
    <div class="row form-group">
        <div class="col-md-4">
            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>UNIT INFORMATION</h4>
                </div>
                <div class="panel-body unit-info-panel list-group">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="control-label upper">UNIT NAME</label>
                                <label class="control-label colorLightGreen form-control label-value">
                                    {{$taskObj->unit->name}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 unit-info-main-div">
                                <label class="control-label upper">UNIT LINKS</label>
                            </div>
                            <div class="col-xs-8" style="padding-top: 7px;">
                                <div class="row unit_info_row_1">
                                    <div class="col-xs-12">
                                        <ul class="unit_info_link_1" style="">
                                            <li><a href="#" class="colorLightBlue upper">OBJECTIVES</a></li>
                                            <li class="mrgrtlt5">|</li>
                                            <li><a href="#" class="colorLightBlue upper">TASKS</a></li>
                                            <li class="mrgrtlt5">|</li>
                                            <li><a href="#" class="colorLightBlue upper">ISSUES</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="unit_info_link_2">
                                            <i class="fa fa-quote-right colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">FORUM</a></li>
                                            <i class="fa fa-comments colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">CHAT</a></li>
                                            <i class="fa fa-wikipedia-w colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">WIKI</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">OTHER LINKS</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue">LINK1, LINK2</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">UNIT CATEGORIES</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue upper">SOFTWARE</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">UNIT LOCATION</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue upper">{{\App\City::getName($taskObj->unit->city_id)}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper" style="width: 100%;">
                                    FUND
                                    <span class="text-right pull-right"> <div class="fund_paid"><i class="fa fa-plus"></i></div></span>
                                </label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <div class="row">
                                    <div class="col-xs-6">Available</div>
                                    <div class="col-xs-6 text-right">12456$</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">Awarded</div>
                                    <div class="col-xs-6 text-right">6563131$</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="left">
                @include('elements.site_activities')
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-grey panel-default">
                <div class="panel-heading current_task_heading featured_unit_heading">
                    <div class="featured_unit current_task">
                        <i class="fa fa-pencil-square-o"></i>
                    </div>
                    <h4>TASK INFORMATION</h4>
                </div>
                <div style="padding: 0px;" class="panel-body current_unit_body list-group form-group">
                    <div class="list-group-item" style="padding-top:0px;padding-bottom:0px;">
                        <div class="row" style="border-bottom:1px solid #ddd;">
                            <div class="col-sm-7 featured_heading">
                                <h4 class="colorLightGreen">{{$taskObj->name}}</h4>
                            </div>
                            <div class="col-sm-5 featured_heading text-right colorLightBlue">
                                <div class="row">
                                    <div class="col-xs-3 text-center">
                                        <i class="fa fa-eye" style="margin-right:2px"></i><i class="fa fa-plus"></i>
                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <div class="col-xs-7 text-center">
                                        <i class="fa fa-history"></i> REVISION HISTORY
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-7 featured_heading" style="min-height: 170px">
                                {!! $taskObj->description !!}
                            </div>
                            <div class="col-xs-5 featured_heading text-right colorLightBlue" style="margin-top:0px;padding-top:0px;">
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">Status</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT text-left">
                                        <label class="control-label colorLightGreen">{{\App\SiteConfigs::task_status($taskObj->status)}}</label>
                                    </div>
                                </div>
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">skills</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT text-left">
                                        <label class="control-label form-control text-label-value">SKILL1</label>
                                        <label class="control-label form-control text-label-value">SKILL2</label>
                                    </div>
                                </div>
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">Award</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT text-left">
                                        <label class="control-label">$60</label>
                                    </div>
                                </div>
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">Completion</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT text-left">
                                        <label class="control-label">30 days</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading current_task_heading featured_unit_heading">
                                <div class="featured_unit current_task">
                                    <i class="fa fa-pencil-square-o"></i>
                                </div>
                                <h4>ACTION ITEMS</h4>
                            </div>
                            <div class="panel-body list-group">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading current_task_heading featured_unit_heading">
                                <div class="featured_unit current_task">
                                    <i class="fa fa-pencil-square-o"></i>
                                </div>
                                <h4>FILE ATTACHMENTS</h4>
                            </div>
                            <div class="panel-body list-group">
                            </div>
                        </div>
                    </div>
                </div>-->

            </div>
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
@section('page-scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
<script type="text/javascript">
    $(function(){
        $('#tabs').tab();

        $(".assign_now").on('click',function(){
            var uid = $(this).attr('data-uid');
            var tid = $(this).attr('data-tid');
            if($.trim(uid) != "" && $.trim(tid) != ""){
                $.ajax({
                    type:'get',
                    url:siteURL+'/tasks/assign',
                    data:{uid:uid,tid:tid },
                    dataType:'json',
                    success:function(resp){
                        if(resp.success){
                            toastr['success']('Task assign successfully', '');
                            window.location.reload(true);
                        }
                    }
                })
            }
        });
    })
</script>
@endsection