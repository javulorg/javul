{{--@extends('layout.master')--}}
{{--@section('title', 'My Watchlist')--}}
{{--@section('content')--}}
{{--    <div class="row">--}}
{{--        <div class="col-sm-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>{{ __('messages.units') }}</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body table-responsive">--}}
{{--                    <table class="table table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>{{ __('messages.unit_name') }}</th>--}}
{{--                            <th>{{ __('messages.unit_category') }}</th>--}}
{{--                            <th>{{ __('messages.description') }}</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(count($watchedUnits) > 0 )--}}
{{--                            @foreach($watchedUnits as $unit)--}}
{{--                                @php--}}
{{--                                    $category_ids = $unit->category_id;--}}
{{--                                    $category_names = $unit->category_name;--}}
{{--                                    $category_ids = explode(",", $category_ids);--}}
{{--                                    $category_names = explode(",", $category_names);--}}
{{--                                @endphp--}}
{{--                                <tr>--}}
{{--                                    <td><a href="{{ url('units/' . $unitIDHashID->encode($unit->id) . '/' . $unit->slug) }}">{{ $unit->name }}</a></td>--}}
{{--                                    <td>--}}
{{--                                        @if(count($category_ids) > 0 )--}}
{{--                                            @foreach($category_ids as $index => $category)--}}
{{--                                                <a href="{{ url('units/category/' . $unitCategoryIDHashID->encode($category)) }}">{{ \App\Models\UnitCategory::getName($category) }}</a>--}}
{{--                                                @if(count($category_ids) > 1 && $index != count($category_ids) -1)--}}
{{--                                                    <span class="mx-1">&#44;</span>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-inline-block text-wrap" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trim($unit->description) }}">--}}
{{--                                            <span class="ellipsis-text">{{ trim($unit->description) }}</span>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="remove-from-watchlist text-danger" data-id="{{ $unitIDHashID->encode($unit->id) }}" data-type="unit">--}}
{{--                                            <span><i class="fa fa-trash" aria-hidden="true"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr>--}}
{{--                                <td colspan="4">No record(s) found.</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-sm-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>{{ __('messages.objectives') }}</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body table-responsive">--}}
{{--                    <table class="table table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Objective Name</th>--}}
{{--                            <th>{{ __('messages.description') }}</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(count($watchedObjectives) > 0)--}}
{{--                            @foreach($watchedObjectives as $objective)--}}
{{--                                <tr>--}}
{{--                                    <td><a href="{{ url('objectives/' . $objectiveIDHashID->encode($objective->id) . '/' . $objective->slug) }}">{{ $objective->name }}</a></td>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-inline-block text-wrap" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trim($objective->description) }}">--}}
{{--                                            <span class="ellipsis-text">{{ trim($objective->description) }}</span>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="remove-from-watchlist text-danger" data-id="{{ $objectiveIDHashID->encode($objective->id) }}" data-type="objective">--}}
{{--                                            <span><i class="fa fa-trash" aria-hidden="true"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr>--}}
{{--                                <td colspan="4">No record(s) found.</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row mt-5 mb-5">--}}
{{--        <div class="col-sm-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Tasks</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body table-responsive">--}}
{{--                    <table class="table table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Task Name</th>--}}
{{--                            <th>Description</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(count($watchedTasks) > 0 )--}}
{{--                            @foreach($watchedTasks as $task)--}}
{{--                                <tr>--}}
{{--                                    <td><a href="{{ url('tasks/'.$taskIDHashID->encode($task->id).'/'.$task->slug) }}">{{ $task->name }}</a></td>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-inline-block text-wrap" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trim($task->description) }}">--}}
{{--                                            <span class="ellipsis-text">{{ trim($task->description) }}</span>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="remove-from-watchlist text-danger" data-id="{{ $taskIDHashID->encode($task->id) }}" data-type="task">--}}
{{--                                            <span><i class="fa fa-trash" aria-hidden="true"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr>--}}
{{--                                <td colspan="3">No record(s) found.</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-sm-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Issues</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body table-responsive">--}}
{{--                    <table class="table table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Issue Name</th>--}}
{{--                            <th>Issue Category</th>--}}
{{--                            <th>Description</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(count($watchedIssues) > 0 )--}}
{{--                            @foreach($watchedIssues as $issue)--}}
{{--                                @php--}}
{{--                                    $category_ids = $issue->category_id;--}}
{{--                                    $category_names = $issue->category_name;--}}
{{--                                    $category_ids = explode(",", $category_ids);--}}
{{--                                    $category_names = explode(",", $category_names);--}}
{{--                                @endphp--}}
{{--                                <tr>--}}
{{--                                    <td><a href="{{ url('issues/'.$issueIDHashID->encode($issue->id).'/'.$issue->slug.'view') }}">{{ $issue->title }}</a></td>--}}
{{--                                    <td>--}}
{{--                                        @if(count($category_ids) > 0 )--}}
{{--                                            @foreach($category_ids as $index => $category)--}}
{{--                                                <a href="{{ url('issue/category/'.$issueDocumentIDHashID->encode($category)) }}">{{ \App\IssueDocument::getName($category) }}</a>--}}
{{--                                                @if(count($category_ids) > 1 && $index != count($category_ids) -1)--}}
{{--                                                    <span class="mx-1">&#44;</span>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-inline-block text-wrap" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trim($issue->description) }}">--}}
{{--                                            <span class="ellipsis-text">{{ trim($issue->description) }}</span>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="remove-from-watchlist text-danger" data-id="{{ $issueIDHashID->encode($issue->id) }}" data-type="issue">--}}
{{--                                            <span><i class="fa fa-trash" aria-hidden="true"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr>--}}
{{--                                <td colspan="4">No record(s) found.</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}









@extends('layout.master')
@section('title', 'My Watchlist')
@section('style')
    <style>
    </style>
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">

            <?php
            $title = 'Activity Log';
            ?>
            @include('layout.v2.global-activity-log',['title' => $title])
        </div>

        <div class="main_content">
            <h2>Watch List</h2>
            <div class="content_block">

                @include('users.watchlist-partials.units')

                @include('users.watchlist-partials.objectives')

                @include('users.watchlist-partials.tasks')

                @include('users.watchlist-partials.issues')

            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function ()
        {
            $('#watchlist-units-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '{{ url("api/watchlist-units/index") }}'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "unit_category",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });


            $('#watchlist-objectives-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '{{ url("api/watchlist-objectives/index") }}'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });

            $('#watchlist-tasks-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '{{ url("api/watchlist-tasks/index") }}'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });

            $('#watchlist-issues-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '{{ url("api/watchlist-issues/index") }}'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });
        });
    </script>
@endsection

