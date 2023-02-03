@extends('layouts.app')
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('bootstrap-toggle-master/css/bootstrap-toggle.min.css')}}">
  <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css')}}">
@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-forward" aria-hidden="true"></span>Workflow Details<small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">
            <a href="{{route('workflows.create')}}" class="btn btn-primary  create">Create</a>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/WorkFlow/WorkFlow Details</li>
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
                <h3 class="panel-title">{{$workflow->name}} Info</h3>
              </div>

              <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">Name: {{$workflow->name}}</li>
              <li class="list-group-item"> Created At: {{$workflow->created_at}}</li>
              <li class="list-group-item"> Stages in Workflow: {{$workflow->stages->count()}}</li>
              <li class="list-group-item"><input type="checkbox" class="active-toggle" id="{{$workflow->id}}" {{$workflow->status==1?'checked':''}} data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></li>

            </ul>
          </div>
          <div class="panel-footer">
            <a href="{{ route('workflows.edit',$workflow->id) }}" class="btn btn-primary">
                Edit Workflow
            </a>

          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">{{$workflow->name}}  Stages</h3>
          </div>

          <div class="panel-body">
        <ul class="list-group">
          @forelse ($workflow->stages as $stage)
          <li class="list-group-item"><strong>Name:</strong> {{$stage->name}}</li>
          <li class="list-group-item"><strong>User:</strong> {{$stage->user->name}}</li>
          <li class="list-group-item"><strong>Position:</strong> {{$stage->position}}</li>
          <br>
          @empty
          There are no stages in this workflow
          @endforelse


        </ul>
      </div>
    </div>


          </div>
          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Support</h3>
              </div>

              <div class="panel-body">
                Need help? Email us at support@snapnet.com.ng
              </div>
            </div>
          </div>
          </div>



      </div>
    </section>
@endsection
@section('scripts')
  <script type="text/javascript" src="{{ asset('bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('toastr/toastr.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('.active-toggle').change(function() {
      var id = $(this).attr('id');
       var isChecked = $(this).is(":checked");
       console.log(isChecked);
       $.get(
         '{{ route('workflows.alter-status') }}',
         { id: id, status: isChecked },
         function(data) {
           if(data=="enabled"){
             toastr.success('Enabled!', 'Workflow Status');
           }else{
             toastr.error('Disabled!', 'Workflow Status')
           }


         }
       );

   });
 });
</script>

@endsection
