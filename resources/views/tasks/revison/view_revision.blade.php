@extends('layout.master')
@section('title', 'Task: View Revision')
@section('style')

    <style>
        .panel {
            border-radius: 0px;
        }
        .panel-default {
            border-color: #ddd;
        }
        .panel-grey .panel-heading {
            background-color: #ebe9e9;
            color: #3F3F3F;
            text-transform: uppercase;

            font-weight: 500;
            border-bottom: 3px solid #5a5858;
        }
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

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-heading d-flex align-items-center">
                        <div class="table_block_icon current_task_heading featured_unit_heading">
                            <img src="{{ asset('v2/assets/img/list.svg') }}" style="margin-bottom:6px;" alt="" class="img-fluid">
                        </div>
                        <h4 class="card-title ml-3" style="font-size: medium;">View Revision: {!! $taskObj->name !!} </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Previous revision</h4>
                            <h5 class="text-center"><?= date("d-m-Y h:A",strtotime($revisions->created_at)) ?>, Edited By User {!! $revisions->first_name .' '. $revisions->last_name !!}</h5>
                            <hr>
                            <div class="wiki-page-desc">{!! $revisions->description !!}</div>
                            <hr>
                            <p><strong>Comment:</strong> {{ $revisions->comment }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
