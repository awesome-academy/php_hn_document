<div class="px-4 d-none d-md-block">
    <div class="d-flex align-items-center">
        <div class="flex-grow-1">
            <input type="text" class="form-control my-3" placeholder="@lang('chat.search')">
        </div>
    </div>
</div>
@foreach ($listConversation as $conversation)
    <a data-url="{{ route('user.show.conversation', ['id' => $conversation->id]) }}"
        class="list-group-item list-group-item-action border-0 conversation">
        @if ($conversation->message->user_id === Auth::id())
            <div class="badge float-right">
            </div>
            <div class="d-flex align-items-start">
                <img src="{{ asset($conversation->user->image) }}" class="rounded-circle mr-1 avatar">
                <div class="flex-grow-1 ml-3">
                    {{ $conversation->user->name }}
                    <div class="small-text">
                        @lang('chat.you') {{ $conversation->message->content }}
                    </div>
                </div>
            </div>
        @elseif ($conversation->isRead)
            <div class="badge float-right">
                <span class="fas fa-circle chat-new"></span>
            </div>
            <div class="d-flex align-items-start">
                <img src="{{ asset($conversation->user->image) }}" class="rounded-circle mr-1 avatar">
                <div class="flex-grow-1 ml-3">
                    {{ $conversation->user->name }}
                    <div class="small-text chat-new">
                        {{ $conversation->message->content }}
                    </div>
                </div>
            </div>
        @else
            <div class="badge float-right">
            </div>
            <div class="d-flex align-items-start">
                <img src="{{ asset($conversation->user->image) }}" class="rounded-circle mr-1 avatar">
                <div class="flex-grow-1 ml-3">
                    {{ $conversation->user->name }}
                    <div class="small-text">
                        {{ $conversation->message->content }}
                    </div>
                </div>
            </div>
        @endif
    </a>
@endforeach
