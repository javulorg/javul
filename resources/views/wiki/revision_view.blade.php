@extends('layout.master')
@section('title', 'Wiki: View Revision')
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
                        <div class="table_block_icon featured_unit current_task">
                            <i class="fa fa-book"></i>
                        </div>
                        <h4 class="card-title m-0" style="color: #0d1217;">{{ $wiki_page['wiki_page_title'] }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Previous revision</h4>
                            <h5 class="text-center">{{ date("d-m-Y h:A", strtotime($wiki_page['time_stamp'])) }}, Edited By User {{ $wiki_page['username'] }}</h5>
                            <hr>
                            <div class="wiki-page-desc">{!! $wiki_page['page_content'] !!}</div>
                            <hr>
                            <p><strong>Comment:</strong> {{ $wiki_page['edit_comment'] }}</p>

                            <div class="text-center"> <a class="btn btn-secondary black_btn" href="{!! url('wiki/edit_revision') !!}/{!! $unit_id !!}/{!! $slug !!}/{!! $wiki_page['revision_id'] !!}"> Edit This Revision </a> </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        <a href="{!! url('wiki/all_pages') !!}/{!! $unit_id !!}/{!! $slug !!}"><i class="fa fa-list"></i>  List All Pages</a>
                    </div>
                    <div class="pagination-right">
                        <a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                    </div>

                </div>
            </div>
        </div>

    </div>


@endsection
