@extends('layouts.app')

@section('content')




<div class="row" id="rated" style="display:none">

  <div class="col-lg-12 col-xl-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">       <h4 class="card-title" id="basic-layout-form"> Ratings  </h4>          

          <a href="#" class="pull-right" id="show_contract" style="color:#000;background:#fff"> </a> 
            <div class="card collapse-icon accordion-icon-rotate">

              <div id="headingcol_0" class="" style="padding:3px 10px; margin-bottom:8px; background:fff; color:#000">
                <a data-toggle="collapse" href="#col_0" aria-expanded="true" aria-controls="collapse31" class="card-title lead"> Contract Creator</a>
              </div>

                  <div id="col_0" role="tabpanel" aria-labelledby="headingcol_0" class="card-collapse collapse" aria-expanded="true">
                    <div class="card-content">
                      <div class="card-body">
                        
                        <table class="table table-sm mb-0" id="">
                          <thead class="thead-dark">
                            <tr>
                              <th>Metrics</th>
                              <th>Weight</th>
                              <th>Contract Creator Rating</th>
                              <th>Rated By</th>
                            </tr>
                          </thead>
                          <tbody id="row_mgrs">
                            @foreach ($metrics as $metric)
                              <tr>
                                <td> {{ $metric->metric_name }} </td>
                                <td> {{ $metric->weight }} </td>
                                <td> <div id="legal_{{$metric->id}}" class="legals"> </div> </td>
                                <td> <div id="legal_rate_{{$metric->id}}" class="legals_rate"> </div> </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>      
                        
                        <input type="hidden" class="form-control" name="contract_id" id="all_contracted_id" value="">                    
                        <input type="hidden" class="form-control" name="count" id="count" value="{{count($metrics)}}">                 
                        <input type="hidden" class="form-control" name="role" id="roled" value="{{\Auth::user()->role_id}}">          
                        <input type="hidden" class="form-control" name="u_id" id="u_id" value="{{\Auth::user()->id}}"> 

                      </div>
                    </div>
                  </div>

                    @foreach($stages as $stage)
                      <div id="headingcol_{{$stage->id}}" class="" style="padding:3px 10px; margin-bottom:8px; background:fff; color:#000">
                        <a data-toggle="collapse" href="#col_{{$stage->id}}" aria-expanded="true" aria-controls="collapse31" class="card-title lead"> {{$stage->name}} </a>
                      </div>

                      <div id="col_{{$stage->id}}" role="tabpanel" aria-labelledby="headingcol_{{$stage->id}}" class="card-collapse collapse" aria-expanded="true">
                        <div class="card-content">
                          <div class="card-body">
                            
                            <table class="table table-sm mb-0" id="">
                              <thead class="thead-dark">
                                <tr>
                                  <th>Metrics</th>
                                  <th>Weight</th>
                                  <th>{{$stage->name}} Rating</th>
                                  <th>Rated By</th>
                                </tr>
                              </thead>
                              <tbody id="row_mgrs">
                                @foreach ($metrics as $metric)
                                  <tr>
                                    <td> {{ $metric->metric_name }} 
                                      <input type="hidden" class="form-control" name="metric_{{$metric->id}}" id="metric_{{$metric->id}}" style="width:40%" value="{{$metric->id}}"> </td>
                                    <td> {{ $metric->weight }} </td>
                                    <td> <div id="manager_{{$stage->user_id}}_{{$metric->id}}" class="managers_rate"> </div> </td>
                                  
                                    <td> <div id="manager_rate_{{$stage->user_id}}_{{$metric->id}}" class="managers_rate"> </div> </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>      

                          </div>
                        </div>
                      </div>
                    @endforeach
              
            </div>
         
        </div>
      </div>
    </div>
  </div>

</div> 




<div class="row" id="contracts">

    <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">    
              <h3 class="card-title" id="basic-layout-form"> 
                <div class="row" style="margin-top: -10px">
                  <div class="col-md-9" style="">
                    View Contract Ratings 
                  </div> 
                  <div class="col-md-3" style="">
                    <form method="get" action="{{ route('performance.ratings') }}">
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
              <div class="media d-flex">

                  <table class="table table-sm mb-0">
                    <thead class="thead-dark">
                      <tr>
                        <th>Name</th>
                        <th>Contract Category</th>
                        <th>Status</th>
                        <th>Vendor</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th style="text-align:right">Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($contracts_paginated->sortByDesc('created_at') as $contract)
                        <tr>
                          <td>{{ $contract->name }}</td>
                          <td>{{ $contract->contract_category?$contract->contract_category->name:'' }}</td>
                          <td>
                            @if($contract->status==0)
                            <span class="badge badge-pill badge-warning" style="color:#fff">Pending</span>
                            @elseif($contract->status==1)
                            <span class="badge badge-pill badge-success" style="color:#fff">Approved</span>
                            @elseif($contract->status==2)
                            <span class="badge badge-pill badge-danger" style="color:#fff">Rejected</span>
                            @endif
                          </td>
                          <!-- <td>{{ $contract->vendor_id }}</td> -->
                          <td>{{ $contract->vendor ? $contract->vendor->name : 'N/A' }}</td>
                          <td>{{ $contract->user->name }}</td>
                          <td>{{date("F j, Y, g:i A", strtotime($contract->created_at))}}</td>
                          <td style="text-align:right">
                          <a id="{{$contract->id}}" data-toggle="tooltip" title="View All Ratings" href="#" class="my-btn btn-sm text-dark all_ratings">  <i class="la la-eye" aria-hidden="true"></i></a>
                          </td>
                        </tr>
                      @empty
                        
                      @endforelse
                     </tbody>
                  </table>
                  
        
                

              </div>
                 
            </div>
          </div>
        </div>
    </div>
</div>

    




   
   
@endsection

@section('scripts')


<script>
    //WHEN THERE IS NOT RATINGS
    $('.all_ratings').click(function(e)
    { 
      $('#rated').show();
      var id = this.id;  
      $.get('{{url('legalContractRatingsById')}}?id=' +id, function(data)
      {        
        // $('.row_mgrs').remove();
        $('.legals').html();
        $('.legals_rate').html();
        $.each(data, function(index, legObj)
        {   
           $('#legal_'+legObj.performance_metric_id+'').html(legObj.rating);
           $('#legal_rate_'+legObj.performance_metric_id+'').html(legObj.author.name);
        });
      });  
      
      $.get('{{url('managerContractRatingsById')}}?id=' +id, function(data)
      {        
        // $('.row_mgrs').remove();
        $('.managers').html();
        $('.managers_rate').html();
        $.each(data, function(index, manObj)
        {   
           $('#manager_'+manObj.appraiser_id+'_'+manObj.performance_metric_id+'').html(manObj.rating);
           $('#manager_rate_'+manObj.appraiser_id+'_'+manObj.performance_metric_id+'').html(manObj.author.name);
        });
      });
 
    });

    $('#show_contract').click(function(e)
    { 
      $('#contracts').hide();
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
