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
                        Tasks (35)
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="type_col">
                                    Type
                                </th>
                                <th class="title_col">
                                    Title
                                </th>
                                <th class="status_col">
                                    Status
                                </th>
                                <th class="replies_col">
                                    Replies
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Some misc Task Title
                                </td>
                                <td class="status_col">
                                    10 minutes ago
                                </td>
                                <td class="replies_col">
                                    $60
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Information tech
                                </td>
                                <td class="title_col">
                                    Research payment gateway methods for implementing in the app
                                </td>
                                <td class="status_col">
                                    Open for Bidding
                                </td>
                                <td class="replies_col">
                                    50 points
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Require feedback if a 1-star rating is given
                                </td>
                                <td class="status_col">

                                </td>
                                <td class="replies_col">

                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Software
                                </td>
                                <td class="title_col">
                                    Debug GPS reporting issues (Goal)
                                </td>
                                <td class="status_col">

                                </td>
                                <td class="replies_col">

                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Information tech
                                </td>
                                <td class="title_col">
                                    Research payment gateway methods for implementing in the app
                                </td>
                                <td class="status_col">
                                    Open for Bidding
                                </td>
                                <td class="replies_col">
                                    50 points
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        $60
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        50 points
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">

                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Status
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        $60
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_ideas">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/humbleicons_bulb.svg" alt="" class="img-fluid">
                        </div>
                        Related ideas
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="type_col">
                                    Type
                                </th>
                                <th class="title_col">
                                    Title
                                </th>
                                <th class="priority_col">
                                    Priority
                                </th>
                                <th class="last_reply_col">
                                    Last Reply
                                </th>
                                <th class="replies_col">
                                    Replies
                                </th>
                                <th class="views_col">
                                    Views
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="type_col">
                                    Misc
                                </td>
                                <td class="title_col">
                                    Create a Customer/Driver complaint review process
                                </td>
                                <td class="priority_col">
                                </td>
                                <td class="last_reply_col">
                                    10 minutes ago
                                </td>
                                <td class="replies_col">
                                    34
                                </td>
                                <td class="views_col">
                                    205
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Add a feature to book ride in advance
                                </td>
                                <td class="priority_col">
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Ability to add multiple stops with extra costs
                                </td>
                                <td class="priority_col">
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:65%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        12
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        78
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:95%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        6 months ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        14
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        156
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_issues">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/bug.svg" alt="" class="img-fluid">
                        </div>
                        Related Issues
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="type_col">
                                    Type
                                </th>
                                <th class="title_col">
                                    Title
                                </th>
                                <th class="priority_col">
                                    Priority
                                </th>
                                <th class="last_reply_col">
                                    Last Reply
                                </th>
                                <th class="replies_col">
                                    Replies
                                </th>
                                <th class="views_col">
                                    Views
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:70%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    10 minutes ago
                                </td>
                                <td class="replies_col">
                                    34
                                </td>
                                <td class="views_col">
                                    205
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Being rated without any feedback / 1* ratings should require feedback
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:95%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            <tr>
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:70%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    10 minutes ago
                                </td>
                                <td class="replies_col">
                                    34
                                </td>
                                <td class="views_col">
                                    205
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Driver
                                </td>
                                <td class="title_col">
                                    Being rated without any feedback / 1* ratings should require feedback
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:95%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    6 months ago
                                </td>
                                <td class="replies_col">
                                    14
                                </td>
                                <td class="views_col">
                                    156
                                </td>
                            </tr>
                            <tr class="hidden_row">
                                <td class="type_col">
                                    Customer
                                </td>
                                <td class="title_col">
                                    Drivers cancelling at the last moment
                                </td>
                                <td class="priority_col">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:65%"></div>
                                    </div>
                                </td>
                                <td class="last_reply_col">
                                    5 days ago
                                </td>
                                <td class="replies_col">
                                    12
                                </td>
                                <td class="views_col">
                                    78
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:65%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        5 days ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        12
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        78
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Being rated without any feedback / 1* ratings should require feedback
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:95%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        6 months ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        14
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        156
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Customer
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Drivers cancelling at the last moment
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                            <div class="mob_table_section hidden_row">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Type
                                    </div>
                                    <div class="mob_table_val">
                                        Driver
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Title
                                    </div>
                                    <div class="mob_table_val">
                                        Not having bonus pay tiers on mid grade or newer vehicles (#157)
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Priority
                                    </div>
                                    <div class="mob_table_val">
                                        <div class="progress">
                                            <div class="progress-bar" style="width:70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Last Reply
                                    </div>
                                    <div class="mob_table_val">
                                        10 minutes ago
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Replies
                                    </div>
                                    <div class="mob_table_val">
                                        34
                                    </div>
                                </div>
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">
                                        Views
                                    </div>
                                    <div class="mob_table_val">
                                        205
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_objective">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/User_Rounded.svg" alt="" class="img-fluid">
                        </div>
                        Parent Objectives
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_txt">
                        <b>Task Name</b>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
                </div>
            </div>
            <div class="content_block">
                <div class="table_block table_block_objective">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="img/Users_Two_Rounded.svg" alt="" class="img-fluid">
                        </div>
                        Child Objectives
                        <div class="arrow">
                            <img src="img/bottom.svg" alt="">
                        </div>
                    </div>
                    <div class="table_block_txt">
                        <b>Task Name</b>
                    </div>
                </div>
                <div class="content_block_bottom">
                    <a href="#"><img src="img/circle-plus.svg" alt=""> Add New</a> <div class="separator"></div> <a href="#" class="see_more">See more</a>
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