@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row">
            @include('elements.user-menu',['page'=>'tasks'])
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="col-sm-12 grey-bg unit_description">
                    <h2 class="unit-heading"><span class="glyphicon glyphicon-edit"></span> &nbsp; <strong>Title of a sample Task</strong></h2>
                    <div class="form-group">
                        <button class="btn orange-bg" id="edit_task"><span class="glyphicon glyphicon-pencil"></span> &nbsp;
                            {!! trans('messages.edit_task') !!}</button>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong>{!! trans('messages.unit_information') !!}<span class="caret"></span> </strong>
                                </div>
                                <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                                <div class="col-xs-7 text-right">Women's Rights</div>
                                <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                                <div class="col-xs-7 text-right">Non-profit-Human-welfare</div>
                                <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                                <div class="col-xs-7 text-right">{!! trans('messages.available') !!}: 5000$</div>
                                <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                                <div class="col-xs-7 text-right">750$</div>
                                <div class="col-xs-12 text-right">
                                    <button class="btn orange-bg btn-sm" id="add_funds">{!! trans('messages.add_funds') !!}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="list-group">
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.objective')) !!}</h4>
                        <div>Title of objectives which task belong to</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_status')) !!}</h4>
                        <div>Unassigned/assigned to user X/Completed</div>
                        <div>Completed On: date 23/05/2016</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_award')) !!}</h4>
                        <div>40 $</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_summary')) !!}</h4>
                        <div>Task summary</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.long_description')) !!}</h4>
                        <div>Text of long description</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('elements.footer')
@endsection