<?php $__env->startSection('title', 'My Watchlist'); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php
            $title = 'Activity Log';
            ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="main_content">
            <h2>Watch List</h2>
            <div class="content_block">

                <?php echo $__env->make('users.watchlist-partials.units', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('users.watchlist-partials.objectives', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('users.watchlist-partials.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('users.watchlist-partials.issues', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function ()
        {
            $('#watchlist-units-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '<?php echo e(url("api/watchlist-units/index")); ?>'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "unit_category",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });


            $('#watchlist-objectives-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '<?php echo e(url("api/watchlist-objectives/index")); ?>'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });

            $('#watchlist-tasks-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '<?php echo e(url("api/watchlist-tasks/index")); ?>'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });

            $('#watchlist-issues-table-id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : false,
                sorting      : false,
                lengthChange : false,
                autoWidth    : false,
                pageLength   : 5,
                searching    : false,
                order        : false,
                "ajax": {
                    "url":  '<?php echo e(url("api/watchlist-issues/index")); ?>'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "description",
                    }
                ],
            });
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/my_watchlist.blade.php ENDPATH**/ ?>