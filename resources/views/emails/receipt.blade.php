@component('mail::message')
# @lang('mail.hi') {{ $user->name }},
@lang('mail.message')

@component('mail::table')
|                               |                           |   |
| ------------------------------|:-------------------------:|--:|
|<h1>@lang('mail.receipt')</h1> |                           |   |
|@lang('mail.value')            |$ {{ $receipt['value'] }}  |   |
|@lang('mail.quantity')         |{{ $receipt['quantity'] }} |   |
|@lang('mail.total')            |$ {{ $receipt['total'] }}  |   |
@endcomponent

@lang('mail.thanks')<br>
@lang('mail.team')
@endcomponent
