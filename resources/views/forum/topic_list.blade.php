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
