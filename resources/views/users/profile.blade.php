@extends('layout.master')
@section('title', 'My Profile')
@section('style')
{{--    <style>--}}
{{--        .badge {--}}
{{--            display: inline-block;--}}
{{--            white-space: nowrap;--}}
{{--        }--}}
{{--    </style>--}}
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
                    {{--        {{ $site_activity_text }}--}}
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
            <h3 style="display: inline-block;width: 70%;">Total Activity Points : {{$activityPoints}} | Idea Points : {{$activityPoints_forum}}</h3>
            @if($userObj->paypal_email)
                <a class="btn btn-outline-dark btn-sm" id="add_funds_btn" href="{!! url('funds/donate/user/'.$userIDHashID->encode($userObj->id)) !!}"
                   style="display: inline-block; float: right; margin-top: 10px;">
                    <i class="fas fa-plus me-1"></i>
                    {!! trans('messages.add_funds')!!}
                </a>
            @endif
        <!-- Tabs navigation -->
            <ul class="nav nav-tabs mt-4 mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#unit_details" type="button" role="tab" aria-controls="unit-details" aria-selected="true">Units Details</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="objectives-details-tab" data-bs-toggle="tab" data-bs-target="#objectives_details" type="button" role="tab" aria-controls="objectives-details" aria-selected="false">Objectives Details</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tasks-details-tab" data-bs-toggle="tab" data-bs-target="#tasks_details" type="button" role="tab" aria-controls="tasks-details" aria-selected="false">Tasks Details</button>
                </li>
            </ul>

            <div id="my-tab-content" class="tab-content">
                @include('users.profile-partials.unit-details')
                @include('users.profile-partials.objectives-details')
                @include('users.profile-partials.tasks-details')
            </div>
{{--            @include('users.profile-partials.user-wiki')--}}
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabs').tab();
        });
    </script>
@endsection
