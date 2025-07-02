<ul class="nav flex-column nav-pills inbox-app" role="tablist" aria-orientation="vertical">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('inbox') ? 'active' : '' }}" href="{{ url('inbox') }}">
            <i class="fas fa-inbox"></i> Inbox
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('message/sent') ? 'active' : '' }}" href="{{ url('message/sent') }}">
            <i class="fas fa-paper-plane"></i> Sent
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('message/send') ? 'active' : '' }}" href="{{ url('message/send') }}">
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
