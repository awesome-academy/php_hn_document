@extends('user.layouts.master')

@section('content')
    <form action={{ route('user.documents.storeUpload') }} method="POST" enctype="multipart/form-data">
        @method('post')
        @csrf
        <div class="container">
            <div class="row it">
                <div class="col-sm-offset-1 col-sm-10" id="one">
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-4 form-group">
                            <h3 class="text-center">@lang('uploads.header')</h3>
                        </div>
                    </div>
                    <div id="uploader">
                        <div class="row uploadDoc">
                            <div class="col-sm-4">
                                <div class="docErr">@lang('uploads.invalid')</div>
                                @error('file')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="fileUpload btn btn-orange">
                                    <img src="{{ asset('images/web/file.svg') }}" class="icon">
                                    <span class="upl" id="upload">@lang('uploads.documents')</span>
                                    <input name="file" type="file" class="upload up" id="up" onchange="readURL(this);" required>
                                </div>
                                <p>
                                    @lang('uploads.supported')
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="inputUsername">@lang('uploads.title')( @lang('uploads.required'))</label>
                                    <input name="name" type="text" class="form-control" id="inputUsername" placeholder="@lang('uploads.title')" required>
                                </div>
                                <div class="form-group">
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="inputUsername">@lang('uploads.description')( @lang('uploads.required'))</label>
                                    <textarea name="description" rows="2" class="form-control" id="inputBio" placeholder="@lang('uploads.description')" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-next" type="submit"><i class="fa fa-paper-plane"></i> @lang('uploads.done')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/upload.js') }}"></script>
@endpush
