@extends('layouts.app')

@section('content')


    

<!-- INCLUDING styles-->
@include('bids.css.styles')

    
<div class="row">     
                
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4>Bids  
                <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right addNew" data-toggle="modal" data-target="#addBidModal"
                   title="Create New Bid" style="margin-top: -10px" id="add"><i class="la la-plus"></i></a>

                <a href="#" class="btn btn-outline-success btn-glow btn-sm pull-right mr-1" data-toggle="modal" data-target="#uploadBidForm"
                   title="Upload Bid using excel" style="margin-top: -10px"><i class="la la-upload"></i></a>

                <a href="{{ url('download-bid-excel') }}" class="btn btn-outline-danger btn-glow btn-sm pull-right mr-1" data-toggle="tooltip"
                   title="Download Bid using excel" style="margin-top: -10px"><i class="la la-download"></i></a>

                <div class="row pull-right mr-1" style="margin-top: -8px">
                    <form id="searchForm" action="{{route('bids.index')}}" method="get">
                    <fieldset>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" placeholder="Search ... " aria-describedby="button-addon2" id="search" name="search" style="height: 30px">
                            <div class="input-group-append"> <button class="btn btn-outline-primary btn-glow btn-sm" type="submit" style="height: 30px"><i class="la la-search"></i> </button> </div>
                        </div>
                    </fieldset>
                    </form>
                </div>

                <div class="row pull-right mr-2" style="margin-top: -8px">
                    <form id="searchForm" action="{{route('bids.index')}}" method="get">
                        <fieldset>
                            <div class="input-group">
                                <select class="form-control tokenizationSelect2" name="column" id="column" style="height: 30px">
                                    <option value="">Select</option>
                                    <option value="bid_code">Bid Code</option>
                                    <option value="name">Bid Name</option>
                                    <option value="description">Description</option>
                                    {{-- <option value="bid_type">Bid Type</option> --}}
                                    <option value="start_date">Start Date</option>
                                    <option value="end_date">End Date</option>
                                    <option value="industry_id">Industry</option>
                                    <option value="status_id">Status</option>
                                </select>
                                <div class="input-group-append"> <button class="btn btn-outline-primary btn-glow btn-sm" type="submit" style="height: 30px"><i class="la la-arrows-v"></i> </button> </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </h4>

              <table class="table table-sm mb-0" id="">
                <thead class="thead-dark">
                  <tr>
                    <th>Bid Code</th>
                    <th>Bid Name</th>
                    <th>Description</th>
                    {{-- <th>Instructions</th> --}}
                    <th>Bid Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Industry</th>
                    <th>Responses</th>
                    <th>Status</th>
                    <th style="text-align:right">Action </th>
                  </tr>
                </thead>
                <tbody>        
                    @forelse ($bids as $bid)                
                        <tr>
                            <td>{{ $bid->bid_code }}</td>
                            <td>{{ $bid->name }}</td>
                            <td>{{ substr($bid->description, 0, 15) }} ...</td>
                            {{-- <td>{{ substr($bid->instruction, 0, 15) }} ...</td> --}}
                            <td> @if($bid->bid_type == 1) Shortlisted Only  @else All Vendor @endif </td>
                            <td>{{date("M j, Y", strtotime($bid->start_date))}}</td>
                            <td>{{date("M j, Y", strtotime($bid->end_date))}}</td>
                            <td>{{ $bid->industry?$bid->industry->name:'' }}</td>
                            <td> {{$controllerName->GetNumberOfBidResponse($bid->id)}} </td>
                            <td>
                                @if($bid->status_id == 0) 
                                  <span class="badge badge-danger">Closed</span>
                                @else <span class="badge badge-success">Open</span> @endif 
                            </td>
                            <td>
                              <a href="#" class="btn-sm text-danger pull-right" data-toggle="tooltip" title="Delete Bid" id="del_{{$bid->id}}"><i class="la la-remove" aria-hidden="true" style="font-size:13px"></i></a>

                              <a href="{{ url('search-for-bidders', $bid->id) }}" class="btn-sm text-primary pull-right edit" data-toggle="tooltip" title="Search For Bidders" id="search_{{$bid->id}}" target="_blank"><i class="la la-search" aria-hidden="true" style="font-size:13px"></i></a>

                              <a href="{{ url('bid-packages', $bid->id) }}" class="btn-sm text-info pull-right edit" data-toggle="tooltip" title="Add Bid Requirements" id="edit_{{$bid->id}}" target="_blank"><i class="la la-credit-card" aria-hidden="true" style="font-size:13px"></i></a>

                              <a onclick="pullBidId({{$bid->id}})" class="btn-sm text-success pull-right edit" data-toggle="modal" title="Edit Bid" data-target="#addBidModal" id="edit_{{$bid->id}}" ><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                            </td>
                        </tr>
                    @empty
                        No Record Has Been Created ! 
                    @endforelse
                </tbody>
              </table>
              {!! $bids->render() !!}

          </div>
        </div>
      </div>
    </div>

</div>






<!-- INCLUDING Modals-->
@include('bids.modals.forms')








    





   
   

   
   
@endsection

@section('scripts')


    

<!-- INCLUDING scripts-->
@include('bids.js.scripts')

  
@endsection
