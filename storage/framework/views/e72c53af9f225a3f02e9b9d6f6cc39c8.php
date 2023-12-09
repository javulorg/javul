<?php $__env->startSection('title', 'Unit: ' . $unitObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
    </style>
<?php $__env->stopSection(); ?>

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
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
            <div class="content_block">

                <div class="content_block">
                </div>
                <div class="col-md-12 order-md-2">
                            <div class="card panel-grey">
                                <div class="card-header">
                                    <h4 class="card-title">Create New Thread</h4>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <form role="form" method="post" id="form_topic_form">
                                                <?php echo csrf_field(); ?>
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" name="title" value="" class="form-control" placeholder="Title" />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea class="form-control summernote" name="desc"></textarea>
                                                </div>
                                                <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
                                                <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
                                                <div class="mb-3">
                                                    <button class="btn btn-primary">Submit New Thread</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function (){
            var xhr;
            $("#form_topic_form").submit(function(){
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }
                $("#form_topic_form").find(".alert").remove();
                xhr = $.ajax({
                    type:'post',
                    url:'<?php echo url('forum/submit'); ?>',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $("#form_topic_form button").button("loading");
                    },
                    error:function(){

                    },
                    success:function(json){
                        if(json['errors']){
                            $.each(json['errors'],function(i,j){
                                $("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");
                            })
                        }
                        if(json['success'])
                        {
                            toastr['success'](json['success'], '');
                            setTimeout(function(){ location = json['location'] },1000);
                        }
                        if(json['error']){
                            toastr['error'](json['error'], '');
                        }
                    }
                });
                return false;
            });



            window.onload = function()
            {
                function chatOnline()
                {
                    $.ajax({
                        type:'post',
                        url: '<?php echo e(url("/chat/online")); ?>',
                        data:{_token:'<?php echo e(csrf_token()); ?>',unit_id:<?php echo $unitObj->id; ?>},
                        dataType:'json',
                        complete: function(xhr, textStatus) {
                            setTimeout(function(){ chatOnline() }, 5000);
                        },
                        success:function(resp,text,xhr){
                            $("#chat-online").html(resp.online);
                        }
                    })
                }
                chatOnline();
            }

            $(".topic-list").delegate(".up-down-vote","click",function(){
                $this = $(this);
                var topic_id  = $this.parents("li:first").attr("data-id");
                var val  = $this.attr("data-value");
                $.ajax({
                    type:'post',
                    url:'<?php echo url('forum/topicUpDown'); ?>',
                    data:{
                        _token : '<?php echo e(csrf_token()); ?>',
                        val : val,
                        topic_id : topic_id,
                        didIt : $this.hasClass("active"),
                    },
                    dataType:'json',
                    beforeSend:function(){
                        if($this.hasClass("active")){
                            $this.parents(".up-down").find(".active").removeClass("active");
                        }
                        else
                        {
                            $this.parents(".up-down").find(".active").removeClass("active");
                            $this.addClass("active");
                        }
                    },
                    success:function(json){
                        if(json['success']){
                            $this.parents(".up-down").find(".count").html(json['count']);
                        }
                        if(json['error']){
                            toastr['error'](json['error'], '');
                        }
                    }
                });
            });

        })
    </script>
<?php $__env->stopSection(); ?>








































































































































<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/forum/forum_create.blade.php ENDPATH**/ ?>