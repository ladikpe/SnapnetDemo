{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <style>
    .sortColumn
    {
      cursor: pointer;
    }

    .la la-arrows-v
    {
      font-size: 13px!important;
    }

    html body .la {
    font-size: 13px!important;  /* font-size: 1.4rem; */
}
  </style>
@endsection
@section('content')


<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>

<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">       
              <h3 class="card-title" id="basic-layout-form"> 
                <div class="row" style="margin-top: -10px">
                  <div class="col-md-9" style="">
                    Contracts 
                  </div> 
                  <div class="col-md-3" style="">
                    <form method="get" action="{{ route('contracts.index') }}">
                      <fieldset>
                        <div class="input-group">
                          <input type="text" class="form-control" name="search" placeholder="Search ... " value="{{ Request::get('search') }}">
                          <div class="input-group-append">
                            <button class="btn btn-default btn-sm" type="submit"><i class="la la-search"></i></button>
                          </div>
                        </div>
                      </fieldset>
                    </form>                    
                  </div>                  
                </div>

               </h3>
               
              <div class="media d-flex" id="contract_table">

                  <table class="table table-sm mb-0" id="old-table">
                    <thead class="thead-dark">
                      <tr>
                        <th class="sortColumn" id="name">Name <i class="la la-arrows-v" style=""></i></th>
                        {{-- <th>Contract Category</th> --}}
                        <th class="sortColumn" id="status">Status <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="vendor_id">Vendor <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="expires">Expiry Date <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="user_id">Created By <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="created_at">Created At <i class="la la-arrows-v" style=""></i></th>
                        <th>Action <a href="{{url('contracts/new')}}" class="pull-right" style="color:#fff !important"><i class="la la-plus"></i></a></th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($contracts->sortByDesc('created_at') as $contract)
                        <tr>
                          <td> {{ $contract->name }}</td>
                          {{-- <td>{{ $contract->contract_category?$contract->contract_category->name:'' }}</td> --}}
                          <td>
                            @if($contract->status == 0)
                              <span class="badge badge-pill badge-warning" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @elseif($contract->status == 1)
                              <span class="badge badge-pill badge-success" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @elseif($contract->status == 2)
                              <span class="badge badge-pill badge-danger" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @endif
                          </td>
                          
                          <td>{{ $contract->vendor ? $contract->vendor->name : 'N/A' }}</td>
                          <td>{{date("M j, Y", strtotime($contract->expires))}}</td>
                          <td>{{ $contract->user->name }}</td>
                          <td>{{date("M j, Y, g:i A", strtotime($contract->created_at))}}</td>
                          <td>

                          <span  data-toggle="tooltip" title="View"><a href="{{ url('contracts/show/'.$contract->id) }}" class="my-btn btn-sm text-dark">  <i class="la la-eye" aria-hidden="true"></i></a></span>
                            <!-- Legal Officers Role -->
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                              @if($contract->ContractPerformance->isNotEmpty())                                  
                                <span title="View Ratings">
                                <a id="{{$contract->id}}" class="my-btn btn-sm text-success view" data-toggle="modal" data-target="#viewRatingModel">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @else                                  
                                <span title="Rate Contract Performance">
                                <a id="star_{{$contract->id}}" class="my-btn btn-sm text-warning" data-toggle="modal" data-target="#ratingModel" onclick="putId({{ $contract->id }})">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @endif
                              
                            <!-- Manager view -->
                            @elseif(Auth::user()->role_id == 5)
                              @if($contract->ContractPerformance->isNotEmpty())                                  
                                <span title="View Legal Officer Ratings">
                                <a id="{{$contract->id}}" class="my-btn btn-sm text-success view_mgr" data-toggle="modal" data-target="#viewRatingMgrModel">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @else                                  
                                <span title="Rate Legal Officers Performance">
                                <a id="star_{{$contract->id}}" class="my-btn btn-sm text-warning rate_user" data-toggle="modal" data-target="#ratingMgrModel" onclick="mgrPutId({{ $contract->id }})"> <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @endif
                            @endif
                            <!-- Managerial Role -->
                            @if($contract->status==1)
                              {{-- <span  data-toggle="tooltip" title="View"><a href="{{ url('download_contract/'.$contract->id) }}" class="my-btn btn-sm text-dark"><i class="la la-download" aria-hidden="true"></i></a></span> --}}
                              <span  data-toggle="tooltip" title="Download"><a href="{{ url('contracts/final/'.$contract->id) }}" class="my-btn btn-sm text-dark"><i class="la la-download" aria-hidden="true"></i></a></span>   
                            @endif
                            
                          </td>
                        </tr>
                      @empty
                        
                      @endforelse
                     </tbody>
                  </table>
                  
              </div>
                  {{ $contracts->links()}}
                
            </div>
          </div>
        </div>
    </div>
</div>









        

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
                                  <div id="stared_{{$performance_metric->id}}" class="star"></div>
                                  <input type="hidden" class="form-control" name="rating_{{$performance_metric->id}}" id="ratinged_{{$performance_metric->id}}" value="">   
                                </td>
                                <td>  <div id="red_{{$performance_metric->id}}"> </div>  </td>
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




         

<!-- Rate Performance -->
<form class="" action="{{url('performance')}}" method="post">
{{ csrf_field() }}
    <div class="modal fade text-left" id="ratingMgrModel" tabindex="-1" role="dialog" aria-labelledby="ratingMgrModel" aria-hidden="true">
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
                        <tbody id="row_mgr_rate">
                            @foreach ($performance_metrics as $performance_metric)
                              <tr>
                                <td> {{ $performance_metric->metric_name }} 
                                <input type="hidden" class="form-control" name="metric_{{$performance_metric->id}}" id="metric_{{$performance_metric->id}}" style="width:40%" value="{{$performance_metric->id}}">  </td>
                                <td> 
                                  <div id="starm_{{$performance_metric->id}}" class="starm"></div>
                                  <input type="hidden" class="form-control" name="rating_{{$performance_metric->id}}" id="ratingm_{{$performance_metric->id}}" value="">   
                                </td>
                                <td>  <div id="rm_{{$performance_metric->id}}"> </div>  </td>
                                <td>{{ $performance_metric->weight }} <div class="rr"> </div> </td>
                              </tr>
                            @endforeach
                          <input type="hidden" class="form-control" name="contracted_id" id="contract_mgr_id" value="">     
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
<div class="modal fade text-left" id="viewRatingMgrModel" tabindex="-1" role="dialog" aria-labelledby="ratingMgrModel" aria-hidden="true">
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
                    <tbody id="row_mgr">
                          
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
      var id = idd.substring(6, 8);
      // alert(id);

      var $rateYo = $('#stared'+id+'').rateYo(); 
      $('#stared'+id+'').mouseover(function () 
      {  
        /* get rating */
        var rating = $rateYo.rateYo("rating");  
        $('#red'+id+'').html(rating); 
        $('#ratinged'+id+'').val(rating);
      });

      //RATE BASED ON ENTERED VALUE

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
      //RATE BASED ON ENTERED VALUE
    });



    // var $rateYo = $("#star").rateYo(); 
    // $("#star").click(function () 
    // {  
    //   /* get rating */
    //   var rating = $rateYo.rateYo("rating");  
    //   $('#r').html(rating); 
    //   $('#rating').val(rating);
    // });
 
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

   

  // $(function()
  // {
    // var contract_id = 22;
    // $('#star_'+id).click(function(e)
  //   { alert();
  //     $.get('{{url('setMetricDetials')}}?contract_id=' +contract_id, function(data)
  //     { 
  //       $.each(data, function(index, dataObj)
  //       {
  //         $('.rr').html(dataObj.rating); 
  //       }          
  //     });       
  //   });
  // });


  //SORT SCRIPT
  $(function()
  {
      $('.sortColumn').click(function(e)
      {
        $('#contract_table').empty();
          var column = $(this).attr('id'); 
            
          $("#contract_table").load("{{url('contract-table')}}?column="+column);  
      });
  });




</script>

    @if(Session::has('success'))
        <script>
            $(function() 
            {
                toastr.success('{{session('success')}}', {timeOut:50000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function() 
            {
                toastr.error('{{session('error')}}', {timeOut:50000});
            });
        </script>
    @endif

@endsection
