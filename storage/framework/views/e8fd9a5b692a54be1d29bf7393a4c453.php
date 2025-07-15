<?php $__env->startSection('title', 'Chat'); ?>
<?php $__env->startSection('style'); ?>
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

        <div class="container-fluid chat-app">
            <div class="chat-box">
                <!-- Sidebar -->
                <div class="chat-sidebar">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="User Search..." />
                    </div>
                    <div id="userList">

                    </div>
                </div>

                <!-- Chat Area -->
                <div class="chat-content">
                    <div class="chat-header" id="chatTitle">
                        <i class="fas fa-comments me-2"></i> Chat with <span class="chat-username">User</span>
                    </div>

                    <div class="chat-messages" id="chatMessages">
                    </div>

                    <div class="chat-input-area">
                        <div class="chat-input-container">
                            <i class="fas fa-house input-icon-left"></i>
                            <input type="text" class="form-control" placeholder="Type your message..." />
                        </div>
                        <button class="btn btn-light" id="smiley"><i class="far fa-smile"></i></button>
                        <button class="btn btn-primary disabled"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roomId = "<?php echo e($roomId); ?>";
        const userId = <?php echo e($user_id); ?>;
        let lastMessageId = 0;
        let pollingTimer;

        const chatInput = document.querySelector(".chat-input-container input");
        const sendButton = document.querySelector(".btn.btn-primary");
        const chatMessagesEl = document.querySelector("#chatMessages");
        const searchInput = document.querySelector(".search-bar input");

        function initChat() {
            loadMessages(true);
            loadUsers();
            setupChatOnlinePolling();
        }

        function loadMessages(repeat = false) {
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url("chat/loadmsg")); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    roomId: roomId,
                    lastId: lastMessageId,
                    loaduser: true
                },
                dataType: 'json',
                success: function (res) {
                    if (res.messages) {
                        res.messages.forEach(msg => {
                            if (msg.id > lastMessageId) {
                                lastMessageId = msg.id;
                                const message = document.createElement("div");
                                message.classList.add("message");
                                message.classList.add(msg.user == userId ? "sent" : "received");
                                message.textContent = msg.body;
                                chatMessagesEl.appendChild(message);
                            }
                        });
                        chatMessagesEl.scrollTop = chatMessagesEl.scrollHeight;
                    }

                    if (repeat) {
                        pollingTimer = setTimeout(() => loadMessages(true), 5000);
                    }
                },
                error: function () {
                    if (repeat) {
                        pollingTimer = setTimeout(() => loadMessages(true), 10000);
                    }
                }
            });
        }

        function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            $.ajax({
                type: 'POST',
                url: '<?php echo e(url("chat/sendmsg")); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    roomId: roomId,
                    message: message
                },
                dataType: 'json',
                beforeSend: function () {
                    chatInput.readOnly = true;
                },
                complete: function () {
                    chatInput.readOnly = false;
                },
                success: function (res) {
                    if (res.success) {
                        chatInput.value = '';
                        sendButton.classList.add("disabled");
                        loadMessages(false);
                    }
                }
            });
        }

        function loadUsers(search = '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url("chat/loaduser")); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    roomId: roomId,
                    search: search
                },
                dataType: 'json',
                success: function (res) {
                    const sidebar = document.querySelector(".chat-sidebar");
                    sidebar.querySelectorAll(".user-item.dynamic").forEach(el => el.remove());

                    res.members.forEach(user => {
                        const item = document.createElement("div");
                        item.className = "user-item dynamic";
                        item.dataset.roomId = user.room_id;
                        item.innerHTML = `<div class="avatar">${user.name.charAt(0)}</div><div>${user.name}</div>`;
                        item.addEventListener("click", function () {
                            if (user.room_id !== roomId) {
                                window.location.href = '<?php echo e(url("chat")); ?>/' + user.room_id;
                            }
                        });
                        sidebar.appendChild(item);
                    });
                }
            });
        }

        function setupChatOnlinePolling() {
            function chatOnline() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo e(url("/chat/online")); ?>',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        unit_id: <?php echo $unitData->id; ?>

                    },
                    dataType: 'json',
                    complete: function () {
                        setTimeout(chatOnline, 5000);
                    },
                    success: function (res) {
                        $("#chat-online").html(res.online);
                    }
                });
            }
            chatOnline();
        }

        // Input handlers
        chatInput.addEventListener("input", function () {
            if (this.value.trim() !== "") {
                sendButton.classList.remove("disabled");
            } else {
                sendButton.classList.add("disabled");
            }
        });

        chatInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                sendMessage();
            }
        });

        sendButton.addEventListener("click", sendMessage);

        // Emoji toggling (if smiley button exists)
        const smileyBtn = document.querySelector("#smiley");
        if (smileyBtn) {
            smileyBtn.addEventListener("click", function (event) {
                event.stopPropagation();
                $(".right .emoji").fadeIn();
                chatInput.focus();
            });
        }

        // Search users
        searchInput.addEventListener("input", function () {
            loadUsers(this.value.trim());
        });

        // Insert smiley support
        $.fn.EnableInsertAtCaret = function () {
            $(this).on("focus", function () {
                $(".insertatcaretactive").removeClass("insertatcaretactive");
                $(this).addClass("insertatcaretactive");
            });
        };

        function insert_smiley(text) {
            $(".chat-input-container input").EnableInsertAtCaret();
            InsertAtCaret(text);
            $(".chat-input-container input").focus();
        }

        function InsertAtCaret(myValue) {
            return $(".insertatcaretactive").each(function () {
                if (document.selection) {
                    this.focus();
                    sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                } else if (this.selectionStart || this.selectionStart == '0') {
                    const startPos = this.selectionStart;
                    const endPos = this.selectionEnd;
                    const scrollTop = this.scrollTop;
                    this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos);
                    this.focus();
                    this.selectionStart = startPos + myValue.length;
                    this.selectionEnd = startPos + myValue.length;
                    this.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }

                sendButton.classList.remove("disabled");
            });
        }

        initChat();
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/chat/chatroom.blade.php ENDPATH**/ ?>