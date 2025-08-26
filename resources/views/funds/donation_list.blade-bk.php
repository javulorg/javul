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
            <?php $title = 'Activity Log'; ?>
            @include('layout.v2.global-activity-log', ['title' => $title, 'unit' => $unitData->id])
            @include('layout.v2.global-finances')
            @include('layout.v2.global-about-site')
        @else
            <?php $title = 'Global Activity Log'; ?>
            @include('layout.v2.global-activity-log', ['title' => $title])
        @endif
    </div>

    <div class="main_content">
        <div class="content_block">
            <div class="table_block table_block_issues">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <i class="fa fa-history" aria-hidden="true"></i>
                    </div>
                    Donation History
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                <div class="table_block_body">
                    <table>
                        <thead>
                            <tr>
                                <th class="type_col">User Name</th>
                                <th class="title_col">Transaction ID</th>
                                <th class="type_col">Amount</th>
                                <th class="title_col">Donated For</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction as $txn)
                            <tr>
                                <td class="type_col">
                                    <a href="{!! url('userprofiles/'.$userIDHashID->encode($txn->user_id)) !!}">
                                        {{ $txn->donated_by }}
                                    </a>
                                </td>

                                <td class="type_col">
                                    {{ $txn->transaction_id }}
                                </td>

                                <td class="type_col">
                                    {{ $txn->amount ?? '-' }}
                                </td>

                                <td class="type_col">
    @if($txn->unit_id > 0)
        <strong>Unit:</strong> {{ $txn->unit_name }}<br>
    @endif
    @if($txn->task_id > 0)
        <strong>Task:</strong> {{ $txn->task_name }}<br>
    @endif
    @if($txn->idea_id > 0)
        <strong>Idea:</strong> {{ $txn->idea_title }}<br>
    @endif
    @if($txn->issues_id > 0)
        <strong>Issue:</strong> {{ $txn->issue_title }}<br>
    @endif
    @if($txn->objective_id > 0)
        <strong>Objective:</strong> {{ $txn->objective_title }}<br>
    @endif
</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="content_block_bottom"></div>

                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left"></div>
                    <div class="pagination-right"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
