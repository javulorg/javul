@extends('layout.master')
@section('title', 'Unit Adminstration ')
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
                <h1>Unit Adminstration</h1>

                <div class="content_block mt-3 mb-4">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                            </div>
                            Categories
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Name</th>
                                    <th class="type_col">Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="title_col">
                                                <a href="{!! url('admin/categories/'. $category->id . '/' .$unitIDHashID->encode($category->unit_id))  !!}"
                                                   title="edit">
                                                    {{$category->title}}
                                                </a>
                                            </td>
                                            <td class="type_col">
                                                @if($category->status == 1)
                                                    <span class="colorLightGreen">Active</span>
                                                @else
                                                    <span class="colorLightGreen">Inactive</span>
                                                @endif
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
                        <div class="pagination-right">
                            <a href="{!! url('admin/categories/create/'.$unitIDHashID->encode($unitObj->id)) !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
