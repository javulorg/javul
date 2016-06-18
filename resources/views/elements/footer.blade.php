<footer>
    <hr />
    <div class="container">
        <div class="row form-group">
            <div class="col-sm-4 text-center">
                <h1>{{number_format($totalUnits)}}</h1>
                <strong class="text-orange">{!! strtoupper(trans('messages.units')) !!}</strong>
            </div>
            <div class="col-sm-4 text-center">
                <h1>{{number_format($totalObjectives)}}</h1>
                <strong class="text-orange">{!! strtoupper(trans('messages.objectives')) !!}</strong>
            </div>
            <div class="col-sm-4 text-center">
                <h1>{{number_format($totalTasks)}}</h1>
                <strong class="text-orange">{!! strtoupper(trans('messages.tasks')) !!}</strong>
            </div>
        </div>
    </div>
    <div class="statistics">
        <div class="container">
            <div class="row form-group">
                <div class="col-sm-12 text-center"><h4>{!! trans('messages.statistics') !!}</h4></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.user_registered') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">{{$totalRegisteredUsers}}</span></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.logged_in') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">{{$totalLoggedinUsers}}</span></div>
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.forum_threads') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">123</span></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.forum_posts') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">833</span></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.wiki_edits') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">21231</span></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-xs-8 form-group">{!! trans('messages.funds_available') !!}</div>
                        <div class="col-xs-4 form-group text-right"><span class="badge">43612</span></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-8">{!! trans('messages.fund_awarded') !!}</div>
                        <div class="col-xs-4 text-right"><span class="badge">12343</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>