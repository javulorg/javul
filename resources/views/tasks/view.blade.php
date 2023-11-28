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
                    <div class="row form-group">
                        <div class="col-md-12 order-md-2">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title">TASK INFORMATION</h5>
                                </div>
                                <div class="card-body">
                                        <div class="list-group">
                                            <div class="list-group-item py-0">
                                                <div class="row border-bottom border-1">
                                                    <div class="col-7">
                                                        <h4 class="text-success">{{$taskObj->name}}</h4>
                                                    </div>

                                                    <div class="col-md-5 text-end">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <a class="add_to_my_watchlist" data-type="task" data-id="{{$taskIDHashID->encode($taskObj->id)}}">
                                                                    <i class="fa fa-eye me-2"></i>
                                                                    <i class="fa fa-plus plus"></i>
                                                                </a>
                                                            </div>
                                                            <div class="col-2">
                                                                @if($taskObj->status == "editable")
                                                                    <a title="Edit Task" href="{!! url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit')!!}">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="col-7">
                                                                <a href="{!! route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]) !!}"><i class="fa fa-history"></i> REVISION HISTORY</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4" style="min-height: 233px">
                                                        {!! $taskObj->description !!}
                                                    </div>

                                                    <div class="col-8 text-end">
                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Status</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="text-success">{{\App\Models\SiteConfigs::task_status($taskObj->status)}}</label>
                                                                @if($taskObj->status == "open_for_bidding" && auth()->check())
                                                                    @if(\App\Models\TaskBidder::checkBid($taskObj->id))
                                                                        <a title="bid now" href="{!! url('tasks/bid_now/'.$taskIDHashID->encode($taskObj->id)).'#bid_now' !!}" class="btn btn-primary btn-sm" style="color:#fff !important;">
                                                                            Bid now
                                                                        </a>
                                                                    @else
                                                                        <a title="applied bid" class="btn btn-warning btn-sm" style="color:#fff !important;">
                                                                            Applied Bid
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Skills</label>
                                                            </div>
                                                            <div class="col-10">
                                                                @if(!empty($skill_names) && count($skill_names) > 0)
                                                                    @foreach($skill_names as $skil)
                                                                        <label class="form-label">{{$skil}}</label>
                                                                    @endforeach
                                                                @else
                                                                    <label class="form-label">-</label>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row border-bottom">
                                                            <div class="col-2">
                                                                <label class="form-label">Award</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ {{ $taskObj->compensation }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Completion</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">{{ $taskObj->completionTime }}</label>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Available</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ {{ number_format($availableFunds,2) }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label class="form-label">Awarded</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="form-label">$ {{ number_format($availableFunds,2) }}</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="p-3 bg-light">
                                        <h4 class="fw-500">Summary:</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="p-3">
                                        {!! $taskObj->summary !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 action_list">
                                    <h4 class="p-3 bg-light fw-500">Action Items</h4>
                                    <div class="list_item_div">
                                        {!! $taskObj->task_action !!}
                                    </div>
                                </div>

                                <div class="col-md-6 file_list">
                                    <h4 class="p-3 bg-light fw-500">File Attachments</h4>
                                    @if(!empty($taskObj->task_documents))
                                        <ul class="list-group list-group-flush" style="padding-left: 30px;">
                                            @foreach($taskObj->task_documents as $index=>$document)
                                                <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                                @if($extension == "pdf") <?php $extension="pdf"; ?>
                                                @elseif($extension == "doc" || $extension == "docx") <?php $extension="docx"; ?>
                                                @elseif($extension == "jpg" || $extension == "jpeg") <?php $extension="jpeg"; ?>
                                                @elseif($extension == "ppt" || $extension == "pptx") <?php $extension="pptx"; ?>
                                                @else <?php $extension="file"; ?> @endif
                                                <li class="list-group-item">
                                                    <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">
                                                        <span>
                                                            @if(empty($document->file_name))
                                                                &nbsp;
                                                            @else
                                                                {{$document->file_name}}
                                                            @endif
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="p-3 bg-light mt-0">
                                        <h4 class="font-weight-bold">Objective: <span class="custom-orange-text">{{$taskObj->objective->name}}</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>

                <div class="row form-group">
                    <div class="col-md-12 order-md-2">
                        <div class="card border">
                            <div class="card-header">
                                <h4 class="d-flex justify-content-between align-items-center">Comments
                                    <?php if(isset($addComments)){ ?>
                                    <a class="btn btn-dark" href="<?= $addComments ?>">Add Comment</a>
                                    <?php } ?>
                                </h4>
                            </div>
                            <div class="card-body objectiveComment">
                                <div class="list-group">
                                    <div class="list-group-item py-0">
                                        <div class="row">
                                            <ul class="posts"></ul>
                                            <div class="d-flex justify-content-end align-items-center mt-3">
                                                <span class="me-3">Showing last <span class="item-count">0</span> comments.</span>
                                                <a href="<?= isset($addComments) ?  $addComments : '' ?>" class="<?= !isset($addComments) ?  'd-none' : '' ?>">View Forum Thread</a>
                                            </div>
                                            <div class="clearfix"></div>
                                            @if(auth()->check())
                                                <hr>
                                                <div class="form">
                                                    <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-sm-12 form-group">
                                                                <h4 class="control-label">Comment</h4>
                                                                <textarea class="form-control" id="comment" name="desc"></textarea>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="unit_id" value="<?=  $unit_id ?>">
                                                        <input type="hidden" name="section_id" value="<?=  $section_id ?>">
                                                        <input type="hidden" name="object_id" value="<?=  $object_id ?>">
                                                        <div class="row">
                                                            <div class="col-sm-12 mt-2 form-group">
                                                                <button class="btn btn-dark float-end">Submit Comment</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12 order-md-2">
                        <div class="card border">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <div class="list-group tab-pane" id="task_bidders">
                                    <div class="list-group-item">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Bidder Name</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($taskBidders) > 0)
                                                @foreach($taskBidders as $bidder)
                                                    <tr>
                                                        <td>
                                                            <a href="{!! url('userprofiles/'.$userIDHashID->encode($bidder->user_id).'/'.
                                        strtolower($bidder->first_name.'_'.$bidder->last_name)) !!}">
                                                                {{$bidder->first_name.' '.$bidder->last_name}}
                                                            </a>
                                                        </td>
                                                        <td>{{$bidder->amount}} <span class="badge">{{$bidder->charge_type}}</span></td>
                                                        <td>
                                                            @if($taskObj->status == "assigned" && $bidder->user_id == $taskObj->assign_to)
                                                                <a class="btn btn-xs btn-warning text-white">Assigned</a>
                                                            @elseif($taskObj->status=="completion_evaluation" && $bidder->user_id == $taskObj->assign_to)
                                                                <a class="btn btn-xs btn-success text-white">Completed</a>
                                                            @elseif($bidder->status == "offer_rejected")
                                                                <a class="btn btn-xs btn-danger text-white">Offer Rejected</a>
                                                            @elseif($taskObj->status=="in_progress" && $bidder->user_id == $taskObj->assign_to)
                                                                <a class="btn btn-xs btn-info text-white">In Progress</a>
                                                            @elseif((empty($taskObj->assign_to) && $isUnitAdminOfTask) || (!empty($taskObj->assign_to) && $isUnitAdminOfTask && $taskObj->status=="open_for_bidding"))
                                                                <a class="btn btn-xs btn-primary assign_now"
                                                                   data-uid="{{$userIDHashID->encode($bidder->user_id)}}"
                                                                   data-tid="{{$taskIDHashID->encode($bidder->task_id)}}"
                                                                   style="color:#fff;">Assign now</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">No bidder found.</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
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
        ClassicEditor
            .create( document.querySelector('#comment') )
            .catch( error => {
                console.error(error);
            } );
    </script>
@endsection
