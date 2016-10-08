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
                            <div class="panel-body table-inner loading_content_hide">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <div class="all_levels">
                                            @if(count($firstBox_skills) > 0)
                                                <select name="skill" id="skill_firstbox" class="first_level hierarchy" size="5" data-number="1">
                                                    @foreach($firstBox_skills as $skill_id=>$skill)
                                                        <option value="{{$skill_id}}">{{$skill}}&nbsp;></option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="margin-bottom: 10px;margin-left: 10px;">
                                        <a class="btn black-btn btn-xs add_skill" id="add_skill_btn" style="padding:5px 16px 8px">
                                            <i class="fa fa-plus plus"></i> <span class="plus_text">ADD SKILL</span>
                                        </a>
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

            $(document).off("change","select.hierarchy").on('change',"select.hierarchy",function(event){
                var that = $(this);
                getNextBox(that);
                return false;
            });
            $(document).off("click","a.hierarchy").on('click',"a.hierarchy",function(event){
                var that = $(this);
                getNextBox(that);
                return false;
            });

            $(document).off("click",".add_skill").on("click",".add_skill",function(){

                var frm = '<form method="post" id="add_skill_form">'+
                        '<div class="row">'+
                        '<div class="col-sm-12">'+
                        '<label class="control-label">Skill Name</label>'+
                        '<input type="text" name="skill_name" class="form-control"/>';

                        var parent_id = 0;
                        if($(this).attr('id') != "add_skill_btn"){
                            parent_id= $(this).parent('div').attr('data-prev');
                        }
                        frm+='<input type="hidden" name="parent_id" value="'+parent_id+'"/></div>'+
                        '</div>'+
                        '</form>';
                var box = bootbox.dialog({
                    title: "Add new skill",
                    message: frm,
                    buttons: {
                        danger: {
                            label: "Cancel",
                            className: "btn-danger",
                            callback: function() {
                                bootbox.hideAll();
                            }
                        },
                        success: {
                            label: "Add Skill",
                            className: "btn-success",
                            callback: function(e) {
                                $.ajax({
                                    type:'get',
                                    url:siteURL+'/job_skills/add',
                                    data:$("#add_skill_form").serialize(),
                                    dataType:'json',
                                    success:function(resp){
                                        if(resp.success){
                                            bootbox.hideAll();
                                            toastr['success']('Job skill added successfully!!!', '') ;
                                            window.location.reload(true);
                                        }
                                        else{
                                            var error='';
                                            $.each(resp.errors,function(index,val){
                                                error+='<span>'+val+'</span>';
                                            });
                                            toastr['error'](error, '') ;
                                            return false;
                                        }
                                    }
                                })
                                return false;
                            }
                        }
                    }
                });

                $(".div-table-second-cell").css('z-index','100');
                $(".list-item-main").css('z-index','100');

                box.on("hidden.bs.modal", function (e) {
                    $(".list-item-main").css('z-index','99999');
                    $(".div-table-second-cell").css('z-index','99999');
                });

                box.modal('show');
                return false;
            });

            $(document).off("click",".delete_skill").on("click",".delete_skill",function(){
                var selected = $(this).attr('data-prev');

                var box = bootbox.dialog({
                    title: "Are you sure?",
                    message: 'Are you sure. you want to delete ?',
                    buttons: {
                        danger: {
                            label: "Cancel",
                            className: "btn-danger",
                            callback: function() {
                                bootbox.hideAll();
                            }
                        },
                        success: {
                            label: "Delete",
                            className: "btn-success",
                            callback: function(e) {
                                $.ajax({
                                    type:'get',
                                    url:siteURL+'/job_skills/delete',
                                    data:{id:selected},
                                    dataType:'json',
                                    success:function(resp){
                                        if(resp.success){
                                            bootbox.hideAll();
                                            toastr['success']('Job skill deleted successfully!!!', '') ;
                                            window.location.reload(true);
                                        }
                                        else{

                                            toastr['error'](resp.msg, '') ;
                                            return false;
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    }
                });

                $(".div-table-second-cell").css('z-index','100');
                $(".list-item-main").css('z-index','100');

                box.on("hidden.bs.modal", function (e) {
                    $(".list-item-main").css('z-index','99999');
                    $(".div-table-second-cell").css('z-index','99999');
                });

                box.modal('show');
                return false;
            });

            $(document).off("click",".edit_skill").on("click",".edit_skill",function(){
                var selected = $(this).attr('data-id');
                var skill_name = $(this).attr('data-text')

                var frm = '<form method="post" id="edit_skill_form">'+
                        '<div class="row">'+
                        '<div class="col-sm-12">'+
                        '<label class="control-label">Skill Name</label>'+
                        '<input type="text" name="skill_name" class="form-control" value="'+skill_name.replace(">","")+'"/>' +
                        '<input type="hidden" name="selected_id" value="'+selected+'"/>';


                frm+='</div>'+
                        '</div>'+
                        '</form>';
                var box = bootbox.dialog({
                    title: "Update skill",
                    message: frm,
                    buttons: {
                        danger: {
                            label: "Cancel",
                            className: "btn-danger",
                            callback: function() {
                                bootbox.hideAll();
                            }
                        },
                        success: {
                            label: "Edit Skill",
                            className: "btn-success",
                            callback: function(e) {
                                $.ajax({
                                    type:'get',
                                    url:siteURL+'/job_skills/edit',
                                    data:$("#edit_skill_form").serialize(),
                                    dataType:'json',
                                    success:function(resp){
                                        if(resp.success){
                                            bootbox.hideAll();
                                            toastr['success']('Job skill updated successfully!!!', '') ;
                                            window.location.reload(true);
                                        }
                                        else{
                                            var error='';
                                            $.each(resp.errors,function(index,val){
                                                error+='<span>'+val+'</span>';
                                            });
                                            toastr['error'](error, '') ;
                                            return false;
                                        }
                                    }
                                })
                                return false;
                            }
                        }
                    }
                });

                $(".div-table-second-cell").css('z-index','100');
                $(".list-item-main").css('z-index','100');

                box.on("hidden.bs.modal", function (e) {
                    $(".list-item-main").css('z-index','99999');
                    $(".div-table-second-cell").css('z-index','99999');
                });

                box.modal('show');
                return false;
            });

            function getNextBox(that){

                if(that.attr('id') == "skill_firstbox"){
                    var id =that.val();
                    var box_number = that.data('number');
                }
                else
                {
                    var id =that.attr('data-value');
                    var box_number = that.parent('div').attr('data-number');
                }
                $.ajax({
                    type:'get',
                    url:siteURL+'/job_skills/get_next_level_skills',
                    data:{id:id},
                    dataType:'json',
                    success:function(resp){
                        if(resp.success){

                            if(Object.keys(resp.data).length > 0)
                            {
                                $(".add_edit_skills").remove();
                                var next_level=$(".all_levels").find('select,div').length;
                                if(next_level > box_number ){
                                    for(var i=box_number;i<=next_level;i++){
                                        if($(".all_levels").find('select,div').length != box_number)
                                            $(".all_levels").find('div:last').remove();
                                    }
                                }
                                next_level=$(".all_levels").find('select,div').length;

                                var html = '<div class="hierarchy new_box" data-prev="'+id+'" data-number="'+(next_level+1)+'">';
                                $.each(resp.data,function(index,val){
                                    html+='<div><a  href="" class="hierarchy" data-value="'+index+'">'+val+'&nbsp;></a><a ' +
                                            'class="edit_skill" data-id="'+index+'" data-text="'+val+'">Edit</a></div>';
                                })
                                html+= '<a class="add_skill">Add skill</a></div>';
                                $(".all_levels").append(html);
                                return false;
                            }
                            else{
                                $(".add_edit_skills").remove();
                                var next_level=$(".all_levels").find('select,div').length;
                                if(next_level > box_number ){
                                    for(var i=box_number;i<=next_level;i++){
                                        if($(".all_levels").find('select,div').length != box_number)
                                            $(".all_levels").find('div:last').remove();
                                    }
                                }

                                var html = '<div class="add_edit_skills" data-prev="'+id+'" style="border: 1px solid rgb(170, 170, 170); display: ' +
                                        'inline-block; height:auto; position: relative;top:10px;' +
                                        'margin-left: 10px;"><button  class="add_skill" style="display: block;' +
                                        'margin:10px">Add Skill</button><button data-prev="'+id+'" class="delete_skill" style="display: block;' +
                                        'margin:10px">Delete Skill</button></div>' ;
                                $(".all_levels").append(html);
                            }
                        }

                    }
                });
            }

        });

    </script>
@endsection