@extends('user.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/buy-coin.css') }}">
@endsection

@section('content')
    <nav>
        <div class="container">
            <div class="row">
                <div class="bc-icons-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb lighten-4">
                            <li class="breadcrumb-item">
                                <a class="text-black-50" href="">@lang('user.buy-coin')</a>
                                <i class="fas fa-angle-double-right mx-2" aria-hidden="true"></i>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
    <div class="container custom py-5">
        <div class="row a">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item">
                                    <a data-toggle="pill" href="#credit-card" class="nav-link active btn ">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        @lang('user.credit_card')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="pill" href="#paypal" class="nav-link btn disabled">
                                        <i class="fab fa-paypal mr-2"></i>
                                        @lang('user.paypal')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="pill" href="#net-banking" class="nav-link btn disabled">
                                        <i class="fas fa-mobile-alt mr-2"></i>
                                        @lang('user.net_banking')
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{ route('payment') }} " method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">
                                            <h6>@lang('user.coin_value')</h6>
                                            @error('value')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <select name="value" class="form-control m-auto">
                                            @foreach (Config::get('user.coin_value') as $coin_value)
                                                <option value="{{ $coin_value }}">
                                                    {{ $coin_value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="d-flex">
                                            <h6 class="mr-3">@lang('user.quantity')</h6>
                                            @error('quantity')
                                                <span class="invalid-feedback d-block mt-0"
                                                    role="alert">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <input type="number" value="{{ Config::get('user.min_quantity') }}"
                                            name="quantity" class="form-control"
                                            min="{{ Config::get('user.min_quantity') }}"
                                            max="{{ Config::get('user.max_quantity') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardNumber">
                                            <h6>@lang('user.card_number')</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="cardNumber"
                                                placeholder="@lang('user.card_number_input')" class="form-control "
                                                disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted">
                                                    <i class="fab fa-cc-visa mx-1"></i>
                                                    <i class="fab fa-cc-mastercard mx-1"></i>
                                                    <i class="fab fa-cc-amex mx-1"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm">
                                            @lang('user.buy-coin')
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
