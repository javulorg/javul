<?php $__env->startSection('title', 'New Message'); ?>

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
                <h5 class="mb-3">Compose New Message</h5>
                <form method="post"  action="<?php echo e(route('message.send-message')); ?>" enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>

                    <?php if($user_id > 0): ?>
                        <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
                    <?php else: ?>
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <select id="user_id_fromSel2" name="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>">
                                        <?php echo e($value->first_name); ?> <?php echo e($value->last_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control summernote" rows="6" name="message" id="message" placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
        ClassicEditor
            .create( document.querySelector('#message') )
            .catch( error => {
                console.error(error);
            } );

        var xhr;
        $("#form_topic_form").submit(function(){
            if(xhr && xhr.readyState != 4){
                xhr.abort();
            }
            $("#form_topic_form").find(".alert").remove();
            xhr = $.ajax({
                type:'post',
                url:'<?php echo url('message/send'); ?>/<?php echo $user_id; ?>',
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function(){
                    $("#form_topic_form button").button("loading");
                },
                error:function(){

                },
                complete:function(){
                    $("#form_topic_form button").button("reset");
                },
                success:function(json){
                    if(json['errors']){
                        $.each(json['errors'],function(i,j){
                            $("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");
                        })
                    }
                    if(json['success']){
                        toastr['success'](json['success'], '');
                        $("#form_topic_form textarea").val('');
                        $("#form_topic_form input").val('');
                        // setTimeout(function(){ location = json['location'] },1000);
                    }
                    if(json['error']){
                        toastr['error'](json['error'], '');
                    }
                }
            });
            return false;
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/message/send.blade.php ENDPATH**/ ?>