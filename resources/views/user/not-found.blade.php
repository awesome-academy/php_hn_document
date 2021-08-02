@extends('user.layouts.master')

@section('content')
    <section class="content-wrapper">
        <div class="container">
            <h3><img class="img-responsive" src="{{ asset('images/web/404-error.jpg') }}"></h3>
            <div>
                <a href="{{ route('home') }}" type="button" class="btn btn-danger">@lang('home.home')</a>
            </div>
        </div>
    </section>
@endsection
