@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
@endsection
@section('content')

    
<div class="row">
  <div class="col-md-12">      
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <h4>Documents </h4>
          <div class="media d-flex">

            

          <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                    {{ session('success') }}
                </div>
            @endif
            
            <table class="table table-stripped" id="">
              <thead>
                <tr>
                  <th>Filename</th>
                  <th>Current Stage</th>
                  <th>Workflow</th>
                  <th>Checkin User</th>
                  <th>Time in stage</th>
                  <th>My Reviews</th>
                  <th>Updated</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($reviews as $review)
                  <tr>
                    <td><a href="{{route('documents.view',$review->document->id)}}">{{$review->document->filename}}</a></td>
                    <td>{{$review->stage->name}}</td>
                    <td>{{$review->stage->workflow->name}}</td>
                    <td>{{$review->document->user->name}}</td>
                    <td>{{ $review->created_at==$review->updated_at?\Carbon\Carbon::parse($review->created_at)->diffForHumans():\Carbon\Carbon::parse($review->created_at)->diffForHumans($review->updated_at) }}</td>
                    <td> {!! $review->stage->user->id==Auth::user()->id?'<span class="label label-info"> Yes</span>' :'<span class="label label-warning"> No</span>'!!} </td>
                    <td>{{date("F j, Y, g:i a", strtotime($review->created_at))}}</td>
                    <td><a href="{{route('documents.showreview',$review->document->id)}}" title="Review"><i class="glyphicon glyphicon-pencil"></i></a> </td>
                  </tr>
                @empty
                  No pending review.
                @endforelse
              </tbody>
            </table>
              {!! $reviews->appends(Request::capture()->except('page'))->render() !!}
         
          </div>



          <div class="col-md-3">

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
  <script type="text/javascript">
  $(document).ready(function() {
    var selected = [];
     var table =$('#gtable').DataTable();

    $('#gtable tbody').on('click', 'tr', function () 
    {
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
