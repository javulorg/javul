<?php $__env->startSection('title', 'Objectives'); ?>

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
                <div class="table_block table_block_objectives">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                        </div>
                        Objectives
                        <div class="arrow">
                            <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <?php if(isset($unitData)): ?>
                            <input type="hidden" name="unit" value="<?php echo e($unitData->id); ?>" id="unit_id">
                        <?php else: ?>
                            <input type="hidden" name="unit" value="<?php echo e(null); ?>" id="unit_id">
                        <?php endif; ?>
                        <table id="unit-objectives-table-id">
                            <thead>
                            <tr>
                                <th class="title_col">Objective Name</th>
                                <th class="type_col">Support</th>
                                <th class="type_col">In progress</th>
                                <th class="type_col">Available</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if(count($unitObjectives) > 0): ?>
                                <?php $__currentLoopData = $unitObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug); ?>" title="edit">
                                                <?php echo e($obj->name); ?>

                                            </a>
                                        </td>
                                        <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('available',$obj->id)); ?></td>
                                        <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('in-progress',$obj->id)); ?></td>
                                        <td  class="text-center"><?php echo e(\App\Models\Task::getTaskCount('completed',$obj->id)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                    </div>
                    <div class="pagination-right">
                        <a href="<?php echo url('objectives/'.$unitIDHashID->encode($unitData->id).'/add'); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="content_block">
                    <div class="table_block table_block_objectives">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Objectives (<?php echo e($objectivesTotal); ?>)
                            <div class="arrow">
                                <img src="<?php echo e(asset('v2/assets/img/bottom.svg')); ?>" alt="">
                            </div>
                        </div>
                        <div class="table_block_body">
                            <?php if(isset($unitData)): ?>
                                <input type="hidden" name="unit" value="<?php echo e($unitData->id); ?>" id="unit_id">
                            <?php else: ?>
                                <input type="hidden" name="unit" value="<?php echo e(null); ?>" id="unit_id">
                            <?php endif; ?>
                            <table>
                                <thead>
                                <tr>
                                    <th class="title_col">Objective Name</th>
                                    <th class="last_reply_col">Unit Name</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if(count($objectivesMasterData) > 0 ): ?>
                                    <?php $__currentLoopData = $objectivesMasterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="title_col">
                                                <a href="<?php echo url('objectives/'.$objectiveIDHashID->encode($objective->id).'/'.$objective->slug); ?>">
                                                    <?php echo e($objective->name); ?>

                                                </a>
                                            </td>
                                            <td class="last_reply_col">
                                                <a href="<?php echo url('units/'.$unitIDHashID->encode($objective->unit_id).'/'. \App\Models\Unit::getSlug($objective->unit_id) ); ?>">
                                                    <?php echo e($objective->unit->name); ?>

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
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                        </div>



                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/index.blade.php ENDPATH**/ ?>