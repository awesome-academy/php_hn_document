@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('home.profile')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                                <a class="text-black-50" href="">@lang('home.edit_profile')</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container custom">
        <div class="row gutters">
            <div class="col-1"></div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img id="avatar" src={{ asset($user->image) }}>
                                    <input id="upload-avatar" type="file" class="d-none">
                                </div>
                                <h5 class="user-name">{{ $user->name }}</h5>
                                <h6 class="user-email">{{ $user->email }}</h6>
                            </div>
                            <div class="about">
                                <h5>@lang('user.about')</h5>
                                <p>{{ $user->about }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <form id="form_edit" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.name')</h6>
                                    <span id="mess_name" class="invalid-feedback d-block" role="alert">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input id="name" type="text" name="name" class="form-control"
                                        value='{{ $user->name }}'>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.email')</h6>
                                    <span id="mess_email" class="invalid-feedback d-block" role="alert">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input id="email" type="email" name="email" class="form-control"
                                        value='{{ $user->email }}'>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.phone')</h6>
                                    <span id="mess_phone" class="invalid-feedback d-block" role="alert">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input id="phone" type="text" name="phone" class="form-control"
                                        value='{{ $user->phone }}'>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.address')</h6>
                                    <span id="mess_address" class="invalid-feedback d-block" role="alert">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input id="address" type="text" name="address" class="form-control"
                                        value='{{ $user->address }}'>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.about')</h6>
                                    <span id="mess_about" class="invalid-feedback d-block" role="alert">
                                        @error('about')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea id="about" type="text" name="about"
                                        class="form-control">{{ $user->about }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">@lang('user.avatar')</h6>
                                    <span id="mess_avatar" class="invalid-feedback d-block" role="alert">
                                        @error('avatar')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input id="avatar" type="file" name="avatar" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <button id="button_edit" type="submit" name="submit"
                                            class="btn btn-primary">@lang('user.update')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/validate_login.js') }}"></script>
@endsection
