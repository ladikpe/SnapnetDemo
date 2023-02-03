@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.min.css')}}">
@endsection
@section('content')



    
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
				      <h4>Groups</h4>
              <div class="media d-flex">

                
              <div class="col-md-9"> 

                <table class="table table-sm" id="gtable">
                  <thead class="thead-dark">
                    <tr>
                      <th>Name</th>
                      <th>Created At</th>
                      <th>No. of Users</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach ($groups as $group)
                    <tr>
                      <td>{{ $group->name }}</td>
                      <td>{{ $group->created_at }}</td>
                      <td><span class="badge">{{ $group->users_count }}</span></td>
                      <td><span  data-toggle="tooltip" title="Edit"><a  class="my-btn   btn-sm text-info" id="{{$group->id}}" href="{{ route('groups.edit',$group->id) }}"><i class="la la-pencil" aria-hidden="true"></i></a></span>
                          <span  data-toggle="tooltip" title="Delete"><a  id="{{$group->id}}" class="my-btn   btn-sm text-danger" onclick="deletesubject(this.id)"><i class="la la-trash" aria-hidden="true"></i></a></span>

                          <span  data-toggle="tooltip" title="View"><a href="{{ route('groups.view',$group->id) }}"  class="my-btn   btn-sm text-success"><i class="la la-eye-open" aria-hidden="true"></i></a></span>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                {!! $groups->appends(Request::capture()->except('page'))->render() !!}
                
              </div>

              <div class="col-md-3">
                  <form class="" action="{{route('groups')}}" method="get" >

                    <div class="form-group">
                      <label for="">Name Contains</label>

                      <input type="text" name="name_contains" class="form-control col-lg-6" id="email_t" placeholder="" value="{{ request()->name_contains }}">

                    </div>

                    <div class="form-group">
                      <label for="">Users</label>
                      <select class="select2 form-control" name="userftype">
                        <option value="or">OR</option>
                        <option value="and">AND</option>
                      </select> 
                      <br> <br>
                      <select id="role_f" class=" select2 form-control col-lg-6" name="user[]" multiple>
                        @forelse ($users as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                        @empty
                          <option value="">No Users Created</option>
                        @endforelse
                      </select>


                    </div>
                    <div class="form-group">
                      <label for="">Created At</label>
                      <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="created_from" placeholder="From date" value="{{ request()->created_from }}"/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="created_to" placeholder="To date" value="{{ request()->created_to }}"/>
                    </div>
                    </div>

                    <div class="form-group">
                      <label for="">Updated At</label>
                      <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="created_from" placeholder="From date" value="{{ request()->updated_from }}"/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="created_to" placeholder="To date" value="{{ request()->updated_to }}"/>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary" >Filter</button>
                    <button type="reset" class="btn btn-default pull-right" >Clear Filters</button>

                  </form>

              </div>


            </div>
            </div>
          </div>
        </div>
        </div>

      </div>
      

@endsection
@section('scripts')
  {{-- <script type="text/javascript" src="{{ asset('datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('datatables/datatables.min.js')}}"></script>
  <script src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('datepicker/bootstrap-datepicker.min.js')}}"></script>

  <script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('.input-daterange').datepicker({
    autoclose: true
});



} );
  </script>


@endsection
