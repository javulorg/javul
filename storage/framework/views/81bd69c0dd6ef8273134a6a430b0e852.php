<div class="content_block mt-3 mb-4">
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

                <?php if(count($issues) > 0): ?>
                    <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <a href="<?php echo url('issues/'.$unitIDHashID->encode($unit_activity_id).'/add'); ?>"><img src="<?php echo e(asset('v2/assets/img/circle-plus.svg')); ?>" alt=""> Add New</a>
        </div>
    </div>
</div>










<?php /**PATH C:\xampp\htdocs\javul\resources\views/units/view-unit-partials/issues.blade.php ENDPATH**/ ?>