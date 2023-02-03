    
    <table class="table table-sm mb-0" id="email_table">
      <thead class="thead-dark">
        <tr>
          <th>#</th>                                            
          <th>Bid Name</th>
          <th>User</th>
          <th>Created by</th>
          <th>Date</th>
          <th style="text-align:right">Action </th>
        </tr>
      </thead>
      <tbody>      @php $i = 1; @endphp    
          @forelse ($bid_email_lists as $bid_email_list)                
              <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $bid_email_list->bid?$bid_email_list->bid->name:'' }}</td>
                  <td>{{ $bid_email_list->user?$bid_email_list->user->name:'' }}</td>
                  <td>{{ $bid_email_list->author?$bid_email_list->author->name:'' }}</td>
                  <td>{{date("M j, Y", strtotime($bid_email_list->created_at))}}</td>
                  <td>
                    <a onclick="setDeleteId({{$bid_email_list->id}})" class="btn-sm text-danger pull-right" data-toggle="modal" data-target="#deleteEmailModal"title="Delete Details" id="del_{{$bid_email_list->id}}"><i class="la la-remove" aria-hidden="true" style="font-size:13px"></i></a>

                    <a onclick="pullEmailListId({{$bid_email_list->id}})" class="btn-sm text-success pull-right edit" data-toggle="tooltip" title="Edit Details" id="edit_{{$bid_email_list->id}}" ><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                  </td>
              </tr> @php $i++; @endphp
          @empty
              No Data Found 
          @endforelse
      </tbody>
    </table>