<ul class="nav flex-column nav-pills inbox-app" role="tablist" aria-orientation="vertical">
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->is('inbox') ? 'active' : ''); ?>" href="<?php echo e(url('inbox')); ?>">
            <i class="fas fa-inbox"></i> Inbox
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->is('message/sent') ? 'active' : ''); ?>" href="<?php echo e(url('message/sent')); ?>">
            <i class="fas fa-paper-plane"></i> Sent
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e(request()->is('message/send') ? 'active' : ''); ?>" href="<?php echo e(url('message/send')); ?>">
            <i class="fas fa-pen"></i> New Message
        </a>
    </li>
</ul>

<style>
    .inbox-app .nav-pills .nav-link {
    font-weight: 500;
    color: #495057;
    border-radius: 6px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    }

    .inbox-app .nav-pills .nav-link i,
    .inbox-app .nav-pills .nav-link svg {
    margin-right: 10px;
    }

    .inbox-app .nav-pills .nav-link.active {
    background-color: #23527c;
    color: #fff !important;
    }
</style>
<?php /**PATH /var/www/html/javul-staging/javul/resources/views/message/menu.blade.php ENDPATH**/ ?>