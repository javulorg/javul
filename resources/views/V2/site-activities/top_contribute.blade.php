@extends('layout.master')
@section('title', 'Issues')
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
        @if(isset($unitData))
        <div class="content_block">
            <div class="table_block table_block_issues">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
                    </div>
                    Top Contributors
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                   <table>
                        <thead>
                            <tr>
                                <th class="type_col">User Name</th>
                                <th class="title_col">Activity Point</th>
                                <th class="type_col">Award </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($mostActiveUnits as $mostActiveUnit)
                            <tr>
                                <td class="type_col">
                                    <a
                                        href="{!! url('userprofiles/'.$userIDHashID->encode($mostActiveUnit->user_id)) !!}">
                                        {{$mostActiveUnit->user_name}}
                                    </a>

                                </td>
                                <td class="title_col">
                                        {{$mostActiveUnit->total_points}}
                                </td>

                                <td class="title_col">
                                        -
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>


                    <div class="mob_table d-sm-none d-block">
                        @if(isset($pagination) && count($pagination) > 0)
                        @foreach($pagination as $obj)
                        <?php
                                            $status_class = '';
                                            $verified_by = '';
                                            $resolved_by = '';

                                            if ($obj->status == "unverified") {
                                                $status_class = "text-danger";
                                            } elseif ($obj->status == "verified") {
                                                $status_class = "text-info";
                                                $verified_by = " (by " . App\Models\User::getUserName($obj->verified_by) . ")";
                                            } elseif ($obj->status == "resolved") {
                                                $status_class = "text-success";
                                                $resolved_by = " (by " . App\Models\User::getUserName($obj->resolved_by) . ")";
                                            }
                                        ?>
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Issue Name</div>
                                <div class="mob_table_val">
                                    <a href="{!! url('issues/'.$issueIDHashID->encode($obj->id).'/view') !!}">
                                        {{$obj->title}}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Status</div>
                                <div class="mob_table_val">
                                    <span class="{{ $status_class }}">{{ ucfirst($obj->status) . $verified_by .
                                        $resolved_by }}</span>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Created By</div>
                                <div class="mob_table_val">
                                    <a href="{!! url('userprofiles/'.$userIDHashID->encode($obj->user_id).'/'.strtolower(str_replace(" ","
                                        _",App\Models\User::getUserName($obj->user_id)))) !!}">
                                        {{ App\Models\User::getUserName($obj->user_id) }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Created Date</div>
                                <div class="mob_table_val">
                                    {{ $obj->created_at }}
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



                </div>
                {{-- <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        {!! $pagination->links('layout.pagination') !!}
                    </div>
                </div> --}}


            </div>
            <div class="d-flex justify-content-between mt-2">
                <div class="pagination-left">
                </div>
                <div class="pagination-right">

                </div>
            </div>
        </div>
        @else
        <div class="content_block">
            <div class="table_block table_block_issues">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
                    </div>
                    Top Contribute
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="table_block_body">
                    {{-- @if(isset($unitData))
                    <input type="hidden" name="unit" value="{{ $unitData->id }}" id="unit_id">
                    @else
                    <input type="hidden" name="unit" value="{{ null }}" id="unit_id">
                    @endif --}}

                    <table>
                        <thead>
                            <tr>
                                <th class="type_col">User Name</th>
                                <th class="title_col">Activity Point</th>
                                <th class="type_col">Award </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($mostActiveUnits as $mostActiveUnit)
                            <tr>
                                <td class="type_col">
                                    <a
                                        href="{!! url('userprofiles/'.$userIDHashID->encode($mostActiveUnit->user_id)) !!}">
                                        {{$mostActiveUnit->user_name}}
                                    </a>

                                </td>
                                <td class="title_col">
                                        {{$mostActiveUnit->total_points}}
                                </td>

                                <td class="title_col">
                                        -
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>



                </div>
                {{-- <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        {!! $pagination->links('layout.pagination') !!}
                    </div>
                </div> --}}
            </div>
            <div class="content_block_bottom">
                {{-- <a href="{{ url('issues/'. $unitIDHashID->encode($issue->unit_id) .'/add') }}">Add New</a> --}}
            </div>
            <div class="d-flex justify-content-between mt-2">
                <div class="pagination-left">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')

@endsection
