<?php $__env->startSection('title', 'Objective: ' . $objectiveObj->name); ?>
<?php $__env->startSection('site-name'); ?>
    <?php if(isset($unitData)): ?>
        <h1><?php echo e($unitData->name); ?></h1>
    <?php else: ?>
        <h1>Javul.org</h1>
    <?php endif; ?>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>
    <?php if(isset($unitData)): ?>
        <?php echo $__env->make('layout.navbar', ['unitData' => $unitData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">
            <?php if(isset($unitData)): ?>
                <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php
                $title = 'Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php
                $title = 'Global Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>


        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_objectives active">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        <?php echo e($objectiveObj->name); ?>

                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="objective_content">
                        <div class="objective_content_row d-sm-flex d-none">
                            <div>
                               <p>
                                   <?php echo $objectiveObj->description; ?>

                               </p>
                            </div>
                            <div class="objective_content_info">
                                <div class="sidebar_block">
                                    <div class="sidebar_block_ttl">
                                        Objective Overview
                                        <div class="arrow">
                                            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="sidebar_block_content">
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Priority:
                                            </div>
                                            <div class="sidebar_block_right">
                                                Medium
                                                <div class="progress">
                                                    <div class="progress-bar" style="width:75%"></div>
                                                </div> <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Status:
                                            </div>
                                            <div class="sidebar_block_right">
                                                <?php echo e(\App\Models\Objective::objectiveStatus()[$objectiveObj->status]); ?>

                                            </div>
                                        </div>
                                        <div class="sidebar_line"></div>
                                        <div class="sidebar_block_row">
                                            <div class="sidebar_block_left">
                                                Funds:
                                            </div>
                                            <div class="sidebar_block_right">
                                                Received $2500<br>
                                                Awarded $<?php echo e(number_format($awardedObjFunds,2)); ?><br>
                                                Available $<?php echo e(number_format($availableObjFunds,2)); ?><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="objective_content_info_links">
                                    <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objectiveObj->id).'/edit'); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/eye.svg')); ?>" alt=""></a>
                                    <div class="separat"></div>
                                    <a href="<?php echo route('objectives_revison',[$objectiveIDHashID->encode($objectiveObj->id)]); ?>" class="edit_icon"><img src="<?php echo e(asset('v2/assets/img/pencil-create.svg')); ?>" alt=""> Revision History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_tasks">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Tasks
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">
                                    Title
                                </th>
                                <th class="status_col">
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($objectiveObj->tasks) > 0): ?>
                                <?php $__currentLoopData = $objectiveObj->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug); ?>" title="edit">
                                                <?php echo e($obj->name); ?>

                                            </a>
                                        </td>
                                        <td class="status_col">
                                            <?php if($obj->status == "editable"): ?>
                                                <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php else: ?>
                                                <span class="text-success"><?php echo e(\App\Models\SiteConfigs::task_status($obj->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No record(s) found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="<?php echo e(url('tasks/create')); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                    <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>


            <div class="content_block_comments">
                <div class="table_block table_block_comments">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/Dialog.svg" alt="" class="img-fluid">
                        </div>
                        Comments
                    </div>
                    <div class="comments_content">
                        <div class="comment_stat">
                            <b>2 review</b> <a href="#">Write a review</a>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <div class="comment_info">
                                    <div class="comment_autor">
                                        John
                                    </div>
                                    <div class="comment_time">
                                        just now
                                    </div>
                                </div>
                                <div class="comment_txt">
                                    Vestibulum sagittis tincidunt est, sit amet vulputate orci fringilla in. Duis iaculis nibh eget arcu volutpat, eget volutpat lorem sollicitudin. Pellentesque finibus id orci nec feugiat. Maecenas laoreet elit vitae magna pellentesque vulputate. Donec dictum hendrerit ex, non dignissim lectus fringilla ac. Aenean sit amet pellentesque lacus. Nam et rhoncus ex.
                                </div>
                            </div>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <div class="comment_info">
                                    <div class="comment_autor">
                                        Michael Fletcher
                                    </div>
                                    <div class="comment_time">
                                        on 08/09/2023 12:20:30
                                    </div>
                                </div>
                                <div class="comment_txt">
                                    Duis iaculis nibh eget arcu volutpat, eget volutpat lorem sollicitudin. Pellentesque finibus id orci nec feugiat. Maecenas laoreet elit vitae magna pellentesque vulputate. Donec dictum hendrerit ex, non dignissim lectus fringilla ac. Aenean sit amet pellentesque lacus. Nam et rhoncus ex.
                                </div>
                            </div>
                        </div>
                        <div class="comment_container">
                            <div class="comment_icon">
                                <img src="img/User_Circle.svg" alt="" class="img-fluid">
                            </div>
                            <div class="comment_content">
                                <textarea cols="30" rows="10" placeholder="White a message..."></textarea>
                                <button type="button" class="btn">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
        </div>





















































































































































    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        ClassicEditor
            .create( document.querySelector('#comment') )
            .catch( error => {
                console.error(error);
            } );
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/view.blade.php ENDPATH**/ ?>