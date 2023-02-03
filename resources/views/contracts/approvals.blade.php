{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <style type="text/css">
    .panel-actions{
      position: absolute;
    top:15%;
    right: 30px;
    z-index: 1;
    transform: translate(0%, -50%);
    margin: auto;
    }
   /* .panel-title {
    display: block;
    margin-top: 0px;
    margin-bottom: 0px;
    font-size: 18px;
    padding: 20px 30px;
}*/
  </style>
@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-file" aria-hidden="true"></span>&nbsp; Manage Contracts <small>
                   
            </small></h4>
          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>

      <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li>Home</li>
          <li class="active" id="indicator">Contracts</li>
        </ol>
      </div>
    </section>

    <section id="main"  style="min-height:480px;">
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
                <h3 class="panel-title">Contracts </h3>
                <div class="panel-actions">
                  <a href="{{url('contracts/new')}}" class="btn btn-primary" style="color:#000;background: #fff !important">Create New</a>
                </div>
              </div>e

              <div class="panel-body">
            <table class="table table-stripped" id="">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Created_By</th>
                  <th>Status</th>
                  <th>Uploaded At</th>
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
              {!! $contracts->appends(Request::capture()->except('page'))->render() !!}
          </div>
        </div>


          </div>
        
        </div>



      </div>
    </section>
@endsection

@section('scripts')

               
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}
<script type="text/javascript">
</script>
@endsection
