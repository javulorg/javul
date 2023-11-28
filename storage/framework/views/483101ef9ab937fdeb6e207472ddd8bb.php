<?php $__env->startSection('title', 'Issues'); ?>
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
                    <div class="table_block table_block_issues">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Issues
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
                                    <th class="title_col">Issue Name</th>
                                    <th class="type_col">Status</th>
                                    <th class="type_col">Created By</th>
                                    <th class="type_col">Created Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($unitIssues) && count($unitIssues) > 0): ?>
                                    <?php $__currentLoopData = $unitIssues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="title_col">
                                                <a href="<?php echo url('issues/'.$issueIDHashID->encode($obj->id).'/view'); ?>"
                                                   title="edit">
                                                    <?php echo e($obj->title); ?>

                                                </a>
                                            </td>
                                            <td class="type_col">
                                                <?php $status_class=''; $verified_by =''; $resolved_by ='';
                                                if($obj->status=="unverified")
                                                    $status_class="text-danger";
                                                elseif($obj->status=="verified"){
                                                    $status_class="text-info";
                                                    $verified_by = " (by ".App\Models\User::getUserName($obj->verified_by).')';
                                                }
                                                elseif($obj->status == "resolved"){
                                                    $status_class = "text-success";
                                                    $resolved_by = " (by ".App\Models\User::getUserName($obj->resolved_by).')';
                                                }
                                                ?>
                                                <span class="<?php echo e($status_class); ?>"><?php echo e(ucfirst($obj->status).$verified_by. $resolved_by); ?></span>
                                            </td>
                                            <td class="type_col">
                                                <a href="<?php echo url('userprofiles/'.$userIDHashID->encode($obj->user_id).'/'.strtolower(str_replace(" ","_",App\Models\User::getUserName($obj->user_id)))); ?>">
                                                    <?php echo e(App\Models\User::getUserName($obj->user_id)); ?>

                                                </a>
                                            </td>
                                            <td class="type_col"><?php echo e($obj->created_at); ?></td>
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
                            <a href="<?php echo url('issues/'.$unitIDHashID->encode($unitData->id).'/add'); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="content_block">
                    <div class="table_block table_block_issues">
                        <div class="table_block_head">
                            <div class="table_block_icon">
                                <img src="<?php echo e(asset('v2/assets/img/bug.svg')); ?>" alt="" class="img-fluid">
                            </div>
                            Issues (<?php echo e($issuesTotal); ?>)
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
                                        <th class="type_col">Issue Name</th>
                                        <th class="title_col">Unit Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($issuesMaster) && count($issuesMaster) > 0 ): ?>
                                        <?php $__currentLoopData = $issuesMaster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="type_col">
                                                    <a href="<?php echo url('issues/'.$issueIDHashID->encode($issue->id).'/view'); ?>">
                                                        <?php echo e($issue->title); ?>

                                                    </a>
                                                </td>
                                                <td class="title_col">
                                                    <a href="<?php echo url('units/'.$unitIDHashID->encode($issue->unit_id).'/'.\App\Models\Unit::getSlug($issue->unit_id)); ?>">
                                                        <?php echo e(\App\Models\Unit::getUnitName($issue->unit_id)); ?>

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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/index.blade.php ENDPATH**/ ?>