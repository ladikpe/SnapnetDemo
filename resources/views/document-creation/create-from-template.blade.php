@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

  <!-- Font Awesome Css -->
  <link href="{{ asset('assets/e-signature/css/font-awesome.min.css') }}" rel="stylesheet" />

  <!-- Bootstrap Select Css -->
  <link href="{{ asset('assets/e-signature/css/bootstrap-select.css') }}" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="{{ asset('assets/e-signature/css/app_style.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{ asset('assets/e-signature/css/jquery.signaturepad.css') }}" rel="stylesheet">

  <style>
    .perm 
    {
      margin-bottom: 20px; background-color: #fff; border: 1px solid #ddd; border-radius: 4px;padding-top: 10px;padding-bottom: 5px;
    }
   .bootstrap-tagsinput .tag 
   {
      margin-right: 2px;
      color: white;
      /* color: #c2185b; */
      background-color: #1976d2;
    }

    .bootstrap-tagsinput 
    {
        display: block;
    }


    .btn sw-btn-next
    {
        background: #5cb85c !important;
    }

    .btn sw-btn-prev
    {
        /*background: #5cb85c;*/
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
      background-color: #999;
      border-radius: 10%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark 
    {
      background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark 
    {
      background-color: #008B8B;
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
    
    #signArea
    {
      width:304px;
      margin: 15px auto;
    }
    .sign-container 
    {
      width: 90%;
      margin: auto;
    }
    .sign-preview 
    {
      width: 150px;
      height: 50px;
      border: solid 1px #CFCFCF;
      margin: 10px 5px;
    }
  </style>


@endsection
@section('content')



<form class="form-horizontal" method="POST" action="{{ route('store-template') }}" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-9">
      <div class="card" style="height: 962px;">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">Create New Document</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"> Document Stage </a></li>
              <li><a data-action="reload" style="font-weight: bold;"> 
                {{strtoupper($controllerName->getDocumentStage($req_id, $requisition->workflow_id))}} </a>
              </li>
            </ul>
          </div>
        </div>




        <div id="smartwizard">
            <ul class="nav">
                <li> <a class="nav-link" href="#step-1"> Document Name </a> </li>
                <li> <a class="nav-link" href="#step-2"> Cover Page </a> </li>
                <li> <a class="nav-link" href="#step-3"> Content </a> </li>
                <li> <a class="nav-link" href="#step-4"> Finish </a> </li>
            </ul>

            <div class="tab-content" style="height: auto !important;">

                {{-- Document DETAILS --}}
                <div id="step-1" class="tab-pane" role="tabpanel">
                      <input type="hidden" name="d_id" id="d_id" value="{{Session::get('document_id')}}">
                      <input type="hidden" name="id" id="id" value="{{$id}}">
                      <input type="hidden" name="requisition_id" id="requisition_id" value="{{Session::get('document_id')}}">
                      <div class="card-content collapse show">
                        <div class="card-body card-border">
                            <div class="form-group row">
                                <div class="col-md-6">
                                  <label for="name" class="col-md-6 form-label" style="padding-left: 0px"> <h4> Document Name </h4> </label>
                           
                                  <input type="text" class="form-control" id="name" placeholder="Contract Name" name="name" 
                                  @if($document_detail)value="{{$document_detail->name}}" 
                                  @else value="{{$requisition->name}}" @endif />
                                  {{-- value="{{ isset($document_detail) ? $document_detail->name : $requisition->name }}" /> --}}                           
                                </div>

                                <div class="col-md-6">
                                    <label for="name" class="col-md-6 form-label" style="padding-left: 0px"> <h4> Document Category </h4> </label>
                                    <select class="form-control" name="document_type_id" name="document_type_id" readonly>

                                      @forelse($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                      @empty
                                      @endforelse
                                    </select>
                                </div>
                            </div>
                            {{-- <a href="" class="btn btn-outline-success btn-glow btn-sm pull-right mb-1" style="padding :0.3rem 0.4rem !important;"><i class="la la-arrow-right" aria-hidden="true"> Next</i>
                            </a> --}}
                        </div>
                      </div>
                </div>


                {{-- Cover Page DETAILS --}}
                <div id="step-2" class="tab-pane" role="tabpanel">
                      <div class="card-content collapse show">
                        <div class="card-body card-border">
                            <div class="form-group row">
                                <label for="cover_page" class="col-md-12 col-form-label"> <h4> Cover Page </h4> </label>
                                <div class="col-md-12">
                                    <textarea name="cover_page" oncopy="return false;" id="cover_page" cols="100%" rows="20">{{$document_detail?$document_detail->cover_page:''}}</textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>


                {{-- Content DETAILS --}}
                <div id="step-3" class="tab-pane" role="tabpanel">
                      <div class="card-content collapse show">
                        <div class="card-body card-border">
                            <div class="form-group row">
                                <label for="content" class="col-md-12 col-form-label"> <h4> Content </h4> </label>
                                <div class="col-md-12">
                                    <textarea oncopy="return false;" name="content" id="content" cols="100%" rows="20">{{$document_detail?$document_detail->content:''}}</textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>


                {{-- FINISH --}}
                <div id="step-4" class="tab-pane" role="tabpanel">
                      <div class="card-content collapse show">
                        <div class="card-body card-border">
                            <div class="form-group row">
                                <label for="content" class="col-md-12 col-form-label" style="text-align: center;"> <h4> Finish </h4> </label>
                                <div class="col-md-12" style="text-align: center;">
                                  {{-- @if($requisition->contract_created == 1 && $document_detail->reviewed_approved == 0) --}}
                                    <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to save document?')"> Save Document </button>
                                  {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                      </div>
                </div>

            </div>
        </div>
















        




          </div>
        </div>


        <div class="col-md-3">
          <div class="card" style="height: 962px;">
          <div class="card-header">

              {{-- <div class="btn-group">
                <button type="button" class="btn btn-outline-info btn-glow dropdown-toggle btn-sm mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                <div class="dropdown-menu" x-placement="bottom-start" 
                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                  @if($requisition->contract_created == 1)
                    <a class="dropdown-item" href="{{ route('view-document', $id) }}">View Document</a>
                      <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#signatureModal" >Sign Document</a>
                      <div class="dropdown-divider"></div>
                  @endif

                  @if($requisition->contract_created == 1 && $document_detail->reviewed_approved == 0)
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#reviewModel">Add Comment</a>
                      <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmModal">Review Document</a>
                  @elseif($requisition->contract_created == 1 && $document_detail->reviewed_approved == 1)
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">Share with Vendor </a>
                      <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">Push for Approval </a>
                  @elseif($requisition->contract_created == 1 && $document_detail->reviewed_approved == 2)
                      <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">Approve </a>
                  @endif
                </div>
              </div> --}}  <div class="pull-left"> Document Management </div>
          </div>

            <div class="card-content collapse show">
              <div class="card-body">
                    
                <div class="col-xs-12">
                    <label for="" class="col-form-label"> Tag </label>
                </div>  
                <div class="col-xs-12">
                    <input type="text" placeholder="Type a Tag and Press Enter" class="form-control" data-role="tagsinput" name="tags" style="" />
                </div>
                     
                <div class="col-xs-12">
                    <label for="" class="col-form-label"> Expires on</label>
                    <input type="date" class="form-control datepicker" name="expire_on" id="expire_on" />
                </div>

                <div class="col-xs-12">
                    <label for="" class="col-form-label"> Grace Period </label>
                    <select class="form-control" name="grace_period" required="">
                      <option value=""></option>
                      <option value="7">1 Week - (7 days)</option>
                      <option value="14">2 Weeks - (14 days)</option>
                      <option value="21">3 Weeks - (21 days)</option>
                      <option value="30">1 Month - (30 days)</option>
                      <option value="60">2 Months - (60 days)</option>
                      <option value="90">3 Months - (90 days)</option>
                    </select>
                </div>
                     
                <div class="col-xs-12" style="display: none;"> 
                    <label for="" class="col-form-label"> Vendor </label>
                    <select class="form-control" name="vendor_id">
                      @forelse ($vendors as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                      @empty
                        <option value="">No Vendor Created</option>
                      @endforelse
                    </select>
                </div>  <br>
                     
                {{-- <div class="col-xs-12" style="min-height: 150px; max-height: 150px; border: thin dotted #eee; overflow: auto;"> 
                    <label for="" class="col-form-label"> Document History </label>
                    <table class="table table-striped table-sm mb-0">
                      <thead class="thead-bg">
                        <tr>
                          <th>Version No</th>
                          <th>Changed By</th>
                          <th>Created On</th>
                        </tr>
                      </thead>

                      <tbody>
                        @forelse($versions as $version)
                          <tr>
                            <td>{{$version->version_number}}</td>
                            <td>{{$version->author?$version->author->name:''}}</td>
                            <td>{{date("M j, Y", strtotime($version->created_at))}}</td>
                          </tr>
                        @empty
                          No Document History Change!
                        @endforelse
                      </tbody>
                    </table>


                </div>  <br> --}}


                
              </div>

              
            </div>
            </div>
        </div>



  </div>
</form>






<!-- INCLUDING modals-->
{{-- @include('document-creation.modals.forms') --}}











@endsection
@section('scripts')
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
  <script src="{{asset('js/select2.min.js')}}"></script>
  <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
  {{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}



{{-- E-SIGNATURE --}}
  <script src="{{ asset('assets/e-signature/js/numeric-1.2.6.min.js') }}"></script> 
  <script src="{{ asset('assets/e-signature/js/bezier.js') }}"></script>
  <script src="{{ asset('assets/e-signature/js/jquery.signaturepad.js') }}"></script> 
  
  <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
  <script src="{{ asset('assets/e-signature/js/json2.min.js') }}"></script>


  <script>
      CKEDITOR.replace( 'cover_page' , 
      {
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField', 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
       
        // { name: 'basicstyles', groups: [  ]},
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'insert', items: [ 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Styles', 'Format', 'Font', 'FontSize'  ] },
      
        // { name: 'styles', items: [] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
        { name: 'others', items: [ '-' ] }
        ]

      }).on('cut copy paste',function(e){e.cancel();});
          // CKEDITOR.replace( 'content' ).on('paste',function(e){e.cancel();});
          // CKEDITOR.instances.editor1.on('copy',function(e){e.cancel();});
          // $('body').bind('copy',function(e){e.preventDefault(); return false;});

      CKEDITOR.config.extraPlugins = "base64image";


      CKEDITOR.replace( 'content' , 
      {
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField', 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
       
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


      $(function()
      {
          $('#yes_btn').click(function(){    $('#confirmModal').modal('hide');   });
          $('#no_btn').click(function(){    $('#confirmModal').modal('hide');   });
      });
  </script>



  <script>

    $(function(e)
    {

      $(function() 
      {
        $('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
      });
      
      $("#btnSaveSign").click(function(e)
      {
        e.preventDefault();
        html2canvas([document.getElementById('sign-pad')],
        {
          onrendered: function (canvas)
          {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            //ajax call to save image inside folder
            $.ajax({
              url: '{{route('save-signature')}}',
              data: { img_data:img_data, _token:'{{csrf_token()}}' },
              type: 'post',
              dataType: 'json',
              success: function (response)
              {
                  if(response.status == 'ok')
                  {
                      toastr.success(data.message); //alert('Signature Appended Successfully');
                  }
                  else
                  {
                      toastr.error(data.error); //alert("Failed To Append Signature, Please Try Again!");
                  }
              }
            });
          }
        });
      });
      
      
      //clear signature   
      $("#btnCleared").click(function(e)
      {
         $('#signArea').signaturePad().clearCanvas();
      });

    });
  </script>





<script>
  $(function () 
  {
 
    $(".star").rateYo(
    {
      starWidth: "20px",
      numStars: 5,
      rating: 0,
      precision: 0,
      minValue: 0,
      maxValue: 5
    });
    
 
    $(".starm").rateYo(
    {
      starWidth: "20px",
      numStars: 5,
      rating: 0,
      precision: 0,
      minValue: 0,
      maxValue: 5
    });
    
    $(".star").click(function () 
    {  
      var idd = $(this).attr('id'); 
      var id = idd.substring(4, 6);
      // alert(id);

      var $rateYo = $('#star'+id+'').rateYo(); 
      $('#star'+id+'').mouseover(function () 
      {  
        /* get rating */
        var rating = $rateYo.rateYo("rating");  
        $('#r'+id+'').html(rating); 
        $('#rating'+id+'').val(rating);
      });
    });
    

    $(".starm").click(function () 
    {  
      var idd = $(this).attr('id'); 
      var id = idd.substring(5, 7);
      // alert(id);

      var $rateYo = $('#starm'+id+'').rateYo(); 

      $('#starm'+id+'').mouseover(function () 
      {  
        /* get rating */
        var rating = $rateYo.rateYo("rating");  
        $('#rm'+id+'').html(rating); 
        $('#ratingm'+id+'').val(rating);
      });
      
    });

 
  });

  function putId(id)
  {
   	$('#contracted_id').val(id);     
  }

  function mgrPutId(id)
  {
   	$('#contract_mgr_id').val(id);     
  }

  
  //AJAX SCRIPT TO GET DETAILS FOR 
  $(function()
  {
    $('.view').click(function(e)
    { 
      var id = this.id; 
      $.get('{{url('getRatingDetails')}}?id=' +id, function(data)
      { 
        $('.table_row').remove();
        // $('#rate_model').html('Performance Rating For ' + data.contract.name);
        $.each(data, function(index, dataObj)
        {
          $('#row').append('<tr class="table_row"> <td> '+dataObj.metric.metric_name+' </td> <td><b> '+dataObj.rating+' </b> </td> <td><b> '+dataObj.metric.weight+' </b> </td> <td> '+dataObj.author.name+' </td>  </tr> ');  
        });
      });       
    });

    $('.view_mgr').click(function(e)
    { 
      var id = this.id; 
      $.get('{{url('getRatingDetails')}}?id=' +id, function(data)
      {  
        $('.table_row').remove();
        // $('#rate_model').html('Performance Rating For ' + data.contract.name);
        $.each(data, function(index, dataObj)
        {  
          $('#row_mgr').append('<tr class="table_row"> <td> '+dataObj.metric.metric_name+' </td> <td><b> '+dataObj.rating+' </b> </td> <td><b> '+dataObj.metric.weight+' </b> </td> <td> '+dataObj.author.name+' </td>  </tr> ');  
        });
      });       
    });


  });




  // SET USERS TO NOTIFY
  $('.recip').each(function()
  {

     $(this).on('change',function()
     {
        var id = $(this).attr('id');
        var value = $(this).attr('value');
        var $el = $('#recipient_' + id);
        if ($(this).is(':checked'))
        {
             $el.val(value);
             return;  
        }
        $el.val('');

      });

  });
  //////
     

</script>

  

@endsection
