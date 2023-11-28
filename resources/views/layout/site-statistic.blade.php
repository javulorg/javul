<div class="site_statistic_head">
    <div class="container text-center">
        Global Site Statistics
    </div>
</div>
<div class="site_statistic_body">
    <div class="container">
        <div class="site_statistic_body_container">
            <div class="statistic_blocks">
                <div class="statistic_block statistic_block_purple">
                    <div class="statistic_block_top">
                        Units
                    </div>
                    <div class="statistic_block_bottom">
                        {{$totalUnits}}
                    </div>
                </div>
                <div class="statistic_block statistic_block_blue">
                    <div class="statistic_block_top">
                        Objectives
                    </div>
                    <div class="statistic_block_bottom">
                        {{ $totalObjectives}}
                    </div>
                </div>
                <div class="statistic_block statistic_block_green">
                    <div class="statistic_block_top">
                        Tasks
                    </div>
                    <div class="statistic_block_bottom">
                        {{$totalTasks}}
                    </div>
                </div>
                <div class="statistic_block statistic_block_orange">
                    <div class="statistic_block_top">
                        Ideas
                    </div>
                    <div class="statistic_block_bottom">
                        115
                    </div>
                </div>
                <div class="statistic_block statistic_block_red">
                    <div class="statistic_block_top">
                        Issues
                    </div>
                    <div class="statistic_block_bottom">
                        {{$totalIssues}}
                    </div>
                </div>
            </div>
            <div class="statistic_center">
                <div class="statistic_row">
                    <div class="statistic_param">
                        {!! trans('messages.user_registered') !!} :
                    </div>
                    <div class="statistic_val">
                        {{$totalRegisteredUsers}}
                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        {!! trans('messages.logged_in') !!} :
                    </div>
                    <div class="statistic_val">
                        {{$totalLoggedinUsers}}
                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        {!! trans('messages.forum_threads') !!} :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        {!! trans('messages.forum_posts') !!} :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
            </div>
            <div class="statistic_right">
                <div class="statistic_row">
                    <div class="statistic_param">
                        {!! trans('messages.wiki_edits') !!} :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
                <div>
                    <div class="statistic_row statistic_row_dollar">
                        <div class="statistic_param">
                            {!! trans('messages.funds_available') !!} :
                        </div>
                        <div class="statistic_val">
                            @if(env('PAYMENT_METHOD') == "Zcash")
                                <img src="{!! url('assets/images/small-zcash-icon.png') !!}" style="width:20px;" /> {{ number_format($totalFundsAvailable,8) }}
                            @else
                                <i class="fa fa-dollar"></i> {{ number_format($totalFundsAvailable,2) }}
                            @endif
                        </div>
                    </div>
                    <div class="statistic_row statistic_row_dollar">
                        <div class="statistic_param">
                            {!! trans('messages.fund_awarded') !!} :
                        </div>
                        <div class="statistic_val">
                            0
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
