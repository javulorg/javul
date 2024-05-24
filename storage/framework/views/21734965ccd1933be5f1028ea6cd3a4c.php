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

                    <div class="input-icon right float-end">
                        <label for="amount" class="control-label">&nbsp;</label>
                        <input id="amount-toggle" checked
                               data-on="Last 6 Months" data-off="Lifetime"
                               data-toggle="toggle" data-width="140" data-height="30" data-onstyle="light" data-offstyle="info"
                               type="checkbox" name="charge_type">
                    </div>
                </div>
            </div>
            
            <!-- Card for Most Active Units -->
            <div class="card mb-3">
                <div class="card-header">
                    Most Active Units
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
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Objectives Created</td>
                            <td><?php echo e($totalObjectivesCreated ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Objectives Edited</td>
                            <td><?php echo e($totalObjectivesEdited ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td><?php echo e($upvoteCreationRatio ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td><?php echo e($upvoteEditRatio ?? 0); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Tasks Details -->

            <div class="card mb-3">
                <div class="card-header">
                    Task Details
                </div>
                <div class="card-body">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px;">Task Metrics</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Feedback Provided for Task Completion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <ul>
                                    <li>Tasks Created: <?php echo e($totalTasksCreated); ?></li>
                                    <li>Tasks Edited: <?php echo e($totalTasksEdited); ?></li>
                                    <li>Tasks Completed: <?php echo e($totalCompletedTasks); ?></li>
                                </ul>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <ul>
                                    <li>Quality of Work: 5</li>
                                    <li>Timeliness: 6</li>
                                    <li>Edits Upvote Ratio: <?php echo e($tasksUpvoteEditRatio ?? 0); ?></li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Issues Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Issue Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Issue Created</td>
                            <td><?php echo e($totalTasksCreated); ?></td>
                        </tr>
                        <tr>
                            <td>Issue Edited</td>
                            <td><?php echo e($totalTasksEdited); ?></td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td><?php echo e($issueUpvoteCreationRatio ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td><?php echo e($issueUpvoteEditRatio ?? 0); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Idea Details -->
            <div class="card mb-3">
                <div class="card-header">
                    Idea Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Idea Created</td>
                            <td><?php echo e($totalIdeasCreated); ?></td>
                        </tr>
                        <tr>
                            <td>Idea Edited</td>
                            <td><?php echo e($totalIdeasUpdated); ?></td>
                        </tr>
                        <tr>
                            <td>Creation Upvote Ratio</td>
                            <td><?php echo e($ideaUpvoteCreationRatio ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Edits Upvote Ratio</td>
                            <td><?php echo e($ideaUpvoteEditRatio ?? 0); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card for Comment Statistics -->
            <div class="card mb-3">
                <div class="card-header">
                    Comment Statistics
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Total Comments</td>
                            <td><span id="totalComments"><?php echo e($totalUserComments); ?></span></td>
                        </tr>
                        <tr>
                            <td>Total Upvotes on Comments</td>
                            <td><span id="totalUpvotes"><?php echo e($totalUpvotesComments); ?></span></td>
                        </tr>
                        <tr>
                            <td>Total Downvotes on Comments</td>
                            <td><span id="totalDownvotes"><?php echo e($totalDownvotesComments); ?></span></td>
                        </tr>
                        <tr>
                            <td>Comments/Upvotes Ratio</td>
                            <td><span id="commentsUpvotesRatio"><?php echo e($totalUpvotesCommentsRatio); ?></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Most Recent Comments
                </div>
                <div class="card-body">
                    <?php echo $__env->make('users.profile-partials.most-recent-comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Top Comments
                </div>
                <div class="card-body">
                    <?php echo $__env->make('users.profile-partials.top-comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/profile.blade.php ENDPATH**/ ?>