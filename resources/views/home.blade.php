@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row form-group">
            @include('elements.user-menu',array('page'=>'home'))
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <h2><strong>Objective: Change the World</strong></h2>
                <div>Explore projects, everywhere</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_units') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Unit 1</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Unit 2</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Unit 3</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Unit 4</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Unit 5</a>
                            </div>
                        </div>
                        <button class="btn orange-bg">{!! Lang::get('messages.all_units') !!}</button>
                        <button class="btn orange-bg">{!! Lang::get('messages.create_units') !!}</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_objective') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Objective 1</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Objective 2</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Objective 3</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Objective 4</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Objective 5</a>
                            </div>
                        </div>
                        <button class="btn orange-bg">{!! Lang::get('messages.all_objectives') !!}</button>
                        <button class="btn orange-bg">{!! Lang::get('messages.create_objectives') !!}</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_tasks') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Task 1</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Task 2</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Task 3</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Task 4</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-dot"></span> Task 5</a>
                            </div>
                        </div>
                        <button class="btn orange-bg">{!! Lang::get('messages.all_tasks') !!}</button>
                        <button class="btn orange-bg">{!! Lang::get('messages.create_tasks') !!}</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-dark-grey panel-default">
                    <div class="panel-heading">
                        <h4>{!! Lang::get('messages.most_recent_users') !!}</h4>
                    </div>
                    <div class="panel-body list-group">
                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> User 1</a>
                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> User 2</a>
                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> User 3</a>
                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> User 4</a>
                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> User 5</a>
                    </div>
                </div>
                <div class="panel panel-dark-grey panel-default">
                    <div class="panel-heading">
                        <h4>{!! Lang::get('messages.activity_log') !!}</h4>
                    </div>
                    <div class="panel-body list-group">
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Objective 1 Created by User 3
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Objective 3 edited by User 4
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Task 1 edited(Objective 1)
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Task 2 created(Objective 1)
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Task 3 assigned to User 1 (Objective 1)
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Objective 1 Created by User 3
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Objective 3 edited by User 4
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Task 1 edited(Objective 1)
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Task 2 created(Objective 1)
                        </a>
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-ok"></span>
                            Objective 3 edited by User 4
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.footer')
@endsection