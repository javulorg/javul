@extends('layout.master')
@section('title', 'Tasks')

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
                <div class="table_block table_block_tasks">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                        </div>
                        Tasks ({{ $tasksTotal }})
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
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                                <th class="type_col"><i class="fa fa-trophy"></i></th>
                                <th class="type_col"><i class="fa fa-clock"></i></th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($unitTasks) > 0)
                                @foreach($unitTasks as $obj)
                                    <tr>
                                        <td class="title_col">
                                            <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                                               title="edit">
                                                {{$obj->name}}
                                            </a>
                                        </td>
                                        <td class="type_col">
                                            @if($obj->status == "draft")
                                                <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                            @else
                                                <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                            @endif
                                        </td>
                                        <td class="type_col">{{\App\Models\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                        <td class="type_col">{{\App\Models\Task::getTaskCount('completed',$obj->id)}}</td>
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
                        <a href="{!! url('tasks/add?unit='.$unitIDHashID->encode($unitData->id)) !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                    </div>
                </div>

            </div>
            @else
                <div class="content_block">
                    <div class="table_block table_block_tasks">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                            </div>
                            Tasks ({{ $tasksTotal }})
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
                                    <th class="type_col">Task Name</th>
                                    <th class="title_col">Unit Name</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($tasksMasterData) > 0 )
                                    @foreach($tasksMasterData as $task)
                                        <tr>
                                            <td class="type_col">
                                                <a href="{!! url('tasks/'.$taskIDHashID->encode($task->id) . '/' . $task->slug) !!}">
                                                    {{$task->name}}
                                                </a>
                                            </td>
                                            <td class="title_col">
                                                <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/'.\App\Models\Unit::getSlug($task->unit_id)) !!}">
                                                    {{\App\Models\Unit::getUnitName($task->unit_id)}}
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
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
@endsection
