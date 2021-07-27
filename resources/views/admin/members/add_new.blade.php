@extends('admin.layouts.master')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5 container-fluid">
        <div class="card-body p-0">
            <form class="user" id="main" action="{{ route('admin.members.store') }}"
                  method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-lg-4 d-none d-lg-block form-group">
                        <img class="img-fluid " id="blah" src="{{ asset(config('user.image_default')) }}"/>
                        <hr>
                        <input accept="image" type='file' id="imgInp" name="file"/>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">@lang('member.create')</h1>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <input id="name" class="form-control form-control-user" type="text"
                                           placeholder="@lang('member.name')" name="name" required>
                                </div>
                                <div class="col-sm-4 messages">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}<p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                <input type="email" class="form-control form-control-user" id="email"
                                       placeholder="@lang('member.email')" name="email" required>
                                </div>
                                <div class="col-sm-4 messages">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}<p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <input id="phone" class="form-control form-control-user" type="text"
                                           placeholder="@lang('member.phone')" name="phone">
                                </div>
                                <div class="col-sm-4 messages">
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}<p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <input id="address" class="form-control form-control-user" type="text"
                                           placeholder="@lang('member.address')" name="address">
                                </div>
                                <div class="col-sm-4 messages">
                                    @error('address')
                                    <p class="text-danger">{{ $message }}<p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <input id="about" class="form-control form-control-user" type="text"
                                           placeholder="@lang('member.about')" name="about">
                                </div>
                                <div class="col-sm-4 messages">
                                    @error('about')
                                    <p class="text-danger">{{ $message }}<p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="password" placeholder="@lang('member.password')" name="password" required>
                                </div>
                                <div class="col-sm-4 messages">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <input id="confirm-password" class="form-control form-control-user" type="password"
                                           placeholder="@lang('member.confirm')" name="password_confirmation" required>
                                </div>
                                <div class="col-sm-4 messages">
                                </div>
                            </div>
                            <hr>
                            <button class="btn btn-info btn-user btn-block" type="submit">
                                    <i class="fas fa-leaf"></i> @lang('member.add')
                                </button>
                            <hr>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/add_member.js') }}"></script>
@endsection
