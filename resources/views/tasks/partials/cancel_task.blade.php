@extends('layout.master')
@section('title', 'Task: ' . $taskObj->name)
@section('style')
    <style>
        .custom-orange-text {
            color: orange;
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
                <div class="table_block table_block_tasks active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                        </div>
                        TASK MANAGEMENT / Cancel Task : {{ $taskObj->name }}
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                                <p>
                                    {!! $taskObj->description !!}
                                </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Task Overview
                                        <div class="arrow">
                                            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                            </div>
                                            <div class="sidebar_block_right">

                                                <div class="progress">
                                                    <div class="progress-bar" style="width:75%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <label class="control-label" style="color: lightgreen;">{{\App\Models\SiteConfigs::task_status($taskObj->status)}}</label>
                                            </div>

                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Skills
                                            </div>
                                            <div class="sidebar_block_right">
                                                @if(!empty($skill_names) && count($skill_names) > 0)
                                                    {{$skill_names[0]}}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Award
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ {{ $taskObj->compensation }}
                                            </div>
                                        </div>


                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Completion
                                            </div>
                                            <div class="sidebar_block_right">
                                                {{ $taskObj->completionTime }}
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Available
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ {{ number_format($availableFunds,2) }}
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Awarded
                                            </div>
                                            <div class="sidebar_block_right">
                                                $ {{ number_format($availableFunds,2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="content_block mt-3">
                <div class="row">
                    <div class="col-sm-12" style="padding:20px 20px 10px 30px;">
                        <form role="form" method="post" action="{{ url('tasks/cancel_task/' . $taskIDHashID->encode($taskObj->id)) }}" >
                            @csrf
                            @method('post')
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">Comments</label>
                                        <textarea class="form-control" name="comment" id="comment"></textarea>
                                    </div>
                                </div>
                                <div class="row form-group mt-4">
                                    <div class="col-sm-12 ">
                                        <button type="submit" class="btn reject-btn m-2" style="background-color: #dc3545; color: white;">
                                             Cancel Task
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
    </script>
@endsection
