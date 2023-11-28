@extends('layout.master')
@section('title', 'Activities')
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
                <div class="table_block table_block_issues">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <i class="fa fa-list"></i>
                        </div>
                        Activities
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Action</th>
                                <th class="last_reply_col">Time</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if($total > 0 )

                                @foreach($activities as $activity)
                                    <tr>
                                        <td class="title_col">
                                            {!! $activity->comment !!}
                                        </td>
                                        <td class="last_reply_col">
                                            {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">No record(s) found.</td>
                                </tr>
                            @endif
                            </tbody>

                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                            {!! $activities->links('layout.pagination') !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
