    <!-- Confirm  modal -->
    <form id="deleteDocumentForm" class="form-horizontal" method="POST" action="{{ route('delete-document') }}" enctype="multipart/form-data">
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

                    <input type="hidden" class="form-control" name="vendor_id" id="vendorId" value="{{request()->route()->parameters['id']}}">

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
    <form class="" action="{{route('update-company-info')}}" method="post">
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

