<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@lang('admin.title')</title>

    <link href="{{ asset('bower_components/startbootstrap-sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('bower_components/startbootstrap-sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-sweetalert/dist/sweetalert.css') }}">
    @yield('css')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin.layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.layouts.header')
                @yield('content')
                @include('admin.layouts.footer')
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('admin.logout_ready')</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">@lang('admin.logout_model')</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('admin.cancel')</button>
                    <a class="btn btn-primary" href="#">@lang('home.logout')</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('bower_components/startbootstrap-sb-admin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('bower_components/validate/validate.min.js') }}"></script>
    <script src="{{ asset('bower_components/underscore/underscore-min.js') }}"></script>
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    @yield('js')
</body>
