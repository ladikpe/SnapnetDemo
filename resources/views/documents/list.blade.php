@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.min.css')}}">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')

    
<div class="row">
  <div class="col-md-12">      
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <h4>Documents </h4>
          <div class="media d-flex">

          <div class="col-md-9">
            <table class="table table-stripped" id="">
              <thead>
                <tr>
                  <th>Document Name</th>
                  <th>Folder</th>
                  <th>Assigned User</th>
                  <th>Status</th>
                  <th>Uploaded At</th>
                  <th>Actions  <a href="{{route('documents.create')}}" class="pull-right" style="color:#202020 !important"><i class="la la-plus"></i></a></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($documents as $document)
                    <tr>
                      <td>{{ $document->filename }}</td>
                      <td>{{ $document->folder->nm?$document->folder->nm:'No Folder' }}</td>
                      <td>{{ $document->user->name }}</td>
                      <td>{{ getReviewStatus($document->id)?'In Review':'Not in Review' }}</td>
                      <td>{{date("F j, Y, g:i a", strtotime($document->created_at))}}</td>
                      <td><span  data-toggle="tooltip" title="View"><a href="{{ route('documents.view',$document->id) }}"  class="my-btn   btn-sm text-success"><i class="la la-eye-open" aria-hidden="true"></i></a></span>
                      </td>
                    </tr>
                  @endforeach

              </tbody>

            </table>
              {!! $documents->appends(Request::capture()->except('page'))->render() !!}
          </div>


          <div class="col-md-3">
            @if (Auth::user()->role_id!=3)
                <h3 class="panel-title">Filters</h3>
              
              <form class="" action="{{route('documents')}}" method="get" >

                <div class="form-group">
                  <label for="">Name Contains</label>

                  <input type="text" name="name_contains" class="form-control col-lg-6" id="name_contains" placeholder="" value="{{ request()->name_contains }}">

                </div>

                <div class="form-group">
                  <label for="">Folder</label>
                  <select id="role_f" class=" select2 form-control col-lg-6" name="folder_id" >
                    <option value="">Any</option>
                    @forelse ($folders as $folder)
                      <option value="{{$folder->id}}">{{$folder->name}}</option>
                    @empty
                      <option value="">No folders Avaiable</option>
                    @endforelse
                  </select>
                </div>

                <div class="form-group">
                  <label for="">Assigned User</label>
                  <select id="role_f" class=" select2 form-control col-lg-6" name="user_id" >
                    <option value="">Any</option>
                    @forelse ($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                    @empty
                      <option value="">No users Avaiable</option>
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
                  <label for="">Expires</label>
                  <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" name="expires_from" placeholder="From date" value="{{ request()->expires_from }}"/>
                    <span class="input-group-addon">to</span>
                    <input type="text" class="input-sm form-control" name="expires_to" placeholder="To date" value="{{ request()->expires_to }}"/>
                </div>
                </div>

                <button type="submit" class="btn btn-primary" >Filter</button>
                <button type="reset" class="btn btn-default pull-right" >Clear Filters</button>
              </form>
            @endif              
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
  <script type="text/javascript" src="{{ asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('.input-daterange').datepicker({
    autoclose: true
});

    var selected = [];
     var table =$('#gtable').DataTable();

    $('#gtable tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);

        // if ( index === -1 ) {
        //     selected.push( id );
        // } else {
        //     selected.splice( index, 1 );
        // }

        $(this).toggleClass('selected');
    });
} );
  </script>


@endsection
