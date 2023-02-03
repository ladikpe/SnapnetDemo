{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

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
        .font-size-17
        {
            font-size: 17px;
            padding: 10px 15px 5px 15px;
            text-align: center;
        }

        .font-large-2
        {
            font-size: 30px!important;
        }
    </style>


        
  {{-- <script src="{{ asset('assets/ckscript.js') }}"></script> --}}
  



@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        <h3 class="card-title" id="basic-layout-form" style="margin-top: -10px; padding: 0px 15px">  Requests
                                  
                            <a href="{{ url('download-request-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download task request in excel" style=""><i class="la la-download"></i> Download</a>

                            <a href="#" class="btn btn-outline-primary btn-glow btn-sm mr-1" data-toggle="modal" data-target="#requestModal" title="Create New Requests" onclick="clearForm()" style="float: right;"><i class="la la-plus"></i> New Request</a>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                <tr>
                                    <th style="color: transparent">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Organization</th>
                                    <th>Purpose</th>
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($requests as $request)
                                    <tr>
                                        <th style="color: transparent">{{ $request->id }}</th>
                                        <td>{{ $request->name }}</td>
                                        <td>{{ $request->email }}</td>
                                        <td>{{ $request->phone}}</td>
                                        <td>{{ $request->organization}}</td>
                                        <td>{!! substr($request->purpose, 0, 100)  !!} ...</td>
                                        {{-- <td>
                                            @if($request->status_id == 0) 
                                                <div class="badge badge-danger text-white"> Declined </div>
                                            @elseif($request->status_id == 1)
                                                <div class="badge badge-warning text-white"> Pending </div>
                                            @elseif($request->status_id == 2)
                                                <div class="badge badge-success text-white"> Approved </div>
                                            @endif
                                        </td> --}}
                                        <td style="text-align: right">

                                            <a href="#" class="btn-sm text-info pull-right" data-toggle="modal" data-target="#requestModal" onclick="getRequest({{$request->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-eye" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $requests->appends(Request::capture()->except('page'))->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>





    {{-- New External Request MODAL --}}
    <div class="modal fade text-left" id="requestModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" 
            aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 55% !important;">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600 text-light" id="myModalLabel33">New Request Form</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>
      
            <form id="addRequestForm" action="{{ url('store-external-requests') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="_id" required>
      
              <div class="modal-body">
      
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name" class="col-form-label font-size"> Fullname <i class="mand">*</i> </label>
                        <input type="text" placeholder="Fullname" class="form-control font-size" name="name" id="name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="col-form-label font-size"> Email <i class="mand">*</i> </label>
                        <input type="email" placeholder="Your Email" class="form-control font-size" name="email" id="email" required>
                    </div>
                </div>
      
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="phone" class="col-form-label font-size"> Phone </label>
                        <input type="text" placeholder="Phone" class="form-control font-size" name="phone" id="phone">
                    </div>

                    <div class="col-md-6">
                        <label for="organization" class="col-form-label font-size"> Organization <i class="mand">*</i> </label>
                        <input type="text" placeholder="Organization" class="form-control font-size" name="organization" id="organization" required>
                    </div>
                </div>
      
                <div class="form-group row">
      
                    <div class="col-md-12">
                        <label for="purpose" class="col-form-label font-size"> Purpose / Description <i class="mand">*</i> </label>
                        <fieldset class="form-group">
                            <textarea class="form-control" cols="30" rows="2" name="purpose" id="purpose" required></textarea>
                        </fieldset>
                    </div>
                </div>
                
      
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm font-size" value="Submit New Request" onclick="return confirm('Are you sure you want to submit?')">
                <input type="button" class="btn btn-outline-warning btn-sm font-size" data-dismiss="modal" value="Close">
              </div>
            </form>
      
          </div>
        </div>
    </div>








@endsection

@section('scripts')



    <script>
        




        function setId(id)
        {
            $('#req_id').val(id);
        } 


        function setApprove()
        {
            $('#approval_type').val('Approve');
        }

        function setDecline()
        {
            $('#approval_type').val('Decline');
        }  

    </script>
    

    <script src="{{asset('jstree/dist/jstree.min.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
    {{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}





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
