@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row form-group">
            @include('elements.user-menu',array('page'=>'tasks'))
            <div class="col-xs-12 grey-bg">
                <h2><span class="glyphicon glyphicon-edit"></span> &nbsp; <strong>Title of a sample Task</strong></h2>
                <div class="form-group">
                    <button class="btn orange-bg" id="edit_task"><span class="glyphicon glyphicon-pencil"></span> &nbsp; Edit Task</button>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <strong>Unit Information:<span class="caret"></span> </strong>
                            </div>
                            <div class="col-xs-5">Unit name:</div>
                            <div class="col-xs-7 text-right">Women's Rights</div>
                            <div class="col-xs-5">Type:</div>
                            <div class="col-xs-7 text-right">Non-profit-Human-welfare</div>
                            <div class="col-xs-5">Funds:</div>
                            <div class="col-xs-7 text-right">Availabe: 5000$</div>
                            <div class="col-xs-5">Awarded:</div>
                            <div class="col-xs-7 text-right">750$</div>
                            <div class="col-xs-12 text-right">
                                <button class="btn orange-bg btn-sm" id="add_funds">Add funds</button>
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
                        <h4 class="text-orange">OBJECTIVE:</h4>
                        <div>Title of objectives which task belong to</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">TASK STATUS:</h4>
                        <div>Unassigned/assigned to user X/Completed</div>
                        <div>Completed On: date 23/05/2016</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">TASK AWARD:</h4>
                        <div>40 $</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">TASK SUMMARY:</h4>
                        <div>Task summary</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">LONG DESCRIPTION:</h4>
                        <div>Text of long description</div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    @include('elements.footer')
@endsection