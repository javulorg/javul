{{-- resources/views/funds/activities.blade.php --}}
@extends('layout.master')

@section('title', 'Finance Activities')

@section('site-name')
@section('navbar')

@include('layout.navbar', ['unitData' => $unitData])

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
                    Fund Activities
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                <div class="table_block_body">
                    <table class="">
                        <thead>
                            <tr>
                                <th class="title_col">Activity</th>
                                <th class="type_col">Amount</th>
                                <th class="type_col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>
                                <td class="title_col">{{ $activity->comments }}</td>
                                <td class="type_col">${{ number_format($activity->amount, 2) }}</td>
                                <td class="type_col">{{ $activity->created_at->format('Y-m-d H:i') }}</td>
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