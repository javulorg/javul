<?php $__env->startSection('page-meta'); ?>
<title>User: <?php echo e($userObj->first_name.' '.$userObj->last_name); ?> - Javul.org</title>
<?php $__env->stopSection(); ?>
<div class="grey-bg" style="padding-top:20px;margin-bottom: 20px; ">
        <div class="row">
            <div class="col-sm-4 text-center form-group">
                <div>
                <?php if(!empty($userObj->profile_pic) ): ?>
                    <img src="<?php echo e($userObj->profile_pic); ?> " class="img-rounded-circle" style="width: 160px;"/>
                <?php else: ?>
                    <img src="<?php echo url('assets/images/user.png'); ?>" class="img-rounded-circle"/>
                <?php endif; ?>
                </div>

                <label class="control-label" style="margin-bottom:0px">Task Completion Ratings
                    <input id="input-3" name="input-3" value="<?php echo e($rating_points); ?>" class="rating-loading">
                    (<?php echo e($rating_points); ?>/5)
                </label>



            </div>
            <div class="col-sm-8 hidden-xs">
                <div class="user-header">
                    <h3><?php echo e($userObj->first_name.' '.$userObj->last_name); ?></h3>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-time"></span>
                    Account age: <?php echo e($userObj->age); ?></label>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <?php $job_skills = explode(",",$userObj->job_skills); ?>
                    Skills:
                    <?php if(!empty($job_skills)): ?>
                        <?php $__currentLoopData = $job_skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="label label-info tags"><?php echo e(\App\Models\JobSkill::getName($skill)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Area of Interest:
                    <?php $area_of_interest = explode(",",$userObj->area_of_interest); ?>
                    <?php if(!empty($area_of_interest)): ?>
                        <?php $__currentLoopData = $area_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="label label-info tags"><?php echo e(\App\Models\AreaOfInterest::getName($interest)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <span class="glyphicon glyphicon-map-marker"></span>
                <?php echo e(\App\Models\Country::getName($userObj->country_id)); ?>

                <span class="glyphicon glyphicon-menu-right"></span>
                <?php echo e(\App\Models\State::getName($userObj->state_id)); ?>

                <span class="glyphicon glyphicon-menu-right"></span>
                <?php echo e(\App\Models\City::getName($userObj->city_id)); ?>

            </div>
            <div class="col-xs-12 visible-xs text-center">
                <div class="user-header">
                    <h3><?php echo e($userObj->first_name.' '.$userObj->last_name); ?></h3>
                </div>
            </div>
            <div class="col-xs-12 visible-xs">
                <div class="user-header">
                    <span class="glyphicon glyphicon-time"></span>
                    Account age: <?php echo e($userObj->created_at); ?></label>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    Skills:
                    <?php if(!empty($skills)): ?>
                    <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="label label-info tags"><?php echo e($skill->skill_name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Area of Interest:
                    <?php if(!empty($interestObj)): ?>
                    <?php $__currentLoopData = $interestObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="label label-info tags"><?php echo e($interest->title); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <span class="glyphicon glyphicon-map-marker"></span>
                <?php echo e(\App\Models\Country::getName($userObj->country_id)); ?>

                <span class="glyphicon glyphicon-menu-right"></span>
                <?php echo e(\App\Models\State::getName($userObj->state_id)); ?>

                <span class="glyphicon glyphicon-menu-right"></span>
                <?php echo e(\App\Models\City::getName($userObj->city_id)); ?>

            </div>
        </div>

    </div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/user-profile.blade.php ENDPATH**/ ?>