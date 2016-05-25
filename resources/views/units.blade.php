@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row form-group">
            @include('elements.user-menu',array('page'=>'units'))
            <div class="col-sm-12 grey-bg">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><span class="glyphicon glyphicon-list-alt"></span> Women's rights</h1><br /><br />
                        <p><span class="glyphicon glyphicon-map-marker"> </span> &nbsp;Afghanistan</p>
                        <p><span class="glyphicon glyphicon-paperclip"> </span> &nbsp; Non-profit > Human welfare</p>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-offset-5 col-sm-7">
                                <div class="panel form-group marginTop20">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <strong>Unit's Funds:</strong>
                                            </div>
                                            <div class="col-xs-6">Available:</div>
                                            <div class="col-xs-6 text-right">5,000 $</div>
                                            <div class="col-xs-6">Awarded:</div>
                                            <div class="col-xs-6 text-right">750 $</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <strong>Unit Links:</strong>
                                            </div>
                                            <div class="col-xs-7 text-right">
                                                <a href="#">Forum</a> | <a href="#">Wiki</a>
                                            </div>
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
                        <h4>Objectives</h4>
                    </div>
                    <div class="panel-body table-inner table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Importance</th>
                                    <th>Date Created</th>
                                    <th>Title</th>
                                    <th>Task Statistics</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Available</th>
                                    <th>In-progress</th>
                                    <th>Completed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>6.5/10</td>
                                    <td>3 days ago</td>
                                    <td>Objective number 1</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>6.5/10</td>
                                    <td>3 days ago</td>
                                    <td>Objective number 1</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>6.5/10</td>
                                    <td>3 days ago</td>
                                    <td>Objective number 1</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn orange-bg" id="add_objective_btn" type="button"><span class="glyphicon glyphicon-plus"></span> Add Objective</button>
                <button class="btn orange-bg" id="see_all_objective_btn" type="button">See all Objectives</button>
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