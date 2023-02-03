@extends('layouts.app')

@section('content')


    

<!-- INCLUDING styles-->

    
<div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Submitted Bids</div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm mb-0" id="assignment_table">
                                <thead class="thead-bg">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Bid Code</th>
				                    <th>Bid Name</th>
				                    <th>Description</th>
				                    <th>Instructions</th>
				                    <th>Bid Type</th>
				                    <th>Start Date</th>
				                    <th>End Date</th>
				                    <th>Industry</th>
				                    <th>Status</th>
				                    <th style="text-align:right">Action </th>
                                </tr>
                                </thead>  @php $i = 1; @endphp
                                <tbody>        
			                    @forelse ($bids as $bid)                
			                        <tr>
			                            <td>{{ $bid->bid?$bid->bid->bid_code:'' }} </td>
			                            <td>{{ $bid->bid?$bid->bid->name:'' }}</td>
			                            <td>{{ substr($bid->bid?$bid->bid->description:'', 0, 10) }}</td>
			                            <td>{{ substr($bid->bid?$bid->bid->instruction:'', 0, 10) }}</td>
			                            <td> @if($bid->bid_type == 1) Shortlisted Only  @else All Vendor @endif </td>
                                        <td>{{ date("M j, Y", strtotime($controllerName->GetBidStartDate($bid->bid_id)) )}}</td>
			                            <td>{{ date("M j, Y", strtotime($controllerName->GetBidEndDate($bid->bid_id)) )}}</td>
			                            <td>{{ $bid->bid->industry?$bid->bid->industry->name:'' }}</td>
			                            <td>
			                                @if($bid->bid->status_id == 0) 
			                                  <span class="badge badge-danger">Closed</span>
			                                @else <span class="badge badge-success">Open</span> @endif 
			                            </td>
			                            <td>
			                              <a onclick="pullBidId({{$bid->id}})" class="btn-sm text-success pull-right edit" data-toggle="modal" title="Edit Bid" data-target="#addBidModal" id="edit_{{$bid->id}}" ><i class="la la-send" aria-hidden="true" style="font-size:13px"></i></a>
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



        <div class="col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <form id="searchForm" action="{{route('submitted-bids')}}" method="get">

                                <div class="card-body" style="padding: 0px">

                                  <div class="form-body">
                                    <h5 class="form-section" style="border-bottom: 1px solid #d1d5ea !important; color: #666 !important;"><i class="la la-sort"></i> Search</h5>

                                <fieldset>
                                  <div class="input-group">
                                    {{-- <div class="input-group-prepend">
                                      <button class="btn btn-outline-light" type="button">Search</button>
                                    </div> --}}
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search ... " aria-label="Amount">
                                    <div class="input-group-append">
                                      <button class="btn btn-default" type="submit"><i class="la la-search"></i></button>
                                    </div>
                                </fieldset>
                            </div>
                            </form>

                            <form id="searchForm" class="form form-horizontal" action="{{route('submitted-bids')}}" method="get">


                                <div class="card-body" style="padding: 0px">

                                  <div class="form-body"> <br> <br> <br>
                                    <h5 class="form-section" style="border-bottom: 1px solid #d1d5ea !important; color: #666 !important;"><i class="la la-sort"></i> Sort</h5>

                                <div class="card-body" style="padding:0px;">
                                    <p>Sort By</p>

                                    <fieldset class="form-group position-relative">
                                      <select class="form-control tokenizationSelect2" name="column" id="column">
                                            <option value="">Select</option>
                                            <option value="id">Requisition NO</option>
                                            <option value="name">Requisition Name</option>
                                            <option value="description">Description</option>
                                            <option value="deadline">Deadline</option>
                                            <option value="assigned_to">Assigned To</option>
                                            <option value="created_by">Created By</option>
                                        </select>
                                    </fieldset>
                                  </div>

                                    <div class="card-body" style="padding:0px;">
                                    <p>Order By</p>
                                      <div class="col-md-6">
                                        <div class="input-group">
                                          <div class="d-inline-block custom-control custom-radio mr-1">
                                            <label class="container"> <span style="margin-left: 20px"> <i class="la la-sort-alpha-asc"> ASC </i></span>
                                                <input type="radio" name="sort" id="asc" value="asc"> <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="input-group">
                                          <div class="d-inline-block custom-control custom-radio">
                                            <label class="container"> <span style="margin-left: 20px"> <i class="la la-sort-alpha-desc"> DESC </i> </span>
                                                <input type="radio" name="sort" id="desc" value="desc">  <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                              <div class="form-actions right">
                                <button type="reset" id="clearBtn" class="btn btn-out-warning btn-sm pull-left"> <i class="la la-sort"></i> Clear Filter </button>

                                <button type="submit" id="filterBtn" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right"> <i class="la la-arrows-v"></i> Sort </button>
                              </div>



                                </div>
                            </form>

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
