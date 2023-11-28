@extends('layout.master')
@section('title', 'New Wiki Page')
@section('style')
    <style>
        .badge {
            display: inline-block;
            white-space: nowrap;
        }
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
            <div class="card" style="margin-top:29px">
                <div class="card-header">
                    <h4 class="card-title mb-0">User Wiki</h4>
                    <div class="user-wikihome-tool small-a">
                        <a href="{{ route('user_wiki_newpage',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> + New Page </a> |
                        <a href="{{ route('user_wiki_recent_changes',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> Recent Changes </a> |
                        <a href="{{ route('user_wiki_page_list',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> List All Pages </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post" id="wiki_forum" role="form" enctype="multipart/form-data">
                        <div class="row">
                            <?php
                            $pageType = isset($userWiki) ? $userWiki->page_type : 1;
                            ?>
                            @if($pageType == 1)
                                <div class="col-sm-12 mb-3">
                                    <label for="title" class="form-label">Page Title</label>
                                    <input class="form-control" id="title" name="title" value="<?= isset($userWiki) ? $userWiki->page_title : '' ?>">
                                </div>
                            @endif
                            <div class="col-sm-12 mb-3">
                                <label for="description" class="form-label">Page Content</label>
                                <textarea  class="form-control old_value d-none"></textarea>
                                <textarea class="form-control summernote" id="description" name="description"><?= isset($userWiki) ? $userWiki->page_content : '' ?></textarea>
                            </div>
                            @if($pageType == 1)
                                <div class="col-sm-12 mb-3">
                                    <label for="private" class="form-label">Privacy</label>
                                    <select class="form-control" id="private" name="private">
                                        <option <?= isset($userWiki) ? ($userWiki->private == 0 ? 'selected' : '' ) : '' ?> value="0">Public</option>
                                        <option <?= isset($userWiki) ? ($userWiki->private == 1 ? 'selected' : '' ) : '' ?> value="1">Private</option>
                                    </select>
                                </div>
                            @endif
                            @if($pageType == 1)
                                <div class="col-sm-12 mb-3">
                                    <label for="edit_comment" class="form-label">Edit Comment</label>
                                    <input class="form-control" id="edit_comment" name="edit_comment" value="">
                                </div>
                            @endif
                            <input class="form-control" type="hidden" name="id" value="<?= isset($userWiki) ? $userWiki->id : '' ?>">
                            <input class="form-control" type="hidden" name="slug" value="{{ $slug }}">
                            @csrf
                            <div class="col-sm-12 mb-3">
                                <input type="button" class="btn btn-secondary cancel-edit" value="Cancel">
                                <button class="btn btn-primary">Save Page</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            ClassicEditor
                .create( document.querySelector('#description'))
                .catch( error => {
                    console.error(error);
            });

            $(".cancel-edit").click(function(){
                var oldValue = $(".old_value").val();
                var newValue = $(".summernote").val();
                if(oldValue != newValue){
                    if (window.confirm('Content Was Changed. Cancel Edit ?')) {
                        history.back();
                    }
                }
                else
                {
                    history.back();
                }
            });

            var xhr;
            $("#wiki_forum").submit(function(){
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }
                $("#wiki_forum").find(".alert").remove();
                xhr = $.ajax({
                    type:'post',
                    url:'{{ route("user_wiki_save_page",[$user_id_hash]) }}',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $("#wiki_forum button").button("loading");
                    },
                    error:function(){

                    },
                    complete:function(){
                        $("#wiki_forum button").button("reset");
                    },
                    success:function(json){
                        if(json['errors']){
                            $.each(json['errors'],function(i,j){
                                $("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");
                            })
                        }
                        if(json['success']){
                            // toastr['success'](json['success'], '');
                            toastr.success('Wiki Page Added', 'Success', {
                                progressBar: true,
                                timeOut: 3000,
                                extendedTimeOut: 2000,
                                closeButton: true,
                                tapToDismiss: false,
                                positionClass: 'toast-top-right',
                                // Customize the background color
                                onShown: function () {
                                    $('.toast-success').css('background-color', '#28a745');
                                }
                            });
                            setTimeout(function(){ location = json['location'] },1000);
                        }
                        if(json['error']){
                            toastr['error'](json['error'], '');
                        }
                    }
                });
                return false;
            })
        });
    </script>
@endsection
