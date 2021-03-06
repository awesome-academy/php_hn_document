<header class="header">
    <div class="header_main">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-3 col-3 order-1">
                    <div class="logo_container">
                        <div class="logo"><a href="{{ route('home') }}">{{ config('web.logo') }}</a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 order-lg-2 order-3 text-lg-left text-right">
                    <div class="header_search">
                        <div class="header_search_content">
                            <div class="header_search_form_container">
                                <form action="{{ route('documents.search') }}" class="header_search_form clearfix">
                                    <input type="search" name="name" required="required" class="header_search_input"
                                        placeholder="@lang('home.search')">
                                    <button type="submit" class="header_search_button trans_300" value="Submit">
                                        <i class="text-white fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 order-lg-2 order-3 text-lg-left text-right my-auto">
                    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                        <div class="top_bar_menu mx-auto">
                            <ul class="standard_dropdown top_bar_dropdown">
                                <li>
                                    <a>@lang('home.categories')<i class="fas fa-chevron-down"></i></a>
                                    @include('user.layouts.categories', ['categories' => $categories])
                                </li>
                            </ul>
                        </div>
                        <div class="top_bar_content mx-auto">
                            <div class="wishlist_content">
                                <div class="wishlist_text">
                                    <a href="{{ route('user.documents.storeUpload') }}">
                                        <i class="fas fa-upload"></i> @lang('home.upload')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-9 order-lg-3 order-2 text-lg-left text-right">
                    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                        <div class="top_bar_content mx-auto" id="notify">
                            <div class="wishlist_text icon" id="bell">
                                <a href="#"><i class="fas fa-bell"></i></a>
                                @if (Auth::check())
                                <input id="userLogin" type="hidden" value="{{ Auth::id() }}">
                                <span data-count="{{ Auth::user()->unreadNotifications->count() }}"
                                    class="badge badge-danger badge-counter">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </div>
                            <div class="notifications" id="box">
                                @if (Auth::check())
                                <h2>@lang('notification.notifications') - <span class="notif-count">
                                        {{ Auth::user()->unreadNotifications->count() }}</span>
                                </h2>
                                <div id="notification-content">
                                    @foreach (Auth::user()->notifications as $notification)
                                    @if($notification->read_at == NULL && array_key_exists("following", $notification->data))
                                    <div class="notifications-item"> <img
                                            src="{{ asset($notification->data['image']) }}">
                                        <a href="{{ route('user.mark', $notification->data['id']) }}">
                                            <div class="text">
                                                <h4>{{ $notification->data['name'] }}</h4>
                                                <p>@lang($notification->data['following'])</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <h2><a href="{{ route('user.mark-all') }}">@lang('notification.mark_all')</a></h2>
                                @else
                                <h2>@lang('notification.login_required')</h2>
                                @endif
                            </div>
                        </div>
                        <div class="top_bar_menu mx-auto">
                            <ul class="standard_dropdown top_bar_dropdown">
                                <li>
                                    <a href="">
                                        @if (App::isLocale(Config::get('user.en')))
                                        <img src="{{ asset('images/web/en.svg') }}" width="20" height="15" loading="lazy">
                                        @else
                                        <img src="{{ asset('images/web/vi.svg') }}" width="20" height="15" loading="lazy">
                                        @endif
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <ul>
                                        @if (App::isLocale(Config::get('user.en')))
                                        <li>
                                            <a href="{{ route('change-language', ['locale' => Config::get('user.vi')]) }}">
                                                <img src="{{ asset('images/web/vi.svg') }}" width="20" height="15" loading="lazy">
                                            </a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ route('change-language', ['locale' => Config::get('user.en')]) }}">
                                                <img src="{{ asset('images/web/en.svg') }}" width="20" height="15" loading="lazy">
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        @if (!Auth::check())
                        <div class="top_bar_content ml-auto">
                            <div class="wishlist_content">
                                <div class="wishlist_text">
                                    <a href="{{ route('register') }}">@lang('home.register')</a>
                                </div>
                            </div>
                        </div>
                        <div class="top_bar_content ml-auto">
                            <div class="wishlist_content">
                                <div class="wishlist_text">
                                    <a href="{{ route('login') }}">@lang('home.sign_in')</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="top_bar_content mx-auto">
                            <div class="wishlist_content">
                                <ul class="standard_dropdown top_bar_dropdown">
                                    <li>
                                        <a href="">@lang('home.profile')<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('users.show', ['user' => Auth::user()->id]) }}">
                                                    @lang('home.view_profile')</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">
                                                    @lang('home.edit_profile')</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.documents.index') }}">
                                                    @lang('home.list_documents')</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="post">
                                                    @csrf
                                                    <input id="logout-input" class="btn" type="submit" value=@lang('home.logout')>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
