@extends('layout.master')
@section('title', 'Unit: ' . $unitObj->name)
@section('style')
    <style>
    </style>
@endsection

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
                @include('layout.v2.global-activity-log',['title' => $title])

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

                <div class="content_block">
                </div>
                <div class="col-md-12 order-md-2">
                            <div class="card panel-grey">
                                <div class="card-header">
                                    <h4 class="card-title">Create New Thread</h4>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <form role="form" method="post" id="form_topic_form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" name="title" value="" class="form-control" placeholder="Title" />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea class="form-control summernote" name="desc"></textarea>
                                                </div>
                                                <input type="hidden" name="unit_id" value="{!! $unit_id !!}">
                                                <input type="hidden" name="section_id" value="{!! $section_id !!}">
                                                <div class="mb-3">
                                                    <button class="btn btn-primary">Submit New Thread</button>
                                                </div>
                                            </form>
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
    <script type="text/javascript">
        $(document).ready(function (){
            var xhr;
            $("#form_topic_form").submit(function(){
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }
                $("#form_topic_form").find(".alert").remove();
                xhr = $.ajax({
                    type:'post',
                    url:'{!! url('forum/submit') !!}',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $("#form_topic_form button").button("loading");
                    },
                    error:function(){

                    },
                    success:function(json){
                        if(json['errors']){
                            $.each(json['errors'],function(i,j){
                                $("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");
                            })
                        }
                        if(json['success'])
                        {
                            toastr['success'](json['success'], '');
                            setTimeout(function(){ location = json['location'] },1000);
                        }
                        if(json['error']){
                            toastr['error'](json['error'], '');
                        }
                    }
                });
                return false;
            });



            window.onload = function()
            {
                function chatOnline()
                {
                    $.ajax({
                        type:'post',
                        url: '{{ url("/chat/online") }}',
                        data:{_token:'{{csrf_token()}}',unit_id:{!! $unitObj->id !!}},
                        dataType:'json',
                        complete: function(xhr, textStatus) {
                            setTimeout(function(){ chatOnline() }, 5000);
                        },
                        success:function(resp,text,xhr){
                            $("#chat-online").html(resp.online);
                        }
                    })
                }
                chatOnline();
            }

            $(".topic-list").delegate(".up-down-vote","click",function(){
                $this = $(this);
                var topic_id  = $this.parents("li:first").attr("data-id");
                var val  = $this.attr("data-value");
                $.ajax({
                    type:'post',
                    url:'{!! url('forum/topicUpDown') !!}',
                    data:{
                        _token : '{{csrf_token()}}',
                        val : val,
                        topic_id : topic_id,
                        didIt : $this.hasClass("active"),
                    },
                    dataType:'json',
                    beforeSend:function(){
                        if($this.hasClass("active")){
                            $this.parents(".up-down").find(".active").removeClass("active");
                        }
                        else
                        {
                            $this.parents(".up-down").find(".active").removeClass("active");
                            $this.addClass("active");
                        }
                    },
                    success:function(json){
                        if(json['success']){
                            $this.parents(".up-down").find(".count").html(json['count']);
                        }
                        if(json['error']){
                            toastr['error'](json['error'], '');
                        }
                    }
                });
            });

        })
    </script>
@endsection






















{{--@extends('layout.default')--}}
{{--@section('page-meta')--}}
{{--<title>Create New Thread - Javul.org</title>--}}
{{--@endsection--}}
{{--@section('page-css')--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row form-group" style="margin-bottom: 15px;">--}}
{{--        @include('elements.user-menu',['page'=>'units'])--}}
{{--    </div>--}}
{{--    <div class="row form-group">--}}
{{--        <div class="col-md-4">--}}
{{--            @include('units.partials.unit_information_left_table')--}}
{{--            <div class="left" style="position: relative;margin-top: 30px;">--}}
{{--                <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">--}}
{{--                    <span></span>--}}
{{--                    <span></span>--}}
{{--                    <span></span>--}}
{{--                </div>--}}
{{--                <div class="site_activity_list">--}}
{{--                    @include('elements.site_activities',['ajax'=>false])--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="panel panel-grey panel-default">--}}
{{--                <div class="panel-heading">--}}
{{--                	Create New Thread--}}
{{--                </h4></div>--}}
{{--                <div class="panel-body list-group">--}}
{{--                    <div class="list-group-item">--}}
{{--                        <form role="form" method="post" id="form_topic_form"  enctype="multipart/form-data">--}}
{{--                            {!! csrf_field() !!}--}}
{{--                            <div class="col-sm-12 form-group">--}}
{{--	                            <label class="control-label">Title</label>--}}
{{--	                            <div class="input-icon right">--}}
{{--	                                <i class="fa"></i>--}}
{{--	                                <input type="text" name="title" value="" class="form-control" placeholder="title"/>--}}
{{--	                            </div>--}}
{{--	                        </div>--}}
{{--	                        <div class="col-sm-12 form-group">--}}
{{--                                <label class="control-label">Content</label>--}}
{{--                                <textarea class="form-control summernote" name="desc"></textarea>--}}
{{--                            </div>--}}
{{--                            <input type="hidden" name="unit_id" value="{!! $unit_id !!}">--}}
{{--                            <input type="hidden" name="section_id" value="{!! $section_id !!}">--}}
{{--                            <div class="col-sm-12 form-group">--}}
{{--                            	<button class="btn black-btn pull-right">Submit New Thread</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@include('elements.footer')--}}
{{--@stop--}}
{{--@section('page-scripts')--}}
{{--<link href="{!! url('assets/plugins/bootstrap-summernote/summernote.css') !!}" rel="stylesheet" type="text/css" />--}}
{{--<script src="{!! url('assets/plugins/bootstrap-summernote/summernote.js') !!}" type="text/javascript"></script>--}}
{{--<script type="text/javascript">--}}
{{--	$('.summernote').ckeditor();--}}

{{--    CKEDITOR.on('instanceReady', function(){--}}
{{--        $.each( CKEDITOR.instances, function(instance) {--}}
{{--            CKEDITOR.instances[instance].on("change", function(e) {--}}
{{--                for ( instance in CKEDITOR.instances )--}}
{{--                    CKEDITOR.instances[instance].updateElement();--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}

{{--    var xhr;--}}
{{--    $("#form_topic_form").submit(function(){--}}
{{--    	if(xhr && xhr.readyState != 4){--}}
{{--            xhr.abort();--}}
{{--        }--}}
{{--        $("#form_topic_form").find(".alert").remove();--}}
{{--        xhr = $.ajax({--}}
{{--            type:'post',--}}
{{--            url:'{!! url('forum/submit') !!}',--}}
{{--            data:$(this).serialize(),--}}
{{--            dataType:'json',--}}
{{--            beforeSend:function(){--}}
{{--            	$("#form_topic_form button").button("loading");--}}
{{--            },--}}
{{--            error:function(){--}}
{{--                --}}
{{--            },--}}
{{--            complete:function(){--}}
{{--            	$("#form_topic_form button").button("reset");--}}
{{--            },--}}
{{--            success:function(json){--}}
{{--                if(json['errors']){--}}
{{--                	$.each(json['errors'],function(i,j){--}}
{{--                		$("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");--}}
{{--                	})--}}
{{--                }--}}
{{--                if(json['success']){--}}
{{--                	toastr['success'](json['success'], '');--}}
{{--                	setTimeout(function(){ location = json['location'] },1000);--}}
{{--                }--}}
{{--                if(json['error']){--}}
{{--                	toastr['error'](json['error'], '');--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--        return false;--}}
{{--    })--}}
{{--</script>--}}
{{--@endsection--}}
