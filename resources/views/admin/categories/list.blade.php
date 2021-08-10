@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <h1 class="h3 mb-2 text-gray-800">@lang('category.list')</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('admin.categories')</h6>
            </div>
            <div class="card-body">
                <input hidden value="{{ route('category.data') }}" id="categoryData">
                <div class="table-responsive">
                    <table class="table table-bordered" id="categoryTable">
                        <thead>
                            <tr>
                                <th>@lang('member.number')</th>
                                <th>@lang('category.name')</th>
                                <th>@lang('category.parent')</th>
                                <th>@lang('category.created')</th>
                                <th>@lang('category.updated')</th>
                                <th id="edit">@lang('category.edit')</th>
                                <th id="delete">@lang('category.delete')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/category_datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/delete_category.js') }}" type="text/javascript"></script>
@endsection
