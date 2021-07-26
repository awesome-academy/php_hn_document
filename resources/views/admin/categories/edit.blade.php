@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <form method="POST" action="{{ route('admin.categories.update', ['category' => $thisCategory->id]) }}">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="">@lang('category.choose_parent'):</label>
                    <select class="form-control" name="category" id="category">
                        <option value="{{ $thisCategory->parent_id }}">{{ ($parent != null ? $parent->name : __('category.root')) }}</option>
                        @include('user.documents.category_options', ['level' => 0])
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('category.name'):</label>
                    <div>
                        <input type="text" class="form-control form-control-user"
                               name="name" placeholder="{{ $thisCategory->name }}" value="{{ $thisCategory->name }}">
                    </div>
                </div>
                <button class="btn btn-warning" type="reset">@lang('admin.reset')</button>
                <button class="btn btn-info" type="submit">@lang('admin.update')</button>
            </form>
        </div>
    </div>
@endsection
