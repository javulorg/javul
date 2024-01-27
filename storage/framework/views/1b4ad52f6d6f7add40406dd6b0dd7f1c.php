<?php $__env->startSection('title', 'Wiki Page List'); ?>
<?php $__env->startSection('style'); ?>
    <style>

    </style>
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
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
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

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="float-start">User Wiki</h4>
                    <div class="user-wikihome-tool float-end">
                        <div class="user-wikihome-tool small-a">
                            <a href="<?php echo e(route('user_wiki_newpage', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash])); ?>">+ New Page</a> |
                            <a href="<?php echo e(route('user_wiki_recent_changes', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash])); ?>">Recent Changes</a> |
                            <a href="<?php echo e(route('user_wiki_page_list', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash])); ?>">List All Pages</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body table-responsive loading_content_hide">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Last Edit</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $userWikiPage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('user_wiki_view', [$slug, $userPageIDHashID->encode($page->id), $page->slug])); ?>">
                                            <?php echo e($page->page_title); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php echo e($Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->diffForHumans()); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('user_wiki_editpage', [str_replace(' ', '_', strtolower($userObj->first_name.' '.$userObj->last_name)), $user_id_hash, $userPageIDHashID->encode($page->id), $page->slug])); ?>">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="<?php echo e($userWikiPage->links() == '' ? 'hide' : ''); ?>">
                            <tr>
                                <td colspan="3"><?php echo e($userWikiPage->links()); ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/wiki/wiki_page_list.blade.php ENDPATH**/ ?>