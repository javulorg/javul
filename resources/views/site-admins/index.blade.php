@extends('layout.app')

@section('title', 'Site Admin')
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
                    <?php
                    $title = 'Global Activity Log';
                    ?>
                @include('layout.v2.global-activity-log',['title' => $title])
        </div>
        <div class="main_content">
            @include('site-admins.users.index')
        </div>
    </div>
@endsection
