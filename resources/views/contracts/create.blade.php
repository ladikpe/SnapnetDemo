@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

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
  </style>


@endsection
@section('content')


<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<form class="form-horizontal" method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data" >
<div class="row">
@csrf
    <div class="col-md-8">
      <div class="card" style="height: 962px;">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">Create New Contract</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
              <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
          </div>
        </div>

        
        <div class="card-content collapse show">
          <div class="card-body">

                    
              <div class="col-xs-12">
                  <h3> Contract Name </h3>
              </div>
          
          
              <div class="col-xs-12">
                  <input type="text" id="name"  class="form-control" placeholder="Contract Name" name="name" value="{{$template->id!=1?$template->name:''}}" />
              </div>   <br>
  

          
              <div class="col-xs-12">
                  <h3> Cover Page </h3>
              </div>
          
          
              <div class="col-xs-12">
                  <textarea name="cover_page" oncopy="return false;" id="cover_page" cols="100%" rows="10">{{isset($template)?$template->cover_page:''}}</textarea>
              </div>   <br>



          
              <div class="col-xs-12">
                  <h3> Content </h3>
              </div>
          
              <div class="col-xs-12">
                  <textarea name="content" id="content" cols="100%" rows="10">{{isset($template)?$template->content:''}}</textarea>
              </div>   <br>

  

              <script>
                CKEDITOR.replace( 'cover_page' , {
                toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'others', items: [ '-' ] }
                ]

              }).on('cut copy paste',function(e){e.cancel();});
                    CKEDITOR.replace( 'content' ).on('paste',function(e){e.cancel();});
                    // CKEDITOR.instances.editor1.on('copy',function(e){e.cancel();});
                    // $('body').bind('copy',function(e){e.preventDefault(); return false;});
            </script>
            


          </div>
        </div>
        <input type="hidden" name="requisition_id" value="{{$requisition_id}}">
        <div class="">                      
          <button type="submit" class="btn btn-dark pull-right"> Save Contract </button>
        </div>




          </div>
        </div>


        <div class="col-md-4">
          <div class="card" style="height: 962px;">
          <div class="card-header">
            <h4 class="card-title" id="basic-layout-form"> Document Management</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
              </ul>
            </div>
          </div>

            <div class="card-content collapse show">
              <div class="card-body">
                    
                <div class="col-xs-12">
                    <h3> Tags </h3>
                </div>  
                <div class="col-xs-12">
                    <input type="text" placeholder="Type a Tag and Press Enter" class="form-control" data-role="tagsinput" name="tags" style="" />
                </div>
                    
                <div class="col-xs-12"> <br>
                    <h3> Expires </h3>
                </div>  
                <div class="col-xs-12">
                    <input type="text" value="" class="form-control datepicker" name="expires" readonly="" />
                </div>
                    
                <div class="col-xs-12"> <br>
                    <h3> Grace Period </h3>
                </div>
                <div class="col-xs-12">
                    <select class="form-control" name="grace_period" required="">
                      <option value="">Select Grace Period</option>
                      <option value="30">1 Month - (30 days)</option>
                      <option value="90">3 Months - (90 days)</option>
                      <option value="180">6 Months - (180 days)</option>
                      <option value="365">12 Months - (365 days)</option>
                    </select>
                </div>
                    
                <div class="col-xs-12"> <br>
                    <h3> Contract Category </h3>
                </div>  
                <div class="col-xs-12">
                    <select class="form-control select2" name="contract_category_id">
                      @forelse ($contract_categories as $contract_category)
                        <option value="{{$contract_category->id}}">{{$contract_category->name}}</option>
                      @empty
                        <option value="">No Contract Categories Created</option>
                      @endforelse
                    </select>
                </div>
                    
                <div class="col-xs-12"> <br>
                    <h3> Vendor </h3>
                </div>  
                <div class="col-xs-12">
                    <select class="form-control" name="vendor_id">
                      <option value=""> Select Vendor </option>
                      @forelse ($vendors as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                      @empty
                        <option value="">No Vendor Created</option>
                      @endforelse
                    </select>
                </div>  <br>



                <!-- Content -->
                



                
              </div>

              
            </div>
            </div>
        </div>



  </div>
</form>







        

<!-- Rate Performance -->
<form class="" action="{{url('performance')}}" method="post">
{{ csrf_field() }}
    <div class="modal fade text-left" id="ratingModel" tabindex="-1" role="dialog" aria-labelledby="ratingModel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel1">Rate Contract Performance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="card-block">
                  <div class="card-body">

                      <table class="table table-sm mb-0" id="">
                        <thead>
                          <tr>
                            <th>Metric Name</th>
                            <th>Star</th>
                            <th>Rating</th>
                            <th>Weight</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($performance_metrics as $performance_metric)
                              <tr>
                                <td> {{ $performance_metric->metric_name }} 
                                <input type="hidden" class="form-control" name="metric_{{$performance_metric->id}}" id="metric_{{$performance_metric->id}}" style="width:40%" value="{{$performance_metric->id}}">  </td>
                                <td> 
                                  <div id="star_{{$performance_metric->id}}" class="star"></div>
                                  <input type="hidden" class="form-control" name="rating_{{$performance_metric->id}}" id="rating_{{$performance_metric->id}}" value="">   
                                </td>
                                <td>  <div id="r_{{$performance_metric->id}}"> </div>  </td>
                                <td>{{ $performance_metric->weight }} <div class="rr"> </div> </td>
                              </tr>
                            @endforeach
                          <input type="hidden" class="form-control" name="contracted_id" id="contracted_id" value="">     
                          <input type="hidden" class="form-control" name="count" id="count" value="{{count($performance_metrics)}}">                         
                          <input type="hidden" class="form-control" name="type" id="" value="rate_performance"> 
                        </tbody>
                      </table>                      

                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-dark">Save Rating</button>
          </div>
        </div>
      </div>
    </div>
</form>  

<!-- View Rating -->
<div class="modal fade text-left" id="viewRatingModel" tabindex="-1" role="dialog" aria-labelledby="ratingModel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="rate_model"> Performance Rating</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <div class="card-block">
              <div class="card-body" id="view_rated">

                  <table class="table table-sm mb-0" id="">
                    <thead class="dark">
                      <tr>
                        <th>Metric Name</th>
                        <th>Rating</th>
                        <th>Weight</th>
                        <th>Rated By</th>
                      </tr>
                    </thead>
                    <tbody id="row">
                          {{--  <tr>
                            <td> {{ $performance_rating->performance_metric_id }} </td>
                            <td> {{ $performance_rating->rating }} <div id="r_{{$performance_rating->id}}"> </div>  </td>
                            <td>{{ $performance_rating->metric->weight }} <div class="rr"> </div> </td>
                          </tr> --}}
                    </tbody>
                  </table>                      

              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>









@endsection
@section('scripts')
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}
<script type="text/javascript">
$(function() 
{
  $('.select2').select2();
  $('.datepicker').datepicker(
  {
    format: 'yyyy-mm-dd',
    startDate: '-3d',
    autoclose:true
  });
  // $(window).resize(function () {
	// 			var h = Math.max($(window).height() - 0, 420);
	// 			$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
	// 		}).resize();
  $('#data')
  .jstree({
    'core' : {
      'multiple':false,
						'data' : {
							'url' : '{{url('folders/get_node')}}',
							'data' : function (node) {
								return { 'id' : node.id };
							}
						},
						'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
					},"checkbox" : {
            three_state : false, // to avoid that fact that checking a node also check others
            whole_node : false,  // to avoid checking the box just clicking the node
            tie_selection : false
	},"plugins":["checkbox"]
});
  $('#data').on('check_node.jstree', function (e, data) {

    //console.log(data.node.id);
    $.get('{{route('folders.ajax')}}', { 'id' : data.node.id })
      .fail(function () {
        data.instance.refresh();
      })
      .done(function(response){
        console.log(response);
      });
  });

  var stgcont = $('#grp-perm-cont');
        var i = $('#grp-perm-cont tr').length -1;

        $('#addGrpPerm').on('click', function() {
        	//console.log('working');
                $('<div class="row perm"> <div class="col-md-12">  <div class="form-group">     <select class="form-control select2" name="group_id[]">  @forelse($groups as $group)<option value="{{$group->id}}">{{$group->name}}</option> @empty<option value="">No Groups Created</option>    @endforelse  </select> </div> </div> <div class="col-md-12">   <div class="form-group"> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio1" value="1"> Forbidden </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio2" value="2"> View </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio3" value="3"> Download </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio4" value="4"> Write </label> <br><label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio5" value="5"> Admin </label> </div>    </div>    <div class="col-md-12">  <a href="#" id="remGrpPerm" class="btn btn-sm btn-danger pull-right">X</a>  </div>  </div>').prependTo(stgcont);
                //console.log('working'+i);
                $( ".perm" ).each(function( index ) {

                  $( this).find( "input:radio" ).attr( "name", "perm_"+index );

                });
                i++;
                console.log(i);
                return false;
        });

        $(document).on('click',"#remGrpPerm",function() 
        {
        	//console.log('working'+i);
                if( i >= 1 ) {
                	 console.log('working'+i);
                        $(this).parents('div .perm').remove();
                        i--;
                }
                return false;
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

</script>

  

@endsection
