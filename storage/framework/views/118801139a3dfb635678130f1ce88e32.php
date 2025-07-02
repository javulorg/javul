<?php $__env->startSection('title', 'View Message'); ?>

<?php $__env->startSection('content'); ?>
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light border-end p-3">
                <?php echo $__env->make('message.menu', [], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <!-- Message Content -->
            <div class="col-md-9 p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <!-- Left: Back button + Subject + From/To -->
                    <div class="d-flex">
                        <!-- Back Button -->
                        <a onclick="history.back()" class="me-3 d-inline-flex align-items-center justify-content-center bg-light text-dark rounded-circle shadow-sm" style="width: 32px; height: 32px;">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <!-- Subject and Sender/Receiver -->
                        <div>
                            <h5 class="mb-1"><?php echo e($message['subject']); ?></h5>
                            <p class="mb-0">
                                <strong><?php echo e($message['to'] == $myId ? 'From' : 'To'); ?>:</strong>
                                <a href="<?php echo e($message['link']); ?>" class="text-decoration-none">
                                    <?php echo e($message['first_name']); ?> <?php echo e($message['last_name']); ?>

                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Right: Date/Time -->
                    <div>
                        <p class="text-muted small mb-0"><?php echo e($message['datetime']); ?></p>
                    </div>
                </div>




                <!-- Message Body -->
                <div class="mb-4 p-3 bg-light rounded border">
                    <?php echo $message['body']; ?>

                </div>

                <!-- Inline Reply Button -->
                <button class="btn btn-outline-primary btn-sm" onclick="toggleReplyForm()">
                    <i class="fas fa-reply me-1"></i> Reply
                </button>

                               <!-- Reply Form -->
                <div id="inlineReplyForm" class="d-none mt-3">
                    <h6>Reply to <?php echo e($message['first_name']); ?> <?php echo e($message['last_name']); ?></h6>
                    <form method="POST" action="<?php echo e(url('message/send-message')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="user_id" value="<?php echo e($message['from']); ?>">

                        <div class="mb-2">
                            <input type="text" name="subject" class="form-control"
                                value="Re: <?php echo e($message['subject']); ?>" required>
                        </div>

                        <div class="mb-2">
                            <textarea name="message" class="form-control" rows="4"
                                    placeholder="Write your reply..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-paper-plane me-1"></i> Send Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function toggleReplyForm() {
        document.getElementById('inlineReplyForm').classList.toggle('d-none');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/message/view.blade.php ENDPATH**/ ?>