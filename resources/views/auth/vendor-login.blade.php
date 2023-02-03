<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Pali365">
    <meta name="keywords" content="Pali365">
    <meta name="author" content="Pali365">
    <title>Pali365</title>
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
</head>
<body style="background-color: #666666;">
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form" method="POST" action="{{ route('vendor.login') }}" novalidate>
          @csrf
          <span class="login100-form-title p-b-43">
            <img src="{{ asset('assets/images/logo.png') }}">
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
              <a href="{{ route('password.request') }}" class="txt1"> Forgot Password? </a>
            </div>
          </div>
      

          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn"> Login </button>
          </div>
          
          <div class="text-center p-t-46 p-b-20">

            <span class="txt2"> Don't have an account? </span>

              <a href="{{ route('vendor-registration') }}" class="btn btn-default btn-block btn-lg"><i class="ft-unlock"></i> Register</a> 
          </div>

          <!-- <div class="login100-form-social flex-c-m">
            <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
              <i class="fa fa-facebook-f" aria-hidden="true"></i>
            </a>

            <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
          </div> -->
        </form>

        <div class="login100-more" style="background-image: url({{ asset('assets/images/Reg_1.jpg') }});">
        </div>
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

</body>
</html>









