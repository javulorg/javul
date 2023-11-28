@extends('layout.master')
@section('title', 'Activities')
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
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .ml-auto {
            margin-left: auto;
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
                @include('layout.v2.global-activity-log',['title' => $title])

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

                        <div class="d-flex justify-content-between ">
                            <div class="pagination-left">
                                {!! $wiki_page['wiki_page_title'] !!}
                            </div>

                        </div>



                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body d-flex justify-content-between mt-2">
                        <div class="clearfix"></div>
                        <div class="col-md-12 wiki-page-desc">{!! $wiki_page['page_content'] !!}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        <a href="{!! url('wiki/recent_changes') !!}/{!! $unit_id !!}/{!! $slug !!}/{!! $wiki_page['wiki_page_id'] !!}"><i class="fa fa-history"></i>  Recent Changes</a>
                    </div>
                    <div>
                        <a href="{!! url('wiki/all_pages') !!}/{!! $unit_id !!}/{!! $slug !!}"><i class="fa fa-list"></i>  List All Pages</a>
                    </div>
                    <div class="pagination-right">
                        <a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                    </div>

                    <div>
                        <a class="edit-link" href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}/{!! $wiki_page['wiki_page_id'] !!}"><i class="fa fa-edit"></i>Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
