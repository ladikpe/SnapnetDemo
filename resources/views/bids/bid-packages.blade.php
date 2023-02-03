@extends('layouts.app')

@section('content')


    

    
<div class="row">  
<div class="col-md-12"> 

    <ul class="nav nav-tabs nav-linetriangle nav-justified mb-1">
      <li class="nav-item">
        <a class="nav-link active" id="profile" data-toggle="tab" href="#email_list" aria-controls="email_list" aria-expanded="true"><i class="la la-envelope"></i> Email Distribution List for Bid</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="document" data-toggle="tab" href="#documents" aria-controls="documents" aria-expanded="false"><i class="la la-tags"></i> Documents</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="email" data-toggle="tab" href="#submitted" aria-controls="submitted" aria-expanded="false"><i class="la la-bullseye"></i> Submitted Bids</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="email" data-toggle="tab" href="#emails" aria-controls="emails" aria-expanded="false"><i class="la la-comment"></i> Email Setup</a>
      </li>
    </ul>  


    <div class="tab-content px-1 pt-1 no-pad">
        <div role="tabpanel" class="tab-pane active" id="email_list" aria-labelledby="email_list" aria-expanded="true">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Email Lists </legend>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                            

                            <div id="email-div">
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
                                <tbody>    @php $i = 1;   @endphp     
                                    @forelse ($bid_email_lists as $bid_email_list) 
                                      @if($bid_email_list->bid_id == $id)               
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
                                        </tr>    @php $i++; @endphp 
                                      @endif 
                                    @empty
                                        No Record Has Been Created ! 
                                    @endforelse
                                </tbody>
                              </table>
                              {!! $bid_email_lists->render() !!}
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>




                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                            <h4> Add Email List </h4>

                                <form id="bidEmailListForm" class="form form-horizontal" action="{{route('add-bid-email-list')}}" method="post"> 
                                @csrf
                                        
                                    <input type="hidden" class="form-control" name="id" id="b_id" >
                                    <input type="hidden" class="form-control" name="bid_id" id="bid_id" value="{{request()->route()->parameters['id']}}">
                                    <div class="form-group row">
                                        <label for="user_id" class="col-sm-12 col-form-label"> User </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="user_id" id="user_id" required>
                                                <option value=""></option>
                                                @forelse($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>                                             
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Clear</button>
                                            <button type="submit" class="btn btn-outline-success btn-glow btn-sm pull-right" onclick="return confirm('Are you sure you want to add/modify detail ?')">Add User</button>
                                        </div>                                             
                                    </div>
                                </form>

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div role="tabpanel" class="tab-pane" id="documents" aria-labelledby="documents" aria-expanded="true">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">  Bid Attachments </legend>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                            

                            <div id="attach-div">
                              <table class="table table-sm mb-0" id="attach_table">
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
                                    @endforelse
                                </tbody>
                              </table>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>




                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                                <fieldset class="scheduler-border" style="padding: 0 3.4em 1.4em 3.4em !important;">
                                    <legend class="scheduler-border"> Add Bid Attachment </legend>

                                        <form id="uploadBidDocumentForm" action="{{ route('upload-bid-attachment') }}" enctype="multipart/form-data" method="POST"> @csrf
                                            <input type="hidden" class="form-control" name="id" id="doc_id" value="">
                                            <input type="hidden" class="form-control" name="bid_id" id="att_bid_id" value="{{request()->route()->parameters['id']}}">

                                            <div class="form-group row">
                                                <label for="doc_name" class="col-form-label">Document Name</label>
                                                <input type="text" class="form-control" name="name" id="doc_name" required>
                                            </div>

                                            <div class="form-group row">
                                                <label for="file" class="col-form-label">File</label>
                                                <input type="file" class="form-control" name="file" id="file" required>
                                            </div>

                                            <div class="form-group row" style="text-align: right">
                                                <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm"><i class="la la-upload" aria-hidden="true"></i> Upload
                                                </button>
                                            </div>
                                        </form>
                                </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </fieldset>
            
        </div>


        <div role="tabpanel" class="tab-pane" id="submitted" aria-labelledby="submitted" aria-expanded="true">
            <form id="bidPackageForm" action="#" method="POST">  @csrf
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">  Submitted Bids </legend>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-content">
                              <div class="card-body">                            

                                 <table class="table table-sm mb-0" id="sub_bid_table">
                                    <thead class="thead-dark">
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
                                      @forelse ($submitted_bids as $bid)                
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
                                                <a onclick="pullBidId({{$bid->id}})" class="btn-sm text-success pull-right edit" data-toggle="tooltip" title="View Bid Response" id="view_{{$bid->id}}" ><i class="la la-send" aria-hidden="true" style="font-size:13px"></i></a>
                                              </td>
                                          </tr>
                                      @empty
                                          No Record Has Been Created ! 
                                      @endforelse
                                  </tbody>
                            </table>    

                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </fieldset>
            </form>
        </div>


        <div role="tabpanel" class="tab-pane" id="emails" aria-labelledby="emails" aria-expanded="true">
          <form id="bidPackageForm" action="{{route('bid-message')}}" method="POST">  @csrf
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">  Setup Bid Message </legend>
                      <div class="row">
                        <div class="col-md-7">
                          <div class="card">
                            <div class="card-content">
                              <div class="card-body">                            

                                    <div class="form-group row">
                                        <label for="message" class="col-sm-12 col-form-label"> Message </label>
                                        <input type="hidden" class="form-control" name="id" id="eb_id">
                                        <input type="hidden" class="form-control" name="bid_id" id="email_bid_id" value="{{request()->route()->parameters['id']}}">
                                        <div class="col-sm-12">
                                            <textarea rows="3" class="form-control" name="message" id="message" required></textarea>
                                        </div>                                             
                                    </div>

                                    <div class="form-group row" style="padding-left: 15px">
                                        <button type="reset" class="btn btn-outline-danger btn-glow btn-sm mr-1" data-toggle="tooltip" title="Clear Message"> Clear</button>

                                        <button type="submit" class="btn btn-outline-success btn-glow btn-sm mr-1" data-toggle="tooltip" title="Add Message" onclick="return confirm('Are you sure you want to message?')"> Save</button>
                                    </div>  

                              </div>
                            </div>
                          </div>
                        </div>




                        <div class="col-md-5">
                          <div class="card">
                            <div class="card-content">
                              <div class="card-body">
                                <h4> Your Messages</h4>

                                    

                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>


        {{-- <div role="tabpanel" class="tab-pane" id="emails" aria-labelledby="emails" aria-expanded="true">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">  Bid Attachments </legend>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                            

                            <div id="attach-div">
                              <table class="table table-sm mb-0" id="attach_table">
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
                                    @endforelse
                                </tbody>
                              </table>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>




                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-content">
                          <div class="card-body">
                                <fieldset class="scheduler-border" style="padding: 0 3.4em 1.4em 3.4em !important;">
                                    <legend class="scheduler-border"> Add Bid Attachment </legend>

                                        <form id="uploadBidDocumentForm" action="{{ route('upload-bid-attachment') }}" enctype="multipart/form-data" method="POST"> @csrf
                                            <input type="hidden" class="form-control" name="id" id="doc_id" value="">
                                            <input type="hidden" class="form-control" name="bid_id" id="att_bid_id" value="{{request()->route()->parameters['id']}}">

                                            <div class="form-group row">
                                                <label for="doc_name" class="col-form-label">Document Name</label>
                                                <input type="text" class="form-control" name="name" id="doc_name" required>
                                            </div>

                                            <div class="form-group row">
                                                <label for="file" class="col-form-label">File</label>
                                                <input type="file" class="form-control" name="file" id="file" required>
                                            </div>

                                            <div class="form-group row" style="text-align: right">
                                                <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm"><i class="la la-upload" aria-hidden="true"></i> Upload
                                                </button>
                                            </div>
                                        </form>
                                </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </fieldset>
            
        </div> --}}
    </div>




                
    
</div>
</div>









    <!-- Confirm  modal -->
    <form class="form-horizontal" id="deleteForm" method="POST" action="{{ route('delete-email-list') }}">
      @csrf
        <div id="deleteEmailModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>


                    <input type="hidden" name="id" id="delete_id">
                    <input type="hidden" name="bid_id" id="bids_id" value="{{request()->route()->parameters['id']}}">

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Do you want to delete details ? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_btn" id="no_btn" class="btn btn-outline-warning btn-glow mr-1"> No </button>

                            <button type="submit" name="yes_btn" id="yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#yesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Success  modal -->
    <div id="yesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Details Removed </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Delete Confirm  modal -->
    <form class="form-horizontal" id="deleteDocForm" method="POST" action="{{ route('delete-bid-document') }}">
      @csrf
        <div id="deleteDocModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>


                    <input type="hidden" name="id" id="del_id">
                    <input type="hidden" name="bid_id" id="del_bid_id" value="{{request()->route()->parameters['id']}}">

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Do you want to delete attachment ? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="del_no_btn" id="del_no_btn" class="btn btn-outline-warning btn-glow mr-1"> No </button>

                            <button type="submit" name="del_yes_btn" id="del_yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#delYesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Success  modal -->
    <div id="delYesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Attachment Removed </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="del_ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    





   
   

   
   
@endsection

@section('scripts')

<!-- INCLUDING Script-->
@include('bids.vendors.js.bid-package-script')

  
@endsection
