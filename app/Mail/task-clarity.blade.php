@component('mail::message')
# Hello {{$name}} 

{!! $message !!}. <br>

<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center">Task Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Task Name</td>
            <td>{{$task}}</td>
        </tr>
        <tr>
            <td>Clarity Message</td>
            <td>{{$clarity}}</td>
        </tr>
    </tbody>
</table>


@component('mail::button', ['url' => $url])
View
@endcomponent

Regards, <br>
{{ config('app.name') }}
@endcomponent
