<?php if(!$ajax): ?>
    <div class="panel panel-grey panel-default">
        <div class="panel-heading loading_content_hide">
            <h4><?php echo e($site_activity_text); ?></h4>
        </div>
        <div class="panel-body list-group loading_content_hide">
            <?php if(count($site_activity) > 0): ?>
                <?php
                    $timezone = 'UTC';
                    if(!empty(\Auth::user()->timezone))
                        $timezone = \Auth::user()->timezone;
                ?>
                <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    /*if(!empty(\Auth::user()->timezone)){
                        $tz = new DateTimeZone(\Auth::user()->timezone);
                        $date = new DateTime($activity->created_at);
                        $date->setTimezone($tz);
                        $activity->created_at = $date->format('Y-m-d H:i:s');
                    }else
                        $activity->created_at = date('Y-m-d H:i:s',strtotime($activity->created_at));*/
                    ?>
                    <div class="list-group-item" style="padding: 0px;padding-bottom:4px">
                        <div class="row" style="padding: 7px 15px">
                            <div class="col-xs-12" style="display: table">
                                <div style="display:table-row">
                                    <div class="div-table-first-cell" data-id="<?php echo e($activity->id); ?>">
                                        <span class="tooltipster" title='<?php echo $activity->created_at->timezone($timezone)->format('Y-m-d H:i:s'); ?>'><?php echo \App\Library\Helpers::timetostr($activity->created_at->timezone($timezone)->format('Y-m-d H:i:s')); ?></span>
                                    </div>
                                    <div class="div-table-second-cell">
                                        <div class="circle activity-refresh">
                                            <i class="fa fa-refresh"></i>
                                        </div>
                                    </div>
                                    <div class="div-table-third-cell">
                                        <?php echo $activity->comment; ?>


                                    </div>
                                    <div class="border-main child_<?php echo e($index); ?>">
                                        <?php if($index == count($site_activity) - 1): ?>
                                            <div class="hide-last-border"></div>
                                            <div class="last-site-activity"></div>
                                        <?php elseif($index == 0): ?>
                                            <div></div>
                                            <div class="first-site-activity"></div>
                                        <?php else: ?>
                                            <div></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-item-main child_<?php echo e($index); ?>"></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($site_activity->lastPage() > 1 && $site_activity->lastPage() != $site_activity->currentPage()): ?>
                    <div class="list-group-item text-right more-btn">
                        <a href="#"class="btn black-btn <?php if($site_activity_text == 'Global Activity Log'): ?> more_site_activity_btn
                    <?php else: ?> more_unit_site_activity_btn <?php endif; ?>"
                           data-url="<?php echo e($site_activity->url($site_activity->currentPage()+1)); ?>" <?php if($site_activity_text == 'Unit Activity Log'): ?>
                           data-unit_id="<?php echo e($unitIDHashID->encode($unit_activity_id)); ?>" <?php endif; ?>
                           type="button">MORE ACTIVITY <span class="more_dots">...</span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="list-group-item">
                    No activity found.
                </div>
            <?php endif; ?>
        </div>

    </div>
<?php else: ?>
    <?php $i=(\Config::get('app.site_activity_page_limit')*$site_activity->currentPage() - \Config::get('app.site_activity_page_limit')) + 1;?>
    <?php if(count($site_activity) > 0): ?>
        <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="list-group-item" style="padding: 0px;padding-bottom:4px">
                <div class="row" style="padding: 7px 15px">
                    <div class="col-xs-12" style="display: table">
                        <div style="display:table-row">
                            <div class="div-table-first-cell">
                                <span class="tooltipster" title='<?php echo ($activity->created_at); ?>'><?php echo \App\Library\Helpers::timetostr($activity->created_at); ?></span>
                            </div>
                            <div class="div-table-second-cell">
                                <div class="circle activity-refresh">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <div class="div-table-third-cell">
                                <?php echo $activity->comment; ?>


                            </div>
                            <div class="border-main child_<?php echo e($i); ?>">
                                <div></div>
                                <?php if($index == count($site_activity) - 1): ?>
                                    <div class="last-site-activity"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-item-main child_<?php echo e($i); ?>"></div>
            </div>
            <?php $i++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($site_activity->lastPage() > 1 && $site_activity->lastPage() != $site_activity->currentPage()): ?>
            <div class="list-group-item text-right more-btn">
                <a href="#"class="btn black-btn <?php if($site_activity_text == 'Global Activity Log'): ?> more_site_activity_btn
                    <?php else: ?> more_unit_site_activity_btn <?php endif; ?>"
                   data-url="<?php echo e($site_activity->url($site_activity->currentPage()+1)); ?>" <?php if($site_activity_text == 'Unit Activity Log'): ?>
                   data-unit_id="<?php echo e($unitIDHashID->encode($unit_activity_id)); ?>" <?php else: ?> data-from_page="global" <?php endif; ?>
                   type="button">MORE ACTIVITY <span class="more_dots">...</span>
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="list-group-item">
            No activity found.
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/elements/site_activities.blade.php ENDPATH**/ ?>