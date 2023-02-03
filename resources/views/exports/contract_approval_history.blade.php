<table>
    <thead>
    <tr>
        <th>Contract Name</th>
        <th>Approved By</th>
        <th>Stage Name</th>
        <th>Status </th>
        <th>Comment </th>
        <th>Started at </th>

        <th>Ended At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contract->contract_reviews as $review)
        <tr>
            <td>{{ $contract->name }}</td>
            <td>{{ $review->approver ? $review->approver->name:'' }}</td>
            <td>{{ $review->stage ? $review->stage->name :''}}</td>
            <td>{{$review->status==0?'Pending':($review->status==1?'Approved':($review->status==2?'Rejected':''))}}</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->created_at }}</td>
            <td>{{ $review->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>