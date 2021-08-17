@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">@lang('admin.document_list')</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('admin.document')</h6>
            </div>
            <div class="card-body">
                <input hidden value="{{ route('document.data') }}" id="documentData">
                <div class="table-responsive">
                    <table class="table table-bordered" id="documentTable">
                        <thead>
                            <tr>
                                <th>@lang('member.number')</th>
                                <th id="cover">@lang('document.cover')</th>
                                <th>@lang('document.name')</th>
                                <th>@lang('document.category')</th>
                                <th>@lang('document.created_by')</th>
                                <th>@lang('document.deleted_at')</th>
                                <th id="restore">@lang('document.restore')</th>
                                <th id="delete">@lang('document.delete')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        window.translations = {!! $translation !!};
    </script>
    <script src="{{ asset('js/document_datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/delete_document.js') }}" type="text/javascript"></script>
@endsection
