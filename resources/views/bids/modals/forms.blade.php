   



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
                                                    <input type="radio" class="type" name="submission_after" id="no" value="0"> 
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div> 

                                            <div class="col-md-6">
                                                <label class="container"> <div style="margin-left: 10%;"> Yes </div>
                                                    <input type="radio" class="type" name="submission_after" id="yes" value="1"> 
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


