@component('mail::message')
# Hello {{$name}} 

{!! $message !!}. <br>




@component('mail::button', ['url' => $url])
View
@endcomponent

Regards, <br>
{{ config('app.name') }}
@endcomponent
