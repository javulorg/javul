<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Javul.org</title>
    <link rel="shortcut icon" href="{!! url('favicon.ico') !!}" type="image/icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{!! url('assets/plugins/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! url('assets/plugins/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! url('assets/css/style.css') !!}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    @yield('page-css')
</head>
<!-- END HEAD -->
    <!-- If login page reload every 15 minutes. -->
    <body>
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
                    <a class="navbar-brand" href="#">
                        <img class="logo" src="{!! url('assets/images/logo.png') !!}" />JAVUL
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#" style="padding-top:10px;"><span class="glyphicon glyphicon-home"></span></a></li>
                        <li><a href="#">{!! Lang::get('messages.about_this_site') !!}</a></li>
                        <li><a href="#">{!! Lang::get('messages.faq') !!}</a></li>
                        <li><a href="#">{!! Lang::get('messages.how_can_i_help') !!}</a></li>
                        <li><a href="#">{!! Lang::get('messages.joul.org_unit') !!}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{!! url('auth/register') !!}">
                                <button type="button" class="btn btn-default orange-bg">{!! Lang::get('messages.signup') !!}</button>
                            </a></li>
                        <li><a href="{!! url('auth/login') !!}">
                                <button type="button" class="btn btn-default orange-bg">{!! Lang::get('messages.sign_in') !!}</button>
                            </a>
                        </li>
                        <li style="width:300px;">
                            <a href="#">
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
        <!-- BEGIN LOGIN -->
        <div class="content">
             @yield('content')
        </div>

        <!--[if lt IE 9]>
        <script src="{!! url('assets/plugins/respond.min.js') !!}"></script>
        <script src="{!! url('assets/plugins/excanvas.min.js') !!}"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{!! url('assets/plugins/jquery.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/plugins/bootstrap/js/bootstrap.min.js') !!}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{!! url('assets/plugins/jquery-validation/js/jquery.validate.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/plugins/jquery-validation/js/additional-methods.min.js') !!}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        @yield('page-scripts')
    </body>
</html>
