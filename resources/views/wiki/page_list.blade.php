@extends('layout.master')
@section('title', 'Wiki : All Pages')
@section('style')
    <style>
        .card-header .button-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            background-color: #564949;
            color: #fff;
            border-color: #D3D3D3;
        }

        .card-header .button-group .btn:hover {
            background-color: #a9a9a9;
            border-color: #a9a9a9;
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

        <div class="main_content">


            <div class="content_block">
                <div class="table_block table_block_wiki_pages">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <i class="fa fa-book"></i>
                        </div>
                        Listing All Wiki Pages
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Title</th>
                                <th class="last_reply_col">Last Edit</th>
                                <th class="last_reply_col">Recent Changes</th>
                                <th class="last_reply_col">#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($pages['pages'])){ ?>
                            <tr>
                                <td class="title_col"> <h6>No any Pages Created yet..  </h6> </td>
                            </tr>
                            <?php  } ?>
                            <?php foreach ($pages['pages'] as $key => $page) { ?>
                            <tr>
                                <td class="last_reply_col">
                                    <a href="{!! url('wiki').'/'.$unit_id.'/'. $page['wiki_page_id'] .'/'.$slug !!}"><?= $page['wiki_page_title'] ?></a>
                                </td>
                                <td><?= $page['time_stamp'] ?></td>
                                <td> <a href="{!! url('wiki/recent_changes') !!}/{!! $unit_id !!}/{!! $slug !!}/{!! $page['wiki_page_id'] !!}"><i class="fa fa-history"></i> </a></td>
                                <td class="last_reply_col"><a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}/{!! $page['wiki_page_id'] !!}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            <?php } ?>
                            </tbody>

                        </table>

                    </div>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                    </div>
                    <div class="pagination-right">
                        <a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
