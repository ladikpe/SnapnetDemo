{{-- template index --}}
@extends('layouts.register-vendor')
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
    </style>
@endsection
@section('content')



    <div class="row">

        <div class="col-md-4" style="background: url({{ asset('assets/images/Reg_1.jpg') }}) no-repeat;">
            
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-content">
                    <form id="vendorForm" action="{{route('vendor.store')}}" enctype="multipart/form-data" method="POST">  @csrf
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Vendor Registration 

                                    <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" onclick="return confirm('Are you sure you want to save details?')"><i class="la la-check" aria-hidden="true"></i> Save
                                    </button>
                                </div>
                            </div>
                        </h3>

                        <div id="smartwizard">
                            <ul class="nav">
                                <li> <a class="nav-link" href="#step-1"> Vendor Profile </a> </li>
                                <li> <a class="nav-link" href="#step-2"> Company Details </a> </li>
                            </ul>

                            <div class="tab-content" style="height: auto !important;">

                                {{-- Vendor DETAILS --}}
                                <div id="step-1" class="tab-pane" role="tabpanel">
                                      <div class="card-content collapse show">
                                            <div class="form-group row">
                                        {{-- <label for="cover_page" class="col-md-12 col-form-label"> <h4> Vendor Profile </h4> </label> --}}
                                                <div class="col-md-12">
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
                                                            </div>
                                                        </div>

                                                    </fieldset>                   
                                                </div>
                                            </div>
                                      </div>
                                </div>


                                {{-- Company DETAILS --}}
                                <div id="step-2" class="tab-pane" role="tabpanel">
                                      <div class="card-content collapse show">
                                            <div class="form-group row">
                                                {{-- <label for="content" class="col-md-12 col-form-label"> <h4> Company Details </h4> </label> --}}
                                                <div class="col-md-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border"> Other Details </legend>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="website">Website</label>
                                                                    <input type="text" class="form-control" name="website" id="website" required>
                                                                </div>

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
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="address">Office Address</label>
                                                                    <input type="text" class="form-control" name="address" id="address" required>
                                                                </div>

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
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                      </div>
                                </div>

                            </div>

                        </div>
                        

                    </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div> 









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="uploadDocumentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Upload Vendor Document</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>

            <form id="uploadDocumentForm" action="{{ route('upload-document') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id" id="id" required>

              <div class="modal-body">

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Upload Documents </legend>

                    <div class="row" style="padding-left: 15px; padding-right: 15px">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="name" class="col-form-label">Document Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="form-group row">
                                <label for="type_id" class="col-form-label">Document Type</label>
                                <select class="form-control" name="type_id" id="type_id" required>
                                    <option value=""></option>
                                    @forelse($document_types as $document_type)
                                        <option value="{{$document_type->id}}">{{$document_type->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-form-label">File</label>
                                <input type="file" class="form-control" name="file" id="file" required>
                            </div>

                            <div class="form-group row">
                                <label for="expiry_date" class="col-form-label">Expiry Date</label>
                                <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                            </div>

                            {{-- <div class="form-group">
                                <button type="button" class="btn btn-outline-success btn-glow pull-right btn-sm"><i class="la la-upload" aria-hidden="true"></i> Upload
                                </button>
                            </div> --}}
                        </div>
                    </div>

                </fieldset>

                

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning btn-sm" value="Clear">
                <input type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" value="Save" onclick="return confirm('Are you sure you want to upload details?')">
              </div>
            </form>

          </div>
        </div>
    </div>














@endsection

@section('scripts')

    <script>
        function getRequirementFilings(id)
        {   
            clearForm();
            $(function()
            {            
                $.get('{{url('get-requirement-and-filings-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#due_date').val(data.due_date);
                    $('#reminder').val(data.reminder);
                });
                
            });
        }


        //ADD FORM
        $("#addForm").on('submit', function(e)
        { 
            clearForm();
            e.preventDefault();
            var id = $('#id').val();
            var name = $('#name').val();
            var description = $('#description').val();
            var due_date = $('#due_date').val();
            var reminder = $('#reminder').val();

            formData = 
            {
                id:id,
                name:name,
                description:description,
                due_date:due_date,
                reminder:reminder,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('requirements-and-filings.store')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {

                    $('#addModal').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('requirements-and-filings.index') }}"); }, 1000);
                    clearForm();
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });



        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('#id').val('');
                $('#name').val('');
                $('#description').val('');
                $('#due_date').prop('value', 0);  
                $('#reminder').val('');             
            });
        }
    </script>
    

    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>

    



    @if(Session::has('info'))
        <script>
            $(function()
            {
                toastr.success('{{session('info')}}', {timeOut:100000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function()
            {
                toastr.error('{{session('error')}}', {timeOut:100000});
            });
        </script>
    @endif

@endsection
