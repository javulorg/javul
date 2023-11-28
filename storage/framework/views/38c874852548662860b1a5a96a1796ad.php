<header>
    <div class="header_container">
        <div class="header_left">
            <div class="burger d-xl-none d-block" id="burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <a href="/" class="logo">
                <img src="<?php echo e(asset('v2/assets/img/logo.png')); ?>" alt="" class="img-fluid">
            </a>
            <style>
                ul li a {
                    text-decoration: none!important;
                }

                ul li a:hover {
                    color: #bbbbbb!important;
                }

            </style>
            <ul class="nav d-xl-flex d-none">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
            <div class="separator d-xl-block d-none"></div>
            <div class="header_ttl d-xl-block d-none">
                Global Links:
            </div>
            <ul class="nav d-xl-flex d-none">
                <li class="nav-item">
                    <a class="nav-link" href="#">Products & Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">People’s Government & Leadership</a>
                </li>
            </ul>
            <div class="separator d-xl-block d-none"></div>
            <div class="header_ttl d-xl-block d-none">
                Explore:
            </div>
            <div class="dropdown d-xl-block">
                <div class="header_dropdown" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Units
                </div>
                <style>
                    header .dropdown-item {
                        padding: 8px 15px!important;
                        font-weight: 700!important;
                        font-size: 13px!important;
                        line-height: 10px!important;
                        margin-bottom: 0px!important;
                        color: var(--second-dark-color)!important;
                    }
                </style>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href="<?php echo url('units'); ?>">All Units</a>
                    <a class="dropdown-item" href="<?php echo url('objectives'); ?>">Objectives</a>
                    <a class="dropdown-item" href="<?php echo url('tasks'); ?>">Tasks</a>
                    <a class="dropdown-item" href="<?php echo url('issues'); ?>">Issues </a>
                    <a class="dropdown-item" href="<?php echo e(url('ideas')); ?>">Ideas</a>
                </div>
            </div>


            <ul class="nav d-xl-flex d-none">
                <li class="nav-item" style="padding-left: 10px;">
                    <a class="nav-link" href="<?php echo e(url('units/create')); ?>"> Create Unit</a>
                </li>
                <li class="nav-item" style="padding-left: 10px;">
                    <a class="nav-link" href="<?php echo e(url('activities')); ?>">Global Activity Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contribute</a>
                </li>
            </ul>
        </div>

        <div class="header_center d-xl-block d-none">

        </div>


        <div class="header_right">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('my_watchlist')); ?>" class="header_btn">
                    <img src="<?php echo e(asset('v2/assets/img/Watchlist.svg')); ?>" alt="" class="img-fluid" style="max-width:88%!important;">
                </a>
                <a href="<?php echo e(route('message_inbox')); ?>" class="header_btn">
                    <img src="<?php echo e(asset('v2/assets/img/mail.svg')); ?>" alt="" class="img-fluid" style="max-width:88%!important;">
                </a>

                <a href="<?php echo e(url('account')); ?>" class="header_btn">
                    <img src="<?php echo e(asset('v2/assets/img/settings.svg')); ?>" alt="Settings" class="img-fluid" style="max-width:88%!important;">
                </a>

                <a href="<?php echo url('userprofiles/'.$userIDHashID->encode(auth()->user()->id).'/'.strtolower(auth()->user()->first_name).'_'.strtolower(auth()->user()->last_name)); ?>" class="header_btn">

                    <img src="<?php echo e(asset('v2/assets/img/user.svg')); ?>" alt="" class="img-fluid">
                </a>

                <a style="text-decoration: none;" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="login_btn">


                     Logout
                </a>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <a href="<?php echo e(url('register')); ?>" class="login_btn">
                    <i class="fas fa-user-plus" aria-hidden="true"></i>
                    <span class="login_btn" style="margin: 0 4px;">Sign Up</span>
                </a>

                <span class="login_btn" style="margin: 0 4px;">&nbsp;|&nbsp;</span>

                <a href="<?php echo e(url('login')); ?>" class="login_btn">
                    <i class="fas fa-sign-in" aria-hidden="true"></i>
                    <span class="login_btn" style="margin: 0 4px;">Login</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="mob_menu" id="mob_menu">
        <nav>
            <div class="nav flex-column">
                <div class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Issues</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Ideas</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Objectives</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Tasks</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Forum</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Chat</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Wiki</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Activity Log</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Top Contributors</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Awards</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Finances</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Donate</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </div>
            </div>
        </nav>
        <div class="other_content">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
            <div id="accordion">
                <div class="card">
                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#collapse1">
                            Global Links: <img src="<?php echo e(asset('v2/assets/img/chevron_down.svg')); ?>">
                        </a>
                    </div>
                    <div id="collapse1" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                                <li>
                                    <a href="#">Products & Services</a>
                                </li>
                                <li>
                                    <a href="#">People’s Government & Leadership</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse2">
                            Explore: <img src="<?php echo e(asset('v2/assets/img/chevron_down.svg')); ?>" alt="">
                        </a>
                    </div>
                    <div id="collapse2" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                                <li>
                                    Units
                                    <ul>
                                        <li>
                                            <a href="#">Objectives</a>
                                        </li>
                                        <li>
                                            <a href="#">Tasks</a>
                                        </li>
                                        <li>
                                            <a href="#">Issues</a>
                                        </li>
                                        <li>
                                            <a href="#">Ideas</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search_modal" id="search_modal">
        <div class="search_modal_content">
            <div class="container">
                <div class="search_block">
                    <div class="search_form">
                        <select name="search_select" id="search_select_modal">
                            <option value="">Search with this Unit</option>
                            <option value="">Search with another Unit</option>
                        </select>
                        <div class="separator"></div>
                        <input type="text">
                        <div class="separator"></div>
                        <button type="submit"><img src="<?php echo e(asset('v2/assets/img/search.svg')); ?>" alt=""></button>
                        <div class="clear_search"></div>
                    </div>
                    <a href="#">
                        Advanced Search
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/header.blade.php ENDPATH**/ ?>