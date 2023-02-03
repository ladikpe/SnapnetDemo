<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Pali365">
  <meta name="keywords" content="Pali365">
  <meta name="author" content="Pali365">
  <title>AA&R-LEGAL - Document Management Solution</title>
  <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
  <!-- <link rel="apple-touch-icon" href="{{ asset('favicon-16x16.png') }}"> -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/app-assets/images/ico/favicon.icos') }}">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/weather-icons/climacons.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/meteocons/style.css') }}">
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/charts/morris.css') }}"> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/charts/chartist.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/charts/chartist-plugin-tooltip.css') }}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/colors/palette-gradient.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/simple-line-icons/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/timeline.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/dashboard-ecommerce.css') }}">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/style.css') }}">
  <!-- END Custom CSS-->

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/raty/jquery.raty.css') }}">
  <!-- END VENDOR CSS-->


  <!-- OLD STYLES -->
  <link rel="stylesheet" href="{{ asset('jstree/dist/themes/default/style.min.css') }}" />
    @yield('stylesheets')
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/toastr.css') }}">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/line-awesome/css/line-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/meteocons/style.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/rateyo.min.css') }}">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css"> -->
 
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/datedropper.min.css') }}">


  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/plugins/forms/checkboxes-radios.css') }}">
  <!-- END Page Level CSS-->


    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/plugins/animate/animate.css') }}">
    <!-- END Page Level CSS-->
   <!-- Include SmartWizard CSS -->
   <link rel="stylesheet" href="{{ asset('assets/smartwizard/dist/css/smart_wizard_all.min.css') }}" />

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/sweetalert.css') }}">
    <!-- END VENDOR CSS-->


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/js/gallery/photo-swipe/photoswipe.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/users.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/timeline.css') }}">

    {{-- DATATABLE --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/datatable.css') }}"> --}}


  <style>
    *
    {
      font-size: 13px;
    }

    .no-pad
    {
      padding: 0px !important;
    }
    .mand
    {
      color: red;
    }

    .a-link
    {
        color: #0c199c !important;
    }



    fieldset.scheduler-border
    {
      border: 1px groove rgb(255 255 255 / 50%) !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #ddd;
      box-shadow:  0px 0px 0px 0px #ddd;
    }

    legend.scheduler-border
    {
      font-size: 1.2em !important;
      font-weight: lighter !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
    }


    .thead-bg
    {
      background: #eeeeee !important;
    }

    a.disabled 
    {
        pointer-events: none;
        color: #ccc;
    }


    .card-border
    {
      border-radius:0px 0px 10px 10px;
      border: #aaa thin dotted;
      border-top: none;
      padding-top: 0px;
    }


    .modal fade text-left
    {
        background: #fff !important;
    }

    .modal-title
    {
      color: #fff !important;
    }


    .container 
    {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 22px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* Hide the browser's default radio button */
    .container input 
    {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark 
    {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #ddd;
      border-radius: 10%;
      box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark 
    {
      background-color: #ccc;
      box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark 
    {
      background-color: #E97451;
      box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after 
    {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after 
    {
      display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after 
    {
      top: 9px;
      left: 9px;
      width: 8px;
      height: 8px;
      border-radius: 10%;
      background: white;
    }

    .modal-content
    {
      box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);             /*box-shadow: 0px 1px 20px 1px rgb(30 159 242 / 60%);*/
    }

    .modal fade text-left
    {
      background: #fff !important;
    }

    .fieldset.scheduler-border
    {
      border: 2px groove #fff !important;
      border-radius: 6px;
      box-shadow: 0px 1px 20px 1px rgb(70 70 70 / 30%);
    }

    .no-pad
    {
      padding: 0px;
    }
    .no-pad-left
    {
      padding-left: 0px;
    }
    .no-pad-right
    {
      padding-right: 0px;
    }

    .pad-left
    {
      padding-left: 60px;
    }
    .pad-right
    {
      padding-right: 15px;
    }
  </style>
</head>



<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-left" style="min-height:30px">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
            <a class="navbar-brand" href="#">
              <img class="brand-logo" alt="PALIPRO-logo" src="{{ asset('assets/images/logo.png') }}" style="margin-left:20px; width:50%">
              
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          
          <ul class="nav navbar-nav float-right">


          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- ////////////////////////////////////////////////////////////////////////////-->




  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
  role="navigation" data-menu="menu-wrapper" style="background:#318CE7;">   {{-- 5D8AA8 --}}  
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" style="font-weight:lighter !important;">

        
      </ul>


    </div>
  </div>

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        

        

           @yield('content')



      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->


  



  <footer class="footer footer-static footer-dark navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} 
          <a class="text-bold-800 grey darken-2" href="#" target="_blank"> </a>, All rights reserved. </span> 
      <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Powered By <i class="la la-power"></i> 
        <img src="{{ asset('assets/images/logo-white.png') }}" style="width: 20%"> </span>
    </p>
  </footer>


  
  <!-- BEGIN VENDOR JS-->


  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ asset('assets/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
  <script src="{{ asset('assets/app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/vendors/js/charts/chartist.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js') }}"></script>
  {{-- <script src="{{ asset('assets/app-assets/vendors/js/charts/raphael-min.js') }}"></script> --}}
  {{-- <script src="{{ asset('assets/app-assets/vendors/js/charts/morris.min.js') }}"></script> --}}
  <script src="{{ asset('assets/app-assets/vendors/js/timeline/horizontal-timeline.js') }}"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{ asset('assets/app-assets/js/core/app-menu.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/core/app.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/customizer.js') }}"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{ asset('assets/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
  <!-- END PAGE LEVEL JS-->

  <!-- OLD SCRIPTS -->
  {{-- <script src="http://cdn.ckeditor.com/4.6.1/full/ckeditor.js"></script> --}}
  <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('assets/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/extensions/toastr.js') }}"></script>

  <script src="{{ asset('assets/app-assets/js/scripts/extensions/rating.js') }}"></script>

  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ asset('assets/app-assets/vendors/js/extensions/jquery.raty.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/modal/components-modal.js') }}"></script>
  <!-- END PAGE VENDOR JS-->
<!-- BEGIN VENDOR JS-->
  <script src="{{ asset('assets/app-assets/vendors/js/vendors.min.js') }}"></script> 

  <script src="{{ asset('assets/app-assets/js/rateyo.min.js') }}"></script>

  <script src="{{ asset('assets/app-assets/vendors/js/ui/jquery-ui.min.js') }}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script> -->

  <script src="{{ asset('assets/app-assets/vendors/js/extensions/datedropper.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/extensions/date-time-dropper.js') }}"></script>

  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{ asset('assets/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/forms/checkbox-radio.js') }}"></script>
  <!-- END PAGE LEVEL JS-->


  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{ asset('assets/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/modal/components-modal.js') }}"></script>
  <!-- END PAGE LEVEL JS-->

  <!-- Include SmartWizard JavaScript source -->
  <script src="{{ asset('assets/smartwizard/dist/js/jquery.smartWizard.min.js') }}"></script>


  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
  <!-- END PAGE VENDOR JS-->


  {{-- DATATABLE --}}
  <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/tables/datatables/datatable-basic.js') }}"></script>
  {{-- <script src="{{ asset('assets/app-assets/js/datatable.js') }}"></script> --}}
  <script src="{{ asset('assets/app-assets/js/scripts/animation/animation.js') }}"></script>


<script>
  //smart wizard
  $(function()
  {
  // Smart Wizard
  $('#smartwizard').smartWizard(
  {
  selected: 0, // Initial selected step, 0 = first step
  theme: 'dots', // theme for the wizard, related css need to include for other than default theme
  justified: true, // Nav menu justification. true/false
  darkMode:false, // Enable/disable Dark Mode if the theme supports. true/false
  autoAdjustHeight: true, // Automatically adjust content height
  cycleSteps: false, // Allows to cycle the navigation of steps
  backButtonSupport: true, // Enable the back button support
  enableURLhash: true, // Enable selection of the step based on url hash
  transition: {
  animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
  speed: '400', // Transion animation speed
  easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
  },
  toolbarSettings: {
  toolbarPosition: 'bottom', // none, top, bottom, both
  toolbarButtonPosition: 'right', // left, right, center
  showNextButton: true, // show/hide a Next button
  showPreviousButton: true, // show/hide a Previous button
  toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
  },
  anchorSettings: {
  anchorClickable: true, // Enable/Disable anchor navigation
  enableAllAnchors: true, // Activates all anchors clickable all times
  markDoneStep: true, // Add done state on navigation
  markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
  removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
  enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
  },
  keyboardSettings: {
  keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
  keyLeft: [37], // Left key code
  keyRight: [39] // Right key code
  },
  lang: { // Language variables for button
  next: 'Next',
  previous: 'Previous'
  },
  disabledSteps: [], // Array Steps disabled
  errorSteps: [], // Highlight step with errors
  hiddenSteps: [] // Hidden steps
  });

  });
  
  </script>

     @yield('scripts')

     
</body>
</html>
