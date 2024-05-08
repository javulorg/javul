<?php $__env->startSection('title', 'Task: View Revision'); ?>
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
                        <div class="table_block_icon current_task_heading featured_unit_heading">
                            <img src="<?php echo e(asset('v2/assets/img/list.svg')); ?>" style="margin-bottom:6px;" alt="" class="img-fluid">
                        </div>
                        <h4 class="card-title ml-3" style="font-size: medium;">View Revision: <?php echo $taskObj->name; ?> </h4>

                        <h4 class="card-title" style="font-size: medium;">View Revision: <?php echo $taskObj->name; ?>

                            <input type="hidden" value="<?php echo e($taskObj->id); ?>" id="task_id">
                            <a href="#" id="thumb-up-btn" class="ml-auto"><i class="fas fa-thumbs-up"></i></a>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Previous revision</h4>
                            <h5 class="text-center"><?= date("d-m-Y h:A",strtotime($revisions->created_at)) ?>, Edited By User <?php echo $revisions->first_name .' '. $revisions->last_name; ?></h5>
                            <hr>
                            <div class="wiki-page-desc"><?php echo $revisions->description; ?></div>
                            <hr>
                            <p><strong>Comment:</strong> <?php echo e($revisions->comment); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#thumb-up-btn').click(function(e) {
                e.preventDefault();
                var taskId = $('#task_id').val();
                $.ajax({
                    type: "POST",
                    url: '<?php echo e(url("/tasks/upvote-edits")); ?>',
                    data: {
                        taskId   : taskId,
                        _token: $('input[name="_token"]').val(),
                    },

                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Tasks likes updated successfully',
                            timer: 2000 // Close after 2 seconds
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'You have already upvoted this task',
                            timer: 2000 // Close after 2 seconds
                        });
                    }
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/tasks/revison/view_revision.blade.php ENDPATH**/ ?>