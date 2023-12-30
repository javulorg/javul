@extends('layout.master')
@section('title', 'Update Objective')
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

        <div class="panel panel-grey panel-default">
            <div class="panel-heading">
                <h4>Update Objective</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" action="{{ url('objectives/'. $objectiveId) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <input type="hidden" name="unit" value="{{ $unitIDHashID->encode($unitData->id) }}">

                            <div class="col-md-12 form-group">
                                <label class="control-label">Objective Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="objective_name"
                                           value="{{ (!empty($objectiveObj))? $objectiveObj->name : old('objective_name') }}"
                                           class="form-control"
                                           placeholder="Objective Name" required/>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Parent objective</label>
                                <div class="input-icon right">
                                    <select class="form-control selectpicker" data-live-search="true" name="parent_objective" id="parent_objective">
                                        <option value="">{!! trans('messages.select') !!}</option>
                                        @if(count($parentObjectivesObj) > 0)
                                            @foreach($parentObjectivesObj as $objective_id=>$parentObjective)
                                                <option value="{{$objectiveIDHashID->encode($objective_id)}}" @if(!empty($objectiveObj) &&
                                                                $objectiveObj->parent_id == $objective_id) selected=selected @endif>{{$parentObjective}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control selectpicker" data-live-search="true" name="status">
                                    @foreach(\App\Models\Objective::objectiveStatus() as $index=>$status)
                                        <option value="{{$index}}"
                                                @if(!empty($objectiveObj) && $objectiveObj->status == $index) selected=selected
                                                @elseif(empty($objectiveObj) && $index != "in-progress") disabled="disabled" @endif>
                                            {{$status}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Objective Description</label>
                                <textarea class="form-control" id="objective_description" name="description">
                                    @if(!empty($objectiveObj)) {{$objectiveObj->description}} @endif
                                </textarea>
                            </div>


                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Comment</label>
                                <input class="form-control" type="text" value="{{ $objectiveObj->comment }}" name="comment">
                            </div>

                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update Objective</span>
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
        $('#objective_description').summernote({
            tabsize: 1,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
