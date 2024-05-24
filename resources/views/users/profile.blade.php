@extends('layout.master')
@section('title', 'My Profile')
@section('style')

@endsection
@section('content')
    <div class="bg-light p-3 mb-4">
        <div class="row">
            <div class="col-sm-4 text-center">
                <div>
                    @if(!empty($userObj->profile_pic))
                        <img src="{{ $userObj->profile_pic }}" class="rounded-circle" style="width: 160px;">
                    @else
                        <img src="{!! url('assets/images/user.png') !!}" class="rounded-circle" style="width: 160px;">
                    @endif
                </div>
                <label class="form-label d-block mb-0">Task Completion Ratings</label>
                <div class="rating" style="font-size: 2rem;">
                    <!-- Rating stars code remains unchanged -->
                </div>
                <span class="d-block text-center fw-bold">{{$rating_points}}/5</span>
            </div>
            <div class="col-sm-8">
                <div class="user-header">
                    <h3>{{$userObj->first_name.' '.$userObj->last_name}}</h3>
                </div>
                <div class="user-header">
                    <span class="bi bi-clock"></span>
                    Account age: {{$userObj->created_at}}
                </div>
                <div class="user-header">
                    <span class="bi bi-hand-thumbs-up"></span>
                    Skills:
                    <?php $job_skills = explode(",",$userObj->job_skills); ?>
                    @if(!empty($job_skills))
                        <div class="mt-2">
                            @foreach($job_skills as $skill)
                                <span class="badge bg-info mb-2">{{\App\Models\JobSkill::getName($skill)}}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="user-header mb-2">
                    <span class="bi bi-bookmark"></span>
                    Area of Interest:
                    <?php $area_of_interest = explode(",",$userObj->area_of_interest); ?>
                    @if(!empty($area_of_interest))
                        <div class="mt-2">
                            @foreach($area_of_interest as $interest)
                                <span class="badge bg-info mb-2" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{\App\Models\AreaOfInterest::getName($interest)}}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="bi bi-geo-alt"></span>
                        {{\App\Models\Country::getName($userObj->country_id)}}
                        <span class="bi bi-caret-right"></span>
                        {{\App\Models\State::getName($userObj->state_id)}}
                        <span class="bi bi-caret-right"></span>
                        {{\App\Models\City::getName($userObj->city_id)}}
                    </div>
                    <div>
                        <a href="{{ route('user_wiki_page_list',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}" class="btn btn-info" style="text-decoration: none;">User Wiki</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-3">
            <div class="sidebar_block">
                <div class="sidebar_block_ttl">
                    User Activity Log
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                    </div>
                </div>
                <div class="sidebar_block_content">
                    @if(count($site_activity) > 0)
                        @foreach($site_activity as $index => $activity)
                            <div class="log_item">
                                <div class="log_icon">
                                    <img src="{{ asset('v2/assets/img/commen.svg') }}" alt="">
                                </div>
                                <div class="log_txt">
                                    <a href="#">{!! $activity->comment !!}</a> {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="log_item">
                            No activity found.
                        </div>
                    @endif

                    <div class="sidebar_block_content_bottom">
                        <a href="#">Top Contributors</a>
                        <div class="separator"></div>
                        <a href="{{ url('activities') }}">More Activity</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">
                        Total Activity Points: {{ $activityPoints }}
                        | Idea Points: {{$activityPoints_forum}}
                    </h3>
                    @if($userObj->paypal_email)
                        <a class="btn btn-outline-dark btn-sm float-end" id="add_funds_btn"
                           href="{!! url('funds/donate/user/'.$userIDHashID->encode($userObj->id)) !!}">
                            <i class="fas fa-plus me-1"></i>
                            {!! trans('messages.add_funds') !!}
                        </a>
                    @endif

                    @auth()
                        @php
                            $userIDHashID = new Hashids\Hashids('user id hash',10,Config::get('app.encode_chars'));
                        @endphp
                        <input type="hidden" value="{{ $userIDHashID->encode(auth()->user()->id) }}" id="user_id">
                        <input type="hidden" value="{{ auth()->user()->username }}" id="username">
                    @endauth
                    <div class="input-icon right float-end">
                        <label for="amount" class="control-label">&nbsp;</label>
                        <input id="amount-toggle" checked
                               data-on="Last 6 Months" data-off="Lifetime"
                               data-toggle="toggle" data-width="140" data-height="30" data-onstyle="light" data-offstyle="info"
                               type="checkbox" name="charge_type">
                    </div>

                </div>
            </div>

            <!-- Card for Most Active Units -->
            <div class="card mb-3">
                <div class="card-header">
                    Most Active Units
                </div>
                <div class="card-body">
                    @include('users.profile-partials.unit-details')
                </div>
            </div>


            <!-- Card for Objectives Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Objectives Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Objectives Created</td>
                            <td>{{ $totalObjectivesCreated ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Objectives Edited</td>
                            <td>{{ $totalObjectivesEdited ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td>{{ $upvoteCreationRatio ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td>{{ $upvoteEditRatio ?? 0 }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Tasks Details -->

            <div class="card mb-3">
                <div class="card-header">
                    Task Details
                </div>
                <div class="card-body">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px;">Task Metrics</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Feedback Provided for Task Completion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <ul>
                                    <li>Tasks Created: {{ $totalTasksCreated }}</li>
                                    <li>Tasks Edited: {{ $totalTasksEdited }}</li>
                                    <li>Tasks Completed: {{ $totalCompletedTasks }}</li>
                                </ul>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <ul>
                                    <li>Quality of Work: 5</li>
                                    <li>Timeliness: 6</li>
                                    <li>Edits Upvote Ratio: {{ $tasksUpvoteEditRatio ?? 0 }}</li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Issues Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Issue Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Issue Created</td>
                            <td>{{ $totalTasksCreated }}</td>
                        </tr>
                        <tr>
                            <td>Issue Edited</td>
                            <td>{{ $totalTasksEdited }}</td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td>{{ $issueUpvoteCreationRatio ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td>{{ $issueUpvoteEditRatio ?? 0 }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Idea Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Idea Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Idea Created</td>
                            <td>{{ $totalIdeasCreated }}</td>
                        </tr>
                        <tr>
                            <td>Idea Edited</td>
                            <td>{{ $totalIdeasUpdated }}</td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td>{{ $ideaUpvoteCreationRatio ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td>{{ $ideaUpvoteEditRatio ?? 0 }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Comment Statistics -->
            <div class="card mb-3">
                <div class="card-header">
                    Comment Statistics
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Total Comments</td>
                            <td><span id="totalComments">{{ $totalUserComments }}</span></td>
                        </tr>
                        <tr>
                            <td>Total Upvotes on Comments</td>
                            <td><span id="totalUpvotes">{{ $totalUpvotesComments }}</span></td>
                        </tr>
                        <tr>
                            <td>Total Downvotes on Comments</td>
                            <td><span id="totalDownvotes">{{ $totalDownvotesComments }}</span></td>
                        </tr>
                        <tr>
                            <td>Comments/Upvotes Ratio</td>
                            <td><span id="commentsUpvotesRatio">{{ $totalUpvotesCommentsRatio }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Most Recent Comments
                </div>
                <div class="card-body">
                    @include('users.profile-partials.most-recent-comments')
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Top Comments
                </div>
                <div class="card-body">
                    @include('users.profile-partials.top-comments')
                </div>
            </div>

        </div>

        <style>
            .card-header {
                background-color: #f8f9fa;
                color: #333;
                font-weight: bold;
            }
            .card-body {
                background-color: #ffffff;
            }

        </style>
    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $('#amount-toggle').change(function () {
                var isChecked = $(this).prop('checked');
                var value = isChecked ? 'specific' : 'Lifetime';
                var userId = $('#user_id').val();
                var userName = $('#username').val();

                $.ajax({
                    url: '{{ url("/userprofiles") }}/' + userId + '/' + userName + '?filter=' + value,
                    method: 'GET',
                    contentType: 'application/json',
                    success: function (response) {
                        console.log('Data filtered successfully:', response);
                    },
                    error: function (error) {
                        console.error('Error filtering data:', error);
                    }
                });
            });
        });
    </script>

@endsection
