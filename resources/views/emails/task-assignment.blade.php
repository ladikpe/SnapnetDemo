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
            <td>{{$task->name}}</td>
        </tr>
        <tr>
            <td>Task Priority</td>
            <td>{{$priority}}</td>
        </tr>
        <tr>
            <td>Task Sensitivity</td>
            <td>{{$sensitivity}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>


@component('mail::button', ['url' => $url])
View
@endcomponent

Regards, <br>
{{ config('app.name') }}
@endcomponent
