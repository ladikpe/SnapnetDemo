@extends('layouts.app')
@section('stylesheets')

@section('content')



    
<div class="row">

    

                
    <div class="col-md-12">

        <form id="userForms" action="{{route('save-change-password')}}" enctype="multipart/form-data" method="POST">  @csrf
            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 col-sm-12 offset-col-4"> </div>

                <div class="col-lg-4 col-md-6 col-sm-12 offset-col-4">
                    <div class="card">

                      @if(session('success'))
                          <div class="alert alert-success alert-dismissible fade show pull-right" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              <span id="" style="text-transform: initial;"> {{session('success')}} </span>
                          </div>
                      @elseif(session('error'))
                          <div class="alert alert-danger alert-dismissible fade show pull-right" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              <span id="" style="text-transform: initial;"> {{session('error')}} </span>
                          </div>
                      @endif

                        <h4 class="card-header card-title mt-0">Change your password</h4>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="current_password"> Current Password</label>
                                        <input type="password" class="form-control" name="current_password" id="current_password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary pull-right mt-2" onmouseenter="checkPassword()" onclick="return confirm('Confirm you are about to change your password ?')">Update Password</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 offset-col-4"> </div>
            </div>
        </form>

    </div>

</div>





   

   
   
@endsection

@section('scripts')

    <script>
        function checkPassword()
        {
            $(function()
            {
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();

                if(password !== confirm_password)
                {  
                    alert('Sorry, you have a new password mis match !');
                }
            });
        }
    </script>



    @if(Session::has('success'))
        <script>
            $(function() 
            {
                toastr.success('{{session('success')}}', {timeOut:50000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function() 
            {
                toastr.error('{{session('error')}}', {timeOut:50000});
            });
        </script>
    @endif   
@endsection
