@extends('layouts.app')
@section('stylesheets')

@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-object-group" aria-hidden="true"></span>&nbsp;Group Details<small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">
            <a href="{{route('groups.create')}}" class="btn btn-primary create">Create</a>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Groups/Group Details</li>
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
                <h3 class="panel-title">{{$group->name}} Group Info</h3>
              </div>

              <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">Name: {{$group->name}}</li>
              <li class="list-group-item"> Created At: {{$group->created_at}}</li>
              <li class="list-group-item"> Members in Group: {{$group->users->count()}}</li>

            </ul>
          </div>
          <div class="panel-footer">
            <a href="{{ route('groups.edit',$group->id) }}" class="btn btn-primary">
                Edit Group
            </a>

          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">{{$group->name}} Group Members</h3>
          </div>

          <div class="panel-body">
        <ul class="list-group">
          @forelse ($group->users as $user)
          <li class="list-group-item">{{$user->name}}</li>
          @empty
          There are no users in this group
          @endforelse


        </ul>
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
