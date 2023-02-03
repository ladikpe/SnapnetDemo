<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="AA&R-LEGAL">
    <meta name="keywords" content="AA&R-LEGAL">
    <meta name="author" content="AA&R-LEGAL">
    <title>AA&R-LEGAL - Document Management Solution </title>
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <!-- <link rel="apple-touch-icon" href="{{ asset('favicon-16x16.png') }}"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/app-assets/images/ico/favicon.icos') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->  
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->  
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/css/util.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/login-asset/css/main.css') }}">
    <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/toastr.css') }}">

  <style type="text/css">
    .font-size
    {
      font-size: 12px !important;
    }

    .mand
    {
      color: red;
    }
  </style>
</head>
<body style="background-color: #666666;">
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form" method="POST" action="{{ route('login') }}" novalidate>
          @csrf
          <span class="login100-form-title p-b-43">
            <img src="{{ asset('assets/images/aa&r-logo.png') }}" height="60" alt="logo">
            {{-- <img src="{{ asset('assets/images/logo.png') }}"> --}}
          </span>
          
          
          <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" tabindex="1" required data-validation-required-message="Please enter your Email." value="{{ old('email') }}" autofocus>
            <span class="focus-input100"></span>            <span class="label-input100">Email</span>
          </div>
          
          
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100 {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" tabindex="2" required data-validation-required-message="Please enter valid passwords.">
            <span class="focus-input100"></span>            <span class="label-input100">Password</span>
          </div>

          <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div class="contact100-form-checkbox">
              <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
              <label class="label-checkbox100" for="ckb1"> Remember me </label>
            </div>

            <div>
              <a href="#" data-toggle="modal" data-target="#ResetPasswordModel" class="txt1"> Forgot Password ? </a>
            </div>
          </div>
      

          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn"> Login </button>
          </div>
      

          <div class="container-login100-form-btn mt-3">
            <button type="button" class="login100-form-btn" style="background: #ddd; color: teal;" data-toggle="modal" data-target="#requestModel"> Raise a Request </button>
          </div>
          
          {{-- <div class="text-center p-t-46 p-b-20">
            <span class="txt2"> 
              <a href="{{ route('show.login') }}" class="btn btn-default btn-block btn-lg"><i class="ft-unlock"></i> Vendor Login</a> 
            </span>
          </div> --}}

          <!-- <div class="login100-form-social flex-c-m">
            <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
              <i class="fa fa-facebook-f" aria-hidden="true"></i>
            </a>

            <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
          </div> -->
        </form>

        <div class="login100-more" style="background-image: url({{ asset('assets/images/login-bg.jpg') }});">
        </div>
      </div>
    </div>
  </div>













  {{-- Reset Password MODAL --}}
  <div class="modal fade text-left" id="ResetPasswordModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary white" style="">
            <label class="modal-title text-text-bold-600 text-light" id="myModalLabel33"> Password Reset Form</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <form id="" action="{{ url('reset-password') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" class="form-control" name="userId" id="userId" required>

            <div class="modal-body">

              <div class="mt-3 mb-3" style="text-align: center; font-size: 16px;"> Reset Password ? </div> 


              <div class="form-group row">

                  <div class="col-md-12">
                      <label for="email_reset" class="col-form-label"> Email </label>
                      <fieldset class="form-group">
                          <input type="email" class="form-control" name="email" id="email_reset" required>
                      </fieldset>
                  </div>
              </div>           

            </div>
            <div class="modal-footer" style="justify-content: center;">
              <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
              <input type="submit" class="btn btn-outline-primary btn-glow" value="Reset" onclick="return confirm('Are you sure you want to reset password?')">
            </div>
          </form>

        </div>
      </div>
  </div>
  






    {{-- New External Request MODAL --}}
    <div class="modal fade text-left" id="requestModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" 
            aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 55% !important;">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600 text-light" id="myModalLabel33">New Request Form</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>
      
            <form id="addRequestForm" action="{{ url('store-external-requests') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="_id" required>
      
              <div class="modal-body">
      
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name" class="col-form-label font-size"> Fullname <i class="mand">*</i> </label>
                        <input type="text" placeholder="Fullname" class="form-control font-size" name="name" id="name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="col-form-label font-size"> Email <i class="mand">*</i> </label>
                        <input type="email" placeholder="Your Email" class="form-control font-size" name="email" id="email" required>
                    </div>
                </div>
      
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="phone" class="col-form-label font-size"> Phone </label>
                        <input type="text" placeholder="Phone" class="form-control font-size" name="phone" id="phone">
                    </div>

                    <div class="col-md-6">
                        <label for="organization" class="col-form-label font-size"> Organization <i class="mand">*</i> </label>
                        <input type="text" placeholder="Organization" class="form-control font-size" name="organization" id="organization" required>
                    </div>
                </div>
      
                <div class="form-group row">
      
                    <div class="col-md-12">
                        <label for="purpose" class="col-form-label font-size"> Purpose / Description <i class="mand">*</i> </label>
                        <fieldset class="form-group">
                            <textarea class="form-control" cols="30" rows="2" name="purpose" id="purpose" required></textarea>
                        </fieldset>
                    </div>
                </div>
                
      
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm font-size" value="Submit New Request" onclick="return confirm('Are you sure you want to submit?')">
                <input type="button" class="btn btn-outline-warning btn-sm font-size" data-dismiss="modal" value="Close">
              </div>
            </form>
      
          </div>
        </div>
    </div>


  

  
  
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('assets/login-asset/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('assets/login-asset/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('assets/login-asset/js/main.js') }}"></script>

  <script src="{{ asset('assets/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/extensions/toastr.js') }}"></script>
  <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>



  <script>
         CKEDITOR.replace( 'purpose' , 
          {
            toolbar: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'forms', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
           
            // { name: 'basicstyles', groups: [  ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            { name: 'insert', items: [ 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Styles', 'Format', 'Font', 'FontSize'  ] },
          
            // { name: 'styles', items: [] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            { name: 'others', items: [ '-' ] }
            ]

          }).on('cut copy paste',function(e){e.cancel();});

      CKEDITOR.config.extraPlugins = "base64image";
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

</body>
</html>