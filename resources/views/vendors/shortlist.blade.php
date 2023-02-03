@php
    use \App\Http\Controllers\VendorController;    $controllerName = new VendorController;
@endphp

@extends('layouts.app')

@section('stylesheets')

    <style>
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
            background-color: #007FFF;
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

        <div class="col-md-3">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <h4> Filter Vendors </h4>

                        <div class="row" style="padding: 15px">
                            <form id="searchForm" action="{{route('vendor-shortlist',[$document_id])}}" method="get" style="width: 100%">
                            <p>Search </p>
                            <fieldset>
                                <div class="input-group" style="">
                                    <input type="text" class="form-control" placeholder="Search ... " aria-describedby="button-addon2" id="search" name="search">
                                    <div class="input-group-append"> <button class="btn btn-secondary" type="submit"><i class="la la-search"></i> </button> </div>
                                </div>
                            </fieldset>
                            </form>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Filtered Search</label>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <form id="searchForm" action="{{route('vendor-shortlist',[$document_id])}}" method="get" style="width: 100%">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="category">Filter by Category</label>
                                        <select class="form-control tokenizationSelect2" name="category" id="category">
                                            <option value="">Select</option>
                                            <option value="Goods">Goods</option>
                                            <option value="Services">Services</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="state_id">Filter by State</label>
                                        <select class="form-control tokenizationSelect2" name="state_id" id="state_id">
                                            <option value="">Select</option>
                                            @forelse($states as $state)
                                                <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" id="serachBtn" class="btn btn-dark btn-sm pull-right"> Search </button>
                                        <button type="reset" id="" class="btn btn-warning btn-sm pull-right mr-1"> Clear </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <h4>List Vendors
{{--                            <input type="checkbox" class="form-control pull-right" id="input-11">--}}
                            <a href="#" id="type-success" class="btn btn-float btn-outline-success btn-round btn-sm pull-right btn-float uploadExcel ml-0"
                               title="Submit" style="margin-top: -4px"><i class="la la-check"></i></a>

                            <div class="form-group pull-right">
                                <label class="container"> <span style="margin-left: 15px"> All </span>
                                    <input type="checkbox" name="check_all" id="check_all" value="asc"> <span class="checkmark"></span>
                                </label>
                            </div>

                        </h4>

                        <table class="table table-sm mb-0" id="">
                            <thead class="thead-dark">
                            <tr>
                                <th>Vendor Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th style="text-align:right">Action </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($vendors as $vendor)
                                <tr>
                                    <td style="padding: 3px">{{ $vendor->name }}</td>
                                    <td style="padding: 3px">{{ $vendor->contact_name }}</td>
                                    <td style="padding: 3px">{{ $vendor->email }}</td>
                                    <td style="padding: 3px">{{ $vendor->phone }}</td>
                                    <td style="padding: 3px">{{ $vendor->category }}</td>
                                    <td style="padding: 3px">
                                        @if($vendor->address){{ $vendor->address }}, {{ $vendor->state?$vendor->state->state_name:'' }}.
                                        {{ $vendor->country?$vendor->country->country_name:'' }}@endif
                                    </td>
                                    <td style="padding: 3px; text-align: right">
                                        <input type="checkbox" class="form-control form-control-sm skin.skin-flat vendChk" id="{{$vendor->id}}"
                                               @if($controllerName->getVendorShortlists($vendor->id, $document_id) == true) checked @endif>
                                        <input type="hidden" class="" name="type" id="type_{{$vendor->id}}">
                                    </td>
                                </tr>
                            @empty
                                No Data Found
                            @endforelse
                            </tbody>
                        </table>
                        {!! $vendors->appends(Request::capture()->except('page'))->render() !!}

                    </div>
                </div>
            </div>
        </div>

    </div>






    <form id="vendorForm" action="{{route('vendor.store')}}" enctype="multipart/form-data" method="POST">  @csrf
    <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Vendor Details</h4>
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




                            <div class="col-md-6">
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

                        <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 50px;">

                        </div>




                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn grey btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Are you sure you want to Add/Modify Vendor?')">Save changes</button>
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




    <!-- DISABLE -->
    <form class="" action="{{url('performance')}}" method="post">
        {{ csrf_field() }}
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
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" name="" id="" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to DISABLE Details?')">
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
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" name="" id="" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to Reactivate Metric?')">
                            <i class="fa fa-ban"></i> Reactivate </button>
                    </div>
                </div>
            </div>
        </div>
    </form>



@endsection

@section('scripts')


    <script>
        //AJAX SCRIPT TO GET DETAILS FOR
        $(function()
        {



            //CHECK ALL CHECKBOXES
            $(function()
            {
                //all checkboxes are check by default
                $('input:checkbox').prop('checked', this.checked);


                $('#check_all').click(function ()
                {
                    $('input:checkbox').prop('checked', this.checked);
                    $('input:checkbox').val(1);
                });


                $('.vendChk').click(function ()
                {
                    var vendor_id = $(this).attr('id');

                    var chk = $('#'+vendor_id).prop('checked');
                    if( chk == true ){ $('#type_'+vendor_id).val(1); }
                    else if( chk == false ){ $('#type_'+vendor_id).val(0); }


                    var document_id = '{{$document_id}}';
                    var action_type = $('#type_'+vendor_id).val();
                    var status_id = 1;

                    formData =
                        {
                            vendor_id:vendor_id,
                            document_id:document_id,
                            action_type:action_type,
                            status_id:status_id,
                            _token:'{{csrf_token()}}'
                        }
                    $.post('{{route('shortlist-vendor')}}', formData, function(data, status, xhr)
                    {
                        // if(data.status=='ok')
                        // {
                        //     toastr.success(data.info);
                        //     //reloading comment table
                        //     reloadComments(document_id);
                        // }
                        // else{ toastr.error(data.error); }
                    });
                });


                //get row clicked
                // $('.check_tabs').click(function()
                // {
                //     var id = $(this).attr('id');  alert();
                //
                //     var chk = $('#'+id).prop('checked');
                //     if( chk == true ){ $('#'+id).val(1); }
                //     else if( chk == false ){ $('#'+id).val(0); }
                //     var tab_val = $(this).val();
                // });


            });

        });


        function setId(id)
        {
            $('#re_id').val(id);
        }

        function putId(id)
        {
            $('#idd').val(id);
        }

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
