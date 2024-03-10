@extends('layout.master')
@section('title', $taskObj->name)
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
{{--    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css" rel="stylesheet">--}}


    <style>
        .custom-orange-text {
            color: orange;
        }

        .badge-success {
            color: #fff;
            background-color: #198754;
        }
        .badge-primary {
            color: #fff;
            background-color: #0d6efd;
        }
        .badge-info {
            color: #212529;
            background-color: #0dcaf0;
        }
        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }
        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }
        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
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
                        {{ $taskObj->name }}
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
                                        Task Information
                                        <div class="arrow">
                                            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total Tasks :
                                            </div>
                                            <div class="sidebar_block_right">
                                                {{$totalTasks}}
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total funds available :
                                            </div>
                                            <div class="sidebar_block_right">
                                                XXX $
                                            </div>
                                        </div>

                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Total funds rewarded :
                                            </div>
                                            <div class="sidebar_block_right">
                                                XXXX $
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="content_block">
                    <div class="row">
                        @php
                            $active = $errors->has('amount') || $errors->has('comment') ? 'bid_now' : 'task_details';
                        @endphp

                        <div class="col-12">
                            <div class="container mt-3">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $active == 'task_details' ? 'active' : '' }}" data-toggle="tab" href="#task_details">
                                            Task Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#task_actions">
                                            Task Actions
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $active == 'bid_now' ? 'active' : '' }}" data-toggle="tab" href="#bid_now">
                                            {{ !empty($taskBidder) ? 'Bid Details' : 'Bid Now' }}
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="task_details" class="container tab-pane fade {{ $active == 'task_details' ? 'show active' : '' }}"><br>
                                        <div class="list-group-item">
                                            <h4 class="text-orange">{!! strtoupper(trans('messages.task_status')) !!}</h4>
                                            @if(empty($taskObj->assigned_to))
                                                <div>Unassigned</div>
                                            @elseif($taskObj->status == "completed")
                                                <div>Completed</div>
                                                <div>Completed On: date 23/05/2016</div>
                                            @else
                                                <div>assigned to user X</div>
                                            @endif
                                        </div>
                                        <div class="list-group-item">
                                            <h4 class="text-orange">{!! strtoupper(trans('messages.task_award')) !!}</h4>
                                            <div>xx $</div>
                                        </div>
                                        <div class="list-group-item">
                                            <h4 class="text-orange">{!! strtoupper(trans('messages.task_summary')) !!}</h4>
                                            <div>{!! $taskObj->summary !!}</div>
                                        </div>
                                        <div class="list-group-item">
                                            <h4 class="text-orange">{!! strtoupper(trans('messages.long_description')) !!}</h4>
                                            <div>{!! $taskObj->description !!}</div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="text-orange">Task Documents</h4>
                                                    @if(!empty($taskObj->task_documents))
                                                        @foreach($taskObj->task_documents as $document)
                                                                <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                                            @if($extension == "pdf") <?php $extension="pdf"; ?>
                                                            @elseif($extension == "doc" || $extension == "docx") <?php $extension="docx"; ?>
                                                            @elseif($extension == "jpg" || $extension == "jpeg") <?php $extension="jpeg"; ?>
                                                            @elseif($extension == "ppt" || $extension == "pptx") <?php $extension="pptx"; ?>
                                                            @else <?php $extension="file"; ?> @endif
                                                            <div class="file_documents">
                                                                <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">
                                                                    <img src="{!! url('assets/images/file_types/'.$extension.'.png') !!}" style="height:50px;">
                                                                    <span style="display:block">
                                        @if(empty($document->file_name))
                                                                            &nbsp;
                                                                        @else
                                                                            {{$document->file_name}}
                                                                        @endif
                                    </span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="task_actions" class="container tab-pane"><br>
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="text-orange">TASK ACTIONS</h4>
                                                    <div>{!! $taskObj->task_action !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="bid_now" class="container tab-pane fade {{ $active == 'bid_now' ? 'show active' : '' }}"><br>
                                        <div class="list-group-item">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-12">
{{--                                                            <label class="control-label" style="margin-bottom:0px">Task Completion Ratings: Quality of works :--}}
{{--                                                                <span class="stars" style="display:inline-block">{{$quality_of_work}}</span>({{$quality_of_work}}/5)--}}
{{--                                                                Timeliness :--}}
{{--                                                                <span class="stars" style="display:inline-block">{{$timeliness}}</span>--}}
{{--                                                                ({{$timeliness}}/5)--}}
{{--                                                            </label>--}}
                                                            <label>Task Completion Ratings:</label>
                                                            <div>
                                                                <label>Quality of works :</label>
                                                                <input id="input-1-ltr-star-xs" name="input-1-ltr-star-xs" class="stelle rating-loading" value="{{ $quality_of_work }}" dir="ltr" data-size="xs">
                                                            </div>
                                                            <div>
                                                                <label>Timeliness :</label>
                                                                <input id="input-1-ltr-star-xs" name="input-1-ltr-star-xs" class="stelle rating-loading" value="{{ $timeliness }}" dir="ltr" data-size="xs">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-xs-6 col-sm-4  {{ $errors->has('amount') ? ' has-error' : '' }}">
                                                    <div class="input-icon right">
                                                        <label for="amount" class="control-label">Amount</label>
                                                        <input name="amount" type="text" required id="amount" class="form-control"
                                                               @if(!empty($taskBidder)) value="{{$taskBidder->amount}}" @else value="{{ old('amount')}}" @endif
                                                               @if(!empty($taskBidder)) disabled @endif/>
                                                        @if ($errors->has('amount'))
                                                            <span class="help-block">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-3 mt-2">
                                                    <div class="input-icon right">
                                                        <label for="amount" class="control-label">&nbsp;</label>
                                                        <input id="amount-toggle" @if(!empty($taskBidder) && $taskBidder->charge_type == "amount") checked
                                                               disabled
                                                               @endif
                                                               data-on="Amount" data-off="Points"
                                                               data-toggle="toggle" data-width="100" data-height="40" data-onstyle="primary"
                                                               type="checkbox" name="charge_type">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group mt-2">
                                                <div class="col-sm-12 {{ $errors->has('comment') ? ' has-error' : '' }}">
                                                    <div class="input-icon right">
                                                        <label for="amount" class="control-label">Comment</label>
                                                        @if(!empty($taskBidder))
                                                            <span class="bid_comment">{!! $taskBidder->comment !!}</span>
                                                        @else
                                                            <textarea class="form-control" id="comment" name="comment">{{old('comment')}}</textarea>
                                                            @if ($errors->has('comment'))
                                                                <span class="help-block">
                                                        <strong>{{ $errors->first('comment') }}</strong>
                                                    </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(empty($taskBidder))
                                                <div class="row form-group mt-3">
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn usermenu-btns orange-bg">Bid</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/js/star-rating.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/themes/krajee-svg/theme.js"></script>


    <script>
        $(document).ready(function(){

            $(document).ready(function() {
                $(".stelle").rating({
                    hoverOnClear: false,
                    theme: "krajee-svg",
                    containerClass: "is-star",
                    language: "it"
                });
            });
            $('.nav-tabs a').click(function(){
                $(this).tab('show');
            });

            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
    </script>
@endsection
