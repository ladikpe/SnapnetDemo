<!DOCTYPE html>
<html>
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Palipro">
    <meta name="keywords" content="Palipro">
    <meta name="author" content="Palipro">
    <title>PaliPro - Document Management Solution</title>
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <!-- <link rel="apple-touch-icon" href="{{ asset('favicon-16x16.png') }}"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/app-assets/images/ico/favicon.icos') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
    <!-- END MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/simple-line-icons/style.css') }}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/style.css') }}">
    <!-- END Custom CSS-->

    <!-- OLD STYLES -->
    <link rel="stylesheet" href="{{ asset('jstree/dist/themes/default/style.min.css') }}" />
      @yield('stylesheets')
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/toastr.css') }}">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/fonts/meteocons/style.min.css') }}">

      <!-- BEGIN Page Level CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/plugins/animate/animate.css') }}">
      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/vendors.css') }}">
      <!-- END VENDOR CSS-->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


    <style>
      .preview
      {
        width: 60%;
        height: auto;
        margin: auto;
        background: #fff;
        font-size: 13px !important; padding: 75px 100px;
      }
      

       body 
      {
        background: #eee;
        display: block;
        font-family: arial, sans-serif;
      }
           
      

      .preview::after 
      {
        /*content: "Draft Copy";
        width: 5em;
        height:80px;
        opacity: 0.3;
        background: url(https://learnjamstack.com/logo.svg) no-repeat;
        position: absolute;
        top:40%;
        right:30%;
        font-size: 10em;
        transform: rotate(-45deg);*/


        /* Legacy vendor prefixes that you probably don't need... */

        /* Safari */
        -webkit-transform: rotate(-45deg);

        /* Firefox */
        -moz-transform: rotate(-45deg);

        /* IE */
        -ms-transform: rotate(-45deg);

        /* Opera */
        -o-transform: rotate(-45deg);
      }

    </style>
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
  </head>

  <body>
    <div class="preview">

        <a href="#" id="convertBtn" onclick="return false" class="btn btn-success btn-xs pull-right no-print" style="margin-left: 5px;">
            <i class="fa fa-download"></i> Download </a>

        <h2 style="text-align: center"> {{$workorder->name}} </h2>

        <div class="row" style=""> {!! $workorder->header !!} </div>


        <table class="table table-sm mt-3 mb-3" border="1">
          <thead>
            <tr style="background: #3b4e87; color: #fff">
              <th> # </th>  <th> PARTS and MATERIALS </th>  <th> Quantity </th>  <th> Unit Price </th>  <th> Line Total </th>
            </tr>
          </thead>
          <tbody> @php $i = 1; @endphp
            @forelse($details as $detail)
              @if($detail->type == 'Parts & Materials')
                <tr> 
                  <td>{{$i}}</td>
                  <td>{{$detail->item}}</td>
                  <td>{{$detail->colume_1}}</td>
                  <td>{{number_format($detail->colume_2, 2)}}</td>
                  <td>{{number_format($detail->line_total, 2)}}</td>
                </tr>
              @endif   @php $i++; @endphp
            @empty
            @endforelse
          </tbody>
        </table>


        <table class="table table-sm mt-3 mb-3" border="1">
          <thead>
            <tr style="background: #3b4e87; color: #fff">
              <th> # </th>  <th> SERVICE and LABOUR </th>  <th> Hour </th>  <th> Rate </th> <th> Line Total </th>
            </tr>
          </thead>
          <tbody> @php $j = 1; $line_total = 0;   $grand_total = 0; @endphp
            @forelse($details as $detail)
              @if($detail->type == 'Service & Labour')
                <tr> 
                  <td>{{$j}}</td>
                  <td>{{$detail->item}}</td>
                  <td>{{$detail->colume_1}}</td>
                  <td>{{number_format($detail->colume_2, 2)}}</td>
                  <td>{{number_format($detail->line_total, 2)}}</td>
                </tr>
              @endif   @php $j++; $line_total += $detail->line_total;  @endphp
            @empty
            @endforelse  
                @php $grand_total = (($workorder->vat * $line_total ) / 100); @endphp
              <tr style="text-align: right"> 
                <td> </td>
                <td>Subtotal</td>
                <td></td>
                <td></td>
                <td>{{number_format($line_total, 2)}}</td>
              </tr>
              <tr style="text-align: right"> 
                <td> </td>
                <td>VAT</td>
                <td></td>
                <td>{{$workorder->vat}}%</td>
                <td>{{number_format((($workorder->vat * $line_total ) / 100), 2)}}</td>
              </tr>
              <tr style="text-align: right"> 
                <td> </td>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>{{number_format(($grand_total + $line_total), 2)}}</td>
              </tr>
              <tr> 
                <td> </td>
                <td colspan="4">Net Order Value in words:</td>
              </tr>

          </tbody>
        </table>


        {!! $workorder->comment !!}        

           

        <textarea rows="10" class="form-control" name="workorder_content" id="workorder_content" style="display: none">{{ $workorder->header }} <table class="table table-sm mt-3 mb-3" border="1">
          <thead>
            <tr style="background: #3b4e87; color: #fff">
              <th> # </th>  <th> PARTS and MATERIALS </th>  <th> Quantity </th>  <th> Unit Price </th>  <th> Line Total </th>
            </tr>
          </thead>
          <tbody> @php $i = 1; @endphp
            @forelse($details as $detail)
              @if($detail->type == 'Parts & Materials')
                <tr> 
                  <td>{{$i}}</td>
                  <td>{{$detail->item}}</td>
                  <td>{{$detail->colume_1}}</td>
                  <td>{{number_format($detail->colume_2, 2)}}</td>
                  <td>{{number_format($detail->line_total, 2)}}</td>
                </tr>
              @endif   @php $i++; @endphp
            @empty
            @endforelse
          </tbody>
        </table>


        <table class="table table-sm mt-3 mb-3" border="1">
          <thead>
            <tr style="background: #3b4e87; color: #fff">
              <th> # </th>  <th> SERVICE and LABOUR </th>  <th> Hour </th>  <th> Rate </th> <th> Line Total </th>
            </tr>
          </thead>
          <tbody> @php $j = 1; $line_total = 0;   $grand_total = 0; @endphp
            @forelse($details as $detail)
              @if($detail->type == 'Service & Labour')
                <tr> 
                  <td>{{$j}}</td>
                  <td>{{$detail->item}}</td>
                  <td>{{$detail->colume_1}}</td>
                  <td>{{number_format($detail->colume_2, 2)}}</td>
                  <td>{{number_format($detail->line_total, 2)}}</td>
                </tr>
              @endif   @php $j++; $line_total += $detail->line_total;  @endphp
            @empty
            @endforelse  
                @php $grand_total = (($workorder->vat * $line_total ) / 100); @endphp

              <tr style="text-align: right"> 
                <td> </td>
                <td>Subtotal</td>
                <td></td>
                <td></td>
                <td>{{number_format($line_total, 2)}}</td>
              </tr>
              <tr style="text-align: right"> 
                <td> </td>
                <td>VAT</td>
                <td></td>
                <td>{{$workorder->vat}}%</td>
                <td>{{number_format((($workorder->vat * $line_total ) / 100), 2)}}</td>
              </tr>
              <tr style="text-align: right"> 
                <td> </td>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>{{number_format(($grand_total + $line_total), 2)}}</td>
              </tr>
              <tr> 
                <td> </td>
                <td colspan="4">Net Order Value in words:</td>
              </tr>

          </tbody>
        </table> {{ $workorder->comment }}</textarea>

    </div>
  </body>
</html>









  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{ asset('assets/app-assets/js/core/app-menu.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/core/app.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/customizer.js') }}"></script>

  <!-- OLD SCRIPTS -->
  {{-- <script src="http://cdn.ckeditor.com/4.6.1/full/ckeditor.js"></script> --}}
  <script src="{{ asset('assets/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('assets/app-assets/js/scripts/extensions/toastr.js') }}"></script>
<!-- BEGIN VENDOR JS-->
  <script src="{{ asset('assets/app-assets/vendors/js/vendors.min.js') }}"></script> 


  <script src="{{ asset('assets/app-assets/vendors/js/ui/jquery-ui.min.js') }}"></script>

  <script src="{{ asset('assets/convert-to-doc/FileSaver.js') }}"></script>
  <script src="{{ asset('assets/convert-to-doc/html-docx.js') }}"></script>


<script>
    document.getElementById('convertBtn').addEventListener('click', function(e)
    {   
        e.preventDefault();

        // for demo purposes only we are using below workaround with getDoc() and manual
        // HTML string preparation instead of simple calling the .getContent(). Becasue
        // .getContent() returns HTML string of the original document and not a modified
        // one whereas getDoc() returns realtime document - exactly what we need.
        var contentDocument = document.querySelector('#workorder_content');
        var content = '<!DOCTYPE html>' + contentDocument.value;
        var orientation = 'portrait';
        var converted = htmlDocx.asBlob(content, {orientation: orientation});

        saveAs(converted, 'New Workorder.docx');
    });

</script>