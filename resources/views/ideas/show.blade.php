@extends('layout.master')
@section('title', 'Idea: ' . $idea->title)
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
{{--                <div class="row form-group">--}}
{{--                    <div class="col-md-12 order-md-2">--}}
{{--                        @include('ideas.partials.idea-information')--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="table_block table_block_ideas active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
                        </div>
                        {{ $idea->title}}
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>

                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    {!! $idea->description !!}
                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Idea Overview
                                        <div class="arrow">
                                            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                @if($idea->status == 1)
                                                    Draft
                                                @elseif($idea->status == 2)
                                                    Assigned to Task
                                                @else
                                                    Implemented
                                                @endif
                                                <div class="progress">

                                                </div> <a href="{!! url('ideas/'. $ideaHashId .'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="{!! url('ideas/'. $ideaHashId .'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/eye.svg') }}" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="{!! url('ideas/'. $ideaHashId .'/history')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""> Revision History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                            </div>
                            Related Task
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">
                                        Title
                                    </th>
                                    <th class="status_col">
                                        Status
                                    </th>
                                    <th class="type_col"><i class="fa fa-trophy"></i></th>
                                    <th class="type_col"><i class="fa fa-clock"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="type_col">
                                        @if(isset($idea->task))
                                            <a href="{!! url('tasks/'.$taskIDHashID->encode($idea->task->id).'/'.$idea->task->name) !!}"
                                               title="edit">
                                                {{ $idea->task->name}}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="title_col">
                                        @if(isset($idea->task))
                                            @if($idea->task->status == "editable")
                                                <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($idea->task->status)}}</span>
                                            @else
                                                <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($idea->task->status)}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="status_col">
                                        @if(isset($idea->task))
                                             {{\App\Models\Task::getTaskCount('in-progress',$idea->task->id)}}
                                        @endif
                                    </td>
                                    <td class="replies_col">
                                        @if(isset($idea->task))
                                            {{\App\Models\Task::getTaskCount('completed',$idea->task->id)}}
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="content_block_bottom">
                    </div>
                </div>

                <div class="content_block mt-3">
                    <div class="table_block table_block_issues">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
                            </div>
                            Related Issues
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="type_col">
                                        Type
                                    </th>
                                    <th class="title_col">
                                        Title
                                    </th>
                                    <th class="priority_col">
                                        Priority
                                    </th>
                                    <th class="last_reply_col">
                                        Last Reply
                                    </th>
                                    <th class="replies_col">
                                        Replies
                                    </th>
                                    <th class="views_col">
                                        Views
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="type_col">
                                        Driver
                                    </td>
                                    <td class="title_col">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </td>
                                    <td class="priority_col">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </td>
                                    <td class="last_reply_col">
                                        10 minutes ago
                                    </td>
                                    <td class="replies_col">
                                        34
                                    </td>
                                    <td class="views_col">
                                        205
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
