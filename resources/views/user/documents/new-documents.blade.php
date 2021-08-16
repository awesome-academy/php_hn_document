<div class="container">
    <div class="row">
        <div class="section-title">
            <h3>@lang('home.new_documents') :</h3>
        </div>
    </div>
    <div class="row">
        @foreach ($newDocuments as $document)
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="card card-small">
                <div class="thumbnail">
                    <img src="{{ asset('uploads/preview/' . $document->name . '-' . config('uploads.cover_page') . '.' . config('uploads.cover_type')) }}"
                        class="img-cover">
                    <a href="{{ route('user.documents.show', $document->id) }}">
                        <div class="thumb-cover"></div>
                    </a>
                    <div class="details">
                        <div class="user">
                            <div class="name">{{ $document->category->name }}</div>
                        </div>
                        <div class="numbers">
                            <b class="downloads"><i class="fa fa-arrow-circle-o-down"></i>
                                {{ $document->downloads_count }}</b>
                            <b class="comments-icon"><i class="fa fa-comment"></i> {{ $document->comments_count }}</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-info">
                    <div class="moving">
                        <a href="{{ route('user.documents.show', $document->id) }}">
                            <h3>{{ $document->name }}</h3>
                            <p>{{ $document->description }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
