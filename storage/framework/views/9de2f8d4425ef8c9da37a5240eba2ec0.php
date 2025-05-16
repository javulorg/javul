<?php $__env->startSection('title', 'New Message'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>New Message</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $__env->make('message.menu', array(), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-10">
                            <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <br>
                                <?php if($user_id > 0): ?>
                                    <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
                                <?php else: ?>
                                    <div class="col-sm-12 form-group">
                                        <label for="user_id_fromSel2">To</label>
                                        <select id="user_id_fromSel2" name="user_id" class="form-control">
                                            <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>">
                                                    <?php echo e($value->first_name); ?> <?php echo e($value->last_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="col-sm-12 form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control summernote" rows="5" name="message" id="message"></textarea>
                                </div>
                                <div class="col-sm-12 mt-3 form-group">
                                    <button class="btn btn-dark float-end">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
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