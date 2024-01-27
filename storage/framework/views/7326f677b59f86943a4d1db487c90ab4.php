<?php $__env->startSection('title', 'Recent Changes'); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .card-header .button-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            background-color: #564949;
            color: #fff;
            border-color: #D3D3D3;
        }

        .card-header .button-group .btn:hover {
            background-color: #a9a9a9;
            border-color: #a9a9a9;
        }
    </style>
<?php $__env->stopSection(); ?>
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


        <div class="main_content mt-2">
            <div class="content_block">
                <div class="table_block table_block_wiki_pages">
                    <div class="table_block_head current_task_heading  current_task_heading_red featured_unit_heading">
                        <div class="table_block_icon featured_unit current_task">
                            <i class="fa fa-book"></i>
                        </div>
                        Recent Changes
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table id="objectives-table-id">
                            <thead>
                            <tr>
                                <th class="last_reply_col">#</th>
                                <th class="title_col">Title</th>
                                <th class="last_reply_col">Time</th>
                                <th class="last_reply_col">Byte</th>
                                <th class="last_reply_col">Username</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($changes['changes'])){ ?>
                            <tr>
                                <td colspan="5" class="text-center"> <h4>No any changes Created yet..  </h4> </td>
                            </tr>
                            <?php  } ?>
                            <?php foreach ($changes['changes'] as $key => $page) { ?>
                            <tr>
                                <td>
                                     <a href="<?php echo url('wiki/revision_view'); ?>/<?php echo $unit_id; ?>/<?php echo $page['revision_id']; ?>/<?php echo $slug; ?>">View</a> |
                                    <a href="<?php echo url('wiki/diff'); ?>/<?php echo $unit_id; ?>/<?php echo $page['revision_id']; ?>/<?php echo $slug; ?>">Diff</a> |
                                    <a href="<?php echo url('wiki/history'); ?>/<?php echo $unit_id; ?>/<?php echo $page['wiki_page_id']; ?>/<?php echo $slug; ?>">Hist</a>
                                </td>
                                <td>
                                    <a href="<?php echo url('wiki').'/'.$unit_id.'/'. $page['wiki_page_id'] .'/'.$slug; ?>"><?= $page['wiki_page_title'] ?></a>
                                </td>
                                <td><?= $page['time_stamp'] ?></td>
                                <td><?= $page['change_byte'] ?></td>
                                <td>
                                    <a href='<?= $page['userlink'] ?>' ><?= $page['user_name'] ?> </a>
                                    (<?= $page['edit_comment'] != '' ? $page['edit_comment'] : '<small> No Comment </small>' ?>)</td>

                            </tr>
                            <?php } ?>
                            </tbody>





















                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        <a href="<?php echo url('wiki/all_pages'); ?>/<?php echo $unit_id; ?>/<?php echo $slug; ?>"><i class="fa fa-list"></i>  List All Pages</a>
                    </div>
                    <div class="pagination-right">
                        <a href="<?php echo url('wiki/edit'); ?>/<?php echo $unit_id; ?>/<?php echo $slug; ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

















































































































<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/wiki/changes_list.blade.php ENDPATH**/ ?>