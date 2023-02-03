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
    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Create a New Prefered Templates </div>
                            </div>
                        </h3>

                        <div class="" id="">
                        <form id="" action="{{ route('store-prefered-template') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="requisition_id" class="col-form-label"> Requisition Name </label>
                                    <select class="form-control" id="requisition_id" name="requisition_id" required="">
                                      <option value=""></option>
                                        @forelse($requisitions as $requisition)
                                            <option value="{{$requisition->id}}">{{$requisition->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="user_id" class="col-form-label"> Send Template to </label>
                                    <select class="form-control" id="user_id" name="user_id" required="">
                                      <option value=""></option>
                                        @forelse($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="file" class="col-form-label"> Template Upload </label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <input type="submit" class="btn btn-outline-success btn-glow btn-sm pull-right ml-1" value="Submit">
                                    <input type="reset" class="btn btn-outline-warning btn-sm pull-right" value="Clear">
                                </div>
                            </div>
                        </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>















@endsection

@section('scripts')

    <script>
        function getRequisition(id)
        {
            clearForm();
            $(function()
            {            
                $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#requisition_id').val(data.id);
                    $('#ass_name').val(data.name);
                    $('#created_by').val(data.user_id);
                });
                
            });
        }

        function getRequisitionClarity(id)
        {
            clearClarityForm();
            $(function()
            {            
                $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#c_requisition_id').val(data.id);
                    $('#c_name').val(data.name);
                    $('#c_created_by').val(data.user_id);
                    $('#c_requestor_id').val(data.author.name);
                });
                
            });
        }

        
        $(".priority").on('click', function(e){         $('#priority').val($(this).val());   }); 
        $(".sensitivity").on('click', function(e){      $('#sensitivity').val($(this).val());   }); 
        // $(".urgency").on('click', function(e){          $('#urgency').val($(this).val());   }); 
       


        //ADD FORM
        $("#assignRequisitionForm").on('submit', function(e)
        { 
            //clearForm();
            e.preventDefault();
            var requisition_id = $('#requisition_id').val();
            var name = $('#ass_name').val();
            var user_id = $('#user_id').val();
            var priority = $('#priority').val();
            var sensitivity = $('#sensitivity').val();
            // var urgency = $('#urgency').val();
            var requestor_id = $('#created_by').val();
            var created_by = $('#created_by').val();

            formData = 
            {
                requisition_id:requisition_id,
                name:name,
                user_id:user_id,
                priority:priority,
                sensitivity:sensitivity,
                // urgency:urgency,
                requestor_id:requestor_id,
                created_by:created_by,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('assignments.store')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    $('#assignRequisition').modal('hide');  alert(data.info);
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('assignments.index') }}"); }, 1000);
                    clearForm();
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });


        //ADD FORM
        $("#requisitionClarityForm").on('submit', function(e)
        { 
            clearClarityForm();
            e.preventDefault();
            var id = $('#c_id').val();
            var requisition_id = $('#c_requisition_id').val();
            var name = $('#c_name').val();
            var user_id = $('#c_created_by').val();
            var clarity = $('#clarity').val();

            formData = 
            {
                id:id,
                requisition_id:requisition_id,
                name:name,
                user_id:user_id,
                clarity:clarity,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('requisition-clarity')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {

                    $('#requisitionClarity').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('assignments.index') }}"); }, 1000);
                    clearClarityForm();
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
                $('#ass_name').val('');
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
