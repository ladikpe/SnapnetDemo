@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-book" aria-hidden="true"></span>&nbsp; Audit Logs <small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Audit Logs</li>
        </ol>
      </div>
    </section>

    <section id="main" style="min-height:480px;">
      <div class="container">
        <div class="row">

          <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                    {{ session('success') }}
                </div>
            @endif
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Audit Logs</h3>
              </div>

              <div class="panel-body">
            <table class="table table-stripped" id="">
              <thead>
                <tr>
                  <th>Level</th>
                  <th>Audit Target</th>
                  {{-- <th>Target name</th>--}}
                  {{-- <th>Message</th> --}}
                  <th>User</th> 
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($auditlogs as $auditlog)
                  <tr>
                    {{-- <td><a href="{{route('documents.view',$review->document->id)}}">{{$review->document->filename}}</a></td> --}}
                    <td>{{$auditlog->level}}</td>
                   {{--  <td><a href="{{$auditlog->route=="reviews"?route('documents.showreview',$auditlog->auditable->document->id):route($auditlog->route.'.view',$auditlog->auditable->id)}}">{{ $auditlog->route=='documents'?$auditlog->auditable->filename:($auditlog->route=='reviews'?$auditlog->auditable->document->filename:'') }}</a></td>
                    <td>{{ $auditlog->route=='documents'?$auditlog->auditable->filename:($auditlog->route=='reviews'?$auditlog->auditable->document->filename:'') }}</td> --}}
                    <td>{{ $auditlog->message }}</td>
                    <td>{{ $auditlog->user->name}}</td>
                    <td>{{date("F j, Y, g:i a", strtotime($auditlog->created_at))}}</td>
                    <td><a href="{{route('auditlogs.view',$auditlog->id)}}" title="Details"><i class="glyphicon glyphicon-pencil"></i></a> </td>
                  </tr>
                @empty
                  No pending review.
                @endforelse

              </tbody>

            </table>
              {!! $auditlogs->appends(Request::capture()->except('page'))->render() !!}
          </div>
        </div>


          </div>
          {{-- <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Support</h3>
              </div>

              <div class="panel-body">
                Need help? Email us at support@snapnet.com.ng
              </div>
            </div>
          </div> --}}
          </div>



      </div>
    </section>
@endsection
@section('scripts')
  {{-- <script type="text/javascript" src="{{ asset('datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('datatables/datatables.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
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
