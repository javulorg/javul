@extends('layout.master')
@section('title', 'Objectives')

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
                <div class="table_block table_block_objectives">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                        </div>
                        Objectives
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        @if(isset($unitData))
                            <input type="hidden" name="unit" value="{{ $unitData->id }}" id="unit_id">
                        @else
                            <input type="hidden" name="unit" value="{{ null }}" id="unit_id">
                        @endif
                        <table id="unit-objectives-table-id">
                            <thead>
                            <tr>
                                <th class="title_col">Objective Name</th>
                                <th class="type_col">Support</th>
                                <th class="type_col">In progress</th>
                                <th class="type_col">Available</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($unitObjectives) > 0)
                                @foreach($unitObjectives as $obj)
                                    <tr>
                                        <td>
                                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">
                                                {{$obj->name}}
                                            </a>
                                        </td>
                                        <td  class="text-center">{{\App\Models\Task::getTaskCount('available',$obj->id)}}</td>
                                        <td  class="text-center">{{\App\Models\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                        <td  class="text-center">{{\App\Models\Task::getTaskCount('completed',$obj->id)}}</td>
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
                        <a href="{!! url('objectives/'.$unitIDHashID->encode($unitData->id).'/add') !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                    </div>
                </div>
            </div>
            @else
                <div class="content_block">
                    <div class="table_block table_block_objectives">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                            </div>
                            Objectives ({{ $objectivesTotal }})
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            @if(isset($unitData))
                                <input type="hidden" name="unit" value="{{ $unitData->id }}" id="unit_id">
                            @else
                                <input type="hidden" name="unit" value="{{ null }}" id="unit_id">
                            @endif
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Objective Name</th>
                                    <th class="last_reply_col">Unit Name</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($objectivesMasterData) > 0 )
                                    @foreach($objectivesMasterData as $objective)
                                        <tr>
                                            <td class="title_col">
                                                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/'.$objective->slug)!!}">
                                                    {{ $objective->name }}
                                                </a>
                                            </td>
                                            <td class="last_reply_col">
                                                <a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id).'/'. \App\Models\Unit::getSlug($objective->unit_id) )!!}">
                                                    {{ $objective->unit->name }}
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
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>
{{--                        <div class="pagination-right">--}}
{{--                            <a href="{{ url('objectives/create') }}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')

@endsection
