{{-- template index --}}
@extends('layouts.app')
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


        .chat-div-req
        {
            text-align: left;
            position: relative;
            display: block;
            float: right;
            padding: 8px 15px;
            margin: 0 20px 10px 0;
            clear: both;
            color: #fff;
            background-color: #1E9FF2;
            border-radius: 4px;
        }

        .chat-div-res
        {
            text-align: right;
            position: relative;
            display: block;
            float: right;
            padding: 8px 15px;
            margin: 0 20px 10px 0;
            clear: both;
            color: #fff;
            background-color: #0FB365;
            border-radius: 4px;
        }

        body
        {
            font-family: sans-serif!important;
        }
    </style>

@endsection
@section('content')



    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Clarity Requested for this Task 
                                </div>
                            </div>
                        </h3>

                        <table class="table mb-0" id="">
                            <tr>
                                <td style="width: 25%; text-align: right;">Task Name</td>
                                <td style="width: 75%; text-align: left">{{$clarity->name}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Task Category</td>
                                <td style="text-align: left;">{{ $clarity->type?$clarity->type->name:'' }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Task Deadline</td>
                                <td style="text-align: left;">{{date("M j, Y", strtotime($clarity->deadline))}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Task Approval Stage</td>
                                <td style="text-align: left;">
                                    {{$controllerName->getRequisitionStage($clarity->id, $clarity->workflow_id)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Assigned Status</td>
                                <td style="text-align: left;">
                                    @if($clarity->assigned == 0) <div class="badge badge-warning"> No </div>
                                    @elseif($clarity->assigned == 1) <div class="badge badge-success"> Yes </div> @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Requested Clarity</td>
                                <td style="text-align: left;">
                                    <div class="badge badge-secondary"> {{$controllerName->getClarityView($req_clarity->id)}} </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Responded</td>
                                <td style="text-align: left;">
                                    <div class="badge badge-secondary"> {{$controllerName->getResponseView($req_clarity->id)}} </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Source</td>
                                <td style="text-align: left;">
                                    <div class="badge badge-secondary">{{$clarity->author?$clarity->author->name:''}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Attached Document</td>
                                <td style="text-align: left;">
                                    @if($clarity->document_name != null)
                                        <a class="pull-left" data-toggle="tooltip" 
                                            title="Download {{$clarity->author?$clarity->author->name:''}}'s Document" href="{{URL::asset($clarity->document_path.'/'.$clarity->document_name)}}" download="{{URL::asset($clarity->document_path.'/'.$clarity->document_name)}}"><i class="la la-file-pdf-o"></i> {{$clarity->document_name}} 
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>



                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-7">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form"> Messages
                            @if($clarity->user_id != Auth::user()->id)
                                <a href="#" class="btn btn-outline-warning btn-glow pull-right btn-sm ml-1" data-toggle="modal" data-target="#closeClarity" onclick="getTaskClarity({{$clarity->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-trash" aria-hidden="true" style="font-weight: bold"></i> Close Clarity
                                </a>
                            @endif

                            <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm" data-toggle="modal" data-target="#requisitionClarityResponse" onclick="getRequisitionClarity({{$clarity->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-reply" aria-hidden="true" style="font-weight: bold"></i> Respond to Request
                            </a>                            
                        </h3>

                        <table class="mt-4 ml-2" style="width: 100%; border: none;">
                            <tr style="border-bottom: none;">
                                <td style="">
                                    @if($all_clarities != null)
                                        @forelse($all_clarities as $clarity)
                                            @if($clarity->type == 'Request')
                                                <div class="col-md-12 ml-2 chat-div-req" style="text-align: left;">
                                                     <i class="">{{ strtoupper( $clarity->author?$clarity->author->name:"" ) }} </i> <br>
                                                     <br>{{$clarity->message}}

                                                     <br>
                                                     @if($document && ($clarity->id == $document->clarity_response_id))  
                                                        <a class="btn btn-sm pull-right" data-toggle="tooltip" style="background: #fff; color: black;" 
                                                        title="Download {{$document->uploader?$document->uploader->name:''}}'s Document" href="{{URL::asset($document->document_path.'/'.$document->document_name)}}" 
                                                        download="{{URL::asset($document->document_path.'/'.$document->document_name)}}"><i class="la la-download"></i> {{$document->document_name}}
                                                        </a>
                                                    @endif

                                                </div>
                                            @elseif($clarity->type == 'Response')
                                                <div class="col-md-12 ml-2 chat-div-res" style="text-align: right;">
                                                    <i class="">{{ strtoupper( $clarity->author?$clarity->author->name:"" ) }} </i><br>
                                                    <br>{{$clarity->message}}

                                                     <br>
                                                     @if($document && ($clarity->id == $document->clarity_response_id))  
                                                        <a class="btn btn-sm pull-left" data-toggle="tooltip" style="background: #fff; color: black;" 
                                                        title="Download {{$document->uploader?$document->uploader->name:''}}'s Document" href="{{URL::asset($document->document_path.'/'.$document->document_name)}}" 
                                                        download="{{URL::asset($document->document_path.'/'.$document->document_name)}}"><i class="la la-download"></i> {{$document->document_name}}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif 
                                        @empty
                                        @endforelse
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>








    {{-- Clarity MODAL --}}
    <div class="modal fade text-left" id="requisitionClarityResponse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Respond to Clarity Request</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form id="requisitionClarityResponseForms" action="{{ route('requisition-clarity-response') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" value="{{$req_clarity->requisition_id}}" required>
            <input type="hidden" class="form-control" name="response_id" id="response_id" value="{{$req_clarity->id}}" required>
            <input type="hidden" class="form-control" name="sender_id" id="sender_id" value="{{$req_clarity->created_by}}" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name" class="col-form-label"> Task Name </label>
                        <input type="text" placeholder="Task Name" class="form-control name" name="name" id="c_name" required readonly>
                    </div>

                    <div class="col-md-6">
                    <label for="requestor_id" class="col-form-label"> Sender </label>
                        <input type="text" placeholder="Requestor Name" class="form-control name" name="requestor_id" id="c_requestor_id" value="{{Auth::user()->name}}" required readonly>
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-12" style="text-align: left">
                        <label for="clar" class="col-form-label">  
                            <img src="{{ asset('assets/images/user1.png') }}" alt="avatar" style="width: 5%; height: 5%">
                            {{$req_clarity->author?$req_clarity->author->name:''}}
                            <button type="button" class="btn btn-warning" style="color: #fff" id="clar" name="clar">{{$req_clarity->clarity}}</button> 
                        </label>
                    </div>

                    <div class="col-md-12" style="text-align: right">
                        <label for="resp" class="col-form-label">  
                            @if($req_clarity->response != null)
                                <button type="button" class="btn btn-success" style="color: #fff" id="resp" name="resp">
                                    {{$req_clarity->response}}</button>
                                    {{$req_clarity->requestor?$req_clarity->requestor->name:''}}
                                <img src="{{ asset('assets/images/user1.png') }}" alt="avatar" style="width: 5%; height: 5%"> 
                            @endif
                        </label>
                    </div>
                </div> --}}

                {{-- @if($req_clarity->created_by == \Auth::user()->id)
                @else --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                        <label for="message" class="col-form-label"> Your Response </label>
                            <textarea rows="4" class="form-control" id="message" name="message" placeholder="Enter Message Here ... " required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                        <label for="file" class="col-form-label"> Document &nbsp; &nbsp; (Optional) </label>
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
                    </div>
                {{-- @endif --}}

                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" value="Close">
                {{-- @if($req_clarity->created_by == \Auth::user()->id) --}}
                {{-- @else --}}
                    <button type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm">Send Response </button>
                {{-- @endif --}}
              </div>
            </form>

          </div>
        </div>
    </div>


    {{-- Process endded Clarity MODAL --}}
    <div class="modal fade text-left" id="closeClarity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Notify Clarification Process Ended</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>

            <form id="requisitionClarityResponseForms" action="{{ route('clarity-endded') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" value="{{$clarity->requisition_id}}" required>
            <input type="hidden" class="form-control" name="requestor_id" id="requestor_id" value="{{$clarity->user_id}}" required>
            <input type="hidden" class="form-control" name="c_id" id="c_id" value="{{$id}}" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="task_name" class="col-form-label"> Task Name </label>
                        <input type="text" placeholder="Task Name" class="form-control name" name="name" id="task_name"  required readonly>
                    </div>

                    <div class="col-md-6">
                    <label for="task_requestor" class="col-form-label"> Requestor </label>
                        <input type="text" placeholder="Requestor Name" class="form-control name" name="task_requestor" id="task_requestor" value="{{$clarity->author?$clarity->author->name:''}}" required readonly>
                    </div>
                </div>

                
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="comment" class="col-form-label"> Your Message </label>
                        <textarea rows="4" class="form-control" id="comment" name="comment" placeholder="Enter Message Here ... " required=""></textarea>
                    </div>
                </div>

                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" value="Close">
                {{-- @if($req_clarity->created_by == \Auth::user()->id) --}}
                {{-- @else --}}
                    <button type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm">Send </button>
                {{-- @endif --}}
              </div>
            </form>

          </div>
        </div>
    </div>















@endsection

@section('scripts')

    <script>

        function getRequisitionClarity(id)
        {
            $(function()
            {            
                $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    // $('#response_id').val(data.id);
                    $('#c_name').val(data.name);
                    $('#sender_id').val(data.user_id);
                    // $('#c_requestor_id').val(data.author.name);
                });
                
            });
        }

        function getTaskClarity(id)
        {
            $(function()
            {            
                $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
                {
                    $('#task_name').val(data.name);
                });
                
            });
        }


        //UPDATE FORM CLARITY
        $("#requisitionClarityResponseForm").on('submit', function(e)
        { 
            e.preventDefault();
            const formData = new FormData(document.querySelector('#requisitionClarityResponseForm'));

            $.post('{{route('requisition-clarity-response')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    $('#requisitionClarityResponse').modal('hide');
                    // toastr.success('Email response sent successfully', {timeOut:10000});  
                    alert('Email response sent successfully');
                    setInterval(function(){ window.location.replace("{{ route('assignments.index') }}"); }, 1000);
                   
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
                $('#requisition_id').val('');
                $('#name').val('');
                $('#created_by').val('');
                $('#user_id').prop('value', 0);               
            });
        }

        function clearClarityForm()
        {
            $(function()
            {            
                //Set values
                $('#c_id').val('');
                $('#c_requisition_id').val('');
                $('#c_name').val('');
                $('#c_created_by').val('');
                $('#clarity').val('');  
                $('#c_requestor').val('');             
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
