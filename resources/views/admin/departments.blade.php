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
                                    <div class="badge badge-primary round text-white" style="padding: 5px 10px; font-size: 15px"> Departments {{$departments->count()}} </div>
                                    <a href="" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" data-toggle="modal" data-target="#addForm" data-toggle="tooltip" title="Create New Purchase Order"><i class="la la-plus"></i> New</a>
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-striped table-bordered zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Department Head</th>
                                    <th>Author</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>  
                                @forelse ($departments as $department)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ $department->description }}</td>
                                        <td>{{ $department->department_head?$department->department_head->name:'' }}</td>
                                        <td>{{ $department->author?$department->author->name:''}}</td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Department">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#editForm" onclick="getDepartment({{$department->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Department">
                                                <a href="#" class="my-btn btn-sm text-danger deleteBtn" id="{{$department->id}}"><i class="la la-trash" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $departments->render() !!} --}}
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
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Department</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addDepartmentForm" action="{{ route('departments.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="" required>

              <div class="modal-body">
                <label>Department Name </label>
                <div class="form-group">
                  <input type="text" placeholder="Department Name" class="form-control _name" name="name" id="name" required>
                </div>

                <label>Department Head </label>
                <div class="form-group">
                  <select class="form-control" name="department_head_id" id="department_head_id" required>
                    <option value="">  </option>
                    @forelse($department_heads as $department_head)
                        <option value="{{$department_head->id}}"> {{$department_head->name}} </option>
                    @empty
                    @endforelse
                  </select>
                </div>


                <label class="panel-title">Description </label>
                <fieldset class="form-group">
                    <textarea class="form-control _description" cols="30" rows="4" name="description" id="description" required></textarea>
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




    {{-- Edit MODAL --}}
    <div class="modal fade text-left" id="editForm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600">Edit Department</label>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </a>
            </div>

            <form id="editDepartmentForm" action="{{ route('departments.store') }}" method="POST">
            @csrf
              <div class="modal-body">
                  <input type="hidden" placeholder="Id" class="form-control _id" name="id" id="_id" required>
                <label>Department Name </label>
                <div class="form-group">
                  <input type="text" placeholder="Department Name" class="form-control" name="name" id="_name" required>
                </div>

                <label>Department Head </label>
                <div class="form-group">
                  <select class="form-control" name="department_head_id" id="_department_head_id" required>
                    <option value="">  </option>
                    @forelse($department_heads as $department_head)
                        <option value="{{$department_head->id}}"> {{$department_head->name}} </option>
                    @empty
                    @endforelse
                  </select>
                </div>


                <label class="panel-title">Description </label>
                <fieldset class="form-group">
                    <textarea class="form-control _description" cols="30" rows="4" name="description" id="_description" required></textarea>
                </fieldset>

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning btn-sm" data-dismiss="modal" value="Clear">
                <input type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="Save">
              </div>
            </form>

          </div>
        </div>
    </div>











@endsection

@section('scripts')

    <script>

        //ADD FORM
        $("#addDepartmentForm").on('submit', function(e)
        { 
            clearForm();
            e.preventDefault();
            var id = $('#id').val();
            var name = $('#name').val();
            var department_head_id = $('#department_head_id').val();
            var description = $('#description').val();

            formData = 
            {
                id:id,
                name:name,
                department_head_id:department_head_id,
                description:description,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('departments.store')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {

                    $('#addForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    clearForm();

                    $('#department_table').prepend(`<tr> <td> ${details.id} </td> <td> ${details.name} </td>  <td> ${details.description} </td>  <td> ${details.department_head.name} </td>  <td> ${details.author.name} </td>  <td style="text-align: right"> <span  details-toggle="tooltip" title="Edit Department"> <a href="#" class="my-btn btn-sm text-info" details-toggle="modal" details-target="#editForm" onclick="getDepartment(${details.id})"><i class="la la-pencil" aria-hidden="true"></i>  </a> </span> <span  details-toggle="tooltip" title="Delete Department">  <a href="#" class="my-btn btn-sm text-danger deleteBtn" id="'+details.id+'"><i class="la la-trash" aria-hidden="true"></i> </a> </span> </td> </tr>`);
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });


        //EIDT FORM
        $("#editDepartmentForms").on('submit', function(e)
        { 
            e.preventDefault();
            var id = $('#_id').val();
            var name = $('#_name').val();
            var department_head_id = $('#_department_head_id').val();
            var description = $('#_description').val();

            formData = 
            {
                id:id,
                name:name,
                _department_head_id:_department_head_id,
                description:description,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('departments.store')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    $('#editForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('departments') }}"); }, 3000);
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});  }
            }); 
        });


        //DELETE FORM
        $(".deleteBtn").on('click', function(e)
        {  
            e.preventDefault();
            var id = $(this).attr("id"); 
            if(confirm('Are you sure you want to delete department?'))
            {   

                formData = 
                {
                    id:id,
                    _token:'{{csrf_token()}}'
                }
                $.post('{{url('delete-department')}}?id=' +id, formData, function(data, status, xhr)
                {
                    if(data.status=='ok')
                    {
                        $('#editForm').modal('hide');
                        toastr.success(data.info, {timeOut:10000});
                        setInterval(function(){ window.location.replace("{{ route('departments') }}"); }, 3000);
                        return;
                    }
                    else
                    {
                         toastr.error(data.error, {timeOut:10000});
                    }
                });
            }
        });


        function getDepartment(id)
        {  
            clearForm();
            $(function()
            {            
                $.get('{{url('get-department-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#_id').val(data.id);
                    $('#_name').val(data.name);
                    $('#_department_head_id').prop('value', data.department_head_id);
                    $('#_description').val(data.description);
                });
                
            });
        }


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('._id').val('');
                $('._name').val('');
                $('._department_head_id').val('');
                $('._description').val('');                
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
