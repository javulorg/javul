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
            </div>
            @include('forum.forum-partials.objectives')

            @include('forum.forum-partials.tasks')

            @include('forum.forum-partials.issues')

            @include('forum.forum-partials.other-discussions')
        </div>

    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
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
    </script>
@endsection
