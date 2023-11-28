@extends('layout.app')

@section('title', 'Home')
@section('style')
@endsection
@section('site-name')
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">
            @if(isset($unitData))
                <?php
                $title = 'Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])
            @else
                <?php
                $title = 'Global Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title])
            @endif
        </div>
        <div class="main_content">

            @include('layout.v2.master.units')

            @include('layout.v2.master.issues')

            @include('layout.v2.master.ideas')

            @include('layout.v2.master.tasks')

            @include('layout.v2.master.objectives')
        </div>
    </div>
@endsection
