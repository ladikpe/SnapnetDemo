@extends('layouts.app')

@section('content')



    
<div class="row">     
                
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4>List Travel Vendors
                <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right addNew" data-toggle="modal" data-target="#new_vendor"
                   title="Create New Vendor" style="margin-top: -10px"><i class="la la-plus"></i></a>

                <a href="#" class="btn btn-outline-success btn-glow btn-sm pull-right uploadExcel mr-1" data-toggle="modal" data-target="#up_vendor"
                   title="Upload Vendor using excel" style="margin-top: -10px"><i class="la la-upload"></i></a>

                <a href="{{ url('download-vendor-excel') }}" class="btn btn-outline-danger btn-glow btn-sm pull-right downloadExcel mr-1" data-toggle="modal"
                   title="Download Vendor using excel" style="margin-top: -10px"><i class="la la-download"></i></a>
            </h4>

              <table class="table table-sm mb-0" id="">
                <thead class="thead-dark">
                  <tr>
                    <th>Region</th>
                    <th>Name</th>
                    <th>Service Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th style="text-align:right">Action </th>
                  </tr>
                </thead>
                <tbody>        
                    @forelse ($vendors as $vendor)                
                        <tr>
                            <td>{{ $vendor->region }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->service }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone }}</td> 
                            <td>{{ $vendor->address }}</td>
                            <td>
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








    {{--    upload--}}
    <form id="excelForms" action="{{route('upload-vendor-store')}}" enctype="multipart/form-data" method="POST">  @csrf
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
