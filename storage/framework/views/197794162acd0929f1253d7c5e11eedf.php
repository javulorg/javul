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
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
            </div>
            <?php echo $__env->make('forum.forum-partials.objectives', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('forum.forum-partials.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('forum.forum-partials.issues', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('forum.forum-partials.other-discussions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/forum/forum_home.blade.php ENDPATH**/ ?>