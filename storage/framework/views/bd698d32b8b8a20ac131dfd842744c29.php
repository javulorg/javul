<?php $__env->startSection('page-css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo url('assets/css/wiki.css'); ?>">
<link href="<?php echo url('assets/plugins/bootstrap-star-rating-master/css/star-rating.css'); ?>" media="all" rel="stylesheet" type="text/css" />
<style>
    span.tags{padding:0 6px;}
    .text-danger{color:#ed6b75 !important;}
    .navbar-nav > li.active{background-color: #e7e7e7;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row form-group" style="margin-bottom:15px;">
        <?php echo $__env->make('elements.user-menu',array('page'=>'home'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php echo $__env->make('users.user-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-sm-4">
            <div class="left" style="position: relative;margin-top: 30px;">
                <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="site_activity_list">
                    <?php echo $__env->make('elements.site_activities_user',['site_activity'=>$site_activities], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
                <div class="panel panel-grey panel-default" style="margin-top:29px ">
                    <div class="panel-heading">
                        <h4 class="pull-left"><?php echo e($pageObj->page_title); ?> </h4>
                        <div class="user-wikihome-tool pull-right small-a">
                           <a href="<?php echo e(route('user_wiki_newpage',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])); ?>"> + New Page </a> | 
                           <a href="<?php echo e(route('user_wiki_recent_changes',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])); ?>"> Recent Changes </a> |
                           <a href="<?php echo e(route('user_wiki_page_list',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])); ?>"> List All Pages </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body table-inner table-responsive loading_content_hide">
                        <div class="pull-right small-a">
                            <a href="<?php echo e(route('user_wiki_editpage',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash, $page_id_hase ])); ?>">Edit</a>
                            <a href="<?php echo e(route('user_wiki_history',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash, $page_id_hase ])); ?>">View History</a>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 wiki-page-desc"><?= $pageObj->page_content ?></div>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-scripts'); ?>
<script src="<?php echo url('assets/plugins/bootstrap-star-rating-master/js/star-rating.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $('#input-3').rating({displayOnly: true, step: 0.1,size:'xs'});
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/users/wiki/wiki_page_view.blade.php ENDPATH**/ ?>