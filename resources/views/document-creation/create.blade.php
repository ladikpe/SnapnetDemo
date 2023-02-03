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

    #cke_1_contents
    {
      height: 400px !important;
    }
  </style>


@endsection
@section('content')



<form class="form-horizontal" method="POST" action="{{ route('document-creations.store') }}" enctype="multipart/form-data">
@csrf
<div class="row">

        
    <div class="col-md-12">
      <div class="card" style="height: 962px;">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">
            Document Stage : <a data-action="reload" style="font-weight: bold;"> {{strtoupper($stage_detail->name)}} 
            </a>

            <button type="button" class="btn btn-outline-success btn-glow btn-sm ml-2" data-toggle="tooltip" title="Add Document Details" onclick="showHideDetails()"> <i class="fa fa-eye"></i> Document Details </button>

            @if($requisition->template_name != null && $requisition->contract_created == 0)
              <a href="{{ url('get-prefered-template', $requisition->id) }}" class="btn btn-outline-info btn-glow btn-sm ml-2" data-toggle="tooltip" title="Use Prefered Template to Generate Document"> <i class="fa fa-file"></i> Use Prefered Template </a>
            @endif


            {{-- @if($document && $document->reviewed_approved < 1) --}}
              <button type="submit" class="btn btn-success btn-glow btn-sm pull-right ml-1" onclick="return confirm('Are you sure you want to save document?')" name="SaveBtn" value="1" style="padding: 8px 15px1important"> Submit </button>
            {{-- @endif --}}

            @if($requisition->contract_created == 1 && $document->reviewed_approved == 3)
              <a class="btn btn-warning btn-glow btn-sm pull-right ml-1" href="{{ route('view-document', $document->id) }}" target="_blank"> 
              <i class="fa fa-eye"></i> View Document </a>
            @endif

            <div class="btn-group pull-right">              

              @if($requisition->contract_created == 1 && $document->reviewed_approved != 3)
              <button type="button" class="btn btn-outline-info btn-glow dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
              <div class="dropdown-menu" x-placement="bottom-start" 
              style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                
                @if($document)
                  @if($document->reviewed_approved < 3)     
                    <a class="dropdown-item pad-tb" href="#" data-toggle="modal" data-target="#reviewModel"> 
                      <i class="fa fa-comments"></i> Add Comment</a>   
                  @endif          
                    {{-- @if($stage_detail->signable == 1)
                      <a class="dropdown-item pad-tb" href="#" data-toggle="modal" data-target="#signatureModal">Sign Document</a>
                    @endif --}}
                    @if($requisition->contract_created == 1 && $document->reviewed_approved == 0)
                      @if($controllerName->getDocumentReviewer($requisition->id) == \Auth::user()->id)
                        <a class="dropdown-item pad-tb" href="#" data-toggle="modal" data-target="#confirmModal"> <i class="fa fa-recycle"></i> Review Document</a>
                      @endif
                    @elseif($requisition->contract_created == 1 && $document->reviewed_approved == 1)
                      {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">Share with Vendor </a>
                        <div class="dropdown-divider"></div> --}}
                      @if($controllerName->getDocumentReviewer($requisition->id) == \Auth::user()->id)
                        <a class="dropdown-item pad-tb" href="#" data-toggle="modal" data-target="#pushForApprovalModal"> <i class="fa fa-envelope"></i> Push for Approval </a>
                      @endif
                    @elseif($requisition->contract_created == 1 && $document->reviewed_approved == 2)
                      {{-- @if($stage)  --}}
                        {{-- @if($stage->name == 'Approval Stage' && $can_approve == true) --}}
                          @if($controllerName->getDelegateApprover($requisition->id) == \Auth::user()->id && 
                              $controllerName->getDelegateDate($requisition->id) >= $today || 
                              \Auth::user()->department->department_head_id == \Auth::user()->id)
                              <a class="dropdown-item pad-tb" href="#approveModal" data-toggle="modal" data-target="#"> <i class="fa fa-check"></i> Approve Document</a>
                              <a class="dropdown-item pad-tb" href="#declineModal" data-toggle="modal" data-target="#"> <i class="fa fa-ban"></i>  Decline Approval</a>
                              <a class="dropdown-item pad-tb" href="#shareWithUserModal" data-toggle="modal" data-target="#"> <i class="fa fa-user"></i> Share with User/Client</a>
                          @endif
                        {{-- @endif --}}
                      {{-- @endif --}}
                    @endif
                @endif
              </div>
              @endif
            </div>




          </h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              {{-- <li><a data-action="collapse"> Document Stage </a></li>
              <li><a data-action="reload" style="font-weight: bold;"> 
                {{strtoupper($stage_detail->name)}} </a>
              </li> --}}
            </ul>
          </div>
        </div>



        <div class="card-body card-border">

          <div class="card-block" id="document-detail" style="display: none;">
              <fieldset class="scheduler-border">
                  <legend class="scheduler-border"> Document Details </legend>
                  <div class="form-group row"> @php $i = 1; @endphp

                    <div class="col-md-4">        
                        <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">   {{-- {{Session::get('document_id')}} --}}

                        {{-- value="{{ isset($document_detail) ? $document_detail->name : $requisition->name }}" /> --}}
                        <label for="name" class="col-form-label"> Document Name </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Document Name" value="{{$document->name}}" required>
                    </div> 

                    <div class="col-md-4">
                        <label for="" class="col-form-label"> Expires on </label>
                        <input type="date" class="form-control datepicker" name="expire_on" id="expire_on" 
                        @if($document)value="{{$document->expire_on}}" @endif />

                    </div>
                    
                    <div class="col-md-3">
                        <label for="" class="col-form-label"> Grace Period </label>
                        <select class="form-control" name="grace_period" required="">                     
                        @if($document)
                          @if($document->grace_period == 7) <option value="7">1 Week - (7 days)</option>
                          @elseif($document->grace_period == 14) <option value="14">2 Weeks - (14 days)</option>
                          @elseif($document->grace_period == 21) <option value="21">3 Weeks - (21 days)</option>
                          @elseif($document->grace_period == 30) <option value="30">1 Month - (30 days)</option>
                          @elseif($document->grace_period == 60) <option value="60">2 Months - (60 days)</option>
                          @elseif($document->grace_period == 90) <option value="90">3 Months - (90 days)</option>
                          @else <option value=""></option> 
                          @endif
                        @endif

                          <option value=""></option> 
                          <option value="7">1 Week - (7 days)</option>
                          <option value="14">2 Weeks - (14 days)</option>
                          <option value="21">3 Weeks - (21 days)</option>
                          <option value="30">1 Month - (30 days)</option>
                          <option value="60">2 Months - (60 days)</option>
                          <option value="90">3 Months - (90 days)</option>
                        </select>
                    </div>
                    

                    <div class="col-md-1">
                        <label for="" class="col-form-label mb-2">  </label>
                        <button type="button" class="btn btn-outline-success btn-glow btn-sm ml-2" data-toggle="tooltip" title="Save Document Details" onclick="showHideDetails()"> <i class="fa fa-check"></i> Save </button>
                    </div>

                    <select class="form-control" name="document_type_id" name="document_type_id" readonly style="display: none;">
                      <option value="{{$document->document_type_id}}">{{$document->document_type?$document->document_type->name:''}}</option>

                      @forelse($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                      @empty
                      @endforelse
                    </select>
                   
                  </div>
               
                  <div class="form-group row"> 
                    <div class="col-md-5" style="min-height: 150px; max-height: 150px; border: thin dotted #eee; overflow: auto;"> 
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
                            @if($versions)
                              @forelse($versions as $version)
                                <tr>
                                  <td>{{$version->version_number}}</td>
                                  <td>{{$version->author?$version->author->name:''}}</td>
                                  <td>{{date("M j, Y", strtotime($version->created_at))}}</td>
                                </tr>
                              @empty
                                No Document History Change!
                              @endforelse
                            @endif
                          </tbody>
                        </table>
                    </div>

                    <div class="col-md-7" style="min-height: 150px; max-height: 150px; border: thin dotted #eee; overflow: auto;"> 
                        <label for="" class="col-form-label"> Comments </label>
                        <table class="table table-striped table-sm mb-0">
                          <thead class="thead-bg">
                            <tr>
                              <th>Comment</th>
                              <th>Commented By</th>
                              <th>Commented On</th>
                            </tr>
                          </thead>

                          <tbody>
                            @if($comments)
                              @forelse($comments as $comment)
                                <tr>
                                  <td>{{$comment->comment}}</td>
                                  <td>{{$comment->author?$comment->author->name:''}}</td>
                                  <td>{{date("M j, Y", strtotime($comment->created_at))}}</td>
                                </tr>
                              @empty
                                No Comment on Document!
                              @endforelse
                            @endif
                          </tbody>
                        </table>
                    </div>
                  </div>
              </fieldset>
          </div>


            <div class="form-group row">
                {{-- <label for="content" class="col-md-12 col-form-label"> <h4> Content </h4> </label> --}}
                <div class="col-md-12 no-pad">
                    <textarea oncopy="return false;" name="content" id="content" cols="208" rows="25">@if($document->content != null){{$document->content}} @elseif($doc_temp) {{$doc_temp->content}}@endif</textarea>
                </div>
            </div>
        </div>                     




          </div>
        </div>




  </div>
</form>






<!-- INCLUDING modals-->
@include('document-creation.modals.forms')











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

    function usePreferedTemp(id)
    {
      $.get('{{url('get-prefered-template')}}?id=' +id, function(data)
      {

            CKEDITOR.instances['content'].setData(data.template_content);
      });
    }

    $('#dec__btn').click(function(e)
    {
        $('#declineModal').modal('hide');
    });   


      CKEDITOR.replace( 'content');

      CKEDITOR.config.extraPlugins = "base64image";

      CKEDITOR.replace( 'signatures');

      CKEDITOR.config.extraPlugins = "base64image";


      $(function()
      {
          $('#yes_btn').click(function(){    $('#confirmModal').modal('hide');   });
          $('#no_btn').click(function(){    $('#confirmModal').modal('hide');   });
      });

      $(function()
      {
          $('#push_yes_btn').click(function(){    $('#pushForApprovalModal').modal('hide');   });
          $('#push_no_btn').click(function(){    $('#pushForApprovalModal').modal('hide');   });
      });

      $(function()
      {
          $('#app_yes_btn').click(function(){    $('#pushForApprovalModal').modal('hide');   });
          $('#app_no_btn').click(function(){    $('#pushForApprovalModal').modal('hide');   });
      });


      // show hide document details()
      function showHideDetails()
      {
          $('#document-detail').toggle();  
      }
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



    @if(Session::has('info'))
        <script>
            $(function()
            {
                toastr.success('{{session('info')}}', {timeOut:100000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function()
            {
                toastr.error('{{session('error')}}', {timeOut:100000});
            });
        </script>
    @endif

  

@endsection
