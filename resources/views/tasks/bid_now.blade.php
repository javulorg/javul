@extends('layout.master')
@section('title', $taskObj->name)
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
                            <ul class="nav nav-tabs" id="taskTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $active == 'task_details' ? 'active' : '' }}" id="task-details-tab" data-toggle="tab" href="#task_details" role="tab" aria-controls="task_details" aria-selected="{{ $active == 'task_details' ? 'true' : 'false' }}">Task Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="task-actions-tab" data-toggle="tab" href="#task_actions" role="tab" aria-controls="task_actions" aria-selected="false">Task Actions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $active == 'bid_now' ? 'active' : '' }}" id="bid-now-tab" data-toggle="tab" href="#bid_now" role="tab" aria-controls="bid_now" aria-selected="{{ $active == 'bid_now' ? 'true' : 'false' }}">
                                        {{ !empty($taskBidder) ? 'Bid Details' : 'Bid Now' }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade {{ $active == 'task_details' ? 'show active' : '' }}" id="task_details" role="tabpanel" aria-labelledby="task-details-tab">
                                    <!-- Task Details Content Here -->
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
                                    <!-- Use Bootstrap components and utilities as needed -->
                                </div>
                                <div class="tab-pane fade" id="task_actions" role="tabpanel" aria-labelledby="task-actions-tab">
                                    <!-- Task Actions Content Here -->
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-orange">TASK ACTIONS</h4>
                                                <div>{!! $taskObj->task_action !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Use Bootstrap components and utilities as needed -->
                                </div>
                                <div class="tab-pane fade {{ $active == 'bid_now' ? 'show active' : '' }}" id="bid_now" role="tabpanel" aria-labelledby="bid-now-tab">
                                    <!-- Bid Now Content Here -->
                                    <div class="list-group-item">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label" style="margin-bottom:0px">Task Completion Ratings: Quality of works :<span
                                                                class="stars" style="display:inline-block">{{$quality_of_work}}</span>
                                                            ({{$quality_of_work}}/5)
                                                            Timeliness :<span class="stars"
                                                                              style="display:inline-block">{{$timeliness}}</span>({{$timeliness}}/5)</label>
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
                                            <div class="col-xs-6 col-sm-3">
                                                <div class="input-icon right">
                                                    <label for="amount" class="control-label">&nbsp;</label>
                                                    <input class="toggle" @if(!empty($taskBidder) && $taskBidder->charge_type == "amount") checked
                                                           disabled
                                                           @endif
                                                           data-on="Amount"
                                                           data-off="Points"
                                                           type="checkbox" name="charge_type">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12 {{ $errors->has('comment') ? ' has-error' : '' }}">
                                                <div class="input-icon right">
                                                    <label for="amount" class="control-label">Comment</label>
                                                    @if(!empty($taskBidder))
                                                        <span class="bid_comment">{!! $taskBidder->comment !!}</span>
                                                    @else
                                                        <textarea class="form-control summernote" id="comment" name="comment">{{old('comment')}}</textarea>
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
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn usermenu-btns orange-bg">Bid</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Use Bootstrap components and utilities as needed -->
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
    <script>
        $(document).ready(function() {
            $("#comment_form").click(function(e)
            {
                var unitId = $('#comment_unit_id').val();
                var sectionId = $('#comment_section_id').val();
                var objectId = $('#comment_object_id').val();
                var desc = $('#comment').val();

                $.ajax({
                    type: "POST",
                    url: '{{ url("/forum/submitauto") }}',
                    data: {
                        unit_id : unitId,
                        section_id : sectionId,
                        object_id : objectId,
                        desc : desc,
                        _token: $('input[name="_token"]').val(),
                    },
                    success: function (response, xhr, textStatus) {
                        if (response.status === 201) {
                            location.reload();
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    },
                });
            });
        });
    </script>
@endsection
