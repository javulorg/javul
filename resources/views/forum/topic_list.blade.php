@extends('layout.master')
@section('title', 'Unit: ')
@section('style')
    <style>
    </style>
@endsection
@section('site-name')
    <h1>{{ $unitObj->name }}</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">

            @include('layout.v2.global-unit-overview')
            <?php
            $title = 'Activity Log';
            ?>
            @include('layout.v2.global-activity-log',['title' => $title])

            @include('layout.v2.global-finances')

            @include('layout.v2.global-about-site')
        </div>

{{--        <div class="col-md-8">--}}
{{--            <div class="panel panel-grey panel-default" style="margin-bottom: 30px;">--}}
{{--                <div class="panel-heading current_unit_heading featured_unit_heading">--}}

{{--                    <h4 style="width: 100%;line-height: 31px;"> Subforum: {!! $section_name !!}--}}
{{--                        <a class="pull-right black-btn" href="{!! url('forum/create').'/'.$unit_id.'/'.$section_name !!}"> Create New Topic </a>--}}
{{--                    </h4>--}}
{{--                </div>--}}
{{--                <div class="panel-body current_unit_body" style="padding-top:0px">--}}
{{--                    <br>--}}
{{--                    <ul class="topic-list">--}}
{{--                        <?php if(empty($topics)){ ?>--}}
{{--                        <h4 class="text-center">No forum topics found</h4>--}}
{{--                        <?php } ?>--}}
{{--                        <?php foreach ($topics as $key => $topic) { ?>--}}
{{--                        <li data-id="{!! $topic->topic_id !!}">--}}
{{--                            <div class="up-down">--}}
{{--                                <i data-value="1" class="glyphicon <?= $topic->updownstatus == 1 ? 'active' : ''  ?> up-down-vote glyphicon-arrow-up"></i>--}}
{{--                                <i class="count">{!! $topic->votecount !!}</i>--}}
{{--                                <i data-value="0" class="glyphicon <?= $topic->updownstatus == -1 ? 'active' : ''  ?> up-down-vote glyphicon-arrow-down"></i>--}}
{{--                            </div>--}}
{{--                            <h4 class="heading"><a href="{!! url('forum/post').'/'.$topic->topic_id.'/'.$topic->slug !!}"> <?= $topic->title ?> </a></h4>--}}
{{--                            <div class="silent">--}}
{{--                                <b>Submitted by</b>  <?= $topic->first_name ." ". $topic->last_name ?> <?= $topic->created_time ?> hour ago. <?= $topic->post   ?>--}}
{{--                                replies.--}}
{{--                                <?php if($topic->post) { ?>--}}
{{--                                (<b>last reply</b> by <a href="{!! $topic->link_reply !!}"> <?= $topic->lastReply ?>)--}}
{{--                                <?php } ?>--}}

{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <?php } ?>--}}
{{--                    </ul>--}}
{{--<!--                    --><?//= $pagination ?>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="main_content">
            @if(\Request::segment(3) == "objectives")
            <div class="d-flex justify-content-between mt-2">
                <div class="pagination-left">
                    <a class="btn btn-secondary btn-sm" href="{!! url('forum/create').'/'.$unit_id.'/'.$section_name !!}">Create New Topic</a>
                </div>
            </div>
            <div class="content_block mt-1">
                <div class="table_block table_block_objectives">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                        </div>
                        {{ __('messages.objectives') }}
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Thread title </th>
                                <th class="last_reply_col">Created By</th>
                                <th class="last_reply_col">replies</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($topics))
                                @foreach($topics as $key => $topic)
                                    <tr>
                                        <td class="title_col">
                                            <a href="{!! url('forum/post').'/'.$topic->topic_id.'/'.$topic->slug !!}"> {{ $topic->title }} </a>
                                        </td>

                                        <td class="last_reply_col">
                                            <a href=""> {{ $topic->first_name ." ". $topic->last_name }} </a>
                                        </td>

                                        <td class="last_reply_col">
                                            {{ $topic->post }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            @endif
                            </tbody>

                        </table>

                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                    </div>
                </div>
            </div>
            @else
            @endif
        </div>
    </div>
@endsection
