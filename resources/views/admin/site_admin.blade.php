@extends('layout.default')
@section('page-css')
    <style>
        .hierarchy{margin-left:10px;margin-top: 10px;}
    </style>
@endsection
@section('content')

    <div class="container">
        <div class="row form-group" style="margin-bottom: 15px;">
            @include('elements.user-menu',array('page'=>'home'))
        </div>
        <div class="row form-group" >
            <div class="col-md-4">
                <div class="left">
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
            <div class="col-sm-8">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>Job Skills</h4>
                            </div>
                            <div class="panel-body table-inner loading_content_hide list-group ">
                                @if(!empty($authUserObj) && $authUserObj->role == "superadmin" && !empty($need_approve_skills) && count($need_approve_skills) > 0)
                                    <div class="row form-group skill-approve-panel">
                                        <div class="col-sm-6">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Skill Name</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($need_approve_skills as $p_skill)
                                                    <tr>
                                                        <td>
                                                            @if($p_skill->action_type == "delete")
                                                                {{\App\JobSkill::getName($p_skill->job_skill_id)}}
                                                            @else
                                                                {{$p_skill->skill_name}}
                                                            @endif
                                                        </td>
                                                        <td>{{ucfirst($p_skill->action_type)}}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-xs btn-success mark-skill-approve"
                                                               data-id="{{$p_skill->prefix_id}}">Mark as
                                                                Approve</a>

                                                            <a href="#" class="btn btn-xs btn-danger discard-change"
                                                               data-id="{{$p_skill->prefix_id}}">Discard</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        @include('admin.partials.skill_browse',['from'=>'site_admin'])
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default ">
                            <div class="panel-heading">
                                <h4>Unit Categories</h4>
                            </div>
                            <div class="panel-body table-inner table-responsive loading_content_hide">
                                <div class="loading_dots category_loading" style="position: absolute;top:0%;left:43%;z-index: 9999;display:
                                none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <table class="table table-striped category-table">
                                    <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($categoriesObj) > 0 && !empty($categoriesObj))
                                        @foreach($categoriesObj as $category)
                                            <tr>
                                                <td>
                                                    <a href="{!! url('category/'.$unitCategoryIDHashID->encode($category->id))!!}">
                                                        {{$category->name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($category->status == "pending")
                                                        <span class="text-danger">{{ucfirst($category->status)}}</span>
                                                    @else
                                                        <span class="colorLightGreen">{{ucfirst($category->status)}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                No record found.
                                            </td>
                                        </tr>
                                    @endif
                                    <tr style="background-color: #fff;text-align: right;">
                                        <td colspan="2">
                                            <a class="btn black-btn" id="add_category_btn" href="{!! url('category/add') !!}" style="padding-right:10px;padding-left:10px">
                                                <i class="fa fa-plus plus"></i> <span class="plus_text">ADD CATEGORY</span>
                                            </a>

                                            @if($categoriesObj->lastPage() > 1 && $categoriesObj->lastPage() != $categoriesObj->currentPage())
                                                <a href="#" data-url="{{$categoriesObj->url($categoriesObj->currentPage()+1) }}"
                                                   class="btn more-black-btn more-category"  type="button" style="margin-right: 0px;padding-right:10px;padding-left:10px">
                                                    <span class="more_dots">...</span> MORE CATEGORIES
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default ">
                            <div class="panel-heading">
                                <h4>Area of interest</h4>
                            </div>
                            <div class="panel-body table-inner table-responsive loading_content_hide">
                                <div class="loading_dots area_of_interest_loading" style="position: absolute;top:0%;left:43%;z-index: 9999;display:
                                none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <table class="table table-striped area_of_interest-table">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Parent Area of Interest</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($area_of_interestObj) > 0 && !empty($area_of_interestObj))
                                        @foreach($area_of_interestObj as $area_of_interest)
                                            <tr>
                                                <td>
                                                    <a href="{!! url('area_of_interest/'.$areaOfInterestIDHashID->encode($area_of_interest->id))!!}">
                                                        {{$area_of_interest->title}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if(!empty($area_of_interest->parent_id))
                                                        <a href="{!! url('area_of_interest/'.$areaOfInterestIDHashID->encode($area_of_interest->parent_id )) !!}">
                                                            {{\App\AreaOfInterest::getName($area_of_interest->parent_id)}}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                No record found.
                                            </td>
                                        </tr>
                                    @endif
                                    <tr style="background-color: #fff;text-align: right;">
                                        <td colspan="2">
                                            <a class="btn black-btn" id="add_category_btn" href="{!! url('area_of_interest/add') !!}" style="padding-right:10px;padding-left:10px">
                                                <i class="fa fa-plus plus"></i> <span class="plus_text">ADD AREA OF INTEREST</span>
                                            </a>

                                            @if($area_of_interestObj->lastPage() > 1 && $area_of_interestObj->lastPage() != $area_of_interestObj->currentPage())
                                                <a href="#" data-url="{{$area_of_interestObj->url($area_of_interestObj->currentPage()+1) }}"
                                                   class="btn more-black-btn more-area-of-interest"  type="button" style="margin-right: 0px;padding-right:10px;padding-left:10px">
                                                    <span class="more_dots">...</span> MORE AREA OF INTEREST
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
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">
        var msg_flag ='{{ $msg_flag }}';
        var msg_type ='{{ $msg_type }}';
        var msg_val ='{{ $msg_val }}';
        var page='site_admin';
    </script>
    <script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/js/admin/site_admin.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/js/admin/skill_browse.js') !!}" type="text/javascript"></script>
@endsection