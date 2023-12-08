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
                <div class="table_block table_block_objectives active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                        </div>
                        {{ $objectiveObj->name}}
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                               <p>
                                   {!! $objectiveObj->description !!}
                               </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Objective Overview
                                        <div class="arrow">
                                            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Priority:
                                            </div>
                                            <div class="sidebar_block_right">
                                                Medium
                                                <div class="progress">
                                                    <div class="progress-bar" style="width:75%"></div>
                                                </div> <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                {{ \App\Models\Objective::objectiveStatus()[$objectiveObj->status] }}
                                            </div>
                                        </div>
                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Funds:
                                            </div>
                                            <div class="sidebar_block_right">
                                                Received $2500<br>
                                                Awarded ${{number_format($awardedObjFunds,2)}}<br>
                                                Available ${{number_format($availableObjFunds,2)}}<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/eye.svg') }}" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="{!! route('objectives_revison',[$objectiveIDHashID->encode($objectiveObj->id)]) !!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""> Revision History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_tasks">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                        </div>
                        Tasks (35)
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
                                <th class="status_col">
                                    Status
                                </th>
                                <th class="replies_col">
                                    Replies
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Some misc Task Title
                                </td>
                                <td class="status_col">
                                    10 minutes ago
                                </td>
                                <td class="replies_col">
                                    $60
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Information tech
                                </td>
                                <td class="title_col">
                                    Research payment gateway methods for implementing in the app
                                </td>
                                <td class="status_col">
                                    Open for Bidding
                                </td>
                                <td class="replies_col">
                                    50 points
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Require feedback if a 1-star rating is given
                                </td>
                                <td class="status_col">

                                </td>
                                <td class="replies_col">

                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Software
                                </td>
                                <td class="title_col">
                                    Debug GPS reporting issues (Goal)
                                </td>
                                <td class="status_col">

                                </td>
                                <td class="replies_col">

                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Information tech
                                </td>
                                <td class="title_col">
                                    Research payment gateway methods for implementing in the app
                                </td>
                                <td class="status_col">
                                    Open for Bidding
                                </td>
                                <td class="replies_col">
                                    50 points
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        $60
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        50 points
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        $60
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_ideas">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/humbleicons_bulb.svg" alt="" class="img-fluid">
                        </div>
                        Related ideas
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
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
                                    Misc
                                </td>
                                <td class="title_col">
                                    Create a Customer/Driver complaint review process
                                </td>
                                <td class="priority_col">
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
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Add a feature to book ride in advance
                                </td>
                                <td class="priority_col">
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Ability to add multiple stops with extra costs
                                </td>
                                <td class="priority_col">
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:65%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        12
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        78
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:95%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        6 months ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        14
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        156
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_issues">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/bug.svg" alt="" class="img-fluid">
                        </div>
                        Related Issues
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
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
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Being rated without any feedback / 1* ratings should require feedback
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:95%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
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
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Being rated without any feedback / 1* ratings should require feedback
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:95%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:65%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        12
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        78
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:95%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        6 months ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        14
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        156
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_objective">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/User_Rounded.svg" alt="" class="img-fluid">
                        </div>
                        Parent Objectives
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_txt">
                        <b>Task Name</b>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_objective">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/Users_Two_Rounded.svg" alt="" class="img-fluid">
                        </div>
                        Child Objectives
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_txt">
                        <b>Task Name</b>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block_comments">
                <div class="table_block table_block_comments">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/Dialog.svg" alt="" class="img-fluid">
                        </div>
                        Comments
                    </div>
                    <div class="comments_content">
                        <div class="comment_stat">
                            <b>2 review</b> <a href="#">Write a review</a>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <div class="comment_info">
                                    <div class="comment_autor">
                                        John
                                    </div>
                                    <div class="comment_time">
                                        just now
                                    </div>
                                </div>
                                <div class="comment_txt">
                                    Vestibulum sagittis tincidunt est, sit amet vulputate orci fringilla in. Duis iaculis nibh eget arcu volutpat, eget volutpat lorem sollicitudin. Pellentesque finibus id orci nec feugiat. Maecenas laoreet elit vitae magna pellentesque vulputate. Donec dictum hendrerit ex, non dignissim lectus fringilla ac. Aenean sit amet pellentesque lacus. Nam et rhoncus ex.
                                </div>
                            </div>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <div class="comment_info">
                                    <div class="comment_autor">
                                        Michael Fletcher
                                    </div>
                                    <div class="comment_time">
                                        on 08/09/2023 12:20:30
                                    </div>
                                </div>
                                <div class="comment_txt">
                                    Duis iaculis nibh eget arcu volutpat, eget volutpat lorem sollicitudin. Pellentesque finibus id orci nec feugiat. Maecenas laoreet elit vitae magna pellentesque vulputate. Donec dictum hendrerit ex, non dignissim lectus fringilla ac. Aenean sit amet pellentesque lacus. Nam et rhoncus ex.
                                </div>
                            </div>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <textarea cols="30" rows="10" placeholder="White a message..."></textarea>
                                <button type="button" class="btn">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
        </div>


{{--        <div class="main_content">--}}
{{--            <div class="content_block">--}}
{{--                <div class="row form-group">--}}
{{--                    <div class="col-md-12 order-md-2">--}}

{{--                        @include('objectives.v2.partials.objectives-information')--}}

{{--                        <div class="mt-2">--}}
{{--                            <div class="table_block table_block_tasks">--}}
{{--                                <div class="table_block_head">--}}
{{--                                    <div class="table_block_icon">--}}
{{--                                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">--}}
{{--                                    </div>--}}
{{--                                    Tasks--}}
{{--                                    <div class="arrow">--}}
{{--                                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="table_block_body">--}}
{{--                                    <table id="tasks-table-id">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th class="title_col">Task Name</th>--}}
{{--                                            <th class="type_col">Status</th>--}}
{{--                                            <th class="type_col"><i class="fa fa-trophy"></i></th>--}}
{{--                                            <th class="type_col"><i class="fa fa-clock"></i></th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}

{{--                                        <tbody>--}}
{{--                                        @if(count($objectiveObj->tasks) > 0)--}}
{{--                                            @foreach($objectiveObj->tasks as $obj)--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">--}}
{{--                                                            {{$obj->name}}--}}
{{--                                                        </a>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-center">--}}
{{--                                                        @if($obj->status == "editable")--}}
{{--                                                            <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>--}}
{{--                                                        @else--}}
{{--                                                            <span class="text-success">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-center">{{\App\Models\Task::getTaskCount('in-progress',$obj->id)}}</td>--}}
{{--                                                    <td class="text-center">{{\App\Models\Task::getTaskCount('completed',$obj->id)}}</td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                        @else--}}
{{--                                            <tr>--}}
{{--                                                <td colspan="4">No record(s) found.</td>--}}
{{--                                            </tr>--}}
{{--                                        @endif--}}
{{--                                        </tbody>--}}

{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between mt-2">--}}
{{--                                <div class="pagination-left">--}}
{{--                                </div>--}}
{{--                                <div class="pagination-right">--}}
{{--                                    <a href="{{ url('tasks/create') }}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="card mb-3">--}}
{{--                            <div class="card-header">--}}
{{--                                <h4 class="card-title">RELATION TO OTHER OBJECTIVES</h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="list-group">--}}
{{--                                    <div class="list-group-item">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label class="form-label">--}}
{{--                                                    Parent Objective--}}
{{--                                                </label>--}}
{{--                                                <label class="form-control label-value">--}}
{{--                                                    <?php $objSlug = \App\Models\Objective::getSlug($objectiveObj->parent_id); ?>--}}
{{--                                                    <a style="font-weight: normal;" class="no-decoration" href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->parent_id).'/'.$objSlug ) !!}">--}}
{{--                                                        {{\App\Models\Objective::getObjectiveName($objectiveObj->parent_id)}}--}}
{{--                                                    </a>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label class="form-label">--}}
{{--                                                    Child Objective--}}
{{--                                                </label>--}}
{{--                                                <label class="form-control label-value">--}}
{{--                                                    ---}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="card mb-3">--}}
{{--                            <div class="card-header">--}}
{{--                                <h4 class="card-title">Comments--}}
{{--                                    <?php if(isset($addComments)){ ?>--}}
{{--                                    <a class="btn black-btn float-end" href="<?= $addComments ?>">Add Comment</a>--}}
{{--                                    <?php } ?>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body list-group objectiveComment">--}}
{{--                                <div class="list-group-item">--}}
{{--                                    <div class="row">--}}
{{--                                        <ul class="posts"></ul>--}}
{{--                                        <div class="pagingnation-forum float-end">Showing last <span class="item-count"> 0 </span> comments.--}}
{{--                                            <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>--}}
{{--                                        </div>--}}
{{--                                        <div class="clearfix"></div>--}}
{{--                                        @if(auth()->check())--}}
{{--                                            <hr>--}}
{{--                                            <div class="form">--}}
{{--                                                <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">--}}
{{--                                                    @csrf--}}
{{--                                                    <div class="col-sm-12 form-group">--}}
{{--                                                        <h4 class="form-label">Comment</h4>--}}
{{--                                                        <textarea class="form-control" id="comment" name="desc"></textarea>--}}
{{--                                                    </div>--}}
{{--                                                    <input type="hidden" name="unit_id" value="<?=  $unit_id ?>">--}}
{{--                                                    <input type="hidden" name="section_id" value="<?=  $section_id ?>">--}}
{{--                                                    <input type="hidden" name="object_id" value="<?=  $object_id ?>">--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-sm-12 mt-2 form-group">--}}
{{--                                                            <button class="btn btn-dark float-end">Submit Comment</button>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@section('scripts')
    <script>
        ClassicEditor
            .create( document.querySelector('#comment') )
            .catch( error => {
                console.error(error);
            } );
    </script>
@endsection
