@extends('layout.master')
@section('title', 'Unit: ' . $unitObj->name)
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
    @include('layout.navbar', ['unitData' => $unitObj])
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">

            @include('layout.v2.global-unit-overview')
            <?php
            $title = 'Activity Log';
            ?>
            @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitObj->id])

            @include('layout.v2.global-finances', ['availableFunds' => $availableFunds, 'awardedFunds' => $awardedFunds])

            @include('layout.v2.global-about-site')
        </div>

        <div class="main_content">
            <div class="content_block">


            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
