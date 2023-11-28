<?php $__env->startSection('title', 'Units'); ?>
<?php $__env->startSection('site-name'); ?>
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">
            <?php if(isset($homeCheck) && $homeCheck != true): ?>
                <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php
                $title = 'Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                <div class="table_block table_block_units">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <i class="fa-brands fa-stack-overflow"></i>
                        </div>
                        Units (<?php echo e($unitsTotal); ?>)
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col"><?php echo e(__('messages.unit_name')); ?></th>
                                <th class="last_reply_col"><?php echo e(__('messages.unit_category')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($allUnits) > 0 ): ?>
                                <?php $__currentLoopData = $allUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $category_ids = $unit->category_id;

                                    $category_names = \App\Models\UnitCategory::getName($category_ids);
                                    $category_ids = explode(",",$category_ids);
                                    $category_names  = explode(",",$category_names );
                                    ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug); ?>">
                                                <?php echo e($unit->name); ?>

                                            </a>
                                        </td>
                                        <td class="last_reply_col">
                                            <?php if(count($category_ids) > 0 ): ?>
                                                <?php $__currentLoopData = $category_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo url('units/category='.strtolower($category_names[$index])); ?>"><?php echo e($category_names[$index]); ?></a>
                                                    <?php if(count($category_ids) > 1 && $index != count($category_ids) -1): ?>
                                                        <span>&#44;</span>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <a href="<?php echo e(url('units/create')); ?>">
                        <img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function () {
            $('#master-units-table-id').DataTable({
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
                    "url":  '<?php echo e(url("api/units/index")); ?>'
                },
                "columns" : [
                    {
                        "data" : "title",
                    },
                    {
                        "data" : "unit_category",
                    },
                ],
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/units/index.blade.php ENDPATH**/ ?>