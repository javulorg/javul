<form role="form" method="post" id="withdraw-amount"  novalidate="novalidate" <?php if($payment_method == "Zcash"): ?> action="<?php echo e(url('account/request-to-transfer-zcash')); ?>" <?php else: ?> action="<?php echo e(url('account/withdraw')); ?>" <?php endif; ?>>
    <?php echo csrf_field(); ?>
    <?php if($errors->has('error')): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <img src="<?php echo url('assets/images/error-icon.png'); ?>"> <strong>Error!</strong> <?php echo e($errors->first('error')); ?>.
        </div>
    <?php endif; ?>

    <?php if($errors->has('paypal_email')): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <img src="<?php echo url('assets/images/error-icon.png'); ?>"> <strong>Error!</strong> <?php echo e($errors->first('paypal_email')); ?>.
        </div>
    <?php endif; ?>
    <?php if(empty(auth()->user()->paypal_email) && $payment_method == "PAYPAL"): ?>
        <div class="row form-group">
            <div class="col-sm-4">
                <label for="paypal_email" class="control-label">Paypal Email ID</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input id="paypal_email" type="email" class="form-control" value="<?php echo e(old('paypal_email')); ?>"
                           name="paypal_email"
                           autocomplete="off" required >
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($payment_method == "Zcash"): ?>
        <div class="row form-group">
            <div class="col-sm-4">
                <label for="zcash_address" class="control-label">Enter your address</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input id="zcash_address" type="text" class="form-control" value="<?php echo e(old('zcash_address')); ?>" placeholder="Please enter Zcash address" name="zcash_address" autocomplete="off" required>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <button type="button" class="btn orange-bg withdraw-submit">
        <?php if($payment_method == "Zcash"): ?>
            <span class="withdraw-text">Send Transfer Request</span>
        <?php else: ?>
            <span class="withdraw-text">Transfer my full balance to my Paypal account</span>
        <?php endif; ?>
    </button>

    <input type="hidden" value="<?php echo e($payment_method); ?>" id="payment_method" name="payment_method"/>
</form>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/user-account-partials/withdraw-amount.blade.php ENDPATH**/ ?>