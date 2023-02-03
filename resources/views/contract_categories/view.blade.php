@extends('layouts.app')
@section('stylesheets')

@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-object-group" aria-hidden="true"></span>&nbsp;Contract Categories Details<small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">
            <a href="{{route('contract_categories.create')}}" class="btn btn-primary create">Create</a>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Contract Categories/Contract Categories Details</li>
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
                <h3 class="panel-title">{{$contract_category->name}} Contract Category Info</h3>
              </div>

              <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">Name: {{$contract_category->name}}</li>
              <li class="list-group-item"> Created At: {{$contract_category->created_at}}</li>
              <li class="list-group-item"> Workflow: {{$contract_category->workflow->name}}</li>

            </ul>
          </div>
          <div class="panel-footer">
            <a href="{{ route('contract_categories.edit',$contract_category->id) }}" class="btn btn-primary">
                Edit Contract Category
            </a>

          </div>
        </div>
        v>
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
