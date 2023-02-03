    
    <table class="table table-sm mb-0" id="docu_table">
      <thead class="thead-dark">
        <tr>
          <th>#</th>                                            
          <th>Document Name</th>
          <th>Document Type</th>
          <th>Expiry Date</th>
          <th style="text-align:right">Action </th>
        </tr>
      </thead>
      <tbody>      @php $i = 1; @endphp    
          @forelse ($vendor_documents as $vendor_document)                
              <tr>
                  <td>{{ $i }}</td>
                  <td style="text-align:right">{{ $vendor_document->name }}</td>
                  <td style="text-align:right">{{ $vendor_document->type?$vendor_document->type->name:'' }}</td>
                  <td style="text-align:right">{{ $vendor_document->expiry_date }}</td>
                  <td>
                    <a class="btn-sm text-danger pull-right" data-toggle="tooltip" title="Delete Document" id="{{$vendor_document->id}}"><i class="la la-close" aria-hidden="true" style="font-size:13px"></i></a>

                    <a class="btn-sm text-info pull-right" data-toggle="tooltip" title="View Document" id="{{$vendor_document->id}}"><i class="la la-eye" aria-hidden="true" style="font-size:13px"></i></a>

                    <a onclick="pullDocumentDetails({{$vendor_document->id}})" class="btn-sm text-success pull-right" data-toggle="tooltip" title="View Document" id="{{$vendor_document->id}}"><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                  </td>
              </tr> @php $i++; @endphp
          @empty
              No Data Found 
          @endforelse
      </tbody>
    </table>