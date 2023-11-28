@extends('layout.master')
@section('title', 'Objective: REVISION HISTORY')
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
            <div class="table_block table_block_objectives">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                    </div>
                    View History: {!! $objectiveObj->name !!}
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    <table id="objectives-table-id">
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
                        @foreach ($revisions as $key => $value)
                            <?php $user_id = $userIDHashID->encode($value->user_id); ?>
                            <tr>
                                <td><input type="checkbox" name="id" value="{{ $value['id'] }}" class="single-checkbox"></td>
                                <td class="title_col"><a href="{!! route('unit_objectives_view',[$objective_id,$value['id']]) !!}">View </a></td>
                                <td class="title_col">{{ $Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->diffForHumans() }}</td>
                                <td class="last_reply_col"><a href="{{ url('userprofiles/'. $user_id .'/'.strtolower($value->first_name.'_'.$value->last_name)) }}">{{ $value->first_name ." ".$value->last_name }}</a></td>
                                <td class="last_reply_col">{{ $value->comment }}</td>
                                <td class="last_reply_col">{{ $value->size }}</td>
                            </tr>
                        @endforeach
                        <tbody>
                        </tbody>
                    </table>
                    <div class="text-center mt-3 mb-3">
                        <button class="btn btn-secondary btn-compare">Compare Revisions</button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <div class="pagination-left">
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
        var loc ='{!! url("objectives") !!}/{!! $objective_id !!}/diff';
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
