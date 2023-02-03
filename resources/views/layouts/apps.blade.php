<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AA&R-LEGAL - Document Management Solution</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    <script src="http://cdn.ckeditor.com/4.6.1/full/ckeditor.js"></script>
    <link rel="stylesheet" href="{{ asset('jstree/dist/themes/default/style.min.css') }}" />
    @yield('stylesheets')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" type="text/css" />

    <style>
      .panel-actions
      {    
        top:15%;
        right: 30px;
        z-index: 1;
        transform: translate(0%, -50%);
        margin: auto;
      }
    .panel-heading-with-action 
    {   
      padding-bottom: 20px;    
    }
     
  </style>


  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" type="text/javascript"></script>    

</head>
<body style="font-family: 'Open Sans', sans-serif;">
  @guest
    @include('includes.login-header')
    @else
      @if (Auth::user()->role_id==1)
        @include('includes.header')
      @elseif (Auth::user()->role_id==2)
        @include('includes.admin-header')
         @elseif (Auth::user()->role_id==3)
        @include('includes.user-header')
      @else
        @include('includes.requisition-header')
      @endif

  @endguest


    @yield('content')

    <footer id="footer">
      <p>Copyright  &copy; {{date('Y')}} Snapnet Limited, </p>
    </footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts')
    <script type="text/javascript">
 //    $(function(){
 //      // console.log('hello');
 //      $(".dropdown-toggle").hover( function(event){
 //        $(this).stop( true ).fadeIn("fast");
 //        $(this).parent("li").toggleClass("open");
 //     });
 // });
    </script>


  </body>
</html>
