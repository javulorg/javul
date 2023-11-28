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
                            Issues
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            @if(isset($unitData))
                                <input type="hidden" name="unit" value="{{ $unitData->id }}" id="unit_id">
                            @else
                                <input type="hidden" name="unit" value="{{ null }}" id="unit_id">
                            @endif

                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Issue Name</th>
                                    <th class="type_col">Status</th>
                                    <th class="type_col">Created By</th>
                                    <th class="type_col">Created Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($unitIssues) && count($unitIssues) > 0)
                                    @foreach($unitIssues as $obj)
                                        <tr>
                                            <td class="title_col">
                                                <a href="{!! url('issues/'.$issueIDHashID->encode($obj->id).'/view') !!}"
                                                   title="edit">
                                                    {{$obj->title}}
                                                </a>
                                            </td>
                                            <td class="type_col">
                                                <?php $status_class=''; $verified_by =''; $resolved_by ='';
                                                if($obj->status=="unverified")
                                                    $status_class="text-danger";
                                                elseif($obj->status=="verified"){
                                                    $status_class="text-info";
                                                    $verified_by = " (by ".App\Models\User::getUserName($obj->verified_by).')';
                                                }
                                                elseif($obj->status == "resolved"){
                                                    $status_class = "text-success";
                                                    $resolved_by = " (by ".App\Models\User::getUserName($obj->resolved_by).')';
                                                }
                                                ?>
                                                <span class="{{$status_class}}">{{ucfirst($obj->status).$verified_by. $resolved_by}}</span>
                                            </td>
                                            <td class="type_col">
                                                <a href="{!! url('userprofiles/'.$userIDHashID->encode($obj->user_id).'/'.strtolower(str_replace(" ","_",App\Models\User::getUserName($obj->user_id)))) !!}">
                                                    {{App\Models\User::getUserName($obj->user_id)}}
                                                </a>
                                            </td>
                                            <td class="type_col">{{$obj->created_at}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record(s) found.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>
                        <div class="pagination-right">
                            <a href="{!! url('issues/'.$unitIDHashID->encode($unitData->id).'/add') !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
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
                            Issues ({{ $issuesTotal }})
                            <div class="arrow">
                                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                            </div>
                        </div>
                            <div class="table_block_body">
                                @if(isset($unitData))
                                    <input type="hidden" name="unit" value="{{ $unitData->id }}" id="unit_id">
                                @else
                                    <input type="hidden" name="unit" value="{{ null }}" id="unit_id">
                                @endif

                                <table>
                                    <thead>
                                    <tr>
                                        <th class="type_col">Issue Name</th>
                                        <th class="title_col">Unit Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($issuesMaster) && count($issuesMaster) > 0 )
                                        @foreach($issuesMaster as $issue)
                                            <tr>
                                                <td class="type_col">
                                                    <a href="{!! url('issues/'.$issueIDHashID->encode($issue->id).'/view') !!}">
                                                        {{$issue->title}}
                                                    </a>
                                                </td>
                                                <td class="title_col">
                                                    <a href="{!! url('units/'.$unitIDHashID->encode($issue->unit_id).'/'.\App\Models\Unit::getSlug($issue->unit_id)) !!}">
                                                        {{\App\Models\Unit::getUnitName($issue->unit_id)}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">No record(s) found.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
