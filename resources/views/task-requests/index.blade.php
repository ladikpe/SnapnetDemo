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
                                    <th>Purpose</th>
                                    <th>Description</th>
                                    <th>Request type</th>
                                    <th>Department</th>
                                    <th>To Approve</th>
                                    <th>Status</th>
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($requests as $request)
                                    <tr>
                                        <th style="color: transparent">{{ $request->id }}</th>
                                        <td>{{ $request->purpose }}</td>
                                        <td>{{ $request->description }}</td>
                                        <td>{{ $request->type?$request->type->name:''}}</td>
                                        <td>{{ $request->department?$request->department->name :''}}</td>
                                        <td>{{ $request->department_head?$request->department_head->name :''}}</td>
                                        <td>
                                            @if($request->status_id == 0) 
                                                <div class="badge badge-danger text-white"> Declined </div>
                                            @elseif($request->status_id == 1)
                                                <div class="badge badge-warning text-white"> Pending </div>
                                            @elseif($request->status_id == 2)
                                                <div class="badge badge-success text-white"> Approved </div>
                                            @endif
                                        </td>
                                        <td style="text-align: right">
                                            @if($request->status_id < 2 && $request->created_by == Auth::user()->id)
                                                <a href="#" class="btn-sm text-danger pull-right deleteBtn" id="{{$request->id}}" style="padding :0.3rem 0.4rem !important;" 
                                                    ><i class="la la-remove" aria-hidden="true"></i>
                                                </a>

                                                <a href="#" class="btn-sm text-info pull-right" data-toggle="modal" data-target="#requestModal" onclick="getRequest({{$request->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if($request->department_head_id == \Auth::user()->id && $request->status_id == 1)
                                                <span  data-toggle="tooltip" title="Approve">
                                                    <a href="#" class="btn btn-sm btn-success text-white pull-right" data-toggle="modal" data-target="#ApproveModal" onclick="setId({{$request->id}})" title="Approve"><i class="la la-check" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            @endif
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









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" 
            aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Request</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>
      
            <form id="addRequestForm" action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="_id" required>
      
              <div class="modal-body">
      
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Purpose <i class="mand">*</i> </label>
                        <input type="text" placeholder="Purpose" class="form-control _purpose" name="purpose" id="purpose" required>
                    </div>
                </div>
      
                <div class="form-group row">
      
                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <fieldset class="form-group">
                            <textarea class="form-control _description" cols="30" rows="2" name="description" id="description"></textarea>
                        </fieldset>
                    </div>
                </div>
      
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="requisition_type_id" class="col-form-label"> Request Type <i class="mand">*</i> </label>
                        <select class="form-control _request_type" id="request_type" name="request_type" required="">
                          <option value=""></option>
                            @forelse($requisition_types as $requisition_type)
                                <option value="{{$requisition_type->id}}">{{$requisition_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
      
      
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="file" class="col-form-label"> Upload Document to support request </label>
                        <input type="file" class="form-control _document" id="file" name="file">
                    </div>
                </div>
                
      
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Submit New Request" onclick="return confirm('Are you sure you want to submit?')">
                <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
              </div>
            </form>
      
          </div>
        </div>
    </div>
      



   

    


    <!-- Confirm  modal -->
    <form id="ApprovalForm" class="form-horizontal" method="POST" action="{{ url('approve-request') }}"> @csrf
        @csrf
          <div id="ApproveModal" class="modal fade" role="dialog" style="margin-top: -6%">
              <div class="modal-dialog" style="margin-top: 10%; max-width: 45% !important;">
  
                  <!-- Modal content-->
                  <div class="modal-content" style="border-bottom: none;">
                      <div class="modal-header" style="">
                          <h4 class="modal-title font-size-14" id="myModalLabel69" style="color :#343333 !important; margin-left: 0% "> 
                            New Task Request Approval
                          <span id="label_code" style="color: #202020; font-size: 15px"></span>  </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="color: #ffffff">X</span>
                          </button>
                      </div>
  
  
                      <div class="swal2-header" style="text-align: center !important; margin-top: -30px">
                       
                          <h2 class="mt-5" id="swal2-title" style="font-size: 16px;">Approval Type? </h2> <br>
                          <div class="form-group row">
                            <div class="col-md-12">
                                {{-- <label for="approval_type" class="col-form-label"> Approval Type</label> --}}

                                <div class="d-inline-block custom-control custom-radio mr-1" style="">
                                    <div class="input-group">
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <label class="container"> <span style="font-size: 13px !important;">
                                                    Approve </span>
                                                <input type="radio" class="appr_type" name="appr_type" id="Approve"
                                                     onchange="setApprove()"> <span class="checkmark"
                                                    style="background: teal"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-inline-block custom-control custom-radio mr-1">
                                    <div class="input-group">
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <label class="container"> <span style="font-size: 13px !important;">
                                                    Decline </span>
                                                <input type="radio" class="appr_type" name="appr_type" id="Decline"
                                                onchange="setDecline()"> <span class="checkmark"
                                                    style="background: #E52B50"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control approval_type" name="approval_type" id="approval_type" >

                            </div>
                        </div>
                       
                      </div>
  
  
                      <div class="modal-body" style="margin-top: -40px">    
      
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="reason" class="col-form-label"> Message <i class="mand">*</i> </label>
                                <textarea rows="3" class="form-control" id="reason" name="reason" required=""></textarea>
                            </div>
                        </div>


                        <input type="hidden" class="form-control" name="req_id" id="req_id" value="">
                        {{-- <center> <h3 class="swal3-title" style="font-size: 15px"> You are sure? </h3> </center> --}}
                        <br>
  
                          <div class="" style="text-align: center!important">
                              <button type="button" name="no_btn" id="no_btn" class="btn btn-default btn-sm mr-1" data-dismiss="modal" > Close </button>
  
                              <button type="submit" name="btn" id="btn" class="btn btn-primary btn-sm" onmouseover="checkApprovalType()"> Submit</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>
  





@endsection

@section('scripts')



    <script>
        function getRequest(id)
        {
            clearForm();
            $(function()
            {            
                $.get('{{url('get-request-by-id')}}?id=' +id, function(data)
                {   
                    //Set values
                    $('#_id').val(data.id);
                    $('._purpose').val(data.purpose);
                    $('._description').prop('value', data.description);
                    $('._request_type').prop('value', data.request_type);
                });
                
            });
        }




        //DELETE FORM
        $(".deleteBtn").on('click', function(e)
        {  
            e.preventDefault();
            var id = $(this).attr("id"); 
            if(confirm('Are you sure you want to delete request?'))
            {  

                formData = 
                {
                    id:id,
                    _token:'{{csrf_token()}}'
                }
                $.post('{{url('delete-request')}}?id=' +id, formData, function(data, status, xhr)
                {
                    if(data.status=='ok')
                    {
                        // $('#editForm').modal('hide');
                        toastr.success(data.info, {timeOut:10000});
                        setInterval(function(){ window.location.replace("{{ route('requests.index') }}"); }, 3000);
                        return;
                    }
                    else
                    {
                         toastr.error(data.error, {timeOut:10000});
                    }
                });
            }
        });


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('._id').val('');
                $('._purpose').val('');
                $('._request_type').prop('value', 0);
                $('._description').val('');                
            });
        }


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
        
        
        
        function checkApprovalType()
        {
            var approval_type = $('#approval_type').val();   var reason = CKEDITOR.instances['reason'].getData();
            if(reason == '')
            {
                alert('Message is Required !');
            }
            if(approval_type == '')
            {
                alert('Approval Type is Required !');
            }
            
        }

    </script>


    <script>
               

        CKEDITOR.replace( 'reason' , 
      {
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField', 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
       
        // { name: 'basicstyles', groups: [  ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'insert', items: [ 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Styles', 'Format', 'Font', 'FontSize'  ] }
        ]

      }).on('cut copy paste',function(e){e.cancel();});

      CKEDITOR.config.extraPlugins = "base64image";
      

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
