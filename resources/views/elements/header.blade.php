<nav class="navbar navbar-default navbar-orange">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="margin-top:5px ">
                <img class="logo" src="{!! url('assets/images/logo.png') !!}" />JAVUL
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{!! url('') !!}"class="header_nav_menus"><span class="glyphicon
                glyphicon-home"></span></a></li>
                <li><a href="#" class="header_nav_menus">{!! Lang::get('messages.about_this_site') !!}</a></li>
                <li><a href="#" class="header_nav_menus">{!! Lang::get('messages.faq') !!}</a></li>
                <li><a href="#" class="header_nav_menus">{!! Lang::get('messages.how_can_i_help') !!}</a></li>
                <li><a href="#" class="header_nav_menus">{!! Lang::get('messages.joul.org_unit') !!}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php $flag=$user_login; ?>
                @if (!$flag)
                <li><a href="{!! url('register') !!}">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns">{!! Lang::get('messages.signup')
                            !!}</button>
                    </a></li>
                <li><a href="{!! url('login') !!}">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns">{!! Lang::get('messages.sign_in') !!}</button>
                    </a>
                </li>
                @else
                <li>
                    <a class="header_nav_menus">{!! Lang::get('messages.welcome') !!} : {{$username}}</a>
                </li>
                <li><a href="{!! url('/logout') !!}">
                        <button type="button" class="btn btn-default orange-bg usermenu-btns">{!! Lang::get('messages.sign_out') !!}</button>
                    </a>
                </li>
                @endif
                <li class="search_div_main">
                    <a href="#" class="search_anchor">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{!! Lang::get('messages.search_for') !!}" aria-describedby="basic-addon1">
                            <span class="input-group-addon orange-bg" id="basic-addon1"><i class="fa fa-search"></i></span>
                        </div>
                    </a>
                </li>
            </ul>


        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>