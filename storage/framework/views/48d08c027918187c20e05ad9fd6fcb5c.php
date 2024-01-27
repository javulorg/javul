<div class="row">
    <div class="col-sm-6 form-group">
        <div class="panel panel-default panel-grey">
            <div class="panel-heading">
                <h4>Withdrawal Request</h4>
            </div>
            <div class="panel-body table-inner table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($withdrawal_list) > 0): ?>
                        <?php $__currentLoopData = $withdrawal_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(date('d-m-Y',strtotime($withdraw->created_at))); ?></td>
                                <td><?php echo e($withdraw->amount); ?></td>
                                <td style="text-transform:capitalize"><?php echo e($withdraw->status); ?></td>
                                <td>
                                    <?php if($withdraw->withdrawal_status == "withdrawal"): ?>
                                        <a class="btn btn-xs btn-danger zcash-cancel" data-id="<?php echo e($withdraw->id); ?>" href="">Cancel</a>
                                    <?php elseif($withdraw->withdrawal_status == "rejected"): ?>
                                        <a class="btn btn-xs btn-danger" href="javascript:void(0);">Rejected by Admin</a>
                                    <?php elseif($withdraw->withdrawal_status == "approved"): ?>
                                        <a class="btn btn-xs btn-success" herf="javascript:void(0);">Approved</a>
                                    <?php elseif($withdraw->withdrawal_status == "cancel"): ?>
                                        <a class="btn btn-xs btn-danger" herf="javascript:void(0);">Cancelled by You</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">
                                No record found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/user-account-partials/withdraw-list.blade.php ENDPATH**/ ?>