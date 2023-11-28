@extends('layout.master')
@section('title', 'Issue: REVISION HISTORY')
@section('style')
<style>
    .table_block_issues_revision .table_block_head_revision{
        background: #ebe9e9;
    }
    .table_block_head_revision{
        padding: 4px 9px;
        display: flex;
        align-items: center;
        font-weight: 700;
        font-size: 16px;
        line-height: 21px;
        color: #1D262D;
        position: relative;
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


        <div class="main_content mt-2">
            <div class="content_block">
            <div class="table_block table_block_issues_revision">
                <div class="table_block_head_revision">
                    <div class="table_block_icon">
{{--                        <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">--}}
                        <i class="fa fa-bug"></i>
                    </div>
                    View History: {!! $issueObj->title !!}
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="title_col">Rev Link</th>
                                <th class="last_reply_col">Time</th>
                                <th class="last_reply_col">Username</th>
                                <th class="last_reply_col">Edit Comment</th>
                                <th class="last_reply_col">Size</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($revisions as $key => $value)
                                @php
                                    $user_id = $userIDHashID->encode($value->user_id);
                                    $formatted_time = $Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->diffForHumans();
                                @endphp
                                <tr>
                                    <td><input type="checkbox" name="id" value="{{ $value['id'] }}" class="single-checkbox"></td>
                                    <td><a href="{!! route('unit_issues_view', [$issue_id, $value['id']]) !!}">View</a></td>
                                    <td>{{ $formatted_time }}</td>
                                    <td><a href="{{ url('userprofiles/'. $user_id .'/'.strtolower($value->first_name.'_'.$value->last_name)) }}">{{ $value->first_name ." ".$value->last_name }}</a></td>
                                    <td>{{ $value->comment }}</td>
                                    <td>{{ $value->size }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    <div class="text-center mt-3 mb-3">
                        <button class="btn btn-secondary btn-compare">Compare Revisions</button>
                    </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
@section('scripts')
            <script type="text/javascript">
                var limit = 3;
                $('input.single-checkbox').on('change', function(evt) {

                    if($('input.single-checkbox:checked').length >= limit) {
                        this.checked = false;
                    }
                    if($('input.single-checkbox:checked').length == 2) {
                        $(".btn-compare").addClass("black-btn");
                    }
                    else
                    {
                        $(".btn-compare").removeClass("black-btn");
                    }
                });
                var loc ='{!! url("issues") !!}/{!! $issue_id !!}/diff';
                var slug ='';

                $(".btn-compare").click(function(){
                    if($('input.single-checkbox:checked').length == 2) {
                        var rev = $('input.single-checkbox:checked')[0].value;
                        var comp = $('input.single-checkbox:checked')[1].value;
                        console.log(loc + "/" + rev + "/" + comp);
                        location.href = loc + "/" + rev + "/" + comp ;
                    }
                })
            </script>
@endsection
