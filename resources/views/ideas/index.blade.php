@extends('layout.master')
@section('title', 'Ideas')
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
            @if(isset($unitData))
                <div class="content_block">
                    <div class="table_block table_block_ideas">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
                            </div>
                            Ideas ({{ $ideasTotal }})
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Idea Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($unitIdea) > 0)
                                @foreach($unitIdea as $idea)
                                    <tr>
                                        <td class="title_col">
                                            <a href="{!! url('ideas/'.$ideaHashID->encode($idea->id)) !!}">
                                                {{ $idea->title }}
                                            </a>
                                        </td>
                                        @if($idea->status == 1)
                                            <td class="type_col"> Draft</td>
                                        @elseif($idea->status == 2)
                                            <td class="type_col">Assigned to Task</td>
                                        @else
                                            <td class="type_col">Implemented</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                        </div>
                    </div>
                </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>
                        <div class="pagination-right">
                            @if(isset($unitData))
                            <a href="{!! url('ideas/'.$unitIDHashID->encode($unitData->id).'/add') !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="content_block">
                    <div class="table_block table_block_ideas">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
                            </div>
                            Ideas ({{ $ideasMasterTotal }})
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="type_col">Idea Name</th>
                                    <th class="title_col">Unit Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($ideasMaster) > 0 )
                                    @foreach($ideasMaster as $idea)
                                        <tr>
                                            <td class="type_col">
                                                <a href="{!! url('ideas/'.$ideaHashID->encode($idea->id)) !!}">
                                                    {{$idea->title}}
                                                </a>
                                            </td>
                                            <td class="title_col">
                                                <a href="{!! url('units/'.$unitIDHashID->encode($idea->unit_id).'/'.\App\Models\Unit::getSlug($idea->unit_id)) !!}">
                                                    {{\App\Models\Unit::getUnitName($idea->unit_id)}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No record(s) found.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="mob_table d-sm-none d-block">
                            </div>
                        </div>
                    </div>
                    <div class="content_block_bottom">
                        <a href="{{ url('ideas') }}">See more</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')

@endsection
