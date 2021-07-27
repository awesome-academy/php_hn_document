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
                <div class="table-responsive">
                    <table class="table table-bordered" id="categoryTable">
                        <thead>
                            <tr>
                                <th>@lang('category.id')</th>
                                <th>@lang('category.name')</th>
                                <th>@lang('category.parent')</th>
                                <th>@lang('category.created')</th>
                                <th>@lang('category.updated')</th>
                                <th>@lang('category.edit')</th>
                                <th>@lang('category.delete')</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>@lang('category.id')</th>
                                <th>@lang('category.name')</th>
                                <th>@lang('category.parent')</th>
                                <th>@lang('category.created')</th>
                                <th>@lang('category.updated')</th>
                                <th>@lang('category.edit')</th>
                                <th>@lang('category.delete')</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td id="dataId">{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ ($category->parent != null ? $category->parent->name : __('category.root')) }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}"
                                    class="btn btn-info">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btnDelete" >
                                        <input id="url" type="hidden" value="{{ route('admin.categories.destroy', ['category' => $category->id]) }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <input id="hasChildren" type="hidden" value="{{ $category->childCategories->count() == null ? 0 : 1 }}">
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/delete_category.js') }}" type="text/javascript"></script>
@endsection
