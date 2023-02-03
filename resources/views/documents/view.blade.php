@extends('layouts.app')
@section('stylesheets')

@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-11">
            <h4><span class="fa fa-file" aria-hidden="true"></span>&nbsp;Documents Details&nbsp;<small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-1">
            <a href="{{route('documents.create')}}" class="btn btn-primary  create">Create</a>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Documents/Document Details</li>
        </ol>
      </div>
    </section>

    <section id="main" style="min-height:480px;">
      <div class="container">
        <div class="row">
`
          <div class="col-md-9">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                    {{ session('success') }}
                </div>
            @endif
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Document Info</h3>
              </div>

              <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">Name: {{$document->filename}}</li>
              <li class="list-group-item"> Created At: {{$document->created_at}}</li>
              <li class="list-group-item"> Folder: {{$document->folder->nm}}</li>
              <li class="list-group-item"> Expires: {{$document->expires?$document->expires:'false'}}</li>
              @if ($document->path!='')
              <li class="list-group-item">

                  <div class="btn-group" role="group" aria-label="...">
                    <form class="" action="{{ route('view') }}" method="post" target="_blank">
                      {{ csrf_field() }}
                      <button class="btn btn-primary" type="submit" name="button" value="{{ $document->id }}"><i class="fa fa-eye">View</i></button>
                    </form>
                    <form class="" action="{{ route('download') }}" method="post" target="_blank">
                      {{ csrf_field() }}
                      <button class="btn btn-primary" type="" name="button" value="{{ $document->id }}"><i class="fa fa-download">Download</i></button>
                    </form>

                </div>



              </li>
            @endif
            </ul>
          </div>

        </div>
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title"> Group Access</h3>
          </div>

          <div class="panel-body">
        {{-- <ul class="list-group">
          @forelse ($group->users as $user)
          <li class="list-group-item">{{$user->name}}</li>
          @empty
          There are no users in this group
          @endforelse


        </ul> --}}
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading main-color-bg">
        <h3 class="panel-title">Review History </h3>
      </div>

      <div class="panel-body">
        {{ $document->workflow->name }}
        @php
          $i=1;
          $current_review;
        @endphp
    <table class="table table-stripped" >
      <thead>
        <tr>
          <th>No</th>
          <th>Stage</th>
          <th>Current</th>
          <th>Status</th>
          <th>Approver</th>
          <th>Comment</th>
          <th>Reviewer</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($document->workflow->stages as $stage)
            <tr>
              <td>{{ $i }}</td>
              <td>{{ $stage->name }}</td>
              @php
              $review=getDocumentReview($document->id,$stage->id);
              @endphp
              @if ($review)

              @if ($review->status==0)
                @php
                  $current_review=$review;
                @endphp
                <td>{!! '<span class="label label-primary">Current</span>' !!}</td>
              <td>{{ 'Pending' }}</td>
              <td></td>
              <td></td>
              <td>{{ $stage->user->name }}</td>
            @elseif ($review->status==1)
                <td></td>
                <td>{{ 'Approved' }}</td>
                <td>{{ $stage->user->name }}</td>
                <td>{{ $review->comment }}</td>
                <td>{{ $stage->user->name }}</td>

              @elseif ($review->status==2)
                  <td></td>
                  <td>{{ 'Rejected' }}</td>
                  <td>{{ $stage->user->name }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $stage->user->name }}</td>
              @endif
              @else
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $stage->user->name }}</td>
              @endif


            </tr>
            @php
              $i++;
            @endphp
          @endforeach

      </tbody>

    </table>

  </div>
</div>


          </div>
          <div class="col-md-3">

          </div>
          </div>



      </div>
    </section>
@endsection
@section('scripts')



@endsection
