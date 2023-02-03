@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')

    
<div class="row">
  <div class="col-md-8">       
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <h4>View User </h4>
              <form method="Post" enctype="multipart/form-data">

              <div class="media d-flex">

                <div class="col-md-6" style="">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $user->name }}" disabled>
                  </div>

                    <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control group-multiple" name="role_id" disabled>
                      @foreach (Config::get('constants.roles') as $role)
                        <option value="{{$role['id']}}" {{ $user->role_id== $role['id']?'selected':''}}>{{ucfirst($role['name'])}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Select Signature</label>
                    <input type="File" class="form-control" name="signature" disabled>
                    {{-- <p class="help-block">Help text here.</p> --}}
                  </div>


                </div>

                <div class="col-md-6" style="">
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" id="name" name="email" value="{{ $user->email }}" disabled>
                  </div>

                  <div class="form-group">
                    <label for="department_id">Department</label>
                    <select class="form-control group-multiple" name="department_id" id="department_id" disabled>
                      @if($department) <option value="{{$department->id}}">{{$department->name}}</option> 
                      @else <option value=""></option> 
                      @endif
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Group</label>
                    <select class="form-control group-multiple" name="group_id[]" multiple disabled>
                      @forelse ($groups as $group)
                        <option value="{{$group->id}}" {{ $user->groups->contains('id',$group->id)?'selected':'' }}>{{$group->name}}</option>
                      @empty
                        <option value="">No Groups Created</option>
                      @endforelse
                    </select>
                    <!-- <p class="help-block">Help text here.</p> -->
                  </div>

                  <div class="panel-footer">
                    <button type="submit" class="btn btn-dark pull-right"> New User </button>

                    <button type="submit" class="btn btn-dark pull-right"> All User </button>
                  </div>

                </div> 

           
             
              </div>
              </form>
        </div>



        
        </div>



      </div>
    </div>



  <div class="col-md-4">       
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <h4>
                  <a href="{{ route('users') }}" class="btn round btn-outline-success btn-min-width btn-glow mr-1 mb-1">View All Users</a>
                  <a href="{{ route('users.create') }}" class="btn round btn-outline-success btn-min-width btn-glow mr-1 mb-1">Create New Users</a>
              </h4>
              <form method="Post" enctype="multipart/form-data">

              <div class="media d-flex">

              </div>
            </form>
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
