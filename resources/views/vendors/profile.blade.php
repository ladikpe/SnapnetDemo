{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style>
        .sortColumn
        {
            cursor: pointer;
        }

        .la la-arrows-v
        {
            font-size: 13px!important;
        }

        html body .la
        {
            font-size: 13px!important;  /* font-size: 1.4rem; */
        }

        .container
        {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container input
        {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark
        {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            border: thin solid #ccc;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark
        {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked ~ .checkmark
        {
            background-color: #0a6aa1;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after
        {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked ~ .checkmark:after
        {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after
        {
            top: 8px;
            left: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: white;
        }

        #docu_table_info
        {
            float: left;
        }

    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <h3 class="card-title" id="basic-layout-form">
                    <div class="row" style="margin-top: -10px">
                        <div class="col-md-12" style=""> Create Document</div>
                    </div>
                </h3> --}}


                <div class="card" style="">
                    <div class="card-content">
                      <div class="card-body">
                        <ul class="nav nav-tabs nav-linetriangle nav-justified mb-1">
                          <li class="nav-item">
                            <a class="nav-link active" id="profile" data-toggle="tab" href="#profile-tab" aria-controls="profile-tab" aria-expanded="true"><i class="la la-user"></i> Profile</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="document" data-toggle="tab" href="#document-tab" aria-controls="document-tab" aria-expanded="false"><i class="la la-tags"></i> Documents</a>
                          </li>
                          
                          <li class="nav-item">
                            <a class="nav-link" id="bid" data-toggle="tab" href="#bid-tab" aria-controls="bid-tab"><i class="la la-bullseye"></i> Bids</a>
                          </li>
                        </ul>


                        <div class="tab-content px-1 pt-1">
                          <div role="tabpanel" class="tab-pane active" id="profile-tab" aria-labelledby="profile-tab" aria-expanded="true">
                            <div id="user-profile">
                              <div class="row">

                                <div class="col-5">
                                  <div class="card profile-with-cover">
                                    <div class="card-img-top img-fluid bg-cover height-200" style="background: url({{ asset('assets/images/profile-pic2.jpg') }}) 50%;"></div>
                                    <div class="media profil-cover-details w-100" style="margin-top: 110px">
                                      <div class="media-left pl-2 pt-2" style="">
                                        <a href="#" class="profile-image">
                                          <img src="{{ asset('assets/images/user1.png') }}" class="rounded-circle img-border height-100"
                                          alt="Card image">
                                        </a>
                                      </div>
                                      <div class="media-body pt-3 px-2">
                                        <div class="row">
                                          <div class="col">
                                            <h2 class="card-title" style="color: #202020;"> {{$vendor->name}} </h2>
                                          </div>
                                          <div class="col text-right">
                                            
                                            <div class="btn-group d-none d-md-block float-right ml-2" role="group" aria-label="Basic example">
                                              @if($vendor->status == 0)
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveVendorModal"  ><i class="la la-dashcube"></i> Approve Vendor</button>
                                              @elseif($vendor->status == 1)
                                                <button type="button" class="btn btn-success" disabled=""><i class="la la-dashcube"></i> Vendor Has Been Approved</button>
                                              @endif
                                              {{-- <button type="button" class="btn btn-success"><i class="la la-cog"></i></button> --}}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    
                                    <div class="card" style="">
                                        <div class="card-content">
                                          <div class="card-body">
                                            <ul class="nav nav-tabs nav-iconfall about">
                                              <li class="nav-item" style="text-align: left">
                                                <a class="nav-link active" id="baseIcon-tab41" data-toggle="tab" aria-controls="tabIcon41" href="#tabIcon41" aria-expanded="true"><i class="la la-user"></i> About</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link disabled" id="baseIcon-tab42" data-toggle="tab" aria-controls="tabIcon42" href="#tabIcon42" aria-expanded="false"><i class="la la-flag"></i> </a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link disabled" id="baseIcon-tab43" data-toggle="tab" aria-controls="tabIcon43" href="#tabIcon43" aria-expanded="false"><i class="la la-cog"></i> </a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link pull-right">
                                                    <button type="button" class="btn btn-outline-success btn-glow btn-sm" data-toggle="modal" data-target="#aboutModal" style="cursor: pointer;">Add Company Profile</button>
                                                </a>
                                              </li>
                                            </ul>
                                            <div class="tab-content px-1 pt-1">
                                              <div role="tabpanel" class="tab-pane active" id="tabIcon41" aria-expanded="true" aria-labelledby="baseIcon-tab41" id="about-div" style="max-height: 200px; overflow: auto;">
                                               {!! $vendor->company_info !!}
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>



                                  </div>
                                </div>



                                <div class="col-7">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"> Vendor Profiles </legend>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Company Name</label>
                                                    <input type="hidden" class="form-control" name="id" id="id">
                                                    <input type="text" class="form-control" name="name" id="name" disabled value="{{$vendor->name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" disabled value="{{$vendor->phone}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="contact_name">Contact Person</label>
                                                    <input type="text" class="form-control" name="contact_name" id="contact_name" disabled value="{{$vendor->contact_name}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="address">Address I</label>
                                                    <input type="text" class="form-control" name="address" id="address" disabled value="{{$vendor->address}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" disabled value="{{$vendor->email}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <input type="text" class="form-control" name="category" id="category" disabled value="{{$vendor->category}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="address_2">Address II</label>
                                                    <input type="text" class="form-control" name="address_2" id="address_2" disabled value="{{$vendor->address_2}}">
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>


                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"> Other Details </legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" name="website" id="website" disabled value="{{$vendor->website}}">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state_id">State</label>
                                                    <input type="text" class="form-control" name="state_id" id="state_id" disabled value="{{$vendor->state?$vendor->state->state_name:''}}">
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name" disabled value="{{$vendor->bank_name}}">
                                                </div> --}}
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country_id">Country</label>
                                                    <input type="text" class="form-control" name="country_id" id="country_id" disabled value="{{$vendor->country?$vendor->country->country_name:''}}">
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label for="account_number">Account Number</label>
                                                    <input type="text" class="form-control" name="account_number" id="account_number" {{$vendor->account_number}} disabled>
                                                </div> --}}
                                            </div>
                                        </div>

                                    </fieldset> 
                                </div>
                              </div>
                            </div>
                          </div>





                          <div class="tab-pane no-pad" id="document-tab" role="tabpanel" aria-labelledby="document-tab-tab1" aria-expanded="false">

                            <div class="row no-pad">
                            
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <h3 class="card-title" id="basic-layout-form">
                                                    <div class="row" style="margin-top: -10px">
                                                        <div class="col-md-12" style=""> {{$vendor->name }}  - Documents 

                                                            <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" data-toggle="modal" data-target="#uploadDocumentModel"><i class="la la-upload" aria-hidden="true"></i> 
                                                            </button>
                                                        </div>
                                                    </div>
                                                </h3>

                                                <div class="col-md-12 no-pad">

                                                    <div class="row" id="document-div">                                                            

                                                          <table class="table table-sm mb-0 d-table" id="docu_table">
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
                                                                        <td>{{ $vendor_document->name }}</td>
                                                                        <td>{{ $vendor_document->type?$vendor_document->type->name:'' }}</td>
                                                                        <td>{{date("M j, Y", strtotime($vendor_document->expiry_date))}}</td>
                                                                        <td>
                                                                          {{-- <a onclick="pullDocumentId({{$vendor_document->id}}, {{$vendor_document->vendor_id}})" class="btn-sm text-danger pull-right" data-toggle="modal" data-target="#deleteModal" title="Delete Document" id="{{$vendor_document->id}}"><i class="la la-close" aria-hidden="true" style="font-size:13px"></i></a> --}}

                                                                          <a class="btn-sm text-info pull-right" data-toggle="tooltip" title="Download Document" id="{{$vendor_document->id}}" href="{{URL::asset($vendor_document->document_path.'/'.$vendor_document->file_name)}}" download="{{URL::asset($vendor_document->document_path.'/'.$vendor_document->file_name)}}"><i class="la la-download" aria-hidden="true" style="font-size:13px"></i></a>

                                                                          {{-- <a onclick="pullDocumentDetails({{$vendor_document->id}})" class="btn-sm text-success pull-right" data-toggle="tooltip" title="View Document" id="{{$vendor_document->id}}"><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a> --}}
                                                                        </td>
                                                                    </tr> @php $i++; @endphp
                                                                @empty
                                                                @endforelse
                                                            </tbody>
                                                          </table>
                                                          {{-- {!! $vendor_documents->render() !!} --}}
                                                    </div>
                                                  
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-md-3 pad-left pad-right">
                                    <fieldset class="scheduler-border" style="padding: 0 3.4em 1.4em 3.4em !important;">
                                        <legend class="scheduler-border"> Documents </legend>

                                        <img alt="Placeholder" src="{{ asset('assets/images/placeholder.jpg') }}" style="max-width: 200px">

                                    </fieldset>
                                </div>
                            </div>


                          </div>






                          <div class="tab-pane" id="bid-tab" role="tabpanel" aria-labelledby="bid-tab" aria-expanded="false">

                            <div class="row no-pad">
                            
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <h3 class="card-title" id="basic-layout-form">
                                                    <div class="row" style="margin-top: -10px">
                                                        <div class="col-md-12" style=""> Bids Submitted by {{$vendor->name }}

                                                           {{--  <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" data-toggle="modal" data-target="#uploadDocumentModel"><i class="la la-upload" aria-hidden="true"></i> 
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </h3>

                                                <div class="col-md-12 no-pad">

                                                    <div class="row" id="sub-bid-div">                                                          

                                                      <table class="table table-sm mb-0 d-table" id="submitted_table">
                                                        <thead class="thead-dark">
                                                          <tr>
                                                            <th>#</th>                                            
                                                            <th>Bid Name</th>
                                                            <th>Note</th>
                                                            <th>Submitted Date</th>
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

                                                                      <a class="btn-sm text-info pull-right" data-toggle="tooltip" title="Show Bid Document" id="_{{$submitted_bid->id}}" onclick="displayBidDocuments({{$submitted_bid->id}})"><i class="la la-eye" aria-hidden="true" style="font-size:13px"></i></a>
                                                                    </td>
                                                                </tr> @php $i++; @endphp
                                                            @empty
                                                            @endforelse
                                                        </tbody>
                                                      </table>
                                                      {{-- {!! $submitted_bids->render() !!} --}}
                                                </div>
                                                  
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-md-4 pad-left pad-right">
                                    <fieldset class="scheduler-border" style="padding: 0 3.4em 1.4em 3.4em !important; background: #F4F5FA">
                                        <legend class="scheduler-border"> Bid Attachments </legend>
                                        
                                        <div class="row" id="sub_bid_div">
                                            
                                        </div>

                                    </fieldset>
                                </div>
                            </div>



                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                        
            </div>
        </div>
    </div>








<!-- INCLUDING modals-->
@include('vendors.modals.forms')








    











@endsection

@section('scripts')






<!-- INCLUDING scripts-->
@include('vendors.js.script')

    

@endsection
