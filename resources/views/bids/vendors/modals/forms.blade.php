   



    <form id="bidForm" action="{{route('bids.store')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal fade text-left" id="addBidModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 65% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Bid Details 
                        <span id="label_code" style="color: #fff; font-size: 15px"></span> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">X</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border"> Bid </legend>
                                        <input type="hidden" class="form-control" name="id" id="id">


                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label"> Bid Name </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" placeholder="Enter Bid Name" name="name" id="name" required>
                                        </div>

                                        <label for="industry_id" class="col-sm-2 col-form-label"> Industry </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="industry_id" id="industry_id">
                                                <option value=""></option>
                                                @forelse($industries as $industry)
                                                    <option value="{{$industry->id}}">{{$industry->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>                                             
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-2 col-form-label"> Bid Description </label>
                                        <div class="col-sm-10">
                                            <textarea rows="2" class="form-control" placeholder="Enter Bid Description" name="description" id="description" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="instruction" class="col-sm-2 col-form-label"> Bid Instruction </label>
                                        <div class="col-sm-10">
                                            <textarea rows="2" class="form-control" placeholder="Enter Bid Instruction" name="instruction" id="instruction" required></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label"> Start Date </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" placeholder="Enter Start Date" name="start_date" id="start_date" required>
                                        </div>

                                        <label for="end_date" class="col-sm-2 col-form-label"> End Date </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" placeholder="Enter End Date" name="end_date" id="end_date" required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="sector" class="col-sm-2 col-form-label"> Bid Type </label>
                                        <div class="col-sm-10 row">
                                            <div class="col-md-5">
                                                <label class="container"> <div style="margin-left: 2%;"> Open to All Vendors </div>
                                                    <input type="radio" class="type" name="bid_type" id="open_type" value="1"> 
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div> 

                                            <div class="col-md-7">
                                                <label class="container"> <div style="margin-left: 2%;"> Only Shortlisted Vendors </div>
                                                    <input type="radio" class="type" name="bid_type" id="shortlisted_type" value="2"> 
                                                    <span class="checkmark"></span>
                                                </label>
                                          </div> 
                                        </div>                                            
                                    </div>


                                    <div class="form-group row">
                                        <label for="countdown" class="col-sm-2 col-form-label"> Countdown in Days </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="countdown" id="countdown">
                                                <option></option>
                                                <option value="1">1 </option>
                                                <option value="2">2 </option>
                                                <option value="3">3 </option>
                                                <option value="4">4 </option>
                                                <option value="5">5 </option>
                                                <option value="6">6 </option>
                                                <option value="7">7 </option>
                                                <option value="8">8 </option>
                                                <option value="9">9 </option>
                                                <option value="10">10 </option>
                                            </select>
                                        </div>

                                        <label for="submission_after" class="col-sm-2 col-form-label"> Allow Submission After Deadline </label>
                                        <div class="col-sm-4 row">
                                            <div class="col-md-6">
                                                <label class="container"> <div style="margin-left: 10%;"> No </div>
                                                    <input type="radio" class="type" name="submission_after" id="no" value="1"> 
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div> 

                                            <div class="col-md-6">
                                                <label class="container"> <div style="margin-left: 10%;"> Yes </div>
                                                    <input type="radio" class="type" name="submission_after" id="yes" value="2"> 
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div> 
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 50px;">

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to add/modify bid ?')">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>





    {{--    upload--}}
    <form id="excelForm" action="{{route('upload-bid')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="uploadBidForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document" style="">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Upload using Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">X</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Upload</label>
                                    <input type="file" class="form-control" name="file" id="file" required>

                                    <a href="{{ url('download-bid-excel-template') }}" id="downVendorTemplate" download="Sample Excel Excel Template" class="btn btn-sm pull-right text-muted"
                                       style="font-size: 12px; border:thin solid #e1e1e1" title="Download Sample Excel Excel Template"> <i class="fa fa-download"></i> Download Template</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-info btn-glow btn-sm" onclick="return confirm('Are you sure you want to Add/Modify Vendor?')">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






    <form id="editSubmitionForm" action="{{route('respond-to-bid')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal fade text-left" id="editSubmitionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 65% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff"> Submitted Bid Details 
                        <span id="label_code" style="color: #fff; font-size: 15px"></span> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">X</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">  </legend>
                                        <input type="hidden" class="form-control" name="id" id="idd">
                                        <input type="hidden" class="form-control" name="bid_id" id="bd_id">


                                    {{-- <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label"> Bid Name </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Enter Bid Name" name="name" id="name">
                                        </div> 

                                        <label for="bid_code" class="col-sm-2 col-form-label"> Bid Code </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Enter Bid Name" name="bid_code" id="bid_code">
                                        </div>                                         
                                    </div> --}}

                                    <div class="form-group row">
                                        <label for="note" class="col-sm-2 col-form-label"> Note </label>
                                        <div class="col-sm-10">
                                            <textarea rows="2" class="form-control" placeholder="Enter Bid Description" name="note" id="note" required></textarea>
                                        </div>
                                    </div>   

                                    <hr>

                                    <div class="form-group row">
                                        <label for="file_name" class="col-sm-2 col-form-label"> Attachment Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="file_name" id="file_name">
                                        </div>   

                                        <label for="file" class="col-sm-2 col-form-label"> Add Attachment </label>
                                        <div class="col-sm-4">
                                            <input type="file" class="form-control" name="file[]" id="file" multiple="">
                                        </div>                                       
                                    </div>

                                    <div class="form-group row">
                                        <label for="note" class="col-sm-2 col-form-label"> Attachments </label>
                                        <div class="col-sm-10" id="attachment-div">
                                            <table class="table table-sm mb-0 d-table" id="attachment_table">
                                                <thead class="thead-dark">
                                                  <tr>
                                                    <th>#</th>                                            
                                                    <th>Bid Name</th>
                                                    <th>Attachment Name</th>
                                                    <th>Uploaded Date</th>
                                                    <th style="text-align:right">Action </th>
                                                  </tr>
                                                </thead>
                                                <tbody>   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 50px;">

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to add/modify bid ?')">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






{{-- ///////////////////////// --}}



<!-- Confirm  modal -->
    <form id="deleteDocumentForm" class="form-horizontal" method="POST" action="{{ route('delete-vendor-doc') }}" enctype="multipart/form-data">
      @csrf
        <div id="deleteModal" class="modal fade" role="dialog" style="margin-top: 10%">
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


                    <input type="hidden" class="form-control" name="document_id" id="document_id">
                    <input type="hidden" class="form-control" name="vendor_id" id="v_id" value="">

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Are you sure you have delete this document? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="doc_no_btn" id="doc_no_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal"> No </button>

                            <button type="submit" name="doc_yes_btn" id="doc_yes_btn" class="btn btn-outline-success btn-glow"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Cancel  modal -->


    <!-- Success  modal -->
    <div id="yesDocModal" class="modal fade" role="dialog" style="margin-top: 10%">
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
                    <center> <h2 class="swal3-title" style="">Document Deleted </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="button" name="ok_doc_btn" id="ok_doc_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!-- Confirm Vendor  modal -->
    <form class="form-horizontal" method="POST" action="">
      @csrf
        <div id="approveVendorModal" class="modal fade" role="dialog" style="margin-top: 10%">
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


                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style=""> You are about to approve this vendor? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_app_btn" id="no_app_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal" > No </button>

                            <button type="button" name="yes_app_btn" id="yes_app_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal" data-toggle="modal" data-target="#yesAppModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Cancel Vendor  modal -->
    <div id="noModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark white" style="border-bottom: none;">                    
                    <div class="swal-icon swal-icon--error">
                      <div class="swal-icon--error__x-mark">
                        <span class="swal-icon--error__line swal-icon--error__line--left"></span>
                        <span class="swal-icon--error__line swal-icon--error__line--right"></span>
                      </div>
                    </div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style=""> You cancelled the operation </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="cancel_btn" id="cancel_btn" class="btn btn-outline-danger btn-glow" data-dismiss="modal"> Close </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Success Vendor  modal -->
    <form class="form-horizontal" id="approveVendorForm" method="POST" action="{{ route('approve-vendor') }}"> @csrf
        <div id="yesAppModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="swal-icon swal-icon--success">
                        <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                        <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                        <div class="swal-icon--success__ring"></div>
                        <div class="swal-icon--success__hide-corners"></div>
                    </div>

                    <input type="hidden" class="form-control" name="vendor_id" id="vendorId" value="{{$vendor->id}}">

                    <div class="modal-body">
                        <center> <h2 class="swal3-title" style=""> Vendor Approved </h2> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="submit" name="ok_app_btn" id="ok_app_btn" class="btn btn-outline-success btn-glow"> Ok </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Review Document with Comments -->
    <form class="" action="{{route('update-about-company')}}" method="post">
     @csrf
        <div class="modal fade text-left" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="reviewModel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark white">
                <h4 class="modal-title text-text-bold-600" id="myModalLabel1">About Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color: red">X</span>
                </button>
              </div>
              <div class="modal-body">
                
                  <div class="card-block">

                      <div class="col-xs-12">
                        <input type="hidden" class="form-control" name="id" id="i_id" value="{{$vendor->id}}">
                          <label for="comment" class="col-form-label"> Company Info </label>
                          <textarea rows="5" class="form-control" name="company_info" id="company_info">{{$vendor->company_info}}</textarea>
                      </div>  
                  </div>
              </div>

              <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger btn-glow btn-sm mr-1">Clear</button>
                <button type="submit" class="btn btn-outline-info btn-glow btn-sm">Save</button>
              </div>
            </div>
          </div>
        </div>
    </form> 

