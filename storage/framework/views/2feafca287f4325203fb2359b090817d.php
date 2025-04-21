<?php $__env->startSection('title', 'Donation'); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .badge {
            display: inline-block;
            white-space: nowrap;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $obj_identifier = get_class($obj); ?>
    <div class="bg-light p-3 mb-4">
        <div class="row">
            <div class="col-sm-4 text-center">
                <div>
                    <?php if(!empty($obj->profile_pic)): ?>
                        <img src="<?php echo e($obj->profile_pic); ?>" class="rounded-circle" style="width: 160px;">
                    <?php else: ?>
                        <img src="<?php echo url('assets/images/user.png'); ?>" class="rounded-circle" style="width: 160px;">
                    <?php endif; ?>
                </div>
                <label class="form-label d-block mb-0">Task Completion Ratings</label>
                <div class="rating" style="font-size: 2rem;">
                    <input type="hidden" name="rating" value="<?php echo e($rating_points); ?>" />
                    <span class="star <?php if($rating_points >= 1): ?> checked <?php endif; ?>" style="opacity: <?php echo e($rating_points >= 1 ? 1 : 0.3); ?>;">&#9733;</span>
                    <span class="star <?php if($rating_points >= 2): ?> checked <?php endif; ?>" style="opacity: <?php echo e($rating_points >= 2 ? 1 : 0.3); ?>;">&#9733;</span>
                    <span class="star <?php if($rating_points >= 3): ?> checked <?php endif; ?>" style="opacity: <?php echo e($rating_points >= 3 ? 1 : 0.3); ?>;">&#9733;</span>
                    <span class="star <?php if($rating_points >= 4): ?> checked <?php endif; ?>" style="opacity: <?php echo e($rating_points >= 4 ? 1 : 0.3); ?>;">&#9733;</span>
                    <span class="star <?php if($rating_points == 5): ?> checked <?php endif; ?>" style="opacity: <?php echo e($rating_points == 5 ? 1 : 0.3); ?>;">&#9733;</span>
                </div>
                <span class="d-block text-center fw-bold"><?php echo e($rating_points); ?>/5</span>
            </div>
            <div class="col-sm-8">
                <div class="user-header">
                    <h3><?php echo e($obj->first_name.' '.$obj->last_name); ?></h3>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="user-header">
                        <span class="bi bi-clock"></span>
                        Account age: <?php echo e($obj->created_at); ?>

                    </div>
                    <div class="user-header">
                        <span class="bi bi-hand-thumbs-up"></span>
                        Skills:
                        <?php $job_skills = explode(",",$obj->job_skills); ?>
                        <?php if(!empty($job_skills)): ?>
                            <?php $__currentLoopData = $job_skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-info"><?php echo e(\App\Models\JobSkill::getName($skill)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="user-header mb-2">
                    <span class="bi bi-bookmark"></span>
                    Area of Interest:
                    <?php $area_of_interest = explode(",",$obj->area_of_interest); ?>
                    <?php if(!empty($area_of_interest)): ?>
                        <?php $__currentLoopData = $area_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-info" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e(\App\Models\AreaOfInterest::getName($interest)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="bi bi-geo-alt"></span>
                        <?php echo e(\App\Models\Country::getName($obj->country_id)); ?>

                        <span class="bi bi-caret-right"></span>
                        <?php echo e(\App\Models\State::getName($obj->state_id)); ?>

                        <span class="bi bi-caret-right"></span>
                        <?php echo e(\App\Models\City::getName($obj->city_id)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php echo $__env->make('layout.v2.global-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-sm-8">
            <?php if($obj_identifier != 'App\Objective'): ?>
                <form accept-charset="UTF-8" action="<?php echo url('funds/donate-amount'); ?>" class="simple_form form-horizontal" method="post"
                      novalidate="novalidate" id="donate_amount_form">
                    <?php echo e(csrf_field()); ?>

                    <?php if(count($errors->all()) > 0): ?>
                        <?php $err_msg ='';?>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $err_msg.='<span>'.$err.'</span>';?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <img src="<?php echo url('assets/images/error-icon.png'); ?>"> <strong>Error!</strong> <?php echo $err_msg; ?>

                        </div>

                    <?php endif; ?>
                    <?php if($current_payment_method == "PAYPAL"): ?>
                        <div class="row form-group donationDiv credit_card"  >
                            <div class="col-sm-4">
                                <label for="amount" class="control-label">Amount to Donate</label>
                                <input type="text" value="" name="donate_amount" id="donate_amount" data-numeric
                                       placeholder="Amount" class="form-control" required autocomplete="off" maxlength="10">

                                <label id="paypal-fees" class="control-label"></label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row form-group donationDiv credit_card">
                        <div class="col-sm-4">
                            <?php if($current_payment_method == "Zcash"): ?>
                                <button id="submit_donate" class="btn black-btn">Donate With Zcash</button>
                            <?php else: ?>
                                <input type="image" id="submit_donate"  src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"/>
                            <?php endif; ?>
                            <input type="hidden" id="paymentMethod" name="paymentMethod" value="<?php echo e($current_payment_method); ?>"/>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <form accept-charset="UTF-8" action="<?php echo url('funds/transfer-from-unit'); ?>" class="simple_form form-horizontal" method="post"
                      novalidate="novalidate" id="donate_amount_form">
                    <?php echo e(csrf_field()); ?>

                    <?php if(count($errors->all()) > 0): ?>
                        <?php $err_msg ='';?>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $err_msg.='<span>'.$err.'</span>';?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <img src="<?php echo url('assets/images/error-icon.png'); ?>"> <strong>Error!</strong> <?php echo $err_msg; ?>

                        </div>

                    <?php endif; ?>
                    <div class="row form-group donationDiv credit_card"  >
                        <div class="col-sm-4">
                            <label for="amount" class="control-label">Amount to Donate For User</label>
                            <input type="text" value="" name="donate_amount" id="donate_amount" data-numeric
                                   placeholder="Amount" class="form-control" required autocomplete="off" maxlength="10">

                            <label id="paypal-fees" class="control-label" <?php if($current_payment_method == "Zcash"): ?> style="display:none" <?php endif; ?>></label>
                        </div>
                    </div>
                    <div class="row form-group donationDiv credit_card"  >
                        <div class="col-sm-2 col-xs-12">
                            <?php if($current_payment_method == "Zcash"): ?>
                                <button id="submit_donate" class="btn black-btn" style="padding: 6px 12px;line-height: unset !important;">Donate With Zcash</button>
                            <?php else: ?>
                                <input type="image" id="submit_donate"  src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"/>
                            <?php endif; ?>
                            <input type="hidden" id="paymentMethod" name="paymentMethod" value="<?php echo e($current_payment_method); ?>"/>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <button class="btn btn-primary">Transfer from Unit</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/funds/donation.blade.php ENDPATH**/ ?>