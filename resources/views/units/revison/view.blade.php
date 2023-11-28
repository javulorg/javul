@extends('layout.master')
@section('title', 'Unit : REVISION HISTORY')
@section('style')
    <style>
    </style>
@endsection
@section('site-name')
    <h1>{{ $units->name }}</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">

            @include('layout.v2.global-unit-overview')
            <?php
            $title = 'Activity Log';
            ?>
            @include('layout.v2.global-activity-log',['title' => $title])

            @include('layout.v2.global-finances')

            @include('layout.v2.global-about-site')
        </div>

        <div class="col-md-10">
            <div class="card">
                <div class="card-header current_task_heading featured_unit_heading">
                    <div class="featured_unit current_task">
                        <i class="fa fa-pencil-square"></i>
                        <h4>View History: {!! $units->name !!} </h4>
                    </div>

                </div>
                <div class="card-body list-group">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rev Link</th>
                                    <th>Time</th>
                                    <th>Username</th>
                                    <th>Edit Comment</th>
                                    <th>Size</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($revisions as $key => $value) {
                                $user_id = $userIDHashID->encode($value->user_id);
                                ?>
                                <tr>
                                    <td> <input type="checkbox" name="id" value="{{ $value['id'] }}" class="single-checkbox"> </td>
                                    <td><a href="{!! route('unit_revison_view',[$unit_id,$value['id']])  !!}">View</a> </td>
                                    <td>{{ $Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->diffForHumans() }}</td>
                                    <td> <a href="{{ url('userprofiles/'. $user_id .'/'.strtolower($value->first_name.'_'.$value->last_name)) }}"> {{ $value->first_name ." ".$value->last_name }} </a></td>
                                    <td>{{ $value->comment }} </td>
                                    <td>{{ $value->size }}</td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-compare">Compare Revisions</button>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
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
        var loc ='{!! url("units") !!}/{!! $unit_id !!}/diff';
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
