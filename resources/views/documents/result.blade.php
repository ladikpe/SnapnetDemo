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
            <h4><span class="fa fa-search" aria-hidden="true"></span>&nbsp;Documents Search&nbsp;&nbsp;<small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">
            <a href="{{route('documents.create')}}" class="btn btn-primary create">Create</a>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Documents/Search</li>
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
                <h3 class="panel-title">Documents </h3>
              </div>

              <div class="panel-body">
            <table class="table table-stripped" id="gtable">
              <thead>
                <tr>
                  <th>Document Name</th>
                  <th>Folder</th>
                  <th>Assigned User</th>
                  <th>Status</th>
                  <th>Uploaded At</th>
                  <th>Actions</th>
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
                      <td><span  data-toggle="tooltip" title="View"><a href="{{ route('documents.view',$document->id) }}"  class="my-btn   btn-sm text-success"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></a></span>
            </td>

                    </tr>
                  @endforeach

              </tbody>

            </table>
          </div>
        </div>

        <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Contracts </h3>
              </div>

              <div class="panel-body">
            <table class="table table-stripped" id="gtable">
              <thead>
                <tr>
                  <th>Contract Name</th>
                  <th>Created By</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($contracts as $contract)
                    <tr>
                      <td>{{ $contract->name }}</td>
                      <td>{{ $contract->user->name }}</td>
                      <td>{{$contract->status==0 ?'In Review':'Approved' }}</td>
                      <td>{{date("F j, Y, g:i a", strtotime($contract->created_at))}}</td>
                      <td><span  data-toggle="tooltip" title="View"><a href="{{ url('contracts/show/'.$contract->id) }}"  class="my-btn   btn-sm text-success"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></a></span>
                      </td>

                    </tr>
                  @endforeach

              </tbody>

            </table>
          </div>
        </div>


          </div>
          
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
