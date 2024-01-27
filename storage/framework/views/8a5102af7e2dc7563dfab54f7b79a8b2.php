<?php $__env->startSection('title', 'Message Inbox'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row form-group">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Message Inbox</h4>
                </div>
                <div class="card-body list-group">
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $__env->make('message.menu', array(), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group">
                                <?php $__currentLoopData = $messages['message']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <a href="<?php echo e(url('message/view/'.$value['message_id'])); ?>">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="heading">
                                                    <?php echo e($value['first_name']); ?> <?php echo e($value['last_name']); ?>

                                                    <span class="time"><?php echo e($value['datetime']); ?></span>
                                                </div>
                                                <div class="body"><?php echo e($value['body']); ?></div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(empty($messages['message'])): ?>
                                    <h4 class="text-center"><br><br>Your <?php echo e($page); ?> is Empty </h4>
                                <?php endif; ?>
                            </ul>
                            <div class="pagination justify-content-center mt-3">
                                <?php echo $messages['pagination']; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/message/inbox.blade.php ENDPATH**/ ?>