<footer>
    <div class="statistics">
        <div class="container">
            <div class="col-sm-4" style="position:relative;top:14px">
                <div class="units square">
                    <div class="label_footer">Units</div>
                    <div class="value">{{$totalUnits}}</div>
                </div>
                <div class="objectives square">
                    <div class="label_footer">Objectives</div>
                    <div class="value">{{$totalObjectives}}</div>
                </div>
                <div class="tasks square">
                    <div class="label_footer">Tasks</div>
                    <div class="value">{{$totalTasks}}</div>
                </div>
                <div class="issues square">
                    <div class="label_footer">Issues</div>
                    <div class="value">{{$totalIssues}}</div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.user_registered') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">{{$totalRegisteredUsers}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.wiki_edits') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">12221</div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.logged_in') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">{{$totalLoggedinUsers}}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.funds_available') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">{{ $totalFundsAvailable }}</div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.forum_threads') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">123</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.fund_awarded') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">12343</div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">{!! trans('messages.forum_posts') !!}</div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">833</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="details">
        <div class="container">
            <div class="row form-group">
                <div class="col-sm-12 text-center">
                    <div id="footer-nav">
                        <ul>
                            @if(!empty($authUserObj))
                                <li><a href="{!! url('site_admin') !!}" class="colorLightBlue">SITE ADMINISTRATION</a></li>
                                <li class="mrgrtlt5">|</li>
                            @endif
                            <li><a href="#" class="colorLightBlue">TERMS OF SERVICE</a></li>
                            <li class="mrgrtlt5">|</li>
                            <li><a href="#" class="colorLightBlue">DISCLAIMER</a></li>
                            <li class="mrgrtlt5">|</li>
                            <li><a href="#" class="colorLightBlue report">REPORT A CONCERN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>