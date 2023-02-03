@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')

    
<form id="searchForm" action="{{route('users.save')}}" method="POST">
@csrf
<div class="row">
  <div class="col-md-8 offset-md-2">      
        <div class="card">
          <div class="card-content">
            <div class="card-body">
				      <h4>Create User</h4>
              <div class="media d-flex">

                <div class="col-md-6" style="">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                    @if ($errors->has('name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control group-multiple" name="role_id" required>
                      <option value=""></option>
                      @foreach ($roles as $role)
                        <option value="{{$role['id']}}">{{ucfirst($role['name'])}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="">Select Signature</label>
                    <input type="File" class="form-control" name="signature" >
                    {{-- <p class="help-block">Help text here.</p> --}}
                  </div>


                </div>

                <div class="col-md-6" style="">
                    <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" id="name" name="email" placeholder="">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="department_id">Department</label>
                    <select class="form-control group-multiple" name="department_id" id="department_id">
                      <option value=""></option>
                      @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{ucfirst($department->name)}}</option>
                      @endforeach
                    </select>
                  </div>

                  {{-- <div class="form-group">
                    <label for="">Group</label>
                    <select class="form-control group-multiple" name="group_id[]" multiple>
                      @forelse ($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                      @empty
                        <option value="">No Groups Created</option>
                      @endforelse
                    </select>
                    <!-- <p class="help-block">Help text here.</p> -->
                  </div> --}}

                  <div class="panel-footer" style="margin-top: 50px !important;">
                    <button type="submit" class="btn btn-primary pull-right"> Create User </button>
                  </div>

                </div> 

                  


              </div>

              <!-- Latest Users -->

          </div>
        
        </div>

      </div>
    </div>

</div>


@endsection
@section('scripts')
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
$(function() 
{
  $('.group-multiple').select2();
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
