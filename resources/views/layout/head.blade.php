@include('layout.header-dependencies')
<div class="wrapper">
    <div class="main-header">

        @include('layout.header')

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
                    <select name="search_select" id="search_select_modal">
                        <option value="">Search with this Unit</option>
                        <option value="">Search with another Unit</option>
                    </select>
                    <div class="separator"></div>
                    <input type="text" placeholder="">
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

        @if (!Route::is('login') && !Route::is('register'))
            <div class="content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
         @endif


    </div>

    @if (Route::is('login') || Route::is('register'))
    <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    @endif


    <div class="main-footer">
        <div class="site_statistic">
            @include('layout.site-statistic')
        </div>

        <footer>
            @include('layout.footer')
            @yield('scripts')
        </footer>
    </div>
</div>
