@php
    $sn=1;
@endphp
<table>
    <thead>
    <tr>
        <th>Contract Name</th>
        <th>Version</th>
        <th>Change By</th>
        <th>Started at </th>
        <th>Ended At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contract->contract_details as $detail)
        <tr>
            <td>{{ $contract->name }}</td>
            <td>{{ $sn }}</td>
            <td>{{ $detail->user->name }}</td>
            <td>{{ $detail->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>