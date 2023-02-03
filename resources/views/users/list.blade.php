@extends('layouts.app')
@section('stylesheets')
{{--
<link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
{{--
<link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{ asset('bootstrap-toggle-master/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" /> --}}

<style>
  .container {
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
  .container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom radio button */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #ddd;
    border-radius: 10%;
    box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
  }

  /* On mouse-over, add a grey background color */
  .container:hover input~.checkmark {
    background-color: #ccc;
    box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
  }

  /* When the radio button is checked, add a blue background */
  .container input:checked~.checkmark {
    background-color: #E97451;
    box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
  }

  /* Create the indicator (the dot/circle - hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the indicator (dot/circle) when checked */
  .container input:checked~.checkmark:after {
    display: block;
  }

  /* Style the indicator (dot/circle) */
  .container .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 10%;
    background: white;
  }

  .modal-content {
    box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
    /*box-shadow: 0px 1px 20px 1px rgb(30 159 242 / 60%);*/
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
                <div class="badge badge-primary round text-white" style="padding: 5px 10px; font-size: 15px"> Users
                  {{$user_count->count()}} </div>
                                  
                    <a href="{{ url('download-users-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download employees in excel" style=""><i class="la la-download"></i> Download</a>

                    <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right uploadExcel mr-1" data-toggle="tooltip" onclick="showmodal('up_users')" title="Upload employees using excel" style=""><i class="la la-upload"></i> Upload</a>

                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-glow pull-right btn-sm mr-1"
                    data-toggle="tooltip" title="Create New User"><i class="la la-plus"></i> New</a>
              </div>
            </div>
            </h3>

            <div class="" id="">
              <table class="table table-striped dtable" style="width: 100%">
                <thead class="">
                  <tr>
                    <th style="color: transparent;"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Department</th>
                    {{-- <th>Groups</th> --}}
                    <th>Active</th>
                    <th>Created At</th>
                    <th style="text-align: right"> Action </th>
                  </tr>
                </thead>
                <tbody> @php $i = 1; @endphp
                  @forelse ($users as $user)
                  <tr>
                    <td style="color: transparent;">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles?$user->roles->name:'' }}</td>
                    <td>{{ $user->department?$user->department->name:'' }}</td>
                    {{-- <td><span class="badge">{{ $user->groups_count }}</span></td> --}}
                    <td>
                      <input type="checkbox" class="" id="{{$user->id}}" {{$user->status==1?'checked':''}} data-on="Yes"
                      data-off="No" data-onstyle="success" data-offstyle="danger" style="font-size: 11px !important" />
                    </td>
                    <td>{{date("F j, Y, g:i a", strtotime($user->created_at))}}</td>
                    <td style="text-align: right">
                      <span data-toggle="tooltip" title="Edit"><a class="my-btn btn-sm text-info"
                          id="{{$user->id}}" href="{{ route('users.edit', $user->id) }}">
                          <i class="la la-pencil" aria-hidden="true"></i></a>
                      </span>
                      {{-- <span data-toggle="tooltip" title="Assign Role">
                        <a href="#" class="my-btn btn-sm text-primary" data-toggle="modal" data-target="#assignModel"
                          onclick="setId({{$user->id}}, {{$i}})"><i class="la la-sign-in" aria-hidden="true"></i></a>
                      </span> --}}
                      <span data-toggle="tooltip" title="View">
                        <a href="{{ route('users.view', $user->id) }}" class="my-btn btn-sm text-success"><i class="la la-eye" aria-hidden="true"></i></a>
                      </span>
                      <span data-toggle="tooltip" title="Reset Password">
                        <a href="#" class="my-btn btn-sm text-warning" data-toggle="modal" data-target="#ResetPasswordModel" onclick="setResetPassId({{$user->id}})">
                          <i class="la la-key" aria-hidden="true"></i></a>
                      </span>
                      @if($user->status == 1)
                        <span data-toggle="tooltip" title="Deactivate {{ $user->name }} account">
                          <a href="#" class="my-btn btn-sm text-danger" data-toggle="modal" data-target="#DisableAccModel" onclick="setDisableId({{$user->id}})"> 
                            <i class="la la-ban" aria-hidden="true"></i></a>
                        </span>
                      @elseif($user->status == 0)
                        <span data-toggle="tooltip" title="Reactivate {{ $user->name }} account">
                          <a href="#" class="my-btn btn-sm text-success"><i class="la la-check" aria-hidden="true"></i></a>
                        </span>
                      @endif
                    </td>
                  </tr> @php $i++; @endphp
                  @empty
                  @endforelse
                </tbody>
              </table>
              {{-- {!! $users->render() !!} --}}
            </div>

        </div>
      </div>
    </div>
  </div>


</div>










{{-- Assign Role MODAL --}}
<form id="assignForm" action="{{route('assign-roles-to-user')}}" method="post">
  @csrf
  <div class="modal fade text-left" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="assignModel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark white">
          <label class="modal-title text-text-bold-600" id="modal_title">Edit User</label> {{-- style="color: #76838f;"
          --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color: red">X</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="card-block">
            {{-- <label for="" class="col-md-1 col-form-label" style="font-size: 16px; padding: 15px 0px"> Recipients
            </label> --}}
            <input type="hidden" name="user_id" id="user_id" value="">

            <div class="form-group row"> @php $i = 1; @endphp
              @forelse($roles as $role)
              <div class="col-md-3">
                <label class="container">
                  <div style="margin-left: 10%;"> {{$role->name}} </div>
                  <input type="checkbox" class="assi" name="role_array[]" id="role_{{$role->id}}" value="{{$role->id}}">
                  <span class="checkmark"></span>
                </label>
              </div> @php $role_arr[$i] = $role->id; $i++; @endphp
              @empty
              @endforelse
            </div>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="reset" class="btn btn-outline-danger btn-glow btn-sm mr-1">Clear</button> --}}
          <button type="submit" class="btn btn-outline-info btn-glow btn-sm" name="assignBtn" id="assignBtn"
            onmouseenter="setBtnAction('Assign')">Assign</button>
          <button type="submit" class="btn btn-outline-info btn-glow btn-sm" name="assignBtn" id="updateBtn"
            onmouseenter="setBtnAction('Update')">Update</button>
          <input type="hidden" class="" name="btnAction" id="btnAction" value="">
        </div>
      </div>
    </div>
  </div>
</form>




{{-- upload --}}
<form id="excelForm" action="{{route('upload-user')}}" enctype="multipart/form-data" method="POST">  @csrf
    <!-- Modal -->
    <div class="modal animated fade text-left" id="up_users" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document" style="">
            <div class="modal-content">
                <div class="modal-header bg-info">
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

                                <a href="{{ url('download-user-excel-template') }}" id="userTemplate" download="Sample Excel Excel Template" class="btn btn-sm pull-right text-muted"
                                   style="font-size: 12px; border:thin solid #808080" title="Download Sample Excel Excel Template"> <i class="fa fa-download"></i> Download Template</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-info btn-glow btn-sm" onclick="return confirm('Are you sure you want to upload users?')">Upload</button>
                </div>
            </div>
        </div>
    </div>
</form>




{{-- Reset Password MODAL --}}
<div class="modal fade text-left" id="ResetPasswordModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white" style="">
          <label class="modal-title text-text-bold-600" id="myModalLabel33"> Password Reset Form</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form id="addRequisitionForm-edit" action="{{ route('reset-user-password') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control" name="userId" id="userId" required>

          <div class="modal-body">

            <div class="mt-3 mb-3" style="text-align: center; font-size: 16px;"> Reset Password ? </div>            

          </div>
          <div class="modal-footer" style="justify-content: center;">
            <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
            <input type="submit" class="btn btn-outline-primary btn-glow" value="Reset" onclick="return confirm('Are you sure you want to reset password?')">
          </div>
        </form>

      </div>
    </div>
</div>


{{-- ACC DEACTIVATION MODAL --}}
<div class="modal fade text-left" id="DisableAccModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white" style="">
          <label class="modal-title text-text-bold-600" id="myModalLabel33"> Deactivate Account Form</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form id="addRequisitionForm-edit" action="{{ route('deactivate-account') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control" name="userid_dec_acc" id="userid_dec_acc" required>

          <div class="modal-body">

            <div class="mt-3 mb-3" style="text-align: center; font-size: 16px;"> Deactivate <span id="nameTitle">  </span> Account ? </div>            

          </div>
          <div class="modal-footer" style="justify-content: center;">
            <input type="button" class="btn btn-outline-default" data-dismiss="modal" value="Close">
            <input type="submit" class="btn btn-outline-warning btn-glow" value="Deactivate" onclick="return confirm('Are you sure you want to deactivate this account?')">
          </div>
        </form>

      </div>
    </div>
</div>











@endsection
@section('scripts')

<script>

  function showmodal(modalid, url=0, hrefid=0)
  {  
      $('#'+modalid).modal('show');
  }

  function setResetPassId(id)
  {
      $('#userId').val(id);
  }

  function setDisableId(id)
  {
      // $('#nameTitle').innerHTML(name);
      $('#userid_dec_acc').val(id);
  }


  function setId(id, numb)
    {   $('.assign_').val('');   
        $('#user_id').val(id);      $('.assi').prop('checked', false); 

        //SET USER NAME
        $.get('{{url('get-user-by-id')}}?id=' +id, function(data)
        {
            //Set values
            $('#modal_title').html('Assign Role(s) To ' + data.name);
        });

        //function to check all assigned roles
        $.get('{{url('get-all-assigned-roles')}}?user_id=' +id, function(data)
        {   console.log(data);
            //Set values
            $.each(data, function(index, Role)
            { 
              if (Role.id != null) 
              {   
                 $('#role_'+Role.role_id).prop('checked', true);   
                 $('#assign_'+Role.role_id).val(Role.role_id);                  
              }
            });

            //HIDE AND SHOW ASSIGN OR UPDATE BTN
            if(data.length == 0){ $('#updateBtn').hide();     $('#assignBtn').show(); }
            else{ $('#updateBtn').show();     $('#assignBtn').hide(); }
        });
    }




    //CHOOSE ROLES TO ASSIGN TO USER
    $('.assi').each(function()
    {
       
       $(this).on('change', function()
       {
          var str = $(this).attr('id');
          var id = str.substring(5, 100);
          var value = $(this).attr('value');
          var $el = $('#assign_' + id);
          if ($(this).is(':checked'))
          {
               $el.val(value);
               return;  
          }
          $el.val('');

        });

    });


    $(function()
    {
        ('#assignBtn').click(function(){ $('#btnAction').val('Assign'); });
        ('#updateBtn').click(function(){ $('#btnAction').val('Update'); });
    });

    function setBtnAction(action){ $('#btnAction').val(action); }
    //////
</script>


{{-- <script src="{{ asset('datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script> --}}
{{-- <script src="{{ asset('datatables/datatables.min.js')}}"></script> --}}
<script src="{{ asset('bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
{{-- <script src="{{ asset('toastr/toastr.min.js')}}"></script> --}}
<script src="{{ asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js')}}"></script>

<script>
  $(function() 
  {
    $('.input-daterange').datepicker(
    {
      autoclose: true
    });
    $('.select2').select2();

    $("#reset_f").on( "click", function() 
    {
      $("#email_f").val()
      $("#email_f").val()
    });

     var selected = [];
     var table =$('#gtable').DataTable();
     $('.active-toggle').change(function() 
     {
        var id = $(this).attr('id');
        var isChecked = $(this).is(":checked");
        console.log(isChecked);
        $.get(
          '{{ route('users.alter-status') }}',
          { id: id, status: isChecked },
          function(data) {
            if(data=="enabled")
            {
              toastr.success('Enabled!', 'User Status');
            }
            if(data=="disabled")
            {
              toastr.error('Disabled!', 'User Status')
            }else
            {
              toastr.error(data, 'User Status');
            }


          }
        );

    });

  

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