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
                        <?php echo e($totalUnits); ?>

                    </div>
                </div>
                <div class="statistic_block statistic_block_blue">
                    <div class="statistic_block_top">
                        Objectives
                    </div>
                    <div class="statistic_block_bottom">
                        <?php echo e($totalObjectives); ?>

                    </div>
                </div>
                <div class="statistic_block statistic_block_green">
                    <div class="statistic_block_top">
                        Tasks
                    </div>
                    <div class="statistic_block_bottom">
                        <?php echo e($totalTasks); ?>

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
                        <?php echo e($totalIssues); ?>

                    </div>
                </div>
            </div>
            <div class="statistic_center">
                <div class="statistic_row">
                    <div class="statistic_param">
                        <?php echo trans('messages.user_registered'); ?> :
                    </div>
                    <div class="statistic_val">
                        <?php echo e($totalRegisteredUsers); ?>

                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        <?php echo trans('messages.logged_in'); ?> :
                    </div>
                    <div class="statistic_val">
                        <?php echo e($totalLoggedinUsers); ?>

                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        <?php echo trans('messages.forum_threads'); ?> :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
                <div class="statistic_row">
                    <div class="statistic_param">
                        <?php echo trans('messages.forum_posts'); ?> :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
            </div>
            <div class="statistic_right">
                <div class="statistic_row">
                    <div class="statistic_param">
                        <?php echo trans('messages.wiki_edits'); ?> :
                    </div>
                    <div class="statistic_val">
                        0
                    </div>
                </div>
                <div>
                    <div class="statistic_row statistic_row_dollar">
                        <div class="statistic_param">
                            <?php echo trans('messages.funds_available'); ?> :
                        </div>
                        <div class="statistic_val">
                            <?php if(env('PAYMENT_METHOD') == "Zcash"): ?>
                                <img src="<?php echo url('assets/images/small-zcash-icon.png'); ?>" style="width:20px;" /> <?php echo e(number_format($totalFundsAvailable,8)); ?>

                            <?php else: ?>
                                <i class="fa fa-dollar"></i> <?php echo e(number_format($totalFundsAvailable,2)); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="statistic_row statistic_row_dollar">
                        <div class="statistic_param">
                            <?php echo trans('messages.fund_awarded'); ?> :
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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/site-statistic.blade.php ENDPATH**/ ?>