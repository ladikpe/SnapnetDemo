@extends('layouts.app')
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Profile <small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">User/Profile</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">

          <div class="col-md-8">
            <!-- Website Overview -->



              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">User Details</h3>
                </div>

                <div class="panel-body">

                  @if (session('error'))
                          <div class="alert alert-danger">
                              {{ session('error') }}
                          </div>
                      @endif
                          @if (session('success'))
                              <div class="alert alert-success">
                                  {{ session('success') }}
                              </div>
                          @endif
                          <form class="form-horizontal" method="POST" action="{{ route('users.updateProfile') }}">
                            {{ csrf_field() }}
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                  </div>

                </div>
                <div class="panel-footer">
                  <div class="form-group">

                                   <button type="submit" class="btn btn-primary">
                                       Change Password
                                   </button>

                           </div>
                </div>
              </form>
                </div>





              <!-- Latest Users -->

          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Change Password</h3>
              </div>

              <div class="panel-body">
                @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success-pass'))
                            <div class="alert alert-success">
                                {{ session('success-pass') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('users.changePassword') }}">
                          {{ csrf_field() }}
              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                  <label for="current-password" class="control-label">Current password</label>
                  <input id="current-password" type="password" class="form-control" name="current-password" required>
                  @if ($errors->has('current-password'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('current-password') }}</strong>
                                      </span>
                                  @endif
                </div>
                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                  <label for="new-password" class="control-label">New password</label>
                  <input id="new-password" type="password" class="form-control" name="new-password" required>
                  @if ($errors->has('new-password'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('new-password') }}</strong>
                                      </span>
                                  @endif
                </div>
                <div class="form-group">
                  <label for="new-password-confirm" class="control-label">Confirm New Password</label>
                  <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                  {{-- <p class="help-block">Help text here.</p> --}}
                </div>

              </div>
              <div class="panel-footer">
                <div class="form-group">

                                 <button type="submit" class="btn btn-primary">
                                     Change Password
                                 </button>

                         </div>
              </div>
            </form>
              </div>
          </div>
          </div>



      </div>
    </section>
@endsection
