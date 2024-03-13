@extends('layout.master')
@section('title', $taskObj->name)
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css" rel="stylesheet">


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
                    <div class="col-md-12">
                            <div class="container mt-3">
                                <!-- Task Details Section -->
                                <section id="task_details" class="mt-4">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <h2 class="text-orange">Task Details</h2>
                                        </div>
                                        <div class="list-group-item">
                                            <h4>Status</h4>
                                            @if(empty($taskObj->assigned_to))
                                                <p>Unassigned</p>
                                            @elseif($taskObj->status == "completed")
                                                <p>Completed</p>
                                                <p>Completed On: 23/05/2016</p>
                                            @else
                                                <p>Assigned to user X</p>
                                            @endif
                                        </div>
                                        <div class="list-group-item">
                                            <h4>Award</h4>
                                            <p>xx $</p>
                                        </div>
                                        <div class="list-group-item">
                                            <h4>Summary</h4>
                                            <p>{!! $taskObj->summary !!}</p>
                                        </div>
                                        <div class="list-group-item">
                                            <h4>Description</h4>
                                            <p>{!! $taskObj->description !!}</p>
                                        </div>
                                        <div class="list-group-item">
                                            <h4>Task Documents</h4>
                                            <!-- Document Listing -->
                                        </div>
                                    </div>
                                </section>

                                <!-- Task Actions Section -->
                                <section id="task_actions" class="mt-4">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <h2 class="text-orange">Task Actions</h2>
                                        </div>
                                        <div class="list-group-item">
                                            <div>{!! $taskObj->task_action !!}</div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Bid Now/Bid Details Section -->
                                <section id="bid_now" class="mt-4">
                                    <form role="form" method="post" action="{{ url('tasks/bid_now/' . $taskIDHashID->encode($taskObj->id)) }}" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">
                                        @csrf
                                        <div class="list-group">
                                        <div class="list-group-item">
                                            <h2 class="text-orange">{{ !empty($taskBidder) ? 'Bid Details' : 'Bid Now' }}</h2>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item">
                                                <div class="row form-group">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="control-label" style="margin-bottom:0px">Task Completion Ratings: Quality of works :
                                                                    <span class="stars" style="display:inline-block">{{$quality_of_work}}</span>({{$quality_of_work}}/5)
                                                                    Timeliness :
                                                                    <span class="stars" style="display:inline-block">{{$timeliness}}</span>
                                                                    ({{$timeliness}}/5)
                                                                </label>
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
                                    </form>
                                </section>
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




{{--@extends('layout.default')--}}
{{--@section('page-meta')--}}
{{--    <title>{!! $taskObj->name !!} - Javul.org</title>--}}
{{--@endsection--}}
{{--@section('page-css')--}}
{{--    <link href="{!! url('assets/plugins/bootstrap-multiselect/bootstrap-multiselect.css') !!}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{!! url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{!! url('assets/plugins/bootstrap-summernote/summernote.css') !!}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{!! url('assets/plugins/bootstrap-star-rating-master/css/star-rating.css') !!}" rel="stylesheet" type="text/css" />--}}

{{--    <style>--}}
{{--        span.stars, span.stars span {--}}
{{--            display: block;--}}
{{--            background: url('{!! url("assets/images/stars.png") !!}') 0 -16px repeat-x;--}}
{{--            width: 80px;--}}
{{--            height: 16px;--}}
{{--        }--}}

{{--        span.stars span {--}}
{{--            background-position: 0 0;--}}
{{--        }--}}
{{--        .hide-native-select .btn-group, .hide-native-select .btn-group .multiselect, .hide-native-select .btn-group.multiselect-container--}}
{{--        {width:100% !important;}--}}
{{--        .bid_comment p{margin:0;}--}}
{{--    </style>--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row form-group" style="margin-bottom:15px;">--}}
{{--            @include('elements.user-menu',['page'=>'units'])--}}
{{--        </div>--}}
{{--        <div class="row form-group">--}}
{{--            <div class="col-sm-12 ">--}}
{{--                <div class="col-sm-6 grey-bg unit_grey_screen_height">--}}
{{--                    <h1 class="unit-heading create_unit_heading">--}}
{{--                        <span class="glyphicon glyphicon-list-alt"></span>--}}
{{--                        {!! $taskObj->name !!}--}}

{{--                    </h1>--}}
{{--                    @if(!empty($daysRemainingTobid))--}}
{{--                        <span style="display: inline-block;font-weight: bold;">Time left for bid: {{$daysRemainingTobid}} days</span>--}}
{{--                    @endif--}}
{{--                    <br /><br />--}}
{{--                </div>--}}
{{--                @include('tasks.partials.task_information')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <?php $active="task_details"; ?>--}}
{{--        @if($errors->has('amount') || $errors->has('comment'))--}}
{{--                <?php $active="bid_now"; ?>--}}
{{--        @endif--}}

{{--        <form role="form" method="post" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">--}}
{{--            {!! csrf_field() !!}--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-4">--}}
{{--                    @include('elements.site_activities',['ajax'=>false])--}}
{{--                </div>--}}
{{--                <div class="col-sm-8">--}}
{{--                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">--}}
{{--                        <li @if($active =="task_details") class="active" @endif><a href="#task_details" data-toggle="tab">Task Details</a></li>--}}
{{--                        <li><a href="#task_actions" data-toggle="tab">Task Actions</a></li>--}}
{{--                        <li @if($active =="bid_now") class="active" @endif><a href="#bid_now" data-toggle="tab">--}}
{{--                                @if(!empty($taskBidder))--}}
{{--                                    Bid Details--}}
{{--                                @else--}}
{{--                                    Bid Now--}}
{{--                                @endif--}}
{{--                            </a></li>--}}
{{--                    </ul>--}}
{{--                    <div id="my-tab-content" class="tab-content">--}}
{{--                        <div class="list-group tab-pane @if($active == 'task_details') active @endif" id="task_details">--}}
{{--                            <div class="list-group-item">--}}
{{--                                <h4 class="text-orange">{!! strtoupper(trans('messages.task_status')) !!}</h4>--}}
{{--                                @if(empty($taskObj->assigned_to))--}}
{{--                                    <div>Unassigned</div>--}}
{{--                                @elseif($taskObj->status == "completed")--}}
{{--                                    <div>Completed</div>--}}
{{--                                    <div>Completed On: date 23/05/2016</div>--}}
{{--                                @else--}}
{{--                                    <div>assigned to user X</div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item">--}}
{{--                                <h4 class="text-orange">{!! strtoupper(trans('messages.task_award')) !!}</h4>--}}
{{--                                <div>xx $</div>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item">--}}
{{--                                <h4 class="text-orange">{!! strtoupper(trans('messages.task_summary')) !!}</h4>--}}
{{--                                <div>{!! $taskObj->summary !!}</div>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item">--}}
{{--                                <h4 class="text-orange">{!! strtoupper(trans('messages.long_description')) !!}</h4>--}}
{{--                                <div>{!! $taskObj->description !!}</div>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <h4 class="text-orange">Task Documents</h4>--}}
{{--                                        @if(!empty($taskObj->task_documents))--}}
{{--                                            @foreach($taskObj->task_documents as $document)--}}
{{--                                                    <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>--}}
{{--                                                @if($extension == "pdf") <?php $extension="pdf"; ?>--}}
{{--                                                @elseif($extension == "doc" || $extension == "docx") <?php $extension="docx"; ?>--}}
{{--                                                @elseif($extension == "jpg" || $extension == "jpeg") <?php $extension="jpeg"; ?>--}}
{{--                                                @elseif($extension == "ppt" || $extension == "pptx") <?php $extension="pptx"; ?>--}}
{{--                                                @else <?php $extension="file"; ?> @endif--}}
{{--                                                <div class="file_documents">--}}
{{--                                                    <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">--}}
{{--                                                        <img src="{!! url('assets/images/file_types/'.$extension.'.png') !!}" style="height:50px;">--}}
{{--                                                        <span style="display:block">--}}
{{--                                        @if(empty($document->file_name))--}}
{{--                                                                &nbsp;--}}
{{--                                                            @else--}}
{{--                                                                {{$document->file_name}}--}}
{{--                                                            @endif--}}
{{--                                    </span>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="list-group tab-pane" id="task_actions">--}}
{{--                            <div class="list-group-item">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <h4 class="text-orange">TASK ACTIONS</h4>--}}
{{--                                        <div>{!! $taskObj->task_action !!}</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="list-group tab-pane @if($active == 'bid_now') active @endif" id="bid_now">--}}
{{--                            <div class="list-group-item">--}}
{{--                                <div class="row form-group">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-12">--}}
{{--                                                <label class="control-label" style="margin-bottom:0px">Task Completion Ratings: Quality of works :<span--}}
{{--                                                        class="stars" style="display:inline-block">{{$quality_of_work}}</span>--}}
{{--                                                    ({{$quality_of_work}}/5)--}}
{{--                                                    Timeliness :<span class="stars"--}}
{{--                                                                      style="display:inline-block">{{$timeliness}}</span>({{$timeliness}}/5)</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row form-group">--}}
{{--                                    <div class="col-xs-6 col-sm-4  {{ $errors->has('amount') ? ' has-error' : '' }}">--}}
{{--                                        <div class="input-icon right">--}}
{{--                                            <label for="amount" class="control-label">Amount</label>--}}
{{--                                            <input name="amount" type="text" required id="amount" class="form-control"--}}
{{--                                                   @if(!empty($taskBidder)) value="{{$taskBidder->amount}}" @else value="{{ old('amount')}}" @endif--}}
{{--                                                   @if(!empty($taskBidder)) disabled @endif/>--}}
{{--                                            @if ($errors->has('amount'))--}}
{{--                                                <span class="help-block">--}}
{{--                                                <strong>{{ $errors->first('amount') }}</strong>--}}
{{--                                            </span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xs-6 col-sm-3">--}}
{{--                                        <div class="input-icon right">--}}
{{--                                            <label for="amount" class="control-label">&nbsp;</label>--}}
{{--                                            <input class="toggle" @if(!empty($taskBidder) && $taskBidder->charge_type == "amount") checked--}}
{{--                                                   disabled--}}
{{--                                                   @endif--}}
{{--                                                   data-on="Amount"--}}
{{--                                                   data-off="Points"--}}
{{--                                                   type="checkbox" name="charge_type">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row form-group">--}}
{{--                                    <div class="col-sm-12 {{ $errors->has('comment') ? ' has-error' : '' }}">--}}
{{--                                        <div class="input-icon right">--}}
{{--                                            <label for="amount" class="control-label">Comment</label>--}}
{{--                                            @if(!empty($taskBidder))--}}
{{--                                                <span class="bid_comment">{!! $taskBidder->comment !!}</span>--}}
{{--                                            @else--}}
{{--                                                <textarea class="form-control summernote" id="comment" name="comment">{{old('comment')}}</textarea>--}}
{{--                                                @if ($errors->has('comment'))--}}
{{--                                                    <span class="help-block">--}}
{{--                                                        <strong>{{ $errors->first('comment') }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @if(empty($taskBidder))--}}
{{--                                    <div class="row form-group">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <button type="submit" class="btn usermenu-btns orange-bg">Bid</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--    @include('elements.footer')--}}
{{--@stop--}}
{{--@section('page-scripts')--}}
{{--    <script src="{!! url('assets/plugins/bootstrap-star-rating-master/js/star-rating.js') !!}"></script>--}}
{{--    <script>--}}
{{--        toastr.options = {--}}
{{--            "closeButton": true,--}}
{{--            "debug": false,--}}
{{--            "positionClass": "toast-top-right",--}}
{{--            "onclick": null,--}}
{{--            "showDuration": "1000",--}}
{{--            "hideDuration": "1000",--}}
{{--            "timeOut": "5000",--}}
{{--            "extendedTimeOut": "1000",--}}
{{--            "showEasing": "swing",--}}
{{--            "hideEasing": "linear",--}}
{{--            "showMethod": "fadeIn",--}}
{{--            "hideMethod": "fadeOut"--}}
{{--        };--}}
{{--        $.fn.stars = function() {--}}
{{--            return $(this).each(function() {--}}
{{--                // Get the value--}}
{{--                var val = parseFloat($(this).html());--}}
{{--                val = Math.round(val * 2) / 2;--}}
{{--                // Make sure that the value is in 0 - 5 range, multiply to get width--}}
{{--                var size = Math.max(0, (Math.min(5, val))) * 16;--}}

{{--                // Create stars holder--}}
{{--                var $span = $('<span />').width(size);--}}
{{--                // Replace the numerical value with stars--}}
{{--                $(this).html($span);--}}
{{--            });--}}
{{--        }--}}
{{--        $(function(){--}}
{{--            $('span.stars').stars();--}}
{{--        });--}}
{{--    </script>--}}
{{--    <script src="{!! url('assets/plugins/bootstrap-summernote/summernote.js') !!}" type="text/javascript"></script>--}}
{{--    <script src="{!! url('assets/js/tasks/task_bid.js') !!}"></script>--}}
{{--@endsection--}}
