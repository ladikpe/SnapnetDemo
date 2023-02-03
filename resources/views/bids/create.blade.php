@extends('layouts.app')

@section('content')



    
<div class="row">     
                
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4>Create New Bid </h4>
                

            <form id="bidForm" action="{{route('bids.store')}}" enctype="multipart/form-data" method="POST">  @csrf
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Bid </legend>


                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label"> Bid Name </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Enter Bid Name" name="name" id="name" required>
                        </div>                                            
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label"> Bid Description </label>
                        <div class="col-sm-10">
                            <textarea rows="2" class="form-control" placeholder="Enter Bid Description" name="description" id="description" required>
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
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Bid Type" name="sector" id="sector">
                        </div>

                        <label for="sector" class="col-sm-2 col-form-label"> Industry </label>
                        <div class="col-sm-4">
                            <select>
                                <option value=""></option>
                                @forelse($industries as $industry)
                                    <option value="{{$industry->id}}">{{$industry->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4">
                            <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to add/modify bid ?')">Save changes</button>
                        </div>
                    </div>

                </fieldset>


          </div>
        </div>
      </div>
    </div>

</div>













    {{--    upload--}}
    <form id="excelForm" action="{{route('upload-vendor')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="uploadBidForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document" style="">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Upload using Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Upload</label>
                                    <input type="file" class="form-control" name="file" id="file" required>

                                    <a id="downVendorTemplate" download="Sample Excel Excel Template" class="btn btn-sm pull-right text-muted"
                                       style="font-size: 12px; border:thin solid #e1e1e1" title="Download Sample Excel Excel Template"> <i class="fa fa-download"></i> Download Template</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn grey btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to Add/Modify Vendor?')">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






   
   

   
   
@endsection

@section('scripts')


    @if(Session::has('success'))
        <script>
            $(function() 
            {
                toastr.success('{{session('success')}}', {timeOut:50000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function() 
            {
                toastr.error('{{session('error')}}', {timeOut:50000});
            });
        </script>
    @endif   
@endsection
