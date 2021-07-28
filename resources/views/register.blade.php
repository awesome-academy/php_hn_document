@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/authentication.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('authen.register')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                            <img src="{{ asset('images/logo.png') }}" class="image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">@lang('authen.signin')</h6>
                            <div class="facebook text-center mr-3">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                            <div class="twitter text-center mr-3">
                                <i class="fab fa-twitter"></i>
                            </div>
                            <div class="linkedin text-center mr-3">
                                <i class="fab fa-linkedin-in"></i>
                            </div>
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="line"></div>
                            <small class="or text-center">@lang('authen.or')</small>
                            <div class="line"></div>
                        </div>
                        <form id="form_register" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.email')</h6>
                                    <span id="mess_email" class="invalid-feedback d-block" role="alert">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </label>
                                <input id="email" class="mb-4" type="email" name="email"
                                    placeholder="@lang('authen.email_input')">
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.name')</h6>
                                    <span id="mess_name" class="invalid-feedback d-block" role="alert">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </label>
                                <input id="name" class="mb-4" type="text" name="name"
                                    placeholder="@lang('authen.name_input')">
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.password')</h6>
                                    <span id="mess_pass" class="invalid-feedback d-block" role="alert">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </label>
                                <input id="password" class="mb-4" type="password" name="password"
                                    placeholder="@lang('authen.password_input')">
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.confirm_password')</h6>
                                    <span id="mess_confirm" class="invalid-feedback d-block" role="alert">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </label>
                                <input id="password_confirm" type="password" name="password_confirmation"
                                    placeholder="@lang('authen.confirm_password_input')">
                            </div>
                            <div class="row mb-3 px-3">
                                <button id="button_register" type="submit"
                                    class="btn btn-blue text-center">@lang('authen.register')</button>
                            </div>
                        </form>
                        <div class="row mb-4 px-3">
                            <small class="font-weight-bold">@lang('authen.question_register')
                                <a class="text-danger" href="{{ route('login') }}">@lang('authen.login')</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/validate_login.js') }}"></script>
@endsection
