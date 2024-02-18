<?php $__env->startSection('title', 'Edit Category: '); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1><?php echo e($unitObj->name); ?></h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
    <?php echo $__env->make('layout.navbar', ['unitData' => $unitObj], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php
            $title = 'Activity Log';
            ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitObj->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-finances', ['availableFunds' => $availableFunds, 'awardedFunds' => $awardedFunds], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Edit Unit Category</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post"  action="<?php echo e(url('admin/categories/' . $category->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <div class="row">

                            <input type="hidden" name="unit_id" value="<?php echo e($category->unit_id); ?>">

                            <div class="col-md-12 form-group">
                                <label class="control-label">Category Title</label>
                                <div class="input-icon right">
                                    <input type="text" name="title" class="form-control" value="<?php echo e($category->title); ?>" required/>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?php echo e($category->status == 1 ? 'selected' : ''); ?>>Active</option>
                                    <option value="0" <?php echo e($category->status == 0 ? 'selected' : ''); ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update Category</span>
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/admin/settings/edit.blade.php ENDPATH**/ ?>