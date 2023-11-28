<?php $__env->startSection('title', 'Chat'); ?>
<?php $__env->startSection('style'); ?>
<style>
    .wrapper {
        position: relative;
        left: 50%;
        /*width: 1000px;*/
        /*height: 800px;*/
        -moz-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }

    .chat-room {
        position: relative;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 75%;
        background-color: #fff;
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .chat-room .left .people,.chat-room .right .chat {
        /*  height: 500px !important;
          overflow: auto;*/
    }
    .chat-room .left {
        float: left;
        width: 37.6%;
        height: 100%;
        border: 1px solid #e6e6e6;
        background-color: #f9f9f9;

    }
    .chat-room .left .top {
        position: relative;

        width: 100%;
        height: 39px;


        background-color: #ebe9e9;
        color: #3F3F3F;
        text-transform: uppercase;
        font-family: "Roboto" !important;
        font-weight: 500;
        border-bottom: 3px solid #5a5858;
    }
    .chat-room .left .top:after {
        position: absolute;
        bottom: 0;
        left: 50%;
        display: block;
        width: 80%;
        height: 1px;
        content: '';
        background-color: #e6e6e6;
        -moz-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
    .chat-room .left input {

        width: 100%;
        height: 32px;
        margin-top: 2px;

        border: 1px solid #e6e6e6;

        -moz-border-radius: 21px;
        -webkit-border-radius: 21px;

        font-family: 'Source Sans Pro', sans-serif;
        font-weight: 400;
        padding-left: 36px;
    }
    .chat-room .left input:focus {
        outline: none;
    }
    .chat-room .left a.search {
        display: block;
        float: left;
        width: 42px;
        height: 42px;
        margin-left: 10px;
        border: 1px solid #e6e6e6;
        background-color: #00b0ff;
        background-image: url("http://s11.postimg.org/dpuahewmn/name_type.png");
        background-repeat: no-repeat;
        background-position: top 12px left 14px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
    .chat-room .left .people {
        margin-left: -1px;
        border-right: 1px solid #e6e6e6;
        border-left: 1px solid #e6e6e6;
        width: -moz-calc(100% + 2px);
        width: -webkit-calc(100% + 2px);
        width: -o-calc(100% + 2px);
        width: calc(100% + 2px);
        padding-left: 0;
        height: 456px;
        overflow: auto;
        overflow-x: hidden;
    }
    .chat-room .left .people .person {
        position: relative;
        width: 100%;
        padding: 12px 10% 16px;
        cursor: pointer;
        background-color: #fff;
        list-style: none;
    }
    .chat-room .left .people .person:after {
        position: absolute;
        bottom: 0;
        left: 50%;
        display: block;
        width: 80%;
        height: 1px;
        content: '';
        background-color: #e6e6e6;
        -moz-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
    .chat-room .left .people .person .img {
        float: left;
        width: 40px;
        height: 40px;
        margin-right: 12px;
        line-height: 40px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        background: #e7ecf1;
        text-align: center;
        font-weight: bold;
        color: #bfbfbf;
        font-size: 22px;
    }
    .chat-room .left .people .person .name {
        font-size: 14px;
        line-height: 36px;
        color: #1a1a1a;
        font-family: 'Source Sans Pro', sans-serif;
        font-weight: 600;
    }
    .chat-room .left .people .person .time {
        font-size: 14px;
        position: absolute;
        top: 16px;
        right: 10%;
        padding: 0 0 5px 5px;
        color: #999;
        background-color: #fff;
    }
    .chat-room .left .people .person .preview {
        font-size: 14px;
        display: inline-block;
        overflow: hidden !important;
        width: 70%;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #999;
    }
    .chat-room .left .people .person.active, .chat-room .left .people .person:hover {
        margin-top: -1px;
        margin-left: -1px;
        padding-top: 13px;
        border: 0;
        background-color: #00b0ff;
        width: -moz-calc(100% + 2px);
        width: -webkit-calc(100% + 2px);
        width: -o-calc(100% + 2px);
        width: calc(100% + 2px);
        padding-left: -moz-calc(10% + 1px);
        padding-left: -webkit-calc(10% + 1px);
        padding-left: -o-calc(10% + 1px);
        padding-left: calc(10% + 1px);
    }
    .chat-room .left .people .person.active span, .chat-room .left .people .person:hover span {
        color: #fff;
        background: transparent;
    }
    .chat-room .left .people .person.active:after, .chat-room .left .people .person:hover:after {
        display: none;
    }
    .chat-room .right {
        position: relative;
        float: left;
        width: 62.4%;
        height: 100%;
    }
    .chat-room .right .top {
        width: 100%;
        height: 40px;
        padding: 10px 29px;
        background-color: #eceff1;
        background-color: #ebe9e9;
        color: #3F3F3F;
        text-transform: uppercase;
        font-family: "Roboto" !important;
        font-weight: 500;
        border-bottom: 3px solid #5a5858;

    }

    .chat-room .right .top span .name {
        color: #1a1a1a;

        font-weight: 500;
        font-size: 15px;
    }
    .chat-room .right .chat {
        position: relative;
        display: none;
        overflow: hidden;
        padding: 0 35px 7px;
        border-width: 1px 1px 1px 2px;
        border-style: solid;
        border-color: #e6e6e6;
        height: -moz-calc(100% - 48px);
        height: -webkit-calc(100% - 48px);
        height: -o-calc(100% - 48px);
        height: calc(100% - 48px);
        -webkit-justify-content: flex-end;
        justify-content: flex-end;
        -webkit-flex-direction: column;
        flex-direction: column;
    }
    .chat-room .right .chat.active-chat {
        display: block;
        background: white;
        height: 410px;
        overflow: auto;
        overflow-x: hidden;
    }
    .chat-room .right .chat.active-chat .bubble {
        -moz-transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
        -o-transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
        -webkit-transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
        transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(1) {
        -moz-animation-duration: 0.15s;
        -webkit-animation-duration: 0.15s;
        animation-duration: 0.15s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(2) {
        -moz-animation-duration: 0.3s;
        -webkit-animation-duration: 0.3s;
        animation-duration: 0.3s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(3) {
        -moz-animation-duration: 0.45s;
        -webkit-animation-duration: 0.45s;
        animation-duration: 0.45s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(4) {
        -moz-animation-duration: 0.6s;
        -webkit-animation-duration: 0.6s;
        animation-duration: 0.6s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(5) {
        -moz-animation-duration: 0.75s;
        -webkit-animation-duration: 0.75s;
        animation-duration: 0.75s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(6) {
        -moz-animation-duration: 0.9s;
        -webkit-animation-duration: 0.9s;
        animation-duration: 0.9s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(7) {
        -moz-animation-duration: 1.05s;
        -webkit-animation-duration: 1.05s;
        animation-duration: 1.05s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(8) {
        -moz-animation-duration: 1.2s;
        -webkit-animation-duration: 1.2s;
        animation-duration: 1.2s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(9) {
        -moz-animation-duration: 1.35s;
        -webkit-animation-duration: 1.35s;
        animation-duration: 1.35s;
    }
    .chat-room .right .chat.active-chat .bubble:nth-of-type(10) {
        -moz-animation-duration: 1.5s;
        -webkit-animation-duration: 1.5s;
        animation-duration: 1.5s;
    }
    .chat-room .right .write {
        bottom: 1px;
        left: 0;
        height: 60px;
        padding-left: 8px;
        border: 1px solid #e6e6e6;
        background-color: #eceff1;

        width: 100%;

    }
    .chat-room .right .emoji {
        width: 200px;
        float: right;
        top: -185px;
        position: relative;
        right: 0;
        background: white;
        padding: 5px 9px;
        border: solid 1px #ddd;
        display: none;
    }

    /*  .hero {
        position:relative;
        background-color:#e15915;
        height:320px !important;
        width:100% !important;
    }
    */
    .chat-room .right .emoji:after {
        content:'';
        position: absolute;
        top: 100%;
        left: 93%;
        margin-left: -50px;
        width: 0;
        height: 0;
        border-top: solid 10px #ddd;
        border-left: solid 10px transparent;
        border-right: solid 10px transparent;
    }

    .chat-room .right .write input,.chat-room .right #editable {
        font-size: 16px;
        float: left;
        width: 400px;
        height: 40px;
        padding: 0 10px;
        color: #1a1a1a;
        border: 0;
        outline: none;
        background-color: #eceff1;
        font-family: 'Source Sans Pro', sans-serif;
        font-weight: 400;
        height: 60px;
        overflow: auto;
        overflow-x: hidden;
    }
    .chat-room .right .write .write-link.attach:before {
        display: inline-block;
        float: left;
        width: 20px;
        height: 60px;
        content: '';
        background-image: url("http://s1.postimg.org/s5gfy283f/attachemnt.png");
        background-repeat: no-repeat;
        background-position: center;
    }
    .chat-room .right .write .write-link.smiley {
        margin-top: 15px;
        font-size: 18px;
        color: #23527c;
        display: inline-block;
        float: left;
        width: 20px;
        height: 60px;
        content: '';
    }

    .chat-room .right .write .write-link.smiley:hover {
        color: #23527c;
    }

    .chat-room .right .write .write-link.send {
        margin-top: 15px;
        font-size: 18px;
        display: inline-block;
        float: left;
        width: 20px;
        height: 60px;
        margin-left: 11px;
        content: '';
    }

    .chat-room .right .write .write-link.send.disabled {
        color: #AAAAAA;
    }


    .chat-room .right .bubble {
        font-size: 13px;
        position: relative;
        display: inline-block;
        clear: both;
        margin-bottom: 8px;
        padding: 10px 10px;
        vertical-align: top;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        padding-bottom: 0px;
    }
    .chat-room .right .bubble:before {
        position: absolute;
        top: 19px;
        display: block;
        width: 8px;
        height: 6px;
        content: '\00a0';
        -moz-transform: rotate(29deg) skew(-35deg);
        -ms-transform: rotate(29deg) skew(-35deg);
        -webkit-transform: rotate(29deg) skew(-35deg);
        transform: rotate(29deg) skew(-35deg);
    }
    .chat-room .right .bubble.you {
        float: left;
        color: #fff;
        background-color: #00b0ff;
        -webkit-align-self: flex-start;
        align-self: flex-start;
        -moz-animation-name: slideFromLeft;
        -webkit-animation-name: slideFromLeft;
        animation-name: slideFromLeft;
    }
    .chat-room .right .bubble.you:before {
        left: -3px;
        background-color: #00b0ff;
    }
    .chat-room .right .bubble.me {
        float: right;
        color: #1a1a1a;
        background-color: #eceff1;
        -webkit-align-self: flex-end;
        align-self: flex-end;
        -moz-animation-name: slideFromRight;
        -webkit-animation-name: slideFromRight;
        animation-name: slideFromRight;
    }
    .chat-room .right .bubble.me:before {
        right: -3px;
        background-color: #eceff1;
    }
    .chat-room .right .conversation-start {
        position: relative;
        width: 100%;
        margin-bottom: 27px;
        text-align: center;
    }
    .chat-room .right .conversation-start span {
        font-size: 14px;
        display: inline-block;
        color: #999;
    }
    .chat-room .right .conversation-start span:before, .chat-room .right .conversation-start span:after {
        position: absolute;
        top: 10px;
        display: inline-block;
        width: 30%;
        height: 1px;
        content: '';
        background-color: #e6e6e6;
    }
    .chat-room .right .conversation-start span:before {
        left: 0;
    }
    .chat-room .right .conversation-start span:after {
        right: 0;
    }

    @keyframes slideFromLeft {
        0% {
            margin-left: -200px;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
        }
        100% {
            margin-left: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
            opacity: 1;
        }
    }
    @-webkit-keyframes slideFromLeft {
        0% {
            margin-left: -200px;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
        }
        100% {
            margin-left: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
            opacity: 1;
        }
    }
    @keyframes slideFromRight {
        0% {
            margin-right: -200px;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
        }
        100% {
            margin-right: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
            opacity: 1;
        }
    }
    @-webkit-keyframes slideFromRight {
        0% {
            margin-right: -200px;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
        }
        100% {
            margin-right: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
            opacity: 1;
        }
    }
    .credits {
        color: white;
        font-size: 11px;
        position: absolute;
        bottom: 10px;
        right: 15px;
    }
    .credits a {
        color: white;
        text-decoration: none;
    }

    i.search-icon.fa.fa-search {
        position: absolute;
        left: 11px;
        top: 12px;
        color: #bfbfbf;
        font-size: 17px;
    }
    span.time {
        display: block;
        font-size: 10px;
        margin-top: 4px;
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

            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="chat-room">
                            <div class="right">
                                <div class="top">
                                    <span>
                                        <i class="fa fa-comments"></i> Chat
                                    </span>
                                </div>
                                <div class="chat active-chat message-load" data-chat="person1"></div>
                                <div class="write">
                                    <textarea id="emoji" hidden></textarea>
                                        <div id="container_emoji" class="hide"></div>
                                        <input id="chat-message" type="text" class="form-control"/>
                                        <a href="javascript:;" class="write-link smiley" id="smiley">
                                            <i class="fa fa-smile" aria-hidden="true"></i>
                                        </a>
                                        <a id="send-message" href="javascript:;" class="write-link send disabled">
                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </a>
                                    <div class="emoji">
                                        <?php foreach ($smily as $key => $value) { ?>
                                            <?= $value ?>
                                         <?php } ?>
                                    </div>
                                </div>
                            </div>



                            <div class="left">
                                <div class="top">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="User Search..">
                                        <span class="input-group-text search-icon">
                                            <i class="fa fa-search"></i>
                                         </span>
                                    </div>
                                </div>
                                <div class="filter-message" id="filterMessage"></div>
                                <ul class="list-group people"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        window.onload = function()
        {
            function chatOnline(){
                $.ajax({
                    type:'post',
                    url:  '<?php echo e(url("/chat/online")); ?>',
                    data:{_token:'<?php echo e(csrf_token()); ?>',unit_id:<?php echo $unitData->id; ?>},
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
        $(document).ready(function() {
            $("#smiley").on("click", function(event) {
                event.stopPropagation();
                $(".write input").focus();
                $(".right .emoji").fadeIn();
            });

            $('#chat-message').on('input', function() {
                if ($(this).val() != '') {
                    $('#send-message').removeClass('disabled');
                } else {
                    $('#send-message').addClass('disabled');
                }
            });

            $(".chat-room").on("contextmenu", "[contextmenu]", function(event) {
                event.preventDefault();
                showMenu(event, $(this));
            });

            $(".chat-room").on("click", "[contextmenu]", function(event) {
                event.preventDefault();
                showMenu(event, $(this));
            });

            function showMenu(event, $this) {
                var html = '\
        <li><a href="' + $this.attr("data-profile") + '"> Profile </a></li>\
        <li><a href="<?php echo url("message/send"); ?>/' + $this.attr("data-id") + '"> Private Message </a></li>';

                if ($this.attr("data-id") == <?php echo e(Auth::user()->id); ?>) {
                    html = '<li><a href="' + $this.attr("data-profile") + '"> My Profile </a></li>';
                }
                $(".custom-menu").finish().toggle(100).css({
                    top: event.pageY + "px",
                    left: event.pageX + "px"
                }).html(html);
            }

            $(document).on("mousedown", function(e) {
                if (!$(e.target).closest(".custom-menu").length) {
                    $(".custom-menu").hide(100);
                }
            });

            $(".custom-menu").on("click", "li", function() {
                $this = $(this);
                switch ($this.attr("data-action")) {
                    case "chat":
                        var userId = $this.attr("data-id");
                        alert(userId);
                        break;
                }
                $(".custom-menu").hide(100);
            });

            $(".right").on("click", ".send", function(event) {
                chat.sendmsg();
            });

            $(".right").on("click", ".emoji", function(event) {
                event.stopPropagation();
            });



            $(document).on("click", function() {
                $(".right .emoji").fadeOut();
            });

            $(".write input").focus();


            var chat = {
                init: function(roomId, user_id) {
                    this.room = roomId;
                    this.user_id = user_id;
                    this.lastId = 0;
                    this.input = ".write input";
                },
                loaduser: function() {
                    var $this = this;
                    $.ajax({
                        type: 'post',
                        url: '<?php echo e(url('chat/loaduser')); ?>',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            roomId: this.room
                        },
                        dataType: 'json',
                        beforeSend: function() {},
                        complete: function() {},
                        success: function(json) {
                            $this.loaduserHtml(json.members);
                        }
                    });
                },
                loaduserHtml: function(json) {
                    var html = '';
                    $.each(json, function(i, j) {
                        if (j.name.toUpperCase().indexOf($(".chat-room input[name=search]").val().toUpperCase()) != -1) {
                            html += '<li class="person" data-id="' + j.user_id + '" data-profile="' + j.link + '" contextmenu data-chat="person1">';
                            html += '    <div class="img">' + j.name.charAt(0) + '</div>';
                            html += '    <span class="name">' + j.name + '</span>';
                            html += '</li>';
                        }
                    });
                    $(".left .people").html(html);
                },
                sendmsg: function() {
                    var $this = this;
                    var message = $.trim($(this.input).val());
                    if (message != '') {
                        $.ajax({
                            type: 'post',
                            url: '<?php echo e(url('chat/sendmsg')); ?>',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>',
                                roomId: this.room,
                                message: message
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                $($this.input).prop("readonly", true);
                            },
                            complete: function() {
                                $($this.input).prop("readonly", false);
                            },
                            success: function(json) {
                                if (json.success) {
                                    $($this.input).val('');
                                    $this.loadmsg(false);
                                } else {
                                    showToastMessage('SOMETHING_GOES_WRONG');
                                }
                            }
                        });
                    }
                },
                loadmsg: function(reCall) {
                    var $this = this;
                    if (this.xhr && this.xhr.readyState != 4) {
                        this.xhr.abort();
                    }
                    this.xhr = $.ajax({
                        type: 'post',
                        url: '<?php echo e(url('chat/loadmsg')); ?>',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            roomId: this.room,
                            lastId: this.lastId,
                            loaduser: true
                        },
                        dataType: 'json',
                        beforeSend: function() {},
                        error: function() {
                            setTimeout(function() {
                                $this.loadmsg();
                            }, 10000);
                        },
                        complete: function() {},
                        success: function(json) {
                            var html = '';
                            if (json.messages) {
                                $.each(json.messages, function(i, j) {
                                    if (Number($this.lastId) <= Number(j.id)) {
                                        $this.lastId = Number(j.id);
                                    }
                                    var classs = "you";
                                    if ($this.user_id == j.user) classs = "me";
                                    html += '<div class="bubble ' + classs + '" data-id="' + j.id + '">';
                                    html += "<b contextmenu  data-id='" + j.user + "' data-profile='" + j.link + "' >" + j.name + "</b><br> " + j.body;
                                    html += '<span class="time">' + j.time + '</span>';
                                    html += '</div>';
                                });
                            }
                            $this.loaduserHtml(json.members);
                            if (reCall) {
                                setTimeout(function() {
                                    $this.loadmsg(true);
                                }, 5000);
                            }
                            if (html != '') {
                                $(".message-load").append(html);
                                if (html != '') $('.message-load').animate({
                                    scrollTop: $('.message-load').prop("scrollHeight")
                                }, 500);
                            }
                        }
                    });
                },
                getid: function() {
                    console.log(this.room);
                }
            };

            chat.init("<?= $roomId ?>", <?= $user_id ?>);
            chat.loaduser();
            chat.loadmsg(true);

            $.fn.EnableInsertAtCaret = function() {
                $(this).on("focus", function() {
                    $(".insertatcaretactive").removeClass("insertatcaretactive");
                    $(this).addClass("insertatcaretactive");
                });
            };

            function insert_smiley(text) {
                $(".write input").EnableInsertAtCaret();
                InsertAtCaret(text);
                $(".write input").focus();
            }

            function InsertAtCaret(myValue) {
                return $(".insertatcaretactive").each(function(i) {
                    if (document.selection) {
                        // For browsers like Internet Explorer
                        this.focus();
                        sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    } else if (this.selectionStart || this.selectionStart == '0') {
                        // For browsers like Firefox and Webkit based
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }

                    $('#send-message').removeClass('disabled');
                });
            }

            $(".write input").keypress(function(e) {
                var key = e.which;
                if (key == 13) {
                    chat.sendmsg();
                    return false;
                }
            });

            $(".chat-room .left input[name=search]").keyup(function() {
                var txt = $(".chat-room input[name=search]").val();

                if (txt.length > 0) {
                    $('#filterMessage').text('Filtered by name: ' + txt);
                } else {
                    $('#filterMessage').text('');
                }

                $("ul.people").find("li").each(function() {
                    if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/chat/chatroom.blade.php ENDPATH**/ ?>