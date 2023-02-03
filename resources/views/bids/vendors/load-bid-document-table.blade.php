    
    <table class="table table-sm mb-0" id="attachment_table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Attachment Name</th>
            <th>Path</th>
            <th>Created by</th>
            <th>Date</th>
            <th style="text-align:right">Action </th>
          </tr>
        </thead>
        <tbody>    @php $i = 1; @endphp     
            @forelse ($documents as $document)                
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $document->name }}</td>
                    <td>{{ $document->path }}</td>
                    <td>{{ $document->author?$document->author->name:'' }}</td>
                    <td>{{date("M j, Y", strtotime($document->created_at))}}</td>
                    <td>
                      <a onclick="setDelDeleteId({{$document->id}})" class="btn-sm text-danger pull-right" data-toggle="modal" data-target="#deleteDocModal"title="Delete Details" id="dele_{{$document->id}}"><i class="la la-remove" aria-hidden="true" style="font-size:13px"></i></a>

                      <a onclick="pullDocId({{$document->id}})" class="btn-sm text-success pull-right edit" data-toggle="tooltip" title="Edit Details" id="docu_{{$document->id}}" ><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                    </td>
                </tr>    @php $i++; @endphp  
            @empty
                No Attachment Uploaded Yet ! 
            @endforelse
        </tbody>
      </table>