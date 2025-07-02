@extends('layout.master')
@section('title', 'Chat')
@section('style')
@endsection
@section('site-name')
@if(isset($unitData))
<h1>{{ $unitData->name }}</h1>
@else
<h1>Javul.org</h1>
@endif
<div class="banner_desc d-md-block d-none">
    Open-source Society
</div>
@endsection

@section('navbar')
@if(isset($unitData))
@include('layout.navbar', ['unitData' => $unitData])
@endif
@endsection
@section('content')
<div class="content_row">
    <div class="sidebar">
        @if(isset($unitData))
        @include('layout.v2.global-unit-overview')
        <?php
                $title = 'Activity Log';
                ?>
        @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])

        @include('layout.v2.global-finances')

        @include('layout.v2.global-about-site')
        @else
        <?php
                $title = 'Global Activity Log';
                ?>
        @include('layout.v2.global-activity-log',['title' => $title])
        @endif
    </div>
    <div class="main_content">

        {{-- <div class="col-md">
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
                                <input id="chat-message" type="text" class="form-control" />
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
        </div> --}}
        <div class="container-fluid chat-app">
            <div class="chat-box">
                <!-- Sidebar -->
                <div class="chat-sidebar">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="User Search..." />
                    </div>

                    {{-- Dynamic users will be appended here via JS --}}
                    {{-- Add static "loading..." fallback if needed --}}
                    <div id="userList">

                    </div>
                </div>

                <!-- Chat Area -->
                <div class="chat-content">
                    <div class="chat-header" id="chatTitle">
                        <i class="fas fa-comments me-2"></i> Chat with <span class="chat-username">User</span>
                    </div>

                    <div class="chat-messages" id="chatMessages">
                        <!-- Messages are dynamically loaded here -->
                        <!-- If no messages -->
                        <!--
                <div class="no-messages">
                    <i class="far fa-comment-dots fa-2x mb-3 d-block"></i>
                    No messages yet. Start the conversation!
                </div>
                -->
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



@endsection
{{-- @section('scripts')
<script>
    window.onload = function()
        {
            function chatOnline(){
                $.ajax({
                    type:'post',
                    url:  '{{ url("/chat/online") }}',
                    data:{_token:'{{csrf_token()}}',unit_id:{!! $unitData->id !!}},
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
        <li><a href="{!! url("message/send") !!}/' + $this.attr("data-id") + '"> Private Message </a></li>';

                if ($this.attr("data-id") == {{ Auth::user()->id }}) {
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
                        url: '{{ url('chat/loaduser') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
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
                            url: '{{ url('chat/sendmsg') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
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
                        url: '{{ url('chat/loadmsg') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
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
@endsection --}}
@section('scripts')
{{-- <script>
    const userId = {{ Auth::id() }};
    const roomId = "{{ $roomId ?? '' }}";
    const chatMessagesEl = document.getElementById("chatMessages");
    const inputField = document.querySelector(".chat-input-container input");
    const sendBtn = document.querySelector(".btn.btn-primary");

    let lastMessageId = 0;
    let messagePolling = null;

    function loadMessages(repeat = true) {
        $.ajax({
            type: 'POST',
            url: '{{ url('chat/loadmsg') }}',
            data: {
                _token: '{{ csrf_token() }}',
                roomId,
                lastId: lastMessageId
            },
            dataType: 'json',
            success: function (response) {
                if (response.messages && response.messages.length > 0) {
                    response.messages.forEach(msg => {
                        const messageDiv = document.createElement("div");
                        messageDiv.classList.add("message", msg.user == userId ? "sent" : "received");
                        messageDiv.textContent = msg.body;
                        chatMessagesEl.appendChild(messageDiv);
                        lastMessageId = Math.max(lastMessageId, parseInt(msg.id));
                    });

                    chatMessagesEl.scrollTop = chatMessagesEl.scrollHeight;
                }

                if (repeat) {
                    clearTimeout(messagePolling);
                    messagePolling = setTimeout(() => loadMessages(true), 5000);
                }
            },
            error: function () {
                if (repeat) {
                    messagePolling = setTimeout(() => loadMessages(true), 10000);
                }
            }
        });
    }

    function sendMessage() {
        const message = inputField.value.trim();
        if (message === "") return;

        $.ajax({
            type: 'POST',
            url: '{{ url('chat/sendmsg') }}',
            data: {
                _token: '{{ csrf_token() }}',
                roomId,
                message
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    inputField.value = "";
                    loadMessages(false);
                }
            }
        });
    }

    sendBtn.addEventListener("click", sendMessage);
    inputField.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            sendMessage();
        }
    });

    // Load messages on page load
    window.onload = function () {
        loadMessages(true);
    };
</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roomId = "{{ $roomId }}";
        const userId = {{ $user_id }};
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
                url: '{{ url("chat/loadmsg") }}',
                data: {
                    _token: '{{ csrf_token() }}',
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
                url: '{{ url("chat/sendmsg") }}',
                data: {
                    _token: '{{ csrf_token() }}',
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
                url: '{{ url("chat/loaduser") }}',
                data: {
                    _token: '{{ csrf_token() }}',
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
                                window.location.href = '{{ url("chat") }}/' + user.room_id;
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
                    url: '{{ url("/chat/online") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        unit_id: {!! $unitData->id !!}
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

@endsection
