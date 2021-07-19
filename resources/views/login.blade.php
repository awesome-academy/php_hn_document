@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/authentication.css') }}">
@endsection

@section('content')
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
                                <div class="fa fa-facebook"></div>
                            </div>
                            <div class="twitter text-center mr-3">
                                <div class="fa fa-twitter"></div>
                            </div>
                            <div class="linkedin text-center mr-3">
                                <div class="fa fa-linkedin"></div>
                            </div>
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="line"></div>
                            <small class="or text-center">@lang('authen.or')</small>
                            <div class="line"></div>
                        </div>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.email')</h6>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </label>
                                <input class="mb-4" type="email" name="email" placeholder=@lang('authen.email_input')>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.password')</h6>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </label>
                                <input type="password" name="password" placeholder=@lang('authen.password_input')>
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input id="chk1" type="checkbox" name="remember" class="custom-control-input">
                                    <label for="chk1" class="custom-control-label text-sm">@lang('authen.remember')</label>
                                </div>
                                <a href="#" class="ml-auto mb-0 text-sm">@lang('authen.forgot')</a>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-blue text-center">@lang('authen.login')</button>
                            </div>
                        </form>
                        <div class="row mb-4 px-3">
                            <small class="font-weight-bold">@lang('authen.question_login')
                                <a class="text-danger" href="{{ route('register') }}">@lang('authen.register')</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
