<?php $__env->startSection('title', 'Message Inbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar bg-light border-end p-3">
                <?php echo $__env->make('message.menu', [], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <!-- Inbox Content -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <h5 class="mb-4">Inbox</h5>

                        <?php if(!empty($messages['message'])): ?>
                        <ul class="list-group">
                            <?php $__currentLoopData = $messages['message']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('message/view/'.$message['message_id'])); ?>"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between">
                                    <div class="message-header">
                                        <?php echo e($message['first_name']); ?> <?php echo e($message['last_name']); ?>

                                        <div class="message-time"><?php echo e($message['datetime']); ?></div>
                                    </div>
                                    <div class="text-truncate" style="max-width: 60%">
                                        <?php echo e(Str::limit($message['body'], 80)); ?>

                                    </div>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <div class="pagination justify-content-center">
                            <?php echo $messages['pagination']; ?>

                        </div>
                        <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <h5>Your <?php echo e($page); ?> is Empty</h5>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/message/inbox.blade.php ENDPATH**/ ?>