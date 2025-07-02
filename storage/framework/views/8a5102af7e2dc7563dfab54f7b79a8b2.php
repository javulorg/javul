<?php $__env->startSection('title', 'Message ' . ucfirst($page)); ?>

<?php $__env->startSection('content'); ?>
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light border-end p-3">
                <?php echo $__env->make('message.menu', [], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <!-- Content Area -->
            <div class="col-md-9 p-4">
                <?php if(!empty($messages['message'])): ?>
                    <div id="inboxList">
                        <h5 class="mb-4"><?php echo e(ucfirst($page)); ?></h5>

                        <ul class="list-group">
                            <?php $__currentLoopData = $messages['message']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item list-group-item-action">
                                    <a href="<?php echo e(url('message/view/'.$value['message_id'])); ?>" class="text-decoration-none text-dark d-block">
                                        <div class="me-auto">
                                            <div>
                                                <span class="fw-bold"><?php echo e($value['subject'] ?? 'No Subject'); ?></span> -
                                                <span class="text-muted fw-light">
                                                    <?php echo e(\Illuminate\Support\Str::words($value['body'] ?? '', 13, '...')); ?>

                                                </span>
                                            </div>
                                            <div class="fw-bold my-1">
                                                <?php echo e(request()->is('inbox') ? 'From:' : 'To:'); ?>

                                                <?php echo e($value['first_name']); ?> <?php echo e($value['last_name']); ?>

                                            </div>
                                            <small class="text-muted"><?php echo e($value['datetime'] ?? ''); ?></small>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>

                    <div class="pagination justify-content-center mt-3">
                        <?php echo $messages['pagination']; ?>

                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <h5>Your <?php echo e(ucfirst($page)); ?> is Empty</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/message/inbox.blade.php ENDPATH**/ ?>