@extends('user.layouts.master')

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="#">@lang('home.home')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <section class="section home-5-bg" id="home">
        <div id="particles-js"></div>
        <div class="bg-overlay"></div>
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="justify-content-center row">
                        <div class="col-lg-7">
                            <div class="mt-40 text-center home-5-content">
                                <div class="home-icon mb-4"><i class="mdi mdi-pinwheel mdi-spin text-white h1"></i></div>
                                <h1 class="text-white font-weight-normal home-5-title mb-0">@lang('home.slogan')</h1>
                                <p class="text-white-70 mt-4 f-15 mb-0">@lang('home.slogan_content')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <br>
        <div class="row">
            @if ($newDocuments != null)
                @include('user.documents.new-documents')
            @endif
        </div>
        <div class="row">
            @if ($mostDownloads != null)
                @include('user.documents.most-downloads')
            @endif
        </div>
    </div>
    <section class="section services-section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>@lang('home.introduction')</h2>
                        <p>@lang('home.introduction_content')</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.discover')</h5>
                            <p>@lang('home.discover_content')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.original')</h5>
                            <p>@lang('home.original_content')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-comment"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.help')</h5>
                            <p>@lang('home.help_content')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-image"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.make')</h5>
                            <p>@lang('home.make_content')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-th"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.mission')</h5>
                            <p>@lang('home.mission_content')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-cog"></i>
                        </div>
                        <div class="feature-content">
                            <h5>@lang('home.supporting')</h5>
                            <p>@lang('home.supporting_content')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
