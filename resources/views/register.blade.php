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
                            <h6 class="mb-0 mr-4 mt-2">@lang('authen.signup')</h6>
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
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.email')</h6>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input class="mb-4" type="email" name="email" placeholder=@lang('authen.email_input')>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.name')</h6>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input class="mb-4" type="text" name="name" placeholder=@lang('authen.name_input')>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm label">@lang('authen.password')</h6>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input class="mb-4" type="password" name="password" placeholder=@lang('authen.password_input')>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                    <h6 class="mb-0 text-sm label">@lang('authen.confirm_password')</h6>
                                </label>
                                <input type="password" name="password_confirmation" placeholder=@lang('authen.confirm_password_input')>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-blue text-center">@lang('authen.register')</button>
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
