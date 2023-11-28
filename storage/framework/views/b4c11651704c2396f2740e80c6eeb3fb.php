<?php $__env->startSection('title', 'Wiki: View Revision'); ?>
<?php $__env->startSection('style'); ?>

    <style>
        .panel {
            border-radius: 0px;
        }
        .panel-default {
            border-color: #ddd;
        }
        .panel-grey .panel-heading {
            background-color: #ebe9e9;
            color: #3F3F3F;
            text-transform: uppercase;

            font-weight: 500;
            border-bottom: 3px solid #5a5858;
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

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-heading d-flex align-items-center">
                        <div class="table_block_icon featured_unit current_task">
                            <i class="fa fa-book"></i>
                        </div>
                        <h4 class="card-title m-0" style="color: #0d1217;"><?php echo e($wiki_page['wiki_page_title']); ?></h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Previous revision</h4>
                            <h5 class="text-center"><?php echo e(date("d-m-Y h:A", strtotime($wiki_page['time_stamp']))); ?>, Edited By User <?php echo e($wiki_page['username']); ?></h5>
                            <hr>
                            <div class="wiki-page-desc"><?php echo $wiki_page['page_content']; ?></div>
                            <hr>
                            <p><strong>Comment:</strong> <?php echo e($wiki_page['edit_comment']); ?></p>

                            <div class="text-center"> <a class="btn btn-secondary black_btn" href="<?php echo url('wiki/edit_revision'); ?>/<?php echo $unit_id; ?>/<?php echo $slug; ?>/<?php echo $wiki_page['revision_id']; ?>"> Edit This Revision </a> </div>
                        </div>
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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/wiki/revision_view.blade.php ENDPATH**/ ?>