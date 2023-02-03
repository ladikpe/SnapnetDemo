@extends('layouts.app')

@section('content')



    
<div class="row">     
                
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4>List Vendors
                <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right addNew" data-toggle="modal" data-target="#new_vendor"
                   title="Create New Vendor" style="margin-top: -10px"><i class="la la-plus"></i></a>

                <a href="#" class="btn btn-outline-success btn-glow btn-sm pull-right uploadExcel mr-1" data-toggle="modal" data-target="#up_vendor"
                   title="Upload Vendor using excel" style="margin-top: -10px"><i class="la la-upload"></i></a>

                <a href="{{ url('download-vendor-excel') }}" class="btn btn-outline-danger btn-glow btn-sm pull-right downloadExcel mr-1" data-toggle="modal"
                   title="Download Vendor using excel" style="margin-top: -10px"><i class="la la-download"></i></a>

                <div class="row pull-right mr-1" style="margin-top: -8px">
                    <form id="searchForm" action="{{route('vendor.index')}}" method="get">
                    <fieldset>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" placeholder="Search ... " aria-describedby="button-addon2" id="search" name="search" style="height: 30px">
                            <div class="input-group-append"> <button class="btn btn-outline-primary btn-glow btn-sm" type="submit" style="height: 30px"><i class="la la-search"></i> </button> </div>
                        </div>
                    </fieldset>
                    </form>
                </div>

                <div class="row pull-right mr-2" style="margin-top: -8px">
                    <form id="searchForm" action="{{route('vendor.index')}}" method="get">  @csrf
                        <fieldset>
                            <div class="input-group">
                                <select class="form-control tokenizationSelect2" name="column" id="column" style="height: 30px">
                                    <option value="">Select</option>
                                    <option value="name">Vendor Company Name</option>
                                    <option value="contact_name">Contact Person</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="category">Category</option>
                                    <option value="address">Address</option>
                                    <option value="state_id">State</option>
                                    <option value="country_id">Country</option>
                                    <option value="status">Approval Status</option>
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
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Category</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th style="text-align:right">Action </th>
                  </tr>
                </thead>
                <tbody>        
                    @forelse ($vendors as $vendor)                
                        <tr>
                            <td>{{ $vendor->vendor_code }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->contact_name }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone }}</td> 
                            <td>{{ $vendor->category }}</td>
                            <td>
                                @if($vendor->address){{ $vendor->address }}, {{ $vendor->state?$vendor->state->state_name:'' }}.
                                {{ $vendor->country?$vendor->country->country_name:'' }}@endif
                            </td>
                            <td>
                                @if($vendor->status == 0) 
                                  <img src="{{URL::asset('assets/images/yellow.png')}}" alt="" height="12" class=""> 
                                @else <img src="{{URL::asset('assets/images/green.png')}}" alt="" height="12" class=""> @endif 
                            </td>
                            <td>
                                @if($vendor->status == 0)
                                    <a onclick="resolveVendorId({{$vendor->id}})" class="btn-sm text-primary pull-right" data-toggle="modal" data-target="#approveVendorModal" title="Approve Vendor" id="app_{{$vendor->id}}">
                                        <i class="la la-check" aria-hidden="true" style="font-size:13px"></i> </a>
                                @elseif($vendor->status == 1)
                                    <a class="btn-sm text-info pull-right" data-toggle="modal" data-target="#VendorApproveModal" title="Vendor Has Been Approved" id="vapp_{{$vendor->id}}">
                                        <i class="la la-check" aria-hidden="true" style="font-size:13px; color: #eee"></i> </a>
                                @endif

                              <a href="{{ route('vendor-profile', $vendor->id) }}" class="btn-sm text-info pull-right" data-toggle="tooltip" title="View Vendor Profile" id="pro_{{$vendor->id}}"><i class="la la-user-secret" aria-hidden="true" style="font-size:13px"></i></a>

                              <a onclick="pullVendorId({{$vendor->id}})" class="btn-sm text-info pull-right edit" data-toggle="modal" title="Edit Vendor" data-target="#new_vendor" id="edit_{{$vendor->id}}" ><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>
                            </td>
                        </tr>
                    @empty
                        No Record Has Been Created ! 
                    @endforelse
                </tbody>
              </table>
              {!! $vendors->render() !!}

          </div>
        </div>
      </div>
    </div>

</div>






    <form id="vendorForm" action="{{route('vendor.store')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal fade text-left" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Vendor Details 
                        <span id="label_code" style="color: #fff; font-size: 15px"></span> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"> Vendor Profiles </legend>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Company Name</label>
                                                    <input type="hidden" class="form-control" name="id" id="id">
                                                    <input type="text" class="form-control" name="name" id="name" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="contact_name">Contact Person</label>
                                                    <input type="text" class="form-control" name="contact_name" id="contact_name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address">Office Address</label>
                                                    <input type="text" class="form-control" name="address" id="address" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="form-control" name="category" id="category">
                                                        <option value=""></option>
                                                        <option value="Goods">Goods</option>
                                                        <option value="Services">Services</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address_2">Address 2</label>
                                                    <input type="text" class="form-control" name="address_2" id="address_2">
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>




                                <div class="col-md-6">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"> Other Details </legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" name="website" id="website" required>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state_id">State</label>
                                                    <select class="form-control" name="state_id" id="state_id" required>
                                                        <option value=""></option>
                                                        @forelse($states as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="vat_number">VAT Registration No</label>
                                                    <input type="text" class="form-control" name="vat_number" id="vat_number">
                                                </div>
                                            </div>


                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="country_id">Country</label>
                                                    <select class="form-control" name="country_id" id="country_id" required>
                                                        <option value=""></option>
                                                        @forelse($countries as $country)
                                                            <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="account_number">Account Number</label>
                                                    <input type="text" class="form-control" name="account_number" id="account_number">
                                                </div>

                                                <div class="form-group">
                                                    <label for="fax_number">FAX Number</label>
                                                    <input type="text" class="form-control" name="fax_number" id="fax_number">
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
                        <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to Add/Modify Vendor?')">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    {{--    upload--}}
    <form id="excelForm" action="{{route('upload-vendor')}}" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="up_vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document" style="">
                <div class="modal-content">
                    <div class="modal-header bg-info">
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

                                    <a href="{{ url('download-vendor-excel-template') }}" id="downVendorTemplate" download="Sample Excel Excel Template" class="btn btn-sm pull-right text-muted"
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




    <!-- DISABLE -->
    <form class="" action="{{url('performance')}}" method="post">
        @csrf
        <div id="disable" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header app_bg">
                  <h4 class="modal-title">Disable This Metric</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>              
                </div>
                             
                      <input type="text" class="form-control" name="id" id="idd"> 
                <input type="hidden" class="form-control" name="type" id="" value="disable_metric">
                


             
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-glow btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" name="" id="" class="btn btn-outline-danger btn-glow btn-sm" onclick="return confirm('Are you sure you want to DISABLE Details?')"> 
                <i class="fa fa-ban"></i> Disable </button>
              </div>
          </div>
          </div>  
      </div>
    </form>

    <!-- ENABLE -->
    <form class="" action="{{url('performance')}}" method="post">
      {{ csrf_field() }}
      <div id="enable" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header app_bg">
                  <h4 class="modal-title">Reactivate This Metric</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                             
                      <input type="text" class="form-control" name="id" id="re_id"> 
                <input type="hidden" class="form-control" name="type" id="" value="enable_metric">
                


             
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-glow btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" name="" id="" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to Reactivate Metric?')"> 
                <i class="fa fa-ban"></i> Reactivate </button>
              </div>
          </div>
          </div>  
      </div>
    </form>







    <!-- Confirm  modal -->
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
                            <button type="button" name="no_btn" id="no_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal" > No </button>

                            <button type="button" name="yes_btn" id="yes_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal" data-toggle="modal" data-target="#yesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Cancel  modal -->
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


    <!-- Success  modal -->
    <form class="form-horizontal" method="POST" action="{{ route('approve-vendor') }}"> @csrf
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

                    <input type="hidden" class="form-control" name="vendor_id" id="vendorId">

                    <div class="modal-body">
                        <center> <h2 class="swal3-title" style=""> Vendor Approved </h2> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="submit" name="ok_btn" id="ok_btn" class="btn btn-outline-success btn-glow"> Ok </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

   
   

   
   
@endsection

@section('scripts')

    <script> 
        function pullVendorId(id)
        {  
            $.get('{{url('getVendorDetails')}}?id=' +id, function(data)
            { 
                $('#id').val(id); 
                $('#label_code').html(' : ' + data.vendor_code);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#contact_name').val(data.contact_name);
                $("#category").prop('value', data.category);
                $('#website').val(data.website);
                $('#address').val(data.address);
                $('#address_2').val(data.address_2);
                $("#state_id").prop('value', data.state_id);
                $("#country_id").prop('value', data.country_id);
                $('#vat_number').val(data.vat_number);
                $('#fax_number').val(data.fax_number);
                $('#bank_name').val(data.bank_name);
                $('#account_number').val(data.account_number);
                $('#title').html('Edit Vendor');
                $('#create').html('Update');  
            });    
        }

        $('.addNew').click(function(e)
        {
            $('#id').val(''); 
            $('#label_code').html(' ');
            $('#name').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#contact_name').val('');
            $("#category").prop('value', '');
            $('#website').val('');
            $('#address').val('');
            $('#address_2').val('');
            $("#state_id").prop('value', '');
            $("#country_id").prop('value', '');
            $('#vat_number').val('');
            $('#fax_number').val('');
            $('#bank_name').val('');
            $('#account_number').val('');
            $('#title').html('Add Vendor');
            $('#create').html('Add');  
        });
    
    </script>

    <script> 
        function resolveVendorId(id)
        {
          $('#vendorId').val(id); 
        }
        
    </script>


    <script>      

        function setId(id)
        {
          $('#re_id').val(id); 
        }


        $(function()
        {
            $('#yes_btn').click(function{     $('#approveVendorModal').modal('hide');     });

            $('#no_btn').click(function{     });
        });

    </script>

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
