@extends('layout.master')
@section('title', 'Create Idea')

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

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Create Idea</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post"  action="{{ url('ideas') }}">
                        @csrf
                        @method('post')
                        <div class="row">

                            <input type="hidden" name="unit_id" value="{{ $unitData->id }}">

                            <div class="col-md-12 form-group">
                                <label class="control-label">Idea Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="title" class="form-control" placeholder="Idea Name"/>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Type</label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="category_id" id="category_id">
                                        <option value="">{!! trans('messages.select') !!}</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->title  }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Task</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="task_id" id="task_id">
                                        <option value="">{!! trans('messages.select') !!}</option>
                                            @foreach($tasks as $task)
                                                <option value="{{ $task->id }}">{{ $task->name  }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Issue</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="issue_id" id="issue_id">
                                        <option value="">{!! trans('messages.select') !!}</option>
                                            @foreach($issues as $issue)
                                                <option value="{{ $issue->id }}">{{ $issue->title  }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="description" name="description">
                                </textarea>
                            </div>


                            <div class="col-sm-12 mt-3 form-group">
                                <input class="form-control" type="file" name="file">
                            </div>



                        </div>


                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create Idea</span>
                                </button>
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
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
