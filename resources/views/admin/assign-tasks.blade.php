{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

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

@endsection
@section('content')


    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        <div class="row" style="padding: 15px;">

                            {{-- <div class="col-md-2"> Delegate Role to User </div> --}}

                            <div class="col-md-3">
                                <a class="" href="#">
                                  <div class="card bg-primary text-white">
                                      <div class="card-body no-pad">
                                          <div class="media">
                                              <div class="media-body overflow-hidden">
                                                  <p class="text-truncate font-size-17"> <i class="la la-newspaper-o"></i> Assigned Tasks {{$assigned_tasks->count()}} 
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
                                <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" data-toggle="modal" data-target="#addForm" onclick="clearForm()" data-toggle="tooltip" title="Assign TAsk to User"><i class="la la-plus"></i> Re-assign Task</a>
                            </div>

                        </div>


                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                <tr>
                                    <th style="color: transparent;">#</th>
                                    <th>Task Name</th>
                                    <th>Prev Task Owner</th>
                                    <th>New Task Owner</th>
                                    <th>Role / Obligation</th>
                                    <th>End date</th>
                                    <th>Status</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($assigned_tasks as $assigned_task)
                                    <tr>
                                        <td style="color: transparent;">{{ $assigned_task->id }}</td>
                                        <td>{{ $assigned_task->document?$assigned_task->document->name:'' }}</td>
                                        <td>{{ $assigned_task->prev_delegate?$assigned_task->prev_delegate->name:''}}</td>
                                        <td>{{ $assigned_task->delegate?$assigned_task->delegate->name:''}}</td>
                                        <td>{{ $assigned_task->action }}</td>
                                        <td>{{ date("M j, Y", strtotime($assigned_task->end_date)) }}</td>
                                        <td>
                                            @if($assigned_task->end_date < $today) <div class="badge badge-danger"> Expired </div>
                                            @elseif($assigned_task->end_date >= $today) <div class="badge badge-success text-white"> Active </div> @endif
                                        </td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Record">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#addForm" onclick="getAssigned({{$assigned_task->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Record">
                                                <a href="{{ url('delete-delegate', $assigned_task->id) }}" class="my-btn btn-sm text-danger deleteBtn" id="{{$assigned_task->id}}" onclick="return confirm('Are you sure you want to DELETE record?')"><i class="la la-close" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                        </td>
                                    </tr> 
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>

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
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Assign Task to User</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addDelegateForm" action="{{ route('add-assign-task') }}" method="POST">
            @csrf
              <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" class="form-control" id="id" name="id" value="">
                        <label for="document_id" class="col-form-label"> Task Name </label>
                        <select class="form-control select2" id="document_id" name="document_id" required="">
                          <option value=""></option>
                            @forelse($documents as $document)
                                <option value="{{$document->id}}">{{$document->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="action" class="col-form-label"> Task Role Obligation </label>
                        <select class="form-control" id="action" name="action" required="">
                          {{-- <option value="Requisition">New Task Creation</option>
                          <option value="Assignment">Task Assignment</option> --}}
                          <option value="Creation">Create Document</option>
                          <option value="Review">Review Document</option>
                          <option value="Approval">Approve Document</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">                        
                        <label for="user_id" class="col-form-label"> Re-assign to </label>
                        <select class="form-control" id="user_id" name="user_id" required="">
                          <option value=""></option>
                            @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="col-form-label"> Expiry/End Date </label>
                        <input type="date" placeholder="End Date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning btn-sm" data-dismiss="modal" value="Clear">
                <input type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to re assign role?')" value="Re assign">
              </div>
            </form>

          </div>
        </div>
    </div>










@endsection

@section('scripts')

    <script src="{{asset('js/select2.min.js')}}"></script>

    <script>

        function getAssigned(id)
        {  
            clearForm();           
            $.get('{{url('get-assign-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#id').val(id);
                $('#document_id').prop('value', data.document_id);
                $('#user_id').prop('value', data.user_id);
                $('#action').val(data.action);
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
                $('#action').val('');
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
