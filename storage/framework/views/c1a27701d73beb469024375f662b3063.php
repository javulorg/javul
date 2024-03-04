<footer>
    <div class="statistics">
        <div class="container">
            <div class="col-sm-4" style="position:relative;top:14px">
                <div class="units square">
                    <div class="label_footer">Units</div>
                    <div class="value"><?php echo e($totalUnits); ?></div>
                </div>
                <div class="objectives square">
                    <div class="label_footer">Objectives</div>
                    <div class="value"><?php echo e($totalObjectives); ?></div>
                </div>
                <div class="tasks square">
                    <div class="label_footer">Tasks</div>
                    <div class="value"><?php echo e($totalTasks); ?></div>
                </div>
                <div class="issues square">
                    <div class="label_footer">Issues</div>
                    <div class="value"><?php echo e($totalIssues); ?></div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.user_registered'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue"><?php echo e($totalRegisteredUsers); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.wiki_edits'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">0</div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.logged_in'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue"><?php echo e($totalLoggedinUsers); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.funds_available'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">
                                <?php if(env('PAYMENT_METHOD') == "Zcash"): ?>
                                    <img src="<?php echo url('assets/images'); ?>/small-zcash-icon.png" style="width:20px;" /> <?php echo e(number_format($totalFundsAvailable,8)); ?>

                                <?php else: ?>
                                    <i class="fa fa-dollar"></i> <?php echo e(number_format($totalFundsAvailable,2)); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.forum_threads'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">0</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.fund_awarded'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">0</div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6"><?php echo trans('messages.forum_posts'); ?></div>
                            <div class="col-sm-6 col-xs-6 text-right colorLightBlue">0</div>
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
                            <?php if(!empty($authUserObj)): ?>
                                <li class="is_logged_in"><a href="<?php echo url('site_admin'); ?>" class="colorLightBlue">SITE ADMINISTRATION</a></li>
                                <li class="mrgrtlt5">|</li>
                            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\javul\resources\views/elements/footer.blade.php ENDPATH**/ ?>