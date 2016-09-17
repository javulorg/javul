@extends('layout.default')
@section('page-css')
    <style>
        .related_para{margin:0 0 10px;}
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row form-group" style="margin-bottom: 15px;">
            @include('elements.user-menu',['page'=>'units'])
        </div>
        <div class="row form-group">
            <div class="col-md-4">
                @include('units.partials.unit_information_left_table',['unitObj'=>$unitObj,'availableFunds'=>$availableUnitFunds,'awardedFunds'=>$awardedUnitFunds])
                <div class="left" style="position: relative;margin-top: 30px;">
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
                <div class="panel panel-grey panel-default">
                    <div class="panel-heading">
                        <h4>ISSUES</h4>
                    </div>
                    <div class="panel-body list-group loading_content_hide">
                        <div class="loading_dots objective_loading" style="position: absolute;top:0;left:43%;z-index: 9999;display:none;">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <table class="table table-striped issue-table">
                            <thead>
                            <tr>
                                <th>Issue Name</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($issuesObj) > 0)
                                @foreach($issuesObj as $obj)
                                    <tr>
                                        <td>
                                            <a href="{!! url('issues/'.$issueIDHashID->encode($obj->id).'/view') !!}"
                                               title="edit">
                                                {{$obj->title}}
                                            </a>
                                        </td>
                                        <td><a href="{!! url('units/'.$unitIDHashID->encode($obj->unit_id).'/'.\App\Unit::getSlug($obj->unit_id)) !!}"
                                               title="edit">{{\App\Unit::getUnitName($obj->unit_id)}}</a></td>
                                        <td>{{$obj->status}}</td>
                                        <td>
                                            <div class="text_wraps" data-toggle="tooltip" data-placement="top"  title="{!!trim
                                            ($obj->description)!!}"><span
                                                        class="ellipsis_text">{!!trim($obj->description)!!}</span></div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            @endif

                            <tr style="background-color: #fff;text-align: right;">
                                <td colspan="5">
                                    <a class="btn black-btn" id="add_objective_btn" href="{!! url('issues/'.$unitIDHashID->encode($unit_activity_id).'/add') !!}">
                                        <i class="fa fa-plus plus"></i> <span class="plus_text">Add Issue</span>
                                    </a>

                                    @if($issuesObj->lastPage() > 1 && $issuesObj->lastPage() != $issuesObj->currentPage())
                                        <a href="#" data-url="{{$issuesObj->url($issuesObj->currentPage()+1) }}" data-unit_id="{{$unitIDHashID->encode($unit_activity_id)}}" class="btn
                                    more-black-btn more-objectives" data-from_page="unit_view" type="button">
                                            <span class="more_dots">...</span> MORE OBJECTIVES
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.footer')
@stop

@section('page-scripts')
    <script src="{!! url('assets/plugins/jquery.ThreeDots.min.js') !!}" type="text/javascript"></script>
    <script>
        var msg_flag ='{{ $msg_flag }}';
        var msg_type ='{{ $msg_type }}';
        var msg_val ='{{ $msg_val }}';
        $(function(){
            $(".unit_description").css("min-height",($(".both-div").height())+10+'px');
            var the_obj = $('.text_wraps').ThreeDots({
                max_rows: 1
            });
        })
    </script>
    <script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
@endsection
