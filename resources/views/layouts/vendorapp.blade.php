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
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/app-assets/images/favicon-16x16.png') }}">
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
              <!-- <h3 class="brand-text">PALI365</h3> -->
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            {{-- <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li> --}}
            <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Settings</a>
              <ul class="mega-dropdown-menu dropdown-menu row">

                <li class="col-md-3 pull-left">
                  <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="la la-newspaper-o"></i> News</h6>
                  <div id="mega-menu-carousel-example">
                    <div>
                      <img class="rounded img-fluid mb-1" src="{{ asset('assets/app-assets/images/slider/slider-2.png') }}"
                      alt="First slide"><a class="news-title mb-0" href="#"></a>
                      <p class="news-content">
                        <span class="font-small-2">January 26, 2021</span>
                      </p>
                    </div>
                  </div>
                </li>


                <li class="col-md-5 pull-left">
                  <h6 class="dropdown-menu-header text-uppercase"><i class="la la-random"></i> Messages & Notifications</h6>
                  <ul class="drilldown-menu">
                    <li class="dropdown-menu-header">
                  <span class="notification-tag badge badge-default badge-danger float-right m-0">3 New</span>
                </li>
                <li class="scrollable-container media-list w-100 ps-container ps-theme-dark" data-ps-id="09e6161c-422e-c30f-5f20-0439881f8b48">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">You have new order!</h6>
                        <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading red darken-1">99% Server load</h6>
                        <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time>
                        </small>
                      </div>
                    </div>
                  </a>
                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                  </ul>
                </li>


                <li class="col-md-4 pull-left">
                  <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="la la-envelope-o"></i> Contact Us</h6>
                  <form class="form form-horizontal">
                    <div class="form-body">
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label" for="inputName1">Name</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <input class="form-control" type="text" id="inputName1" placeholder="John Doe">
                            <div class="form-control-position pl-1"><i class="la la-user"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label" for="inputEmail1">Email</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <input class="form-control" type="email" id="inputEmail1" placeholder="john@example.com">
                            <div class="form-control-position pl-1"><i class="la la-envelope-o"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label" for="inputMessage1">Message</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <textarea class="form-control" id="inputMessage1" rows="2" placeholder="Simple Textarea"></textarea>
                            <div class="form-control-position pl-1"><i class="la la-commenting-o"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 mb-1">
                          <button class="btn btn-info float-right" type="button"><i class="la la-paper-plane-o"></i> Send </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </li>

              </ul>
            </li> 

            <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i>
              <input class="input" type="text" class="form-control" placeholder="Search ..." name="q" value="{{ request()->q }}" style="border-color: none none #ddd none !important;"></a>
                          
                <div class="search-input">
                  {{-- <input class="input" type="text" placeholder="Search ..." name="q" value="{{ request()->q }}"> --}}
                  <!-- <button class="btn btn-default pull-left" type="submit"><i class="la la-search"></i></button> -->
                </div>
                
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">



            <li class="dropdown dropdown-notification nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="avatar avatar-online" style="margin-bottom: 4px">
                  <i class="ficon ft-mail"></i></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Messages</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
                </li>
                  {{--  <li class="scrollable-container media-list w-100">--}}
                  {{--     <a href="javascript:void(0)">--}}
                  {{--        <div class="media">--}}
                  {{--          <div class="media-left">--}}
                  {{--            <span class="avatar avatar-sm avatar-online rounded-circle">--}}
                  {{--               <img src="{{ asset('assets/app-assets/images/portrait/small/avatar-s-19.png') }}" alt="avatar"><i></i></span>--}}
                  {{--                 </div>--}}
                  {{--                  <div class="media-body">--}}
                  {{--                    <h6 class="media-heading">Margaret Govan</h6>--}}
                  {{--                     <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>--}}
                  {{--                        <small>--}}
                  {{--                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>--}}
                  {{--                        </small>--}}
                  {{--                      </div>--}}
                  {{--                    </div>--}}
                  {{--                  </a>--}}
                  {{--                </li>--}}
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
              </ul>
            </li>

            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="avatar avatar-online">
                  <img src="{{ asset('assets/images/wrench.png') }}" alt="avatar"><i></i></span>
              </a>
              {{-- @if(Auth::guard('vendor')->user()->roles->id == 1)
                <div class="dropdown-menu dropdown-menu-right">                  
                    <a class="dropdown-item" href="{{ route('roles.index') }}"><i class="la la-street-view"></i> Roles</a>
                    <a class="dropdown-item" href="{{ route('departments') }}"><i class="la la-suitcase"></i> Permissions</a>
                    <a class="dropdown-item" href="{{ route('departments') }}"><i class="la la-bank"></i> Departments</a>
                    <a class="dropdown-item" href="{{ route('groups') }}"><i class="la la-group"></i> Groups</a>
                    <a class="dropdown-item" href="{{ route('contract_categories') }}"><i class="la la-sitemap"></i> Contracts Categories</a>
                    <a class="dropdown-item" href="{{ route('workflows') }}"><i class="la la-tasks"></i> Workflows</a>
                </div>
              @endif --}}
            </li>


            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">{{ Auth::guard('vendor')->user()->name }} 
                  <span class="user-name text-bold-700"> 
                    {{ isActiveRoute('users.profile') }} </span>
                </span>
                <span class="avatar avatar-online">
                  <img src="{{ asset('assets/images/user1.png') }}" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile', Auth::guard('vendor')->user()->id) }}"><i class="la la-edit"></i> Edit Profile</a>
                <a class="dropdown-item" href="{{ route('reset-password-view') }}"><i class="la la-lock"></i> Reset Password</a>
                {{-- @if(Auth::guard('vendor')->user()->roles->id == 1)
                  <a class="dropdown-item" href="{{ route('users') }}"><i class="ft-users"></i> Users</a>
                @endif --}}
                {{-- <a class="dropdown-item" href="{{ route('vendor.index') }}"><i class="la la-registered"></i> Vendors</a> --}}

                {{--<a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>--}}
                {{--<a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>--}}
                {{-- <a class="dropdown-item" href="{{ route('folders') }}"><i class="la la-bank"></i> Folders</a> --}}
                {{-- <a class="dropdown-item" href="{{ route('departments') }}"><i class="la la-bank"></i> Tags</a> --}}
                {{-- <div class="dropdown-divider"></div>--}}
               <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"><i class="la la-power-off"> Logout</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
              </div>
            </li>




            <!-- <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">1</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Notifications</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                </li>
                <li class="scrollable-container media-list w-100">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">You have new order!</h6>
                        <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- //////////////////////////////////////////////////////////////////////////// -->




  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
  role="navigation" data-menu="menu-wrapper" style="background:#318CE7;">   {{-- 5D8AA8 --}}  
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" style="font-weight:lighter !important;">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">  <span><i class="la la-dashboard"></i>Dashboard</span> </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('profile', Auth::guard('vendor')->user()->id) }}">  <span><i class="la la-user"></i>Profile</span> </a>
        </li>

        {{-- <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span> <i class="la la-file-text"></i>Documents</span></a>
          @if(Auth::guard('vendor')->user()->roles->id == 2 || Auth::guard('vendor')->user()->roles->id == 3 || Auth::guard('vendor')->user()->roles->id == 4 || Auth::guard('vendor')->user()->id == 2)
            <ul class="dropdown-menu">
                @if(Auth::guard('vendor')->user()->roles->id == 2)
                  <li data-menu="">
                    <a class="dropdown-item" href="{{ route('requisitions.index') }}"> <i class="la la-book"></i> Requisitions </a> 
                  </li>
                @elseif(Auth::guard('vendor')->user()->roles->id == 3)
                  <li data-menu="">
                    <a class="dropdown-item" href="{{ route('assignments.index') }}"> <i class="la la-mail-forward"></i> Assignment </a> 
                  </li>
                @elseif(Auth::guard('vendor')->user()->roles->id == 4 || Auth::guard('vendor')->user()->id == 2)
                  <li data-menu="">
                    <a class="dropdown-item" href="{{ route('document-creations.index') }}"> <i class="la la-plus-circle"></i> Document Creation </a> 
                  </li>
                @endif
             <li data-menu=""><a class="dropdown-item" href="#"> </a> </li>
              <li data-menu=""><a class="dropdown-item" href="{{ route('documents.create') }}"> <i class="la la-plus"></i>Create</a> </li>
              <li data-menu=""><a class="dropdown-item" href="{{ route('documents') }}"> <i class="la la-list"></i>List</a> </li>
            </ul>
          @endif
        </li>
 --}}
        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span> <i class="la la-bullseye"></i>Bids</span></a>
          <ul class="dropdown-menu">
            {{-- <li data-menu=""><a class="dropdown-item" href="{{ route('bids.index') }}"> <i class="la la-fax"></i>Bids</a> </li> --}}
            <li data-menu=""><a class="dropdown-item" href="{{ route('vendor-bids.index') }}"> <i class="la la-fax"></i>Bids</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('submit-bids') }}"> <i class="la la-check-circle"></i>Submitted Bids</a> </li>
          </ul>
        </li>

        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span> <i class="la la-file"></i>Jobs</span></a>
          <ul class="dropdown-menu">
            {{-- <li data-menu=""><a class="dropdown-item" href="{{ route('bids.index') }}"> <i class="la la-fax"></i>Bids</a> </li> --}}
            <li data-menu=""><a class="dropdown-item" href="#"> <i class="la la-file-text-o"></i>Workorders</a> </li>
            <li data-menu=""><a class="dropdown-item" href="#"> <i class="la la-certificate"></i>Job Completion</a> </li>
          </ul>
        </li>

        {{-- <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span><i class="la la-paste"></i>Orders</span></a>
          <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{ route('purchase-template') }}"> <i class="la la-sticky-note"></i> Template - Purchase Order </a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('purchase-order-requisition') }}"> <i class="la la-pencil-square"></i> Requisition - Purchase Order </a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('purchase-order.index') }}"> <i class="la la-list"></i> List All - Purchase Order</a> </li>

            <li data-menu=""><a class="dropdown-item" href="#"> <i class="la la-sticky-note"></i> Service Order Template</a> </li>
            <li data-menu=""><a class="dropdown-item" href="#"> <i class="la la-pencil-square"></i> Service Order Requisition</a> </li>
            <li data-menu=""><a class="dropdown-item" href="#"> <i class="la la-list"></i> Create Service Order</a> </li>

            <li data-menu=""><a class="dropdown-item" href="{{ route('quotation.index') }}"> <i class="la la-file-text-o"></i> Quotation & Tender</a> </li>
          </ul>
        </li> --}}
        

        <li class="nav-item">
          <a class="nav-link" href="">  <span></span> </a>
        </li>

        {{-- <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span><i class="la la-refresh"></i>Reviews</span></a>
          <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{route('documents.reviews')}}"> <i class="la la-thumbs-o-up"></i> Document Reviews </a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('performance.index') }}"> <i class="la la-line-chart"></i> Performance Settings</a> 
            </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('requirements-and-filings.index') }}"> <i class="la la-cog"></i> Requirements & Filings</a> 
            </li>
          </ul>
        </li>

        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span><i class="la la-suitcase"></i>Contracts</span></a>
          <ul class="dropdown-menu">
            @if(Auth::guard('vendor')->user()->role_id == 5)
              <li data-menu=""><a class="dropdown-item" href="{{ url('contracts/requisitions') }}">
              <i class="la la-pencil-square"></i>Manager Requisitions </a> </li>
            @endif
            <li data-menu=""><a class="dropdown-item" href="{{ url('contracts/user_requisitions') }}">
            <i class="la la-pencil-square"></i>Contracts Requisitions</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ url('contract_approvals') }}">
            <i class="la la-check-circle"></i>Contracts Approvals</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ url('contracts') }}">
            <i class="la la-comment-o"></i>Contracts</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ url('performance/ratings') }}">
            <i class="la la-star-half-full"></i>View Rating</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ url('contracts/dashboard') }}">
            <i class="la la-signal"></i>Contracts Dashboard</a> </li>
            <li data-menu=""><a class="dropdown-item" href="{{ route('template.index') }}">
            <i class="la la-sticky-note"></i>Templates</a> </li>
          </ul>
        </li> --}}

        {{-- <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><span><i class="la la-registered"></i>Vendor</span></a>
          <ul class="dropdown-menu">
              <li data-menu=""><a class="dropdown-item" href="{{ route('vendor-registration') }}"><i class="la la-user-plus"></i> Vendor Registration </a> </li>
              <li data-menu=""><a class="dropdown-item" href="{{ route('vendor.index') }}"> <i class="la la-list"></i>List Vendors </a> </li>
              <li data-menu=""><a class="dropdown-item" href="{{ url('vendor-shortlist/1') }}"> <i class="la la-list"></i>Shortlist Vendors </a> </li>
          </ul>
        </li> --}}

                


{{--        <li class="nav-item">--}}
{{--          <a class="nav-link" href="#"> <span>Audit Logs</span> </a>--}}
{{--        </li>--}}

        <li class="nav-item" style="float: right">
          <a class="nav-link" href="https://support.snapnet.com.ng/PaliproAARlogin?email={{Auth::guard('vendor')->user()->email}}&name={{Auth::guard('vendor')->user()->name}}">
            <span><i class="la la-info"></i>Support  </span> </a>
        </li>

        
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
