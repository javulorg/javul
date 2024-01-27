<?php $__env->startSection('title', 'Unit : REVISION HISTORY'); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1><?php echo e($units->name); ?></h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
    <?php echo $__env->make('layout.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php
            $title = 'Activity Log';
            ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-md-10">
            <div class="card">
                <div class="card-header current_task_heading featured_unit_heading">
                    <div class="featured_unit current_task">
                        <i class="fa fa-pencil-square"></i>
                        <h4>View History: <?php echo $units->name; ?> </h4>
                    </div>

                </div>
                <div class="card-body list-group">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rev Link</th>
                                    <th>Time</th>
                                    <th>Username</th>
                                    <th>Edit Comment</th>
                                    <th>Size</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($revisions as $key => $value) {
                                $user_id = $userIDHashID->encode($value->user_id);
                                ?>
                                <tr>
                                    <td> <input type="checkbox" name="id" value="<?php echo e($value['id']); ?>" class="single-checkbox"> </td>
                                    <td><a href="<?php echo route('unit_revison_view',[$unit_id,$value['id']]); ?>">View</a> </td>
                                    <td><?php echo e($Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->diffForHumans()); ?></td>
                                    <td> <a href="<?php echo e(url('userprofiles/'. $user_id .'/'.strtolower($value->first_name.'_'.$value->last_name))); ?>"> <?php echo e($value->first_name ." ".$value->last_name); ?> </a></td>
                                    <td><?php echo e($value->comment); ?> </td>
                                    <td><?php echo e($value->size); ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-compare">Compare Revisions</button>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        var limit = 3;
        $('input.single-checkbox').on('change', function(evt) {

            if($('input.single-checkbox:checked').length >= limit) {
                this.checked = false;
            }
            if($('input.single-checkbox:checked').length == 2) {
                $(".btn-compare").addClass("black-btn");
            }
            else
            {
                $(".btn-compare").removeClass("black-btn");
            }
        });
        var loc ='<?php echo url("units"); ?>/<?php echo $unit_id; ?>/diff';
        var slug ='';

        $(".btn-compare").click(function(){
            if($('input.single-checkbox:checked').length == 2) {
                var rev = $('input.single-checkbox:checked')[0].value;
                var comp = $('input.single-checkbox:checked')[1].value;
                console.log(loc + "/" + rev + "/" + comp);
                location.href = loc + "/" + rev + "/" + comp ;
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/units/revison/view.blade.php ENDPATH**/ ?>