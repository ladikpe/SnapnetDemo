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
        .font-size-17
        {
            font-size: 17px;
            padding: 5px 15px 5px 15px;
            text-align: center;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    {{-- <link href="../css/froala_style.min.css" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('content')


    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        <div class="row">

                            {{-- <div class="col-md-2"> Delegate Role to User </div> --}}

                            <div class="col-md-3">
                                <a class="" href="#">
                                  <div class="card bg-primary text-white">
                                      <div class="card-body no-pad">
                                          <div class="media">
                                              <div class="media-body overflow-hidden">
                                                  <p class="text-truncate font-size-17"> <i class="la la-arrow-circle-right"></i> Delegated Roles {{$delegate_roles->count()}} 
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a class="" href="#">
                                  <div class="card bg-success text-white">
                                      <div class="card-body no-pad">
                                          <div class="media">
                                              <div class="media-body overflow-hidden">
                                                  <p class="text-truncate font-size-17">
                                                     <i class="la la-check"></i> Active Account {{$active->count()}} 
                                                   </p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a class="" href="#">
                                  <div class="card bg-danger text-white">
                                      <div class="card-body no-pad">
                                          <div class="media">
                                              <div class="media-body overflow-hidden">
                                                  <p class="text-truncate font-size-17">
                                                     <i class="la la-ban"></i> Account Expired {{$expired->count()}} 
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                            </div>

                            <div class="col-md-3"> 
                                <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" data-toggle="modal" data-target="#addForm" onclick="clearForm()" data-toggle="tooltip" title="Delegate Role to User"><i class="la la-plus"></i> Delegate Role</a>
                            </div>

                        </div>


                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                <tr>
                                    <th style="color: transparent;">#</th>
                                    <th>Department</th>
                                    <th>Delegator</th>
                                    <th>Prev Dept Head</th>
                                    <th>Delegated to</th>
                                    <th>Action</th>
                                    <th>End date</th>
                                    <th>Status</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($delegate_roles as $delegate_role)
                                    <tr>
                                        <td style="color: transparent;">{{ $delegate_role->id }}</td>
                                        <td>{{ $delegate_role->department?$delegate_role->department->name:'' }}</td>
                                        <td>{{ $delegate_role->delegator?$delegate_role->delegator->name:'' }}</td>
                                        <td>{{ $delegate_role->prev_dept_head?$delegate_role->prev_dept_head->name:''}}</td>
                                        <td>{{ $delegate_role->delegate?$delegate_role->delegate->name:''}}</td>
                                        <td> Delegate Role </td>
                                        <td>{{ date("M j, Y", strtotime($delegate_role->end_date)) }}</td>
                                        <td>
                                            @if($delegate_role->end_date < $today) <div class="badge badge-danger"> Expired </div>
                                            @elseif($delegate_role->end_date >= $today) <div class="badge badge-success text-white"> Active </div> @endif
                                        </td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Record">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#addForm" onclick="getDelegate({{$delegate_role->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Record">
                                                <a href="{{ url('delete-delegate', $delegate_role->id) }}" class="my-btn btn-sm text-danger deleteBtn" id="{{$delegate_role->id}}" onclick="return confirm('Are you sure you want to DELETE record?')"><i class="la la-close" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                        {{-- <div class="mt-4" id="example">
                            <div class="fr-view">
                              Here comes the HTML edited with the Froala rich text editor.
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>

    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addForm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Delegate Role to User</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addDelegateForm" action="{{ route('add-delegate-role') }}" method="POST">
            @csrf
              <div class="modal-body">

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Role Delegation Form </legend>

                    <div style="margin: 1% 0% 1% 0%; width: 100%">

                        {{-- <h5> Vendor Shortlist </h5> --}}
                        <table class="table table-sm mb-4 dtable" style="-webkit-print-color-adjust: exact!important;">
                            {{-- <thead class="">
                                <tr style="">
                                    <th colSpan="2" style="background: #cccccc !important; color: #fff !important; text-align: center">
                                        Delegate Role Form </th>
                                </tr>
                            </thead> --}}
                            <tbody>
                                <tr>
                                    <td style="width: 30%; text-align: right; padding-right: 2%"><b> Department </b></td>
                                    <td style="width: 70%; text-align: left; padding-left: 2%">
                                        <input type="hidden" class="form-control" id="id" name="id" value="">
                                        <select class="form-control" id="department_id" name="department_id" readonly="true">
                                            <option value="{{$department_id}}">{{$department}}</option>
                                            {{-- @forelse($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @empty
                                            @endforelse --}}
                                        </select>
                                    </td>
                                </tr>
                                <tr> <td colspan="2" style="height: 5px"></td> </tr>

                                <tr>
                                    <td style="width: 35%; text-align: right; padding-right: 2%"><b> Delegate to </b></td>
                                    <td style="width: 65%; text-align: left; padding-left: 2%">
                                        <select class="form-control" id="user_id" name="user_id" required="">
                                            <option value=""></option>
                                            @forelse($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </td>
                                </tr>
                                <tr> <td colspan="2" style="height: 5px"></td> </tr>

                                <tr>
                                    <td style="width: 35%; text-align: right; padding-right: 2%"><b> Expiry Date </b></td>
                                    <td style="width: 65%; text-align: left; padding-left: 2%">
                                        <input type="date" placeholder="End Date" class="form-control" name="end_date" id="end_date" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning" data-dismiss="modal" value="Clear">
                <input type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to delegate role?')" value="Delegate">
              </div>
            </form>

          </div>
        </div>
    </div>










@endsection

@section('scripts')

    <script>

        function getDelegate(id)
        {  
            clearForm();           
            $.get('{{url('get-delegate-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#id').val(id);
                $('#department_id').prop('value', data.department_id);
                $('#user_id').prop('value', data.user_id);
                $('#end_date').val(data.end_date);
            });
        }


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('#id').val('');
                $('#document_id').prop('value', '');
                $('#user_id').prop('value', '');
                $('#end_date').val('');
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
