<ul class="list-unstyled message-menu">
    <li class="nav-item <?= $page == 'inbox' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo e(url('inbox')); ?>">Inbox</a>
    </li>
    <li class="nav-item <?= $page == 'sent' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo e(url('message/sent')); ?>">Sent</a>
    </li>
    <li class="nav-item <?= $page == 'new' ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo e(url('message/send')); ?>">New Message</a>
    </li>
</ul>

<style>
    .related_para {
        margin: 0 0 10px;
    }

    .custom-menu {
        display: none;
        z-index: 1000;
        position: absolute;
        overflow: hidden;
        border: 1px solid #CCC;
        white-space: nowrap;
        font-family: sans-serif;
        background: #FFF;
        color: #333;
        border-radius: 5px;
        padding: 0;
    }

    /* Each of the items in the list */
    .custom-menu li {
        padding: 8px 12px;
        cursor: pointer;
        list-style-type: none;
        transition: all .3s ease;
    }

    .custom-menu li:hover {
        background-color: #DEF;
    }

    .message {
        padding: 0;
    }

    .message li {
        list-style: none;
        padding: 6px 6px;
        background: #fafcfb;
        border: solid 1px #e5e5e5;
        margin: 4px 0px;
    }

    .message li .heading {
        font-weight: bold;
        font-size: 14px;
    }

    .message li .time {
        font-size: 10px;
        color: #555;
        font-weight: normal;
    }

    .message li .body {
        /* white-space: nowrap;*/
        /* word-wrap: break-word; */
        font-size: 12px;
        margin-top: 3px;
        /*overflow: hidden;
            text-overflow: ellipsis;*/
    }

    .message-menu {
        padding: 0;
        margin-top: 10px;
    }

    .message-menu li.active a {
        color: black;
    }

    .message-menu li.active {
        border-bottom: solid 2px #cccecd;
    }

    .message li>a:hover {
        text-decoration: none;
    }

    .message li>a {
        color: inherit;
    }

    .message-menu li {
        list-style: none;
        padding: 8px 0;
        background: #edf1f1;
        margin-bottom: 4px;
        text-align: center;
        color: black;
    }

    .message-menu a {
        color: gray;
    }

</style>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/message/menu.blade.php ENDPATH**/ ?>