@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label for="">@lang('category.choose_parent'):</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">@lang('category.select_parent')</option>
                        @include('user.documents.category_options', ['level' => 0])
                    </select>
                </div>
                <div class="form-group">
                    @error('name')
                    <span class="invalid-feedback d-block mt-0" role="alert">{{ $message }}</span>
                    @enderror
                    <label>@lang('category.name'):</label>
                    <div>
                        <input type="text" class="form-control form-control-user"
                               name="name" placeholder="@lang('category.type_name')">
                    </div>
                </div>
                <button class="btn btn-warning" type="reset">@lang('admin.reset')</button>
                <button class="btn btn-success" type="submit">@lang('admin.add')</button>
            </form>
        </div>
    </div>
@endsection
