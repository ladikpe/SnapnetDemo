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
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet"> -->
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
    <!-- END VENDOR CSS-->



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
    </style>
</head>



<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">


    <div class="app-content content">

        <div class="content-wrapper" style="">
            <div class="col-lg-8 offset-md-2" style="background: #fff">

                <div class="col-md-12" style="position: fixed; z-index: 1000; right: 20px">

                    <a href="#" id="convertBtn" onclick="return false" class="btn btn-success btn-xs pull-right no-print" style="margin-left: 5px; margin-right: 25px">
                        <i class="fa fa-download"></i> Download </a>

                    <textarea rows="10" class="form-control" name="comp_content" id="comp_content" style="display: none">{{ $purchase_order->contents }}</textarea>

                </div>

                <div id="preview" style="font-size: 18px!important;"> {!! $purchase_order->contents !!} </div>

            </div> <!-- end col -->
        </div> <!-- end row -->

    </div>




</body>
</html>
