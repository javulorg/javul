@include('layout.header-dependencies')
@include('layout.header')
<div class="wrapper position-relative">


    <div class="banner">
        <div class="banner_left_side">
            <div class="banner_car">
                <img src="{{ asset('v2/assets/img/main-logo.png') }}" alt="" class="img-fluid">
            </div>
            <div>
                @yield('site-name')
            </div>
        </div>
        <div class="container">
            <div class="search_block d-lg-block d-none">
                <div class="search_form">
                    <div class="separator"></div>
                    <input type="text" placeholder="Search Site-wide">
                    <div class="separator"></div>
                    <button type="submit"><img src="{{ asset('v2/assets/img/search.svg') }}" alt=""></button>
                    <div class="clear_search"></div>
                </div>
                <a href="#">
                    Advanced Search
                </a>
            </div>
            <div class="search_btn d-md-none d-flex" id="search_btn">
                <img src="{{ asset('v2/assets/img/search.svg') }}" alt="">
            </div>
        </div>
    </div>

    @yield('navbar')

    <div class="breadcrumbs">
        <!-- <div class="container">
            <div class="bread">
                <a href="/">Urban Planning</a><div class="separator"></div><a href="#">Public Transport</a><div class="separator"></div><a href="#">Taxis</a>
            </div>
        </div> -->


    </div>

    <div class="mt-2" id="loadingDiv" style="display: none;"><img id="loading" src="{!! url('assets/images/loader.gif') !!}" alt="" />
fffffff
    </div>

    <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <div class="site_statistic">
        @include('layout.site-statistic')
    </div>
    <footer>
    @include('layout.footer')
        @yield('scripts')
    </footer>
</div>



