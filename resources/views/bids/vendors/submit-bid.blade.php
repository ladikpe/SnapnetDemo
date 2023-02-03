@extends('layouts.vendorapp')

@section('content')


    

<!-- INCLUDING styles-->

    
<div class="row">     
                
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4>Bids </h4>

            	<table class="table table-sm mb-0 d-table" id="submitted_table">
                    <thead class="thead-dark">
                      <tr>
                        <th>#</th>                                            
                        <th>Bid Name</th>
                        <th>Note</th>
                        <th>Submitted Date</th>
                        <th>Satus</th>
                        <th style="text-align:right">Action </th>
                      </tr>
                    </thead>
                    <tbody>      @php $i = 1; @endphp    
                        @forelse ($submitted_bids as $submitted_bid)                
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $submitted_bid->bid?$submitted_bid->bid->name:'' }}</td>
                                <td>{{ $submitted_bid->note }}</td>
                                <td>{{date("M j, Y", strtotime($submitted_bid->created_at))}}</td>
                                <td>
                                	@if($submitted_bid->status_id == 0) 
	                                  <span class="badge badge-danger">Closed</span>
	                                @else <span class="badge badge-success">Open</span> @endif 
                                </td>
                                <td>

                                  <a class="btn-sm text-info pull-right" data-toggle="tooltip" title="Edit Bid " id="_{{$submitted_bid->id}}"><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                                </td>
                            </tr> @php $i++; @endphp
                        @empty
                        @endforelse
                    </tbody>
                  </table>

          </div>
        </div>
      </div>
    </div>

</div>






<!-- INCLUDING Modals-->








    





   
   

   
   
@endsection

@section('scripts')


    

<!-- INCLUDING scripts-->

  
@endsection
