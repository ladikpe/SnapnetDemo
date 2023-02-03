{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px;  padding: 0px 15px">
                                <div class="col-md-12" style="">  
                                    <div class="badge badge-primary round text-white" style="padding: 5px 10px; font-size: 15px"> Contract Type: {{$contractType->count()}} </div>
                                    <a href="" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" onclick="clearForm()" data-toggle="modal" data-target="#addForm" data-toggle="tooltip" title="Create New Contract Type"><i class="la la-plus"></i> New</a>
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="requisition_table">
                                <thead class="">
                                <tr>
                                    <th style="color: transparent;">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>  
                                @foreach ($contractType as $con)
                                    <tr>
                                        <td style="color: transparent;">{{ $con->id }}</td>
                                        <td>{{ $con->name }}</td>
                                        <td>{{ $con->description }}</td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Message">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#addForm" onclick="getMessage({{$con->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Message">
                                                <a href="#"  onclick="deleteItem({{$con->id}})" class="my-btn btn-sm text-danger deleteBtn" id="{{$con->id}}" 
                                                ><i class="la la-trash" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{-- {!! $contractType->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Contract Type</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addMessageForms" action="{{ route('contract-type.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="id">

              <div class="modal-body">
                <label>Name </label>
                <div class="form-group">
                  <input type="text" placeholder="Contract Type Name" class="form-control _header" name="name" id="name" required>
                </div>

                <label class="panel-title">Description</label>
                <fieldset class="form-group">
                    <textarea class="form-control _message" cols="30" rows="8" name="description" id="description" required></textarea>
                </fieldset>

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning" data-dismiss="modal" value="Clear">
                <input type="submit" class="btn btn-primary" value="Save">
              </div>
            </form>

          </div>
        </div>
    </div>













@endsection

@section('scripts')
    <script>
        
    </script>

    <script>

        //ADD FORM

        function deleteItem(id){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"DELETE",
                url:"contract-type/"+id,
                data:{id:id},
                success:function(result){
                    location.reload();
                }
            });
        }

        function getMessage(id)
        {  
            //clearForm();
            $(function()
            {            
                $.get('contract-type/'+id+'/edit', function(data)
                {
                    //Set values
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                });                
            });
        }


        function clearForm()
        {
            $(function()
            {            
                //Set values
                    $('#id').val('');
                    $('#name').val('');
                    $('#description').val('');            
            });
        }
    </script>
    



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
