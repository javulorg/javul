@extends('layout.master')
@section('title', 'Wiki Page List')
@section('style')
    <style>

    </style>
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
                    <input type="hidden" name="rating" value="{{ $rating_points }}" />
                    <span class="star @if($rating_points >= 1) checked @endif" style="opacity: {{ $rating_points >= 1 ? 1 : 0.3 }};">&#9733;</span>
                    <span class="star @if($rating_points >= 2) checked @endif" style="opacity: {{ $rating_points >= 2 ? 1 : 0.3 }};">&#9733;</span>
                    <span class="star @if($rating_points >= 3) checked @endif" style="opacity: {{ $rating_points >= 3 ? 1 : 0.3 }};">&#9733;</span>
                    <span class="star @if($rating_points >= 4) checked @endif" style="opacity: {{ $rating_points >= 4 ? 1 : 0.3 }};">&#9733;</span>
                    <span class="star @if($rating_points == 5) checked @endif" style="opacity: {{ $rating_points == 5 ? 1 : 0.3 }};">&#9733;</span>
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
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
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

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="float-start">User Wiki</h4>
                    <div class="user-wikihome-tool float-end">
                        <div class="user-wikihome-tool small-a">
                            <a href="{{ route('user_wiki_newpage', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash]) }}">+ New Page</a> |
                            <a href="{{ route('user_wiki_recent_changes', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash]) }}">Recent Changes</a> |
                            <a href="{{ route('user_wiki_page_list', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash]) }}">List All Pages</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body table-responsive loading_content_hide">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Last Edit</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($userWikiPage as $page)
                                <tr>
                                    <td>
                                        <a href="{{ route('user_wiki_view', [$slug, $userPageIDHashID->encode($page->id), $page->slug]) }}">
                                            {{ $page->page_title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user_wiki_editpage', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash, $userPageIDHashID->encode($page->id), $page->slug]) }}">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="{{ $userWikiPage->links() == '' ? 'hide' : '' }}">
                            <tr>
                                <td colspan="3">{{ $userWikiPage->links() }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
