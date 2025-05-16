@extends('layout.master')
@section('title', 'My Tasks')

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
        @auth()
        @if(in_array(auth()->user()->role, [0,2,3,4]))
        <div class="content_block">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    Assigned Tasks ({{ isset($assignedTasks) ? count($assignedTasks) : 0 }})
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                                <th class="type_col"></th>
                            </tr>
                        </thead>

                        <tbody>

                            @if(count($assignedTasks) > 0)
                            @foreach($assignedTasks as $assignedTask)
                            {{-- @dd($assignedTask->id) --}}
                            @if(\App\Models\SiteConfigs::task_status($assignedTask->status) == 'Assigned')
                            <tr>
                                <td class="title_col">

                                    <a href="{!! url('tasks/'.$taskIDHashID->encode($assignedTask->id).'/'.$assignedTask->slug) !!}"
                                        title="edit">
                                        {{$assignedTask->name}}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span class="colorLightGreen">
                                        {{\App\Models\SiteConfigs::task_status($assignedTask->status)}}
                                    </span>
                                </td>

                                <td class="type_col">
                                    <a href="{{ url('notifications',$assignedTask->id) }}" class="btn btn-sm m-2"
                                        style="background-color: #198754; color: white;" title="Accept Task">
                                        <i class="bi bi-check2"></i>
                                    </a>
                                    <a href="{!! url('tasks/cancel_task/'.$taskIDHashID->encode($assignedTask->id)) !!}"
                                        class="btn btn-sm m-2" style="background-color: #dc3545; color: white;"
                                        title="Cancel Task">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
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

        <div class="content_block">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    In Progress Tasks ({{ isset($inProgressTasks) ? count($inProgressTasks) : 0 }})
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($inProgressTasks as $inProgressTask)
                            <tr>
                                <td class="title_col">
                                    <a href="{{ url('tasks/' . $taskIDHashID->encode($inProgressTask->id) . '/' . $inProgressTask->slug) }}"
                                        title="edit">
                                        {{ $inProgressTask->name }}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span class="colorLightGreen">{{
                                        \App\Models\SiteConfigs::task_status($inProgressTask->status) }}</span>
                                </td>
                                <td class="type_col">
                                    <form method="POST"
                                        action="{{ url('tasks/complete_task/' . $taskIDHashID->encode($inProgressTask->id)) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm m-2"
                                            style="background-color: #198754; color: white;" title="Complete Task">
                                            <i class="bi bi-check2"></i>
                                        </button>

                                        <a href="{!! url('tasks/cancel_task/'.$taskIDHashID->encode($assignedTask->id)) !!}"
                                            class="btn btn-sm m-2" style="background-color: #dc3545; color: white;"
                                            title="Cancel Task">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <div class="pagination-left">
                </div>
            </div>
        </div>

        <div class="content_block">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    Completed Tasks ({{ isset($completedTasks) ? count($completedTasks) : 0 }})
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if(count($underTask) > 0)
                            {{-- @dd($underTask) --}}

                            @foreach($underTask as $completedTask)

                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('tasks/'.$taskIDHashID->encode($completedTask->id).'/'.$completedTask->slug) !!}"
                                        title="edit">
                                        {{$completedTask->name}}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span
                                        class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($completedTask->status)}}</span>
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

        <div class="content_block">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    Bids Tasks ({{ isset($myBids) ? count($myBids) : 0 }})
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($myBids) > 0)
                            @foreach($myBids as $myBid)
                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('tasks/'.$taskIDHashID->encode($myBid->task_id).'/'.$myBid->slug) !!}"
                                        title="edit">
                                        {{$myBid->name}}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span
                                        class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($myBid->task_status)}}</span>
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
        <div class="content_block">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    Task Evaluation ({{ isset($myEvaluationTask) ? count($myEvaluationTask) : 0 }})
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Task Name</th>
                                <th class="type_col">Completed By</th>
                                <th class="type_col">Status</th>
                                <th class="type_col"></th>
                            </tr>
                        </thead>

                        <tbody>

                            @if(count($myEvaluationTask) > 0)

                            @foreach($myEvaluationTask as $valuationTask)
                            {{-- @dd($valuationTask) --}}
                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('tasks/'.$taskIDHashID->encode($valuationTask->task_id).'/'.$valuationTask->slug) !!}"
                                        title="edit">
                                        {{-- {{$valuationTask->name}} --}}
                                       {{ $valuationTask->{"max(tasks.name)"} }}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <a href="{!! url('userprofiles/'.$userIDHashID->encode($valuationTask->user_id).'/'.strtolower
                                ($valuationTask->first_name.'_'.$valuationTask->last_name)) !!}" title="edit">
                                        {{$valuationTask->first_name.' '.$valuationTask->last_name}}
                                    </a>
                                </td>
                                {{-- <td class="type_col">
                                    <span
                                        class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($valuationTask->task_status)}}</span>
                                </td> --}}

                                <td class="type_col">
                                    <a href="{!! url('tasks/complete_task/'.$taskIDHashID->encode($valuationTask->task_id)) !!}"
                                        class="btn btn-xs btn-success mark-complete">
                                        Mark as Complete
                                    </a>
                                    <a href="{!! url('tasks/complete_task/'.$taskIDHashID->encode($valuationTask->task_id)) !!}"
                                        class="btn btn-xs btn-danger re-assigned">
                                        Re Assign
                                    </a>
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
        @endif
        @endauth
    </div>
</div>
@endsection

@section('scripts')
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.accept-task-btn');

        buttons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // prevent default click navigation

                const taskId = this.getAttribute('data-id');
                const row = document.getElementById('task-row-' + taskId);
                const url = this.getAttribute('href');

                // Navigate to the form route in a new hidden tab
                window.open(url, '_blank'); // or _self if you don't want new tab

                // Remove the row immediately from the table
                if (row) {
                    row.remove();
                }
            });
        });
    });
</script> --}}


@endsection
