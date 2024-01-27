<?php $__env->startSection('title', 'Ideas'); ?>
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
            <?php if(isset($unitData)): ?>
                <div class="content_block">
                    <div class="table_block table_block_ideas">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Ideas (<?php echo e($ideasTotal); ?>)
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Idea Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($unitIdea) > 0): ?>
                                <?php $__currentLoopData = $unitIdea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="title_col">
                                            <a href="<?php echo url('ideas/'.$ideaHashID->encode($idea->id)); ?>">
                                                <?php echo e($idea->title); ?>

                                            </a>
                                        </td>
                                        <?php if($idea->status == 1): ?>
                                            <td class="type_col"> Draft</td>
                                        <?php elseif($idea->status == 2): ?>
                                            <td class="type_col">Assigned to Task</td>
                                        <?php else: ?>
                                            <td class="type_col">Implemented</td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                        </div>
                    </div>
                </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>
                        <div class="pagination-right">
                            <?php if(isset($unitData)): ?>
                            <a href="<?php echo url('ideas/'.$unitIDHashID->encode($unitData->id).'/add'); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="content_block">
                    <div class="table_block table_block_ideas">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/humbleicons_bulb.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Ideas (<?php echo e($ideasMasterTotal); ?>)
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <table>
                                <thead>
                                <tr>
                                    <th class="type_col">Idea Name</th>
                                    <th class="title_col">Unit Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($ideasMaster) > 0 ): ?>
                                    <?php $__currentLoopData = $ideasMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="type_col">
                                                <a href="<?php echo url('ideas/'.$ideaHashID->encode($idea->id)); ?>">
                                                    <?php echo e($idea->title); ?>

                                                </a>
                                            </td>
                                            <td class="title_col">
                                                <a href="<?php echo url('units/'.$unitIDHashID->encode($idea->unit_id).'/'.\App\Models\Unit::getSlug($idea->unit_id)); ?>">
                                                    <?php echo e(\App\Models\Unit::getUnitName($idea->unit_id)); ?>

                                                </a>
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
                            <div class="mob_table d-sm-none d-block">
                            </div>
                        </div>
                    </div>
                    <div class="content_block_bottom">
                        <a href="<?php echo e(url('ideas')); ?>">See more</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/ideas/index.blade.php ENDPATH**/ ?>