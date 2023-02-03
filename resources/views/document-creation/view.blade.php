<!DOCTYPE html>
<html>
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
      .body
      {
        width: 95%;
        margin: auto;
        background: #fff;
        font-size: 13px !important; padding: 75px 100px;
      }
      

       body 
      {
        background: #eee;
        display: block;
        font-family: arial, sans-serif;
        /*min-height: 300vh;
        position: relative;
        margin: 0;*/
      }

      /*body:before
      {
        content: "";
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        right: 0;
        background: url("{{ asset('assets/images/draft.png') }}");
      }*/
           
      

      .preview::after 
      {
        content: "Draft Copy";
        width: 5em;
        height:80px;
        opacity: 0.3;
        /*background: url(https://learnjamstack.com/logo.svg) no-repeat;*/
        position: absolute;
        top:40%;
        right:30%;
        font-size: 10em;
        transform: rotate(-45deg);


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

      .review::after 
      {
        content: "Reviewed Copy";
        width: 5em;
        height:80px;
        opacity: 0.3;
        /*background: url(https://learnjamstack.com/logo.svg) no-repeat;*/
        position: absolute;
        top:40%;
        right:30%;
        font-size: 10em;
        transform: rotate(-45deg);


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

      .approved::after 
      {
        content: "Final Copy";
        width: 5em;
        height:80px;
        opacity: 0.3;
        /*background: url(https://learnjamstack.com/logo.svg) no-repeat;*/
        position: absolute;
        top:40%;
        right:32%;
        font-size: 10em;
        transform: rotate(-45deg);


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

      .classification::after 
      {
        content: "Final Copy";
        width: 5em;
        height:80px;
        opacity: 0.3;
        /*background: url(https://learnjamstack.com/logo.svg) no-repeat;*/
        position: absolute;
        top:40%;
        right:30%;
        font-size: 10em;
        transform: rotate(-45deg);


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



      @media print
      {    
          .no-print, .no-print *
          {
              display: none !important;
          }
      }

    </style>

  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
  </head>

  <body>
    <div> 
      {{-- @if($position->position_id <= 2) class="preview body"
      @elseif($position->position_id == 3) class="review body"
      @elseif($position->position_id >= 5) class="approved body"
      @endif --}}

        <a href="#" id="convertBtn" onclick="return false" class="btn btn-success btn-xs pull-right btn-sm no-print" style="margin-left: 5px;">
            <i class="la la-download"></i> Download to Word  </a>

        <button type="button" id="prtotBtn" class="btn btn-primary pull-right btn-sm no-print" onclick="window.print(); return false;"><i class="la la-print"></i> Download in PDF </button>

        {{-- <h2 style="text-align: center"> {{$document_detail->name}} </h2> --}}

        {{-- {!! $document_detail->cover_page !!} --}}
        {!! $document_detail->content !!}   
        {{-- {!! $document_detail->cover_page !!}    --}}


        <input type="hidden" class="form-control" id="doc_name" placeholder="Contract Name" name="doc_name" value="{{$document_detail->name}}" />

        <div class="row mt-2" style="">
          <div class="col-md-6 offset-md-3" style="padding: 0px">

            <table class="table table-sm table-striped">
              <tbody>
                @forelse($signatures as $signature)
                  <tr>
                    <td style="text-align: left">{{$signature->name}}</td>
                    <td style="text-align: center"> {!! $signature->image !!} </td>
                    <td style="text-align: right">{{date('F, j Y', strtotime($document_detail->updated_at))}}</td>
                  </tr>
                @empty
                @endforelse
              </tbody>
            </table>

          </div>
        </div>     

            <textarea rows="10" class="form-control" name="document_content" id="document_content" style="display: none">{{ $document_detail->content }}
              {{-- {{ $document_detail->cover_page }} --}}

              <div class="row mt-2" style="">
                <div class="col-md-6" style="padding: 0px">

                  <table class="table table-sm table-striped">
                    <tbody>
                      @forelse($signatures as $signature)
                        <tr>
                          <td>{{$signature->name}}</td>
                          <td style="text-align: center"> {!! $signature->image !!} </td>
                          <td>{{date('F, j Y', strtotime($document_detail->updated_at))}}</td>
                        </tr>
                      @empty
                      @endforelse
                    </tbody>
                  </table>
                  
                </div>
              </div>


            {{-- @forelse($signatures as $signature)
              <div class="row" style="">
                <div class="col-md-12" style="padding: 0px">
                  <div class="col-md-6" style="">
                    <div class="row">
                      <div class="col-md-4">{{$signature->name}}</div>
                      <div class="col-md-4">{!! $signature->signature !!}</div>
                      <div class="col-md-4">{{date('F, j Y', strtotime($document_detail->updated_at))}}</div>  
                    </div>                    
                  </div>
                </div>
              </div>
            @empty
            @endforelse --}}
          </textarea>

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
        var doc_name = document.querySelector('#doc_name').value;
        var contentDocument = document.querySelector('#document_content');
        var content = '<!DOCTYPE html>' + contentDocument.value;
        var orientation = 'portrait';
        var converted = htmlDocx.asBlob(content, {orientation: orientation});

        saveAs(converted, doc_name);
    });

</script>