<nav class="navbar navbar-grey" style="margin-bottom: 0px;min-height: 35px;">
    <div class="text-center under-construction-block">
        <img class="under-construction-image" src="<?php echo url('assets/images/construction.png'); ?>">This site is under construction. Some links and functionalities may not work. <a target="_blank" href="https://javul.org/wiki/Website_is_under_construction">(details)</a>
    </div>

    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle navbar-top-menu collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-0" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-0">
            <ul class="top-most-icons nav">
                    <?php if(empty($authUserObj)): ?>
                    <li class="top_menu_li">
                        <a href="<?php echo url('register'); ?>">
                            Sign Up <i class="fa fa-user-plus" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li">
                        <a href="<?php echo url('login'); ?>">
                            Login <i class="fa fa-sign-in" aria-hidden="true"></i>
                        </a>
                    </li>

                <?php else: ?>
                    <li class="top_menu_li is_logged_in">
                        <a href="#" data-toggle="popover" class="notification_popover">
                            Alerts <i id="alerts-notification" class="fa fa-bell <?php if($notificationCount > 0): ?> colorOrange <?php endif; ?>" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('my_watchlist'); ?>">
                            Watch List <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('my_contributions'); ?>">
                            My Contributions <i class="fa fa-file-text" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('my_tasks'); ?>">
                            My Tasks <i class="fa fa-tasks" aria-hidden="true"></i>
                        </a>
                    </li>

                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo route('message_inbox'); ?>">
                            Inbox <span id="unread-message"  class="badge badge-danger"></span> <i class="fa fa-envelope" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator middle_sep is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="middle_li_block is_logged_in" style="display: none;"></li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('userprofiles/'.$userIDHashID->encode(\Auth::user()->id).'/'.strtolower(\Auth::user()->first_name).'_'.strtolower(\Auth::user()->last_name)); ?>">
                            My Profile <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('account'); ?>">
                            Account Settings <i class="fa fa-cog" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo url('userprofiles/'.$userIDHashID->encode(\Auth::user()->id).'/'.strtolower(\Auth::user()->first_name).'_'.strtolower(\Auth::user()->last_name)); ?>">
                            <?php if(!empty($authUserObj->username)): ?>
                                Logged in as: <?php echo e($authUserObj->username); ?>

                            <?php else: ?>
                                Logged in as: <?php echo e($authUserObj->first_name.' '.$authUserObj->last_name); ?>

                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="top_menu_separator is_logged_in">&nbsp;|&nbsp;</li>
                    <li class="top_menu_li is_logged_in">
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    </li>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo e(csrf_field()); ?></form>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<nav class="navbar navbar-grey navbar-orange">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo url(''); ?>">
                <img class="logo" src="<?php echo url('assets/images/logo.png'); ?>" />JAVUL
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo url(''); ?>" class="header_nav_menus home"><span class="glyphicon
                glyphicon-home"></span></a></li>
                <li><a href="#" class="header_nav_menus"><?php echo trans('messages.about_this_site'); ?></a></li>
                <li><a href="#" class="header_nav_menus"><?php echo trans('messages.faq'); ?></a></li>
                <li><a href="#" class="header_nav_menus"><?php echo trans('messages.how_can_i_help'); ?></a></li>
                <li><a href="#" class="header_nav_menus"><?php echo trans('messages.joul.org_unit'); ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right search-navbar">
                <?php if(empty($authUserObj)): ?>
                <!--<li><a href="<?php echo url('register'); ?>">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns"><?php echo trans('messages.signup'); ?></button>
                    </a></li>
                <li><a href="<?php echo url('login'); ?>">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns"><?php echo trans('messages.sign_in'); ?></button>
                    </a>
                </li>-->
                <?php else: ?>
                <!--<li>
                    <a class="header_nav_menus" href="<?php echo url('account'); ?>">
                        <?php echo trans('messages.welcome'); ?> : <?php echo e($authUserObj->first_name.' '.$authUserObj->last_name); ?>

                    </a>
                </li>
                <li><a href="<?php echo url('account/logout'); ?>">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns"><?php echo trans('messages.sign_out'); ?></button>
                    </a>
                </li>-->
                <?php endif; ?>


                <li class="search_div_main " style="padding-top: 15px;">
                    <form action="<?php echo url('global_search'); ?>" method="get" id="form-global-search">
                        <div class="input-group add-on">
                            <input type="text" class="form-control" id="search_box" name="search_term"
                                   placeholder="<?php echo trans('messages.search_for'); ?>"
                                   aria-describedby="basic-addon1"
                                    <?php if(\Request::method('post') && \Request::has('search_term')): ?> value="<?php echo e(\Request::get('search_term')); ?>" <?php endif; ?>>
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit" style="background-color:#ccc;">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<script type="text/javascript">

    
    var report_concern_token='<?php echo e(csrf_token()); ?>';

</script>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/elements/header.blade.php ENDPATH**/ ?>