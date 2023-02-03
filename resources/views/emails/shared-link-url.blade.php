@component('mail::message')
# Hello {{$name}} 

{!! $message !!}. <br>

<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center"> Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Comment</td>
            <td>{!! $comment !!}</td>
        </tr>
        <tr>
            <td>Link / URL</td>
            <td>{{$link_url}}</td>
        </tr>
    </tbody>
</table>


@component('mail::button', ['url' => $url])
View
@endcomponent

Regards, <br>
{{ config('app.name') }}
@endcomponent
