
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

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
                        <h2 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px; padding: 0px 15px">
                                <div class="col-md-12" style=""> 
                                    <div class="badge badge-secondary round text-white" style="padding: 5px 10px; font-size: 15px"> Roles {{$no_of_roles}} </div>
                                    <a href="#" data-toggle="modal" data-target="#addRoleForm" class="btn btn-outline-success btn-glow pull-right btn-sm ml-1" style="font-size: 15px"><i class="la la-plus" aria-hidden="true" style=""></i> New
                                    </a>

                                    {{-- <a href="" class="btn btn-outline-info btn-glow pull-right btn-sm"><i class="la la-edit" aria-hidden="true" style="font-weight: bold;"></i> </a> --}}
                                    {{-- {{ route('users_api') }} --}}
                                </div>
                            </div>
                        </h2>

                        <div class="" id="">
                            <table class="table table-striped table-bordered zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Description</th>
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Delete Role">
                                                <a href="#" class="my-btn btn-sm text-danger deleteBtn" style=""><i class="la la-close" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Edit Role">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#editRoleForm" onclick="getRole({{$role->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>                                                
                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {!! $roles->render() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addRoleForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Role</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addRoleFormForm" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id" id="id" value="0" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Role Name </label>
                        <input type="text" placeholder="Role Name" class="form-control name" name="name" id="name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <textarea rows="3" placeholder="Description" class="form-control" name="description" id="description" required></textarea>
                    </div>
                </div>

                

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning" value="Clear">
                <input type="submit" class="btn btn-outline-success btn-glow pull-right" value="Save">
              </div>
            </form>

          </div>
        </div>
    </div>


    {{-- Edit MODAL --}}
    <div class="modal fade text-left" id="editRoleForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Edit Role</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="editRoleFormForm" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id" id="_id" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Role Name </label>
                        <input type="text" placeholder="Role Name" class="form-control name" name="name" id="_name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <textarea rows="3" placeholder="Description" class="form-control" name="description" id="_description" required></textarea>
                    </div>
                </div>

                

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning btn-sm" value="Clear">
                <input type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" onclick="return confirm('Are you sure you want to UPDATE Role?')" value="Update">
              </div>
            </form>

          </div>
        </div>
    </div>














@endsection

@section('scripts')

    <script>
        function getRole(id)
        {
            clearForm();
            $(function()
            {            
                $.get('{{url('get-role-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#_id').val(data.id);
                    $('#_name').val(data.name);
                    $('#_description').val(data.description);
                });
                
            });
        }


        //ADD FORM
        $("#addRoleForm").on('submit', function(e)
        { 
            clearForm();
            e.preventDefault();
            var id = $('#id').val();
            var name = $('#name').val();
            var description = $('#description').val();

            formData = 
            {
                id:id,
                name:name,
                description:description,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('roles.store')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {

                    $('#addRoleForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('roles.index') }}"); }, 1000);
                    clearForm();
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });


        //EDIT FORM
        $("#editRoleForm").on('submit', function(e)
        { 
            e.preventDefault();
            var id = $('#_id').val();
            var name = $('#_name').val();
            var description = $('#_description').val();

            formData = 
            {
                id:id,
                name:name,
                description:description,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('roles.store')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {

                    $('#editRoleForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('roles.index') }}"); }, 1000);
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
