<div class="panel-grey panel-default">
    <div class="panel-heading loading_content_hide">
        <h4>ACTIVITY LOG </h4>
    </div>
    <div class="panel-body list-group loading_content_hide">
        <?php if(count($site_activity) > 0): ?>
            <?php
            $timezone = 'UTC';
            if(!empty(\Auth::user()->timezone))
                $timezone = \Auth::user()->timezone;
            ?>
            <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item" style="padding: 0px;padding-bottom:4px">
                    <div class="row" style="padding: 7px 15px">
                        <div class="col-xs-12" style="display: table">
                            <div style="display:table-row">
                                <div class="div-table-first-cell">
                                    <span class="tooltipster" title='<?php echo $activity->created_at->timezone($timezone)->format('Y-m-d H:i:s'); ?>'><?php echo \App\Library\Helpers::timetostr($activity->created_at->timezone($timezone)); ?></span>
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
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-item-main child_<?php echo e($index); ?>"></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="list-group-item">
                No activity found.
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/elements/site_activities_user.blade.php ENDPATH**/ ?>