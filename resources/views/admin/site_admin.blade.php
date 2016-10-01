@extends('layout.default')

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
                <div class="row">
                    <div class="col-sm-6">
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

                    <div class="col-sm-6">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>Job Skills</h4>
                            </div>
                            <div class="panel-body table-inner table-responsive loading_content_hide">
                                <div class="loading_dots skill_loading" style="position: absolute;top:30%;left:43%;z-index: 9999;display:
                                none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <table class="table table-striped skill-table">
                                    <thead>
                                    <tr>
                                        <th>Skill Name</th>
                                        <th>Parent Skill</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($jobSkillsObj) > 0)
                                        @foreach($jobSkillsObj as $skill)
                                            <tr>
                                                <td>
                                                    <a href="{!! url('job_skills/'.$jobSkillIDHashID->encode($skill->id)) !!}">
                                                        {{$skill->skill_name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if(!empty($skill->parent_id))
                                                        <a href="{!! url('job_skills/'.$jobSkillIDHashID->encode($skill->parent_id )) !!}">
                                                            {{\App\JobSkill::getName($skill->parent_id)}}
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
                                            <a class="btn black-btn" id="add_skill_btn" href="{!! url('job_skills/add') !!}">
                                                <i class="fa fa-plus plus"></i> <span class="plus_text">ADD SKILL</span>
                                            </a>

                                            @if($jobSkillsObj->lastPage() > 1 && $jobSkillsObj->lastPage() != $jobSkillsObj->currentPage())
                                                <a href="#" data-url="{{$jobSkillsObj->url($jobSkillsObj->currentPage()+1) }}"
                                                   class="btn more-black-btn more-skills"  type="button">
                                                    <span class="more_dots">...</span> MORE SKILLS
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
    </script>
    <script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('.show_bid_details').on('click',function(){
                var id = $(this).attr('data-id');
                if($.trim(id) != ""){
                    $.ajax({
                        type:'get',
                        url:siteURL+'/tasks/get_biding_details',
                        data:{id:id},
                        dataType:'json',
                        success:function(resp){
                            if(resp.success){
                                bootbox.dialog({
                                    message: resp.html
                                });
                            }
                        }
                    })
                }
                return false;
            });
        })
    </script>
@endsection