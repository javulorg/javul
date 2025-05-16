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
                                            <label class="control-label"
                                                style="color: lightgreen;">{{\App\Models\SiteConfigs::task_status($taskObj->status)}}</label>
                                            @if($taskObj->status == "open_for_bidding" && auth()->check())
                                            @if(\App\Models\TaskBidder::checkBid($taskObj->id))
                                            <a title="Bid Now"
                                                href="{!! url('tasks/bid_now/'.$taskIDHashID->encode($taskObj->id)).'#bid_now' !!}"
                                                class="btn btn-success btn-sm" style="color:#fff !important;">
                                                Bid Now
                                            </a>
                                            @else
                                            <a title="Applied Bid" class="btn btn-warning btn-sm disabled"
                                                style="color:#fff !important;">
                                                Applied Bid
                                            </a>
                                            @endif
                                            @endif
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
                            <div class="objective_content_info_links">
                                {{-- <a class="add_to_my_watchlist edit_icon" data-type="task"
                                    data-id="{{$taskIDHashID->encode($taskObj->id)}}"
                                    data-redirect="{{url()->current()}}"><img src="{{ asset('v2/assets/img/eye.svg') }}"
                                        alt=""></a> --}}
                                {{-- <a
                                    href="{{ route('watchlistTask.store', ['userId' => $unitData->id, 'unitId' => $unitData->id, 'task_id' => $taskObj->id]) }}"
                                    class="edit_icon">
                                    <img src="{{ asset('v2/assets/img/eye.svg') }}" alt="">
                                </a> --}}
                                @php
                                $isTaskWatched = \App\Models\Watchlist::where('user_id', $unitData->id)
                                ->where('unit_id', $unitData->id)
                                ->where('task_id', $taskObj->id)
                                ->exists();
                                @endphp

                                <a href="javascript:void(0);" class="edit_icon watchlist-link"
                                    data-id="{{ $taskObj->id }}"
                                    data-url="{{ route('watchlistTask.store', ['userId' => $unitData->id, 'unitId' => $unitData->id, 'task_id' => $taskObj->id]) }}"
                                    id="task-eye-link-{{ $taskObj->id }}"
                                    style="{{ $isTaskWatched ? 'display: none;' : '' }}">
                                    <img src="{{ asset('v2/assets/img/eye.svg') }}" style="height: 20px; width: 20px;"
                                        alt="Watch" id="task-eye-icon-{{ $taskObj->id }}">
                                </a>

                                <img src="{{ asset('v2/assets/img/eye-slash.svg') }}"
                                    style="height: 20px; width: 20px; {{ $isTaskWatched ? '' : 'display: none;' }}"
                                    alt="Watched" id="task-eye-off-icon-{{ $taskObj->id }}">





                                {{-- $encodedObjectiveID = $objectiveIDHashID->encode($objective_id);

                                return redirect('objectives/' . $encodedObjectiveID . '/' . $unitObj->slug)
                                ->with('success', 'Task created successfully!'); --}}
                                <div class="separat"></div>
                                <a href="{!! route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]) !!}"
                                    class="edit_icon"> Revision History</a>
                                <div class="separat"></div>
                                <a href="{!! url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit')!!}"
                                    class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}"
                                        alt=""></a>
                                @php
                                $allowedRoles = [1, 2, 3];
                                @endphp

                                @if (in_array(auth()->user()->role, $allowedRoles))
                                <a href="javascript:void(0);" class="delete-task" data-id="{{ $taskObj->id }}">
                                    <i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>
                                </a>
                                @endif




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content_block mt-4">
            <div class="table_block table_block_objectives active">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                    </div>
                    Objectives
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                <?php $objSlug = \App\Models\Objective::getSlug($taskObj->objective->id); ?>
                <div class="table_block_txt">
                    <a style="font-weight: normal;" class="no-decoration"
                        href="{!! url('objectives/'.$objectiveIDHashID->encode($taskObj->objective->id).'/'.$objSlug ) !!}">
                        {{ $taskObj->objective->name }}
                    </a>
                </div>
            </div>
        </div>

        <div class="content_block_comments mt-4">
            <div class="table_block table_block_comments">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/Dialog.svg') }}" alt="" class="img-fluid">
                    </div>
                    Comments
                </div>
                <div class="comments_content">
                    <div class="comment_stat">
                        {{-- @if(isset($comments))--}}
                        {{-- <b>{{ $comments->count() }} review</b> <a href="#">Write a review</a>--}}
                        {{-- @endif--}}
                        {{-- <b>0 review</b> <a href="#">Write a review</a>--}}
                    </div>

                    @if(isset($comments))
                    @foreach($comments as $comment)
                    <div class="comment_container">
                        <div class="comment_icon">
                            <img src="{{ asset('v2/assets/img/User_Circle.svg') }}" alt="" class="img-fluid">
                        </div>
                        <div class="comment_content">
                            <div class="comment_info">
                                <div class="comment_autor">
                                    @php
                                    $user = \App\Models\User::where('id',
                                    $comment->user_id)->select('first_name','last_name')->first();
                                    @endphp
                                    {{ $user->first_name . ' ' . $user->last_name }}
                                </div>
                                <div class="comment_time">
                                    {{ Carbon\Carbon::parse($comment->created_time)->diffForHumans() }}

                                </div>
                            </div>
                            <div class="comment_txt">
                                {{ $comment->post }}
                            </div>

                            <div class="comment_actions">
                                <input type="hidden" value="{{ $comment->id }}" id="comment_id_{{ $comment->id }}">

                                <button type="button" class="like_button">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span id="like_count" class="badge badge-primary">
                                        <span class="count"> {{ $comment->likes }}</span>
                                    </span>
                                </button>
                                <button type="button" class="dislike_button">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span id="dislike_count" class="badge badge-danger">
                                        <span class="count"> {{ $comment->dislikes }}</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <style>
                        .comment_actions form {
                            display: inline-block;
                            margin-right: 10px;
                        }

                        .comment_actions form:last-child {
                            margin-right: 0;
                        }

                        .badge .count {
                            color: black;
                            /* Adjust color as needed */
                        }
                    </style>
                    @endforeach
                    @endif



                    <div class="comment_container">
                        <div class="comment_icon">
                            <img src="{{ asset('v2/assets/img/User_Circle.svg') }}" alt="" class="img-fluid">
                        </div>
                        <input type="hidden" name="unit_id" id="comment_unit_id" value="<?=  $unit_id ?>">
                        <input type="hidden" name="section_id" id="comment_section_id" value="<?=  $section_id ?>">
                        <input type="hidden" name="object_id" id="comment_object_id" value="<?=  $object_id ?>">
                        <div class="comment_content">
                            <textarea cols="30" id="comment" rows="10" placeholder="White a message..."></textarea>
                            <button id="comment_form" class="btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_block_bottom">
                <a href="{{url('objectives/'.$userIDHashID->encode($object_id).'/'. $objSlug .'/'.$unit_id.'/tasks')}}"><img
                        src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
                <div class="separator"></div> <a href="{{ url('tasks?unit=' . $unitData->id) }}" class="see_more"
                    onclick="window.location.href=this.href; return true;" class="see_more">See more</a>
            </div>
        </div>


        <div class="content_block mt-4">
            <div class="table_block table_block_tasks">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/auction.png') }}" alt="" class="img-fluid">
                    </div>
                    Bidders
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">

                    <table>
                        <thead>
                            <tr>
                                <th class="title_col">Bidder Name</th>
                                <th class="type_col">Amount</th>
                                <th class="type_col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($taskBidders) > 0)
                            @foreach($taskBidders as $bidder)
                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('userprofiles/'.$userIDHashID->encode($bidder->user_id).'/'.
                                                strtolower($bidder->first_name.'_'.$bidder->last_name)) !!}">
                                        {{$bidder->first_name.' '
                                        .$bidder->last_name}}
                                    </a>
                                </td>
                                <td class="type_col">{{$bidder->amount}} <span class="badge"
                                        style="color: #0d1217; font-size:12px;">{{$bidder->charge_type}}</span></td>
                                <td class="type_col">
                                    @if($taskObj->status == "assigned" && $bidder->user_id == $taskObj->assign_to)
                                    <a class="btn btn-sm btn-warning" style="color:#fff;">Assigned</a>
                                    @elseif($taskObj->status=="completion_evaluation" && $bidder->user_id ==
                                    $taskObj->assign_to)
                                    <a class="btn btn-sm btn-success" style="color:#fff;">Completed</a>
                                    @elseif($bidder->status == "offer_rejected")
                                    <a class="btn btn-sm btn-danger" style="color:#fff;">Offer Rejected</a>
                                    @elseif($taskObj->status=="in_progress" && $bidder->user_id == $taskObj->assign_to)
                                    <a class="btn btn-sm btn-info" style="color:#fff;">In Progress</a>
                                    {{-- @elseif((empty($taskObj->assign_to) && ($isUnitAdminOfTask ||
                                    auth()->user()->role == 1 || auth()->user()->role == 3)) ||
                                    (!empty($taskObj->assign_to) && ($isUnitAdminOfTask || auth()->user()->role == 1 ||
                                    auth()->user()->role == 3) && $taskObj->status=="open_for_bidding"))--}}
                                    @elseif(
                                    (
                                    (empty($taskObj->assign_to) && ($isUnitAdminOfTask || (auth()->user()?->role == 1)
                                    || (auth()->user()?->role == 3)))
                                    ||
                                    (!empty($taskObj->assign_to) && ($isUnitAdminOfTask || (auth()->user()?->role == 1)
                                    || (auth()->user()?->role == 3)) && $taskObj->status=="open_for_bidding")
                                    )
                                    )
                                    <a class="btn btn-sm btn-primary assign_now"
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
                                <td colspan="3">No record(s) found.</td>
                            </tr>
                            @endif
                        </tbody>

                        <div class="mob_table d-sm-none d-block">
                            @if(count($taskBidders) > 0)
                            @foreach($taskBidders as $bidder)
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Bidder Name</div>
                                    <div class="mob_table_val">
                                        <a href="{!! url('userprofiles/'.$userIDHashID->encode($bidder->user_id).'/'.
                                                        strtolower($bidder->first_name.'_'.$bidder->last_name)) !!}">
                                            {{$bidder->first_name . ' ' . $bidder->last_name}}
                                        </a>
                                    </div>
                                </div>

                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Amount</div>
                                    <div class="mob_table_val">
                                        {{$bidder->amount}}
                                        <span class="badge" style="color: #0d1217; font-size:12px;">
                                            {{$bidder->charge_type}}
                                        </span>
                                    </div>
                                </div>

                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Status</div>
                                    <div class="mob_table_val">
                                        @if($taskObj->status == "assigned" && $bidder->user_id == $taskObj->assign_to)
                                        <span class="btn btn-sm btn-warning" style="color:#fff;">Assigned</span>
                                        @elseif($taskObj->status=="completion_evaluation" && $bidder->user_id ==
                                        $taskObj->assign_to)
                                        <span class="btn btn-sm btn-success" style="color:#fff;">Completed</span>
                                        @elseif($bidder->status == "offer_rejected")
                                        <span class="btn btn-sm btn-danger" style="color:#fff;">Offer Rejected</span>
                                        @elseif($taskObj->status=="in_progress" && $bidder->user_id ==
                                        $taskObj->assign_to)
                                        <span class="btn btn-sm btn-info" style="color:#fff;">In Progress</span>
                                        @elseif(
                                        (
                                        (empty($taskObj->assign_to) && ($isUnitAdminOfTask || (auth()->user()?->role ==
                                        1) || (auth()->user()?->role == 3)))
                                        ||
                                        (!empty($taskObj->assign_to) && ($isUnitAdminOfTask || (auth()->user()?->role ==
                                        1) || (auth()->user()?->role == 3)) && $taskObj->status=="open_for_bidding")
                                        )
                                        )
                                        <a class="btn btn-sm btn-primary assign_now"
                                            data-uid="{{$userIDHashID->encode($bidder->user_id)}}"
                                            data-tid="{{$taskIDHashID->encode($bidder->task_id)}}"
                                            style="color:#fff;">Assign now</a>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_val text-center">
                                        No record(s) found.
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
            $("#comment_form").click(function(e){
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

            $(".assign_now").click(function (e) {
                var uid = $(this).attr('data-uid');
                var tid = $(this).attr('data-tid');
                if($.trim(uid) != "" && $.trim(tid) != ""){
                    $.ajax({
                        type:'GET',
                        url: '{{ url("/tasks/assign") }}',
                        data:{uid:uid,tid:tid },
                        dataType:'json',
                        success:function(resp){
                            if (resp.success) {
                                // Show SweetAlert notification
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Task assigned successfully!',
                                    timer: 2000, // Set a timer for auto-close
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reload the page
                                    window.location.reload(true);
                                });
                            }
                        }
                    })
                }
            });

            $('.like_button').click(function() {
                var commentId = $(this).closest('.comment_container').find('input[type=hidden]').val();
                $.ajax({
                    url: '{{ route("like") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment_id: commentId
                    },
                    success: function(response) {
                        $('#like_count').text(response.dislike_count);
                        location.reload();
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });

            $('.dislike_button').click(function() {
                var commentId = $(this).closest('.comment_container').find('input[type=hidden]').val();
                $.ajax({
                    url: '{{ route("dislike") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment_id: commentId
                    },
                    success: function(response) {
                        console.log(response)

                        $('#dislike_count').text(response.dislike_count);
                        location.reload();

                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.watchlist-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const url = this.dataset.url;
                const taskId = this.dataset.id;

                const eyeIcon = document.getElementById('task-eye-icon-' + taskId);
                const eyeOffIcon = document.getElementById('task-eye-off-icon-' + taskId);
                const anchor = document.getElementById('task-eye-link-' + taskId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Hide clickable eye icon
                        anchor.style.display = "none";

                        // Show eye-off icon permanently
                        if (eyeOffIcon) {
                            eyeOffIcon.style.display = "inline-block";
                        }

                        alert(data.message || "Added to watchlist!");
                    })
                    .catch(err => {
                        console.error('Watchlist error:', err);
                        alert("Something went wrong!");
                    });
            });
        });
    });
</script>

<script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>

<script>
    $(document).ready(function () {
        $('.delete-task').click(function () {
            if (!confirm('Are you sure you want to delete this task?')) {
                return;
            }

            var taskId = $(this).data('id');

            $.ajax({
                url: '/tasks/' + taskId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function (response) {
                    // Redirect back like Laravel's redirect()->back()
                    window.location.href = document.referrer;
                },
                error: function () {
                    alert('Failed to delete task.');
                }
            });
        });
    });
</script>



@endsection
