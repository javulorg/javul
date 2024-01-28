<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        Unit Overview
        <div class="arrow">
            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Type:
            </div>
            <div class="sidebar_block_right">
                <?php if(isset($unitObj) && $unitObj->unit_type == 0 ): ?>
                    Product
                <?php elseif(isset($unitObj) && $unitObj->unit_type == 1): ?>
                    Service
                <?php else: ?>
                    People’s Government
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($unitObj) && ( $unitObj->unit_type == 0 || $unitObj->unit_type == 1) ): ?>
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Product Name:
                </div>
                <div class="sidebar_block_right">
                   <?php echo e($unitObj->product_name); ?>

                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Service Name:
                </div>
                <div class="sidebar_block_right">
                    <?php echo e($unitObj->service_name); ?>

                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Business Model:
                </div>
                <div class="sidebar_block_right">
                    <?php if($unitObj->business_model == 0): ?>
                        Community-owned
                    <?php else: ?>
                        Corporate
                    <?php endif; ?>
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Operational Grade:
                </div>
                <div class="sidebar_block_right">
                    <?php echo e($unitObj->operational_grade); ?> <img src="<?php echo e(asset('v2/assets/img/question.svg')); ?>" alt="" class="question">
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                   Company :
                </div>
                <div class="sidebar_block_right">
                    <?php echo e($unitObj->company); ?>

                </div>
            </div>
        <?php elseif(isset($unitObj) && ($unitObj->unit_type == 2)): ?>
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">
                    <?php if($unitObj->scope == 0): ?>
                        City
                    <?php elseif($unitObj->scope == 1): ?>
                        County
                    <?php elseif($unitObj->scope == 2): ?>
                        State
                    <?php elseif($unitObj->scope == 3): ?>
                        National
                    <?php elseif($unitObj->scope == 4): ?>
                        International
                    <?php else: ?>
                    <?php endif; ?>
                    
                </div>
            </div>
        <?php else: ?>
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">

                </div>
            </div>
        <?php endif; ?>





        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Issue Resolution:
            </div>
            <div class="sidebar_block_right">
                <div class="blue_progress"></div> <?php echo e($totalIssueResolutions); ?> %
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Location:
            </div>
            <div class="sidebar_block_right">
                Worldwide
            </div>
        </div>

        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Funded:
            </div>
            <div class="sidebar_block_right">
                <div class="green_progress"></div> 105%
            </div>
        </div>
        <?php if(isset($unitObj)): ?>
        <div class="sidebar_block_content_bottom">
            <a href="<?php echo route('unit_revison',[$unitIDHashID->encode($unitObj->id)]); ?>"><i class="fa fa-history"></i></a>
            <div class="separator"></div>
            <a href="<?php echo url('units/'.$unitIDHashID->encode($unitObj->id).'/edit'); ?>"><i class="fa fa-edit"></i></a>
            <div class="separator"></div>
            <a class="add_to_my_watchlist" data-type="unit"  data-id="<?php echo e($unitIDHashID->encode($unitObj->id)); ?>" data-redirect="<?php echo e(url()->current()); ?>"><i class="fa fa-list"></i></a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/v2/global-unit-overview.blade.php ENDPATH**/ ?>