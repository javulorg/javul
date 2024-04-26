<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bg-light p-3 mb-4">
        <div class="row">
            <div class="col-sm-4 text-center">
                <div>
                    <?php if(!empty($userObj->profile_pic)): ?>
                        <img src="<?php echo e($userObj->profile_pic); ?>" class="rounded-circle" style="width: 160px;">
                    <?php else: ?>
                        <img src="<?php echo url('assets/images/user.png'); ?>" class="rounded-circle" style="width: 160px;">
                    <?php endif; ?>
                </div>
                <label class="form-label d-block mb-0">Task Completion Ratings</label>
                <div class="rating" style="font-size: 2rem;">
                    <!-- Rating stars code remains unchanged -->
                </div>
                <span class="d-block text-center fw-bold"><?php echo e($rating_points); ?>/5</span>
            </div>
            <div class="col-sm-8">
                <div class="user-header">
                    <h3><?php echo e($userObj->first_name.' '.$userObj->last_name); ?></h3>
                </div>
                <div class="user-header">
                    <span class="bi bi-clock"></span>
                    Account age: <?php echo e($userObj->created_at); ?>

                </div>
                <div class="user-header">
                    <span class="bi bi-hand-thumbs-up"></span>
                    Skills:
                    <?php $job_skills = explode(",",$userObj->job_skills); ?>
                    <?php if(!empty($job_skills)): ?>
                        <div class="mt-2">
                            <?php $__currentLoopData = $job_skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-info mb-2"><?php echo e(\App\Models\JobSkill::getName($skill)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="user-header mb-2">
                    <span class="bi bi-bookmark"></span>
                    Area of Interest:
                    <?php $area_of_interest = explode(",",$userObj->area_of_interest); ?>
                    <?php if(!empty($area_of_interest)): ?>
                        <div class="mt-2">
                            <?php $__currentLoopData = $area_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-info mb-2" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e(\App\Models\AreaOfInterest::getName($interest)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="bi bi-geo-alt"></span>
                        <?php echo e(\App\Models\Country::getName($userObj->country_id)); ?>

                        <span class="bi bi-caret-right"></span>
                        <?php echo e(\App\Models\State::getName($userObj->state_id)); ?>

                        <span class="bi bi-caret-right"></span>
                        <?php echo e(\App\Models\City::getName($userObj->city_id)); ?>

                    </div>
                    <div>
                        <a href="<?php echo e(route('user_wiki_page_list',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])); ?>" class="btn btn-info" style="text-decoration: none;">User Wiki</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-3">
            <div class="sidebar_block">
                <div class="sidebar_block_ttl">
                    
                    User Activity Log
                    <div class="arrow">
                        <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                    </div>
                </div>
                <div class="sidebar_block_content">
                    <?php if(count($site_activity) > 0): ?>
                        <?php $__currentLoopData = $site_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="log_item">
                                <div class="log_icon">
                                    <img src="<?php echo e(asset('v2/assets/img/commen.svg')); ?>" alt="">
                                </div>
                                <div class="log_txt">
                                    <a href="#"><?php echo $activity->comment; ?></a> <?php echo \App\Library\Helpers::timetostr($activity->created_at); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="log_item">
                            No activity found.
                        </div>
                    <?php endif; ?>

                    <div class="sidebar_block_content_bottom">
                        <a href="#">Top Contributors</a>
                        <div class="separator"></div>
                        <a href="<?php echo e(url('activities')); ?>">More Activity</a>
                    </div>
                </div>
            </div>

        </div>



        <div class="col-sm-8">
            <!-- Enhanced Header Card -->
            <!-- Enhanced Header Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">
                        Total Activity Points: <?php echo e($activityPoints); ?>

                        | Idea Points: <?php echo e($activityPoints_forum); ?>

                    </h3>
                    <?php if($userObj->paypal_email): ?>
                        <a class="btn btn-outline-dark btn-sm float-end" id="add_funds_btn"
                           href="<?php echo url('funds/donate/user/'.$userIDHashID->encode($userObj->id)); ?>">
                            <i class="fas fa-plus me-1"></i>
                            <?php echo trans('messages.add_funds'); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card for Most Active Units -->
            <div class="card mb-3">
                <div class="card-header">
                    Units Details
                </div>
                <div class="card-body">
                    <?php echo $__env->make('users.profile-partials.unit-details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <!-- Card for Objectives Details -->

            <div class="card mb-3">
                <div class="card-header">
                    Objectives Details
                </div>
                <div class="card-body">

                    <!-- Flex Container for side-by-side layout -->
                    <div class="mb-4" style="display: flex; justify-content: space-between;">

                        <div class="mt-4" style="flex: 1; padding-right: 20px;">

                            <ul>
                                <li>Objectives Created: <?php echo e($totalObjectivesCreated ?? 0); ?></li>
                                <li>Objectives Edited: <?php echo e($totalObjectivesEdited ?? 0); ?></li>
                            </ul>
                        </div>

                        <!-- New Section for Objective Upvote Ratios -->
                        <div class="mt-4" style="flex: 1; padding-left: 20px;">
                            <ul>
                                <li>Creation Upvote Ratio: 5</li>
                                <li>Edits Upvote Ratio: 6</li>
                            </ul>
                        </div>

                    </div>

                    <?php echo $__env->make('users.profile-partials.objectives-details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>


            <!-- Card for Tasks Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Tasks Details
                </div>
                <div class="card-body">
                    <?php echo $__env->make('users.profile-partials.tasks-details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="mt-4">
                        <h5>Task Metrics</h5>
                        <ul>
                            <li>Tasks Created: 2</li>
                            <li>Tasks Edited: 3</li>
                            <li>Tasks Completed: 4</li>
                        </ul>
                    </div>

                    <!-- New Section for Feedback on Tasks -->
                    <div class="mt-4">
                        <h5>Feedback Provided for Task Completion</h5>
                        <ul>
                            <li>Quality of Work: 5</li>
                            <li>Timeliness: 6</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card for Most Active Units -->
            <div class="card mb-3">
                <div class="card-header">
                    Most Active Units
                </div>
                <div class="card-body">
                    <!-- You will need to include a component here that fetches and displays the most active units -->
                </div>
            </div>



            <div class="card mb-3">
                    <div class="card-header">
                        Comment Statistics
                    </div>
                    <div class="card-body">
                        <p>Total Comments: <span id="totalComments">0</span></p>
                        <p>Total Upvotes on Comments: <span id="totalUpvotes">0</span></p>
                        <p>Comments/Upvotes Ratio: <span id="commentsUpvotesRatio">0</span></p>

                        <p>Most Recent Comments: <span id="totalUpvotes">0</span></p>
                        <p>Top Comments: <span id="commentsUpvotesRatio">0</span></p>
                    </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Activity by Unit
                </div>
                <div class="card-body">
                    <div id="activityByUnitList"></div>
                </div>
            </div>

        </div>




        <style>
            .card-header {
                background-color: #f8f9fa;
                color: #333;
                font-weight: bold;
            }
            .card-body {
                background-color: #ffffff;
            }

        </style>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabs').tab();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile.blade.php ENDPATH**/ ?>