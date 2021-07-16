<header class="header">
    <div class="header_main">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-3 col-3 order-1">
                    <div class="logo_container">
                        <div class="logo"><a href="{{ route('home') }}">{{ config('web.logo') }}</a></div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                    <div class="header_search">
                        <div class="header_search_content">
                            <div class="header_search_form_container">
                                <form action="#" class="header_search_form clearfix">
                                    <input type="search" required="required" class="header_search_input" placeholder="@lang('home.search')">
                                    <div class="custom_dropdown">
                                        <div class="custom_dropdown_list">
                                            <span class="custom_dropdown_placeholder clc">@lang('home.categories')</span><i class="fas fa-chevron-down"></i>
                                            <ul class="custom_list clc">
                                                <li><a class="clc" href="#">@lang('home.categories')</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{ asset(config('web.search')) }}" alt=""></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                        <div class="top_bar_menu">
                            <ul class="standard_dropdown top_bar_dropdown">
                                <li> <a href="#">@lang('home.en')<i class="fas fa-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="#">@lang('home.vi')</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="top_bar_content ml-auto">
                            <div class="wishlist_content">
                                <div class="wishlist_text"><a href="#"><i class="fas fa-upload"></i>@lang('home.upload')</a></div>
                            </div>
                        </div>
                        <div class="top_bar_content ml-auto">
                            <div class="top_bar_user">
                                <div class="user_icon"><img src="{{ asset(config('web.user')) }}" alt=""></div>
                                <div><a href="#">@lang('home.register')</a></div>
                                <div><a href="#">@lang('home.sign_in')</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main_nav">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="main_nav_content d-flex flex-row">
                        <div class="main_nav_menu">
                            <ul class="standard_dropdown main_nav_dropdown">
                                <li><a href="#">@lang('home.home')<i class="fas fa-chevron-down"></i></a></li>
                                <li class="hassubs"><a href="#">@lang('home.home')<i class="fas fa-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="#">@lang('home.home')<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="#">@lang('home.home')<i class="fas fa-chevron-down"></i></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
