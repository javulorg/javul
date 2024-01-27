@extends('layout.master')
@section('title', 'Issue: ' . $issueObj->title)
@section('style')
    <style>
        a.modal-link {
            font-size: 13px;
            text-decoration: none; /* Remove underline */
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

        <input type="hidden" id="issue_id" name="issue_id" value="{{ $issueObj->id }}">
        <input type="hidden" id="unit_id" name="unit_id" value="{{ $unitData->id }}">

        <div class="content_block">
            <div class="table_block table_block_issues active">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
                    </div>
                    {{$issueObj->title}}
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="objective_content">
                    <div class="objective_content_row d-sm-flex d-none">
                        <div>
                            <p>
                                {!! $issueObj->description !!}
                            </p>
                        </div>
                        <div class="objective_content_info">
                            <div class="sidebar_block">
                                <div class="sidebar_block_ttl">
                                    Issue Overview
                                    <div class="arrow">
                                        <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="sidebar_block_content">
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Priority:
                                        </div>
                                        <div class="sidebar_block_right">
                                            Medium
                                            <div class="progress">
                                                <div class="progress-bar" style="width:75%"></div>
                                            </div>
                                        </div>

                                        <div class="sidebar_block_right">
                                            <a href="#" class="modal-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rate</a>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Priority</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="ratingForm">
                                                                <div class="form-group">
                                                                    <label for="rating">Select rating:</label><br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input" id="rating1" name="rating" value="1">
                                                                        <label class="form-check-label" for="rating1">Low</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input" id="rating2" name="rating" value="2">
                                                                        <label class="form-check-label" for="rating2">Medium-Low</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input" id="rating3" name="rating" value="3">
                                                                        <label class="form-check-label" for="rating3">Medium</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input" id="rating4" name="rating" value="4">
                                                                        <label class="form-check-label" for="rating4">Medium-High</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input" id="rating5" name="rating" value="5">
                                                                        <label class="form-check-label" for="rating5">High</label>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" id="submitRating" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Status:
                                        </div>
                                        <div class="sidebar_block_right">
                                            <?php $verified_by ='';?>
                                            @if($issueObj->status == 1)
                                                    <?php $verified_by = " (by ".App\Models\User::getUserName($issueObj->verified_by).')';?>
                                            @endif
                                            {{ucfirst($issueObj->status == 1 ? 'Resolved' : 'Assigned To Task'. $verified_by )}}
                                        </div>
                                    </div>
                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Support
                                        </div>
                                        <div class="sidebar_block_right">
                                            <?php
                                            $voteClass = "";
                                            $upvoteClass = "";
                                            $downvoteClass = "";

                                            if (auth()->check()) {
                                                $voteClass = "vote";
                                                $flag = \App\Models\ImportanceLevel::checkImportanceLevel($issueObj->id, 'issue_id');

                                                if ($flag == "1") {
                                                    $upvoteClass = "success-upvote";
                                                } elseif ($flag == "-1") {
                                                    $downvoteClass = "success-downvote";
                                                }
                                            }
                                            ?>

                                            <div style="float:left;">{{ $importancePercentage }}%</div>

                                            <div class="vote-buttons">
                                                <span class="fa fa-thumbs-up {{ $voteClass }} upvote {{ $upvoteClass }}"
                                                      @if (auth()->check()) data-id="{{ $issueIDHashID->encode($issueObj->id) }}" data-type="up" @endif
                                                      title="Upvote"></span>
                                                {{ $upvotedCnt }}

                                                <span class="fa fa-thumbs-down {{ $voteClass }} downvote {{ $downvoteClass }}"
                                                      @if (auth()->check()) data-id="{{ $issueIDHashID->encode($issueObj->id) }}" data-type="down" @endif
                                                      title="Downvote"></span>
                                                {{ $downvotedCnt }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="objective_content_info_links">
                                <a class="add_to_my_watchlist edit_icon" data-type="issue" data-id="{{$issueIDHashID->encode($issueObj->id)}}" data-redirect="{{url()->current()}}"><img src="{{ asset('v2/assets/img/eye.svg') }}" alt=""></a>
                                <div class="separat"></div>
                                <a href="{!! route('issues_revison',[$issueIDHashID->encode($issueObj->id)]) !!}" class="edit_icon"> Revision History</a>
                                <div class="separat"></div>
                                <a href="{!! url('issues/'.$issueIDHashID->encode($issueObj->id).'/edit')!!}" class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content_block">
            <div class="table_block table_block_objective">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/User_Rounded.svg') }}" alt="" class="img-fluid">
                    </div>
                    Associated Objective
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                @php
                    $objectiveID = $issueObj->objective_id;
                    $objSlug = \App\Models\Objective::getSlug($objectiveID);
                    $objectiveUrl = url('objectives/'.$objectiveIDHashID->encode($objectiveID).'/'.$objSlug);
                    $objectiveName = \App\Models\Objective::getObjectiveName($objectiveID);
                @endphp

                <div class="table_block_txt">
                    <a style="font-weight: normal;" class="no-decoration" href="{{ $objectiveUrl }}">
                        {{ $objectiveName }}
                    </a>
                </div>
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>

        <div class="content_block">
            <div class="table_block table_block_objective">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/User_Rounded.svg') }}" alt="" class="img-fluid">
                    </div>
                    Associated Tasks
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                @php
                    $taskIDs = explode(",", $issueObj->task_id);
                @endphp
                @if(count($taskIDs) > 0)
                    @foreach($taskIDs as $taskID)
                        @php
                            $taskSlug = \App\Models\Task::getSlug($taskID);
                            $taskUrl = url('tasks/'.$taskIDHashID->encode($taskID).'/'.$taskSlug);
                            $taskName = \App\Models\Task::getName($taskID);
                        @endphp
                        <div class="table_block_txt">
                            <a style="font-weight: normal;" class="no-decoration" href="{{ $taskUrl }}">
                                {{ $taskName }}
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>


        <div class="content_block_comments">
            <div class="table_block table_block_comments">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/Dialog.svg') }}" alt="" class="img-fluid">
                    </div>
                    Comments
                </div>
                <div class="comments_content">
                    <div class="comment_stat">

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
                                                $user = \App\Models\User::where('id', $comment->user_id)->select('first_name','last_name')->first();
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
                                </div>
                            </div>
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
                            <button id="comment_form"  class="btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_block_bottom">
                <a href="#"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.modal-link').click(function() {
                var modalId = $(this).data('modal-id');
                $('#modalIdSpan').text(modalId);
            });

            $('#submitRating').click(function() {
                var selectedRating = $("input[name='rating']:checked").val();
                if (selectedRating !== undefined) {

                    var unitId = $('#unit_id').val();
                    var typeId = $('#issue_id').val();
                    $.ajax({
                        url: '{{ url("priorities") }}',
                        type: 'POST',
                        data: {
                            type_value   : 1,
                            rating :selectedRating,
                            unit_id : unitId,
                            type_id : typeId,
                            _token: $('input[name="_token"]').val(),
                        },
                        success: function (response, xhr, textStatus) {
                            if (response.status === 201) {
                                $('#exampleModal').modal('hide');
                                location.reload();
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText);
                        },
                    });
                }else {
                    alert("Please select a rating.");
                }

            });

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
