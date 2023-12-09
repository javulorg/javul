{{--@extends('layout.master')--}}
{{--@section('title', 'Objective: ' . $objectiveObj->name)--}}
{{--@section('site-name')--}}
{{--    @if(isset($unitData))--}}
{{--        <h1>{{ $unitData->name }}</h1>--}}
{{--    @else--}}
{{--        <h1>Javul.org</h1>--}}
{{--    @endif--}}
{{--    <div class="banner_desc d-md-block d-none">--}}
{{--        Open-source Society--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@section('navbar')--}}
{{--    @if(isset($unitData))--}}
{{--        @include('layout.navbar', ['unitData' => $unitData])--}}
{{--    @endif--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <div class="content_row">--}}
{{--        <div class="sidebar">--}}
{{--            @if(isset($unitData))--}}
{{--                @include('layout.v2.global-unit-overview')--}}
{{--                <?php--}}
{{--                $title = 'Activity Log';--}}
{{--                ?>--}}
{{--                @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])--}}

{{--                @include('layout.v2.global-finances')--}}

{{--                @include('layout.v2.global-about-site')--}}
{{--            @else--}}
{{--                <?php--}}
{{--                $title = 'Global Activity Log';--}}
{{--                ?>--}}
{{--                @include('layout.v2.global-activity-log',['title' => $title])--}}
{{--            @endif--}}
{{--        </div>--}}


{{--        <div class="main_content">--}}
{{--            <div class="content_block">--}}
{{--                <div class="table_block table_block_objectives active">--}}
{{--                    <div class="table_block_head">--}}
{{--                        <div class="table_block_icon">--}}
{{--                            <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">--}}
{{--                        </div>--}}
{{--                        {{ $objectiveObj->name}}--}}
{{--                        <div class="arrow">--}}
{{--                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="objective_content">--}}
{{--                        <div class="objective_content_row d-sm-flex d-none">--}}
{{--                            <div>--}}
{{--                               <p>--}}
{{--                                   {!! $objectiveObj->description !!}--}}
{{--                               </p>--}}
{{--                            </div>--}}
{{--                            <div class="objective_content_info">--}}
{{--                                <div class="sidebar_block">--}}
{{--                                    <div class="sidebar_block_ttl">--}}
{{--                                        Objective Overview--}}
{{--                                        <div class="arrow">--}}
{{--                                            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="sidebar_block_content">--}}
{{--                                        <div class="sidebar_block_row">--}}
{{--                                            <div class="sidebar_block_left">--}}
{{--                                                Priority:--}}
{{--                                            </div>--}}
{{--                                            <div class="sidebar_block_right">--}}
{{--                                                Medium--}}
{{--                                                <div class="progress">--}}
{{--                                                    <div class="progress-bar" style="width:75%"></div>--}}
{{--                                                </div> <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""></a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="sidebar_block_row">--}}
{{--                                            <div class="sidebar_block_left">--}}
{{--                                                Status:--}}
{{--                                            </div>--}}
{{--                                            <div class="sidebar_block_right">--}}
{{--                                                {{ \App\Models\Objective::objectiveStatus()[$objectiveObj->status] }}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="sidebar_line"></div>--}}
{{--                                        <div class="sidebar_block_row">--}}
{{--                                            <div class="sidebar_block_left">--}}
{{--                                                Funds:--}}
{{--                                            </div>--}}
{{--                                            <div class="sidebar_block_right">--}}
{{--                                                Received $2500<br>--}}
{{--                                                Awarded ${{number_format($awardedObjFunds,2)}}<br>--}}
{{--                                                Available ${{number_format($availableObjFunds,2)}}<br>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="objective_content_info_links">--}}
{{--                                    <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/eye.svg') }}" alt=""></a>--}}
{{--                                    <div class="separat"></div>--}}
{{--                                    <a href="{!! route('objectives_revison',[$objectiveIDHashID->encode($objectiveObj->id)]) !!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""> Revision History</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            start tasks--}}
{{--            <div class="content_block">--}}
{{--                <div class="table_block table_block_tasks">--}}
{{--                    <div class="table_block_head">--}}
{{--                        <div class="table_block_icon">--}}
{{--                            <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">--}}
{{--                        </div>--}}
{{--                        Tasks--}}
{{--                        <div class="arrow">--}}
{{--                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="table_block_body">--}}
{{--                        <table>--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th class="title_col">--}}
{{--                                    Title--}}
{{--                                </th>--}}
{{--                                <th class="status_col">--}}
{{--                                    Status--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @if(count($objectiveObj->tasks) > 0)--}}
{{--                                @foreach($objectiveObj->tasks as $obj)--}}
{{--                                    <tr>--}}
{{--                                        <td class="title_col">--}}
{{--                                            <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">--}}
{{--                                                {{$obj->name}}--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
{{--                                        <td class="status_col">--}}
{{--                                            @if($obj->status == "editable")--}}
{{--                                                <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>--}}
{{--                                            @else--}}
{{--                                                <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                                <tr>--}}
{{--                                    <td colspan="4">No record(s) found.</td>--}}
{{--                                </tr>--}}
{{--                            @endif--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="content_block_bottom">--}}
{{--                    <a href="{{ url('tasks/create') }}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>--}}
{{--                    <div class="separator"></div> <a href="#" class="see_more">See more</a>--}}
{{--                </div>--}}
{{--            </div>--}}



{{--            <div class="content_block_comments">--}}
{{--                <div class="table_block table_block_comments">--}}
{{--                    <div class="table_block_head">--}}
{{--                        <div class="table_block_icon">--}}
{{--                            <img src="{{ asset('v2/assets/img/Dialog.svg') }}" alt="" class="img-fluid">--}}
{{--                        </div>--}}
{{--                        Comments--}}
{{--                    </div>--}}
{{--                    <div class="comments_content">--}}
{{--                        <div class="comment_stat">--}}
{{--                            <b>2 review</b> <a href="#">Write a review</a>--}}
{{--                        </div>--}}
{{--                        <div class="comment_container">--}}
{{--                            <div class="comment_icon">--}}
{{--                                <img src="{{ asset('v2/assets/img/User_Circle.svg') }}" alt="" class="img-fluid">--}}
{{--                            </div>--}}
{{--                            <div class="comment_content">--}}
{{--                                <div class="comment_info">--}}
{{--                                    <div class="comment_autor">--}}
{{--                                        John--}}
{{--                                    </div>--}}
{{--                                    <div class="comment_time">--}}
{{--                                        just now--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="comment_txt">--}}
{{--                                    Vestibulum sagittis tincidunt est, sit amet vulputate orci fringilla in. Duis iaculis nibh eget arcu volutpat, eget volutpat lorem sollicitudin. Pellentesque finibus id orci nec feugiat. Maecenas laoreet elit vitae magna pellentesque vulputate. Donec dictum hendrerit ex, non dignissim lectus fringilla ac. Aenean sit amet pellentesque lacus. Nam et rhoncus ex.--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="comment_container">--}}
{{--                            <form method="post" action="">--}}
{{--                                <div class="comment_icon">--}}
{{--                                    <img src="{{ asset('v2/assets/img/User_Circle.svg') }}" alt="" class="img-fluid">--}}
{{--                                </div>--}}
{{--                                <div class="comment_content">--}}
{{--                                    <textarea cols="30" rows="10" placeholder="White a message..."></textarea>--}}
{{--                                    <button type="button" class="btn">Send</button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="content_block_bottom">--}}
{{--                    <a href="#"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        ClassicEditor--}}
{{--            .create( document.querySelector('#comment') )--}}
{{--            .catch( error => {--}}
{{--                console.error(error);--}}
{{--            } );--}}


{{--        $(".objectiveComment #form_topic_form").submit(function(){--}}
{{--            if(xhr && xhr.readyState != 4){--}}
{{--                xhr.abort();--}}
{{--            }--}}

{{--            $("#form_topic_form").find(".alert").remove();--}}

{{--            xhr = $.ajax({--}}
{{--                type:'post',--}}
{{--                url:siteURL + '/forum/submitauto',--}}
{{--                data:$(this).serialize(),--}}
{{--                dataType:'json',--}}
{{--                beforeSend:function(){--}}
{{--                    $("#form_topic_form button.btn").button("loading");--}}
{{--                },--}}
{{--                error:function(){--}}

{{--                },--}}
{{--                complete:function(){--}}
{{--                    $("#form_topic_form button.btn").button("reset");--}}
{{--                },--}}
{{--                success:function(json){--}}

{{--                    if(json['success']){--}}
{{--                        CKupdate();--}}
{{--                        loadComments();--}}
{{--                        toastr['success'](json['success'], '');--}}
{{--                    }--}}

{{--                    if(json['error']){--}}
{{--                        showToastMessage(json['error']);--}}
{{--                        // toastr['error'](json['error'], '');--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}

{{--            return false;--}}
{{--        })--}}


{{--        function loadComments(){--}}
{{--            $.ajax({--}}
{{--                type:'post',--}}
{{--                url: siteURL + '/forum/loadObjectiveComment' ,--}}
{{--                data:$(".objectiveComment #form_topic_form").serialize(),--}}
{{--                dataType:'json',--}}
{{--                beforeSend:function(){--}}
{{--                    $(".objectiveLoader").show();--}}
{{--                },--}}
{{--                error:function(){--}}
{{--                    $(".objectiveLoader").hide();--}}
{{--                },--}}
{{--                complete:function(){--}}
{{--                    $(".objectiveLoader").hide();--}}
{{--                },--}}
{{--                success:function(json){--}}
{{--                    var html = '';--}}
{{--                    var count = 0;--}}
{{--                    $.each(json['comments']['items'],function(i,j){--}}
{{--                        var b = j['ideapoint'] == 1 ? 'active' : '';--}}
{{--                        count ++;--}}

{{--                        html += '<li class="post-div">';--}}
{{--                        html += '    <div class="heading"><a href="' + j['link'] +'">';--}}
{{--                        html += '        ' + j['first_name'] +  " " +   j['last_name'] ;--}}
{{--                        html += '        </a><span class="date">' + j['created_time'] +'</span>';--}}
{{--                        html += '        <span class="point">' + j['updownpoint'] +' points</span>  ';--}}
{{--                        html += '        <span class="idea-point"><i class="fa ideapoint ' + b +'  fa-lightbulb-o"></i>' + j['ideascore'] +'</span>';--}}
{{--                        html += '    </div>';--}}
{{--                        html += '    <div class="post-body">';--}}
{{--                        html += '        ' + j['post'] +'';--}}
{{--                        html += '    </div>';--}}
{{--                        html += '</li>';--}}
{{--                    })--}}

{{--                    if(html == ''){--}}
{{--                        html = '<h4 class="text-center">No forum threads found</h4><br>';--}}
{{--                    }--}}

{{--                    $(".objectiveComment .pagingnation-forum .item-count").html(count);--}}

{{--                    $(".objectiveComment .posts").html(html);--}}
{{--                }--}}
{{--            })--}}
{{--        }--}}
{{--        loadComments();--}}
{{--    </script>--}}
{{--@endsection--}}






















@extends('layout.master')
@section('title', 'Objective: ' . $objectiveObj->name)
@section('site-name')
    @if(isset($unitData))
        <h1>{{ $unitData->name }}</h1>
    @else
        <h1>Javul.org</h1>
    @endif
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection

@section('navbar')
    @if(isset($unitData))
        @include('layout.navbar', ['unitData' => $unitData])
    @endif
@endsection

@section('content')
    <div class="content_row">
        <div class="sidebar">
            @if(isset($unitData))
                @include('layout.v2.global-unit-overview')
                    <?php
                    $title = 'Activity Log';
                    ?>
                @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])

                @include('layout.v2.global-finances')

                @include('layout.v2.global-about-site')
            @else
                    <?php
                    $title = 'Global Activity Log';
                    ?>
                @include('layout.v2.global-activity-log',['title' => $title])
            @endif
        </div>

        <div class="main_content">
            <div class="content_block">
                <div class="row form-group">
                    <div class="col-md-12 order-md-2">

                        @include('objectives.v2.partials.objectives-information')

                        <div class="mt-2">
                            <div class="table_block table_block_tasks">
                                <div class="table_block_head">
                                    <div class="table_block_icon">
                                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                                    </div>
                                    Tasks
                                    <div class="arrow">
                                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="table_block_body">
                                    <table id="tasks-table-id">
                                        <thead>
                                        <tr>
                                            <th class="title_col">Task Name</th>
                                            <th class="type_col">Status</th>
                                            <th class="type_col"><i class="fa fa-trophy"></i></th>
                                            <th class="type_col"><i class="fa fa-clock"></i></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(count($objectiveObj->tasks) > 0)
                                            @foreach($objectiveObj->tasks as $obj)
                                                <tr>
                                                    <td>
                                                        <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">
                                                            {{$obj->name}}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($obj->status == "editable")
                                                            <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                                        @else
                                                            <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{\App\Models\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                                    <td class="text-center">{{\App\Models\Task::getTaskCount('completed',$obj->id)}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">No record(s) found.</td>
                                            </tr>
                                        @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="pagination-left">
                                </div>
                                <div class="pagination-right">
                                    <a href="{{ url('tasks/create') }}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                                </div>
                            </div>

                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">RELATION TO OTHER OBJECTIVES</h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">
                                                    Parent Objective
                                                </label>
                                                <label class="form-control label-value">
                                                    <?php $objSlug = \App\Models\Objective::getSlug($objectiveObj->parent_id); ?>
                                                    <a style="font-weight: normal;" class="no-decoration" href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->parent_id).'/'.$objSlug ) !!}">
                                                        {{\App\Models\Objective::getObjectiveName($objectiveObj->parent_id)}}
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">
                                                    Child Objective
                                                </label>
                                                <label class="form-control label-value">
                                                    -
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Comments
                                    <?php if(isset($addComments)){ ?>
                                    <a class="btn black-btn float-end" href="<?= $addComments ?>">Add Comment</a>
                                    <?php } ?>
                                </h4>
                            </div>
                            <div class="card-body list-group objectiveComment">
                                <div class="list-group-item">
                                    <div class="row">
                                        <ul class="posts"></ul>
                                        <div class="pagingnation-forum float-end">Showing last <span class="item-count"> 0 </span> comments.
                                            <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>
                                        </div>
                                        <div class="clearfix"></div>
                                        @if(auth()->check())
                                            <hr>
                                            <div class="form">
                                                <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                                    <div class="col-sm-12 form-group">
                                                        <h4 class="form-label">Comment</h4>
                                                        <textarea class="form-control" id="comment" name="desc"></textarea>
                                                    </div>
                                                    <input type="hidden" name="unit_id" id="comment_unit_id" value="<?=  $unit_id ?>">
                                                    <input type="hidden" name="section_id" id="comment_section_id" value="<?=  $section_id ?>">
                                                    <input type="hidden" name="object_id" id="comment_object_id" value="<?=  $object_id ?>">
                                                    <div class="row">
                                                        <div class="col-sm-12 mt-2 form-group">
                                                            <button class="btn btn-dark float-end">Submit Comment</button>
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
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(".objectiveComment #form_topic_form").submit(function(e)
            {
                var unitId = $('#comment_unit_id').val();
                var sectionId = $('#comment_section_id').val();
                var objectId = $('#comment_object_id').val();
                var desc = $('#comment').val();

                $.ajax({
                    type: "POST",
                    url: '{{ url("/forum/submitauto") }}',
                    data: {
                       unit_id : unitId,
                       section_id : sectionId,
                       object_id : objectId,
                       desc : desc,
                        _token: $('input[name="_token"]').val(),
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    },
                });
            })


            {{--function loadComments(){--}}
            {{--    $.ajax({--}}
            {{--        type:'post',--}}
            {{--        url:  '{{ url("/forum/loadObjectiveComment") }}' ,--}}
            {{--        data:$(".objectiveComment #form_topic_form").serialize(),--}}
            {{--        dataType:'json',--}}
            {{--        beforeSend:function(){--}}
            {{--            $(".objectiveLoader").show();--}}
            {{--        },--}}
            {{--        error:function(){--}}
            {{--            $(".objectiveLoader").hide();--}}
            {{--        },--}}
            {{--        complete:function(){--}}
            {{--            $(".objectiveLoader").hide();--}}
            {{--        },--}}
            {{--        success:function(json){--}}
            {{--            var html = '';--}}
            {{--            var count = 0;--}}
            {{--            $.each(json['comments']['items'],function(i,j){--}}
            {{--                var b = j['ideapoint'] == 1 ? 'active' : '';--}}
            {{--                count ++;--}}

            {{--                html += '<li class="post-div">';--}}
            {{--                html += '    <div class="heading"><a href="' + j['link'] +'">';--}}
            {{--                html += '        ' + j['first_name'] +  " " +   j['last_name'] ;--}}
            {{--                html += '        </a><span class="date">' + j['created_time'] +'</span>';--}}
            {{--                html += '        <span class="point">' + j['updownpoint'] +' points</span>  ';--}}
            {{--                html += '        <span class="idea-point"><i class="fa ideapoint ' + b +'  fa-lightbulb-o"></i>' + j['ideascore'] +'</span>';--}}
            {{--                html += '    </div>';--}}
            {{--                html += '    <div class="post-body">';--}}
            {{--                html += '        ' + j['post'] +'';--}}
            {{--                html += '    </div>';--}}
            {{--                html += '</li>';--}}
            {{--            })--}}

            {{--            if(html == ''){--}}
            {{--                html = '<h4 class="text-center">No forum threads found</h4><br>';--}}
            {{--            }--}}

            {{--            $(".objectiveComment .pagingnation-forum .item-count").html(count);--}}

            {{--            $(".objectiveComment .posts").html(html);--}}
            {{--        }--}}
            {{--    })--}}
            {{--}--}}
            {{--loadComments();--}}
        });



    </script>
@endsection
