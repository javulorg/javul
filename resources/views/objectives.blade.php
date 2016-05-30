@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row">
            @include('elements.user-menu',['page'=>'objectives'])
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="col-md-6 grey-bg unit_description">
                    <h1 class="unit-heading"><span class="glyphicon glyphicon-list-alt"></span> Title of sample Objective</h1>
                    <div class="form-group">
                        Objective Summary: Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book.
                    </div>
                    <div>
                        <button class="btn orange-bg" id="edit_object"><span class="glyphicon glyphicon-pencil"></span> &nbsp;
                            {!! trans('messages.edit_objective') !!}</button>
                    </div>

                </div>
                <div class="col-md-6 grey-bg unit_description">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="panel form-group marginTop20">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_funds') !!}</strong>
                                        </div>
                                        <div class="col-xs-6">{!! trans('messages.available') !!}</div>
                                        <div class="col-xs-6 text-right">400 $</div>
                                        <div class="col-xs-6">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-6 text-right">100 $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_funds_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="panel form-group marginTop20">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_information') !!}</strong>
                                        </div>
                                        <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                                        <div class="col-xs-7 text-right">Woman's Rights</div>
                                        <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                                        <div class="col-xs-7 text-right">Non-profit-Human-welfare</div>
                                        <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                                        <div class="col-xs-7 text-right">Available 5000 $</div>
                                        <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-7 text-right">750 $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_unit_fund_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="panel panel-default panel-dark-grey">
                    <div class="panel-heading">
                        <h4>Tasks</h4>
                    </div>
                    <div class="panel-body table-inner table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Date Created</th>
                                <th>Title</th>
                                <th>Objective</th>
                                <th>Status</th>
                                <th>Award</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2 weeks ago</td>
                                <td>Task number 1</td>
                                <td>Title of Objective for this task</td>
                                <td>Assigned to User 1</td>
                                <td>$ 10</td>
                            </tr>
                            <tr>
                                <td>2 weeks ago</td>
                                <td>Task number 1</td>
                                <td>Title of Objective for this task</td>
                                <td>Assigned to User 1</td>
                                <td>$ 10</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn orange-bg" type="button" id="add_task_btn"><span class="glyphicon glyphicon-plus"></span> Add Tasks</button>
                <button class="btn orange-bg" type="button" id="see_all_task_btn">See all Tasks</button>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-6 col-xs-12">
                <div class="panel panel-default panel-dark-grey">
                    <div class="panel-heading">
                        <h4>Activity Log</h4>
                    </div>
                    <div class="panel-body table-inner table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Objective 1 created by User 3</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Objective 3 edited by User 4</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Task 1 edited(Objective 1)</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Task 2 edited(Objective 1)</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Task 3 assigned to User 1(Objective 1)</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;Task 4 completed by User 2</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-ok"></span> &nbsp;500 $ was donated to Unit's funds 6 days ago.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('elements.footer')
@endsection