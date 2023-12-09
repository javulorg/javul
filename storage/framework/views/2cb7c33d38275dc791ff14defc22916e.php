<?php $__env->startSection('title', 'Forum Thread: ' . $topic->title); ?>
<?php $__env->startSection('style'); ?>
    <style type="text/css">
        .post-desc {
            margin-left: 24px;
        }
        .post-desc .up-down .glyphicon-arrow-up {
            margin: 0;
        }
        .post-desc .ideapoint  {
            cursor: pointer;
        }
        .post-desc .ideapoint.active {
            color: #fdb105;
        }
        .post-desc .up-down .count {
            margin: 0;
            text-align: center;
        }
        .post-desc .up-down {
            left: 18px;
        }
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Forum Thread: <?= $topic->title ?>
                                <?php if(isset($topic->objectLink)){ ?>
                                <a class="pull-right" href="<?= $topic->objectLink ?>"><?= $topic->objectLinkText ?></a>
                                <?php } ?>
                            </h4>
                        </div>
                        <div class="card-body list-group panel-body">
                            <div class="list-group-item">
                                <div class="post-desc">
                                    <div class="up-down">
                                        <i data-value="1" data-id="<?= $topic->topic_id ?>" class="bi <?= $topic->updownstatus == 1 ? 'bi-arrow-up active' : 'bi-arrow-up' ?>"></i>
                                        <i data-value="0" data-id="<?= $topic->topic_id ?>" class="bi <?= $topic->updownstatus == -1 ? 'bi-arrow-down active' : 'bi-arrow-down' ?>"></i>
                                    </div>
                                    <b><a href="<?= $topic->link ?>"> <?= $topic->first_name ." " . $topic->last_name ?> </a></b>
                                    <?= $topic->created_time ?> Point <span class="pointcount"><?= (int)$topic->votecount ?></span>
                                    <i data-id="<?= $topic->topic_id ?>" data-value="<?= (int)$topic->topicideapointstatus ?>" class="bi <?= (int)$topic->topicideapointstatus ? 'bi-lightbulb-fill active' : 'bi-lightbulb' ?>"></i>
                                    <span class="ideacount"> <?= (int)$topic->idepointcount ?> </span>
                                    <br>
                                    <?= $topic->desc ?>
                                </div>
                                <hr>
                                <div class="post-placeholder"></div>
                                <form role="form" method="post" class="post-form" id="form_topic_form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('post'); ?>
                                    <div class="form-group">
                                        <textarea class="form-control summernote" name="post"></textarea>
                                    </div>
                                    <input type="hidden" name="reply_id" value="0">
                                    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                                    <div class="col-sm-12 mt-2 form-group">
                                        <button type="submit" class="btn btn-dark pull-right">Submit Reply</button>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(".post-desc").on("click", ".ideapoint", function(){
            var $this = $(this);
            var topic_id = $this.attr("data-id");
            var val = $this.attr("data-value");

            $.ajax({
                type: 'post',
                url: '<?php echo url('forum/post_ideapoint'); ?>',
                data: {
                    _token: $("#form_topic_form").find("input[name=_token]").val(),
                    val: val,
                    topic_id: topic_id
                },
                dataType: 'json',
                beforeSend: function(){
                    $this.toggleClass("active", '');
                },
                success: function(json){
                    $this.attr("data-value", json['val']);
                    var count = Number($this.parents(".post-desc").find(".ideacount").text());
                    $this.parents(".post-desc").find(".ideacount").text(count + (Number(json['val']) == 1 ? 1 : -1));

                    if(json['error']){
                        toastr['error'](json['error'], '');
                    }
                }
            });
        });

        $(".post-desc").on("click", ".up-down-vote", function(){
            var $this = $(this);
            var topic_id = $this.attr("data-id");
            var val = $this.attr("data-value");

            $.ajax({
                type: 'post',
                url: '<?php echo url('forum/topicUpDown'); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    val: val,
                    topic_id: topic_id,
                    didIt: $this.hasClass("active")
                },
                dataType: 'json',
                beforeSend: function(){
                    if($this.hasClass("active")){
                        $this.parents(".up-down").find(".active").removeClass("active");
                    }
                    else {
                        $this.parents(".up-down").find(".active").removeClass("active");
                        $this.addClass("active");
                    }
                },
                success: function(json){
                    if(json['success']){
                        $this.parents(".post-desc").find(".pointcount").html(json['count']);
                    }

                    if(json['error']){
                        toastr['error'](json['error'], '');
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var xhr;

            $(".panel-body").on("submit", ".post-form", function(event) {
                event.preventDefault();

                // Store a reference to the form
                var $form = $(this);

                // Abort any ongoing AJAX request
                if (xhr && xhr.readyState !== 4) {
                    xhr.abort();
                }

                // Remove existing alerts
                $form.find(".alert").remove();

                // Send AJAX request
                xhr = $.ajax({
                    type: 'POST',
                    url: '<?php echo url('forum/postSubmit'); ?>',
                    data: $form.serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $form.find("button[type=submit]").button("loading");
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle error
                    },
                    // complete: function() {
                    //     $form.find("button[type=submit]").button("reset");
                    // },
                    success: function(json) {
                        if (json.errors) {
                            // Display validation errors
                            $.each(json.errors, function(field, errorMessage) {
                                $form.find("[name='" + field + "']").after("<div class='alert alert-danger'>" + errorMessage + "</div>");
                            });
                        } else {
                            var $loader = $(".loader");
                            var $postContainer = $form.parents("li:first");

                            if ($form.attr("id") === "form_topic_form") {
                                $postContainer = $(".post-placeholder");
                            }

                            var html = renderHtml(json.post.items, $form.serializeArray(), $loader, $postContainer, $form.attr("id") !== "form_topic_form");
                            $loader, $postContainer.append(html);

                            if (json.success) {
                                toastr.success(json.success, '');
                                location.reload(); // Reload the page
                            }
                            if (json.error) {
                                toastr.error(json.error, '');
                            }
                        }

                        $form.find("button[type=submit]").button("reset");
                    }
                });

                var reply_id = $form.find('[name=reply_id]').val();
                $('.tool').find('[data-reply=' + reply_id + ']').show();

                return false;
            });
        })





        function loadTopic(data,$input,$placeholder){
            data['_token'] = $("#form_topic_form").find("input[name=_token]").val();
            $.ajax({
                type:'post',
                url:'<?php echo url('forum/postLoad'); ?>',
                data:data,
                dataType:'json',
                // beforeSend:function(){
                //     $input.button("loading");
                // },
                error:function(){

                },
                complete:function(){
                    $input.button("reset");
                },
                success:function(json){
                    if(json['error']){
                        toastr['error'](json['error'], '');
                    }

                    var html = renderHtml(json['post'],data,$input,$placeholder);
                    html += json['paginate'];
                    $placeholder.append(html);
                }
            });
        }
        function renderHtml(json,data,$input,$placeholder,IsPrepend){
            var html = '';
            if(json){
                $.each(json,function(i,j){
                    html += '<ul class="posts">';
                    html += '<li class="post-div" data-id="'+ j['post_id'] +'">';
                    html += '       <div class="up-down">';
                    html += '           <i data-value="1" class="glyphicon '+ (j['updown'] == 1 ? 'active' : '') +' up-down-vote glyphicon-arrow-up"></i>';
                    html += '           <i data-value="0" class="glyphicon '+ (j['updown'] == -1 ? 'active' : '') +' up-down-vote glyphicon-arrow-down"></i>';
                    html += '       </div>';
                    html += '    <div class="heading"><a href="'+ j['link'] +'">';
                    html +=          j['first_name'] + " "+  j['last_name'];
                    html += '        </a><span class="date">'+  j['created_time'] + '</span>';
                    html += '        <span class="point">'+  j['updownpoint'] + ' points</span>  ';
                    html += '        <span class="idea-point"><i data-value="'+ j['ideapoint'] +'" class="fa ideapoint '+ (j['ideapoint'] == 1 ? 'active' : '') +'  fa-lightbulb-o"></i><span class="count">'+ j['ideascore'] +'</span></span>';
                    html += '    </div>';
                    html += '    <div class="post-body">';
                    html +=          j['post'];
                    html += '       <div class="tool">';
                    html += '           <a href="javascript:void(0)" data-reply="'+ j['post_id'] +'" > Reply </a>';
                    html += '       </div>';
                    html += '    </div>';
                    if(j['reply']){
                        html += renderHtml(j['child']['items'],data,$input,$placeholder,IsPrepend);
                    }
                    html += '</li>';
                    html += '</ul>';
                });
            }
            /*if(data['parent'] == '0'){
                $('[data-parent="0"]').parents("li").remove();
                if(json['left']){
                    html += "<li class='loadmore' ><a href='javascript:void(0)' data-parent='0' data-page='"+ (Number(data['page']) + 1) +"' > Load more post </a> ("+ json['left'] +" post) </li>";
                }
            }
            else
            {
                $placeholder.find(".loadmore:first").remove();
                if(json['left']){
                    html += "<li class='loadmore' ><a href='javascript:void(0)' data-parent='0' data-page='"+ (Number(data['page']) + 1) +"' > Load more post </a> ("+ json['left'] +" post) </li>";
                }
            }*/

            return html;
        }

        $(".post-placeholder").on("click", ".cancel-reply", function() {
            var $tool = $(this).parents(".tool");
            var $form = $(this).parents("form");

            $tool.find('[data-reply]').show();
            $form.remove();
        });
        $(".post-placeholder").on("click", ".up-down-vote", function() {
            var $this = $(this);
            var post_id = $this.parents("li:first").attr("data-id");
            var val = $this.attr("data-value");

            $.ajax({
                type: 'POST',
                url: '<?php echo url('forum/postUpDown'); ?>',
                data: {
                    _token: $("#form_topic_form").find("input[name=_token]").val(),
                    val: val,
                    post_id: post_id,
                    didIt: $this.hasClass("active"),
                },
                dataType: 'json',
                beforeSend: function() {
                    var $upDown = $this.parents(".up-down");
                    var $active = $upDown.find(".active");

                    if ($this.hasClass("active")) {
                        $active.removeClass("active");
                    } else {
                        $active.removeClass("active");
                        $this.addClass("active");
                    }
                },
                success: function(json) {
                    $this.parents("li.post-div").find(".heading .point").text(json.point + " Points");
                    if (json.error) {
                        toastr.error(json.error, '');
                    }
                }
            });
        });

        $(".post-placeholder").on("click", ".ideapoint", function() {
            var $this = $(this);
            var post_id = $this.parents("li:first").attr("data-id");
            var val = $this.attr("data-value");

            $.ajax({
                type: 'POST',
                url: '<?php echo url('forum/ideapoint'); ?>',
                data: {
                    _token: $("#form_topic_form").find("input[name=_token]").val(),
                    val: val,
                    post_id: post_id,
                },
                dataType: 'json',
                beforeSend: function() {
                    $this.toggleClass("active");
                },
                success: function(json) {
                    $this.attr("data-value", json.val);
                    var $ideaPoint = $this.parents(".idea-point");
                    var $count = $ideaPoint.find(".count");
                    var count = Number($count.text());
                    $count.text(count + (Number(json.val) === 1 ? 1 : -1));

                    if (json.error) {
                        toastr.error(json.error, '');
                    }
                }
            });
        });
        $(".post-placeholder").on("click", "[data-reply]", function() {
            var $this = $(this);
            var id = $this.attr("data-reply");
            var html = '';
            html += '<form role="form" class="post-form" method="post" id="reply-' + id + '" enctype="multipart/form-data">';
            html += '    <?php echo csrf_field(); ?>';
            html += '    ';
            html += '    <div class="form-group">';
            html += '        <textarea class="form-control summernote" name="post"></textarea>';
            html += '    </div>';
            html += '    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">';
            html += '    <input type="hidden" name="reply_id" value="' + id + '">';
            html += '    <div class="pull-right form-group">';
            html += '        <button type="submit" class="btn black-btn">Submit Reply</button>';
            html += '        <button type="button" class="btn black-btn cancel-reply">Cancel</button>';
            html += '    </div>';
            html += '    <div class="clearfix"></div>';
            html += '</form>';

            $("#reply-" + id).remove();
            $this.before(html);

            $("#reply-" + id + " .summernote").ckeditor();

            $this.hide();
        });

        $(".post-placeholder").on("click", ".loadmore", function() {
            var $this = $(this);
            var page = $this.find("a").attr("data-page");
            var parent = $this.find("a").attr("data-parent");
            var data = {};
            data['topic_id'] = '<?php echo $topic_id; ?>';
            data['page'] = page;
            data['parent'] = parent;
            var $placeholder = $this.parents("ul:first");
            if (parent == 0) {
                $placeholder = $(".post-placeholder");
                $this.remove();
            }
            loadTopic(data, $this, $placeholder);
        });
        var data = {};
        data['topic_id'] = '<?php echo $topic_id; ?>';
        data['page'] = '<?= isset($_GET["page"]) ? (int)$_GET["page"] : 0 ?>';
        data['parent'] = 0;
        loadTopic(data,$(".loader"),$(".post-placeholder"));
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/forum/post.blade.php ENDPATH**/ ?>