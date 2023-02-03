@extends('layouts.app')
@section('stylesheets')
{{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" /> --}}
<style type="text/css">
  body
    {
      margin: 0;
      font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.45;
      color: #6B6F82;
      text-align: left;
      background-color: #F9FAFD;
    }
    .table thead th
    {
      border-bottom: none !important;
    }
</style>
@endsection
@section('content')
  
  
{{-- LEGAL DEPARTMENT --}}
  @if(Auth::user()->department_id == 1 || Auth::user()->department_id == 4)
     
{{-- TABLES --}}
    <div class="row">  
      <div class="col-md-7 no-pad">
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">   

                    <div class="row">
                      <div class="col-md-6">
                          <a class="" href="#">
                            <div class="card bg-success text-white">
                                <div class="card-body no-pad">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate" style="font-size: 15px;"> 
                                            <i class="la la-list mt-1"></i> All Contracts 
                                            <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($contracts)}} </span> 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>
                      </div>

                      <div class="col-md-6">
                          <a class="" href="#">
                            <div class="card bg-warning text-white">
                                <div class="card-body no-pad">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate" style="font-size: 15px;">
                                               <i class="la la-exclamation mt-1"></i> Expired Contracts
                                               <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($expired_contracts)}} </span>
                                             </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>
                      </div>
                    </div>



                    {{-- <h4> All Expired Statutory Documents
                      <span id="ct_pend" class="badge badge-pill badge-danger badge-up badge-glow" style="margin-right:15px; margin-top: 8%">  </span>
                    </h4> --}}
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:130px; max-height:130px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Name</th>
                              <th>Category</th>
                              <th>Duration</th>
                              <th>Expiration Date</th>
                              <th>Grace Period</th>
                              <th>Status</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($expired_contracts)
                              @forelse($expired_contracts as $contract)  @php $ct++;  @endphp                              
                                  <tr>
                                    <td>{{ $contract->name}}</td>
                                    <td>{{ $contract->document_type?$contract->document_type->name:''}}</td>
                                    @php
                                      $start = strtotime($contract->created_at);        $end = strtotime($contract->expire_on);
                                      $duration_in_days = ceil(abs($end - $start) / 86400);
                                    @endphp
                                    <td>{{ $duration_in_days }} day(s)</td>
                                    <td>{{ date("d M, Y", strtotime($contract->expire_on))}}</td>
                                    <td>{{ $contract->grace_period }} day(s)</td>
                                    <td>
                                      @if($contract->expire_on <= $today && $contract->grace_end >= $today)
                                        <span class="badge badge-warning text-white"> Grace Period </span>
                                      @else
                                        <span class="badge badge-danger text-white"> Expired </span>
                                      @endif
                                    </td>
                                    <td style="text-align: right;">
                                      {{-- if user is department head --}}
                                        <a class="btn-sm pull-right" href="{{url('document-details', $contract->id)}}"> <i class="la la-eye" data-toggle="tooltip" title="View Document Details" style="font-size:12px !important; color:#0047AB; padding:0px!important" target="_blank"></i>  
                                        </a>
                                      {{-- else --}}
                                        
                                      {{-- endif --}}
                                    </td>
                                  </tr>
                              @empty
                                No Record(s)                         
                              @endforelse         <input type="hidden" class="form-control" id="ct" value="{{$ct}}" /> 
                            @endif
                          </tbody> 
                        </table> 
                      </div>                      

                    </div>


                  </div>
                </div>
              </div>
          </div>
      </div> 




      <div class="col-md-5 no-pad">
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">
                    <div class="card-header">
                      <h4 class="card-title">Contract Category </h4>
                      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                      <div class="heading-elements">
                        <ul class="list-inline mb-0">
                          <li><a data-action="reload"> <span class="badge badge-pill badge-success badge-up badge-glow text-white" style="margin-top: -15px; margin-right: -8px;"> {{ $contract_count }} </span></a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="card-content collapse show">
                      <div class="card-body pt-0">

                        @forelse($categories as $category)
                          <p> {{$category['name']}}
                            <span class="float-right text-bold-600">
                              @if($contract_count > 0) {{ number_format( ($category['value'] * 100) / $contract_count, 0) }}% @else 0% @endif
                            </span>
                          </p>
                          <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: @if($contract_count > 0) {{ number_format( ($category['value'] * 100) / $contract_count, 0) }}% @else 0% @endif" 
                              aria-valuenow="@if($contract_count > 0) {{ number_format( ($category['value'] * 100) / $contract_count, 0) }}% @else 0% @endif" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        @empty
                        @endforelse
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>


    </div>


    <div class="row">
      <div class="col-md-5">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body"> 
                <h4 class="card-title">Contract Category </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                 {{-- <h4> Contract Compliance Chart </h4> --}}

                <div class="frame" style=""><canvas id="contractPieChart"></canvas></div> 
              </div>
            </div>
          </div>
      </div>


      <div class="col-md-7 no-pad">
        <div class="col-lg-12 col-12 pull-left">
          <div class="card pull-up">
            <div class="card-header bg-hexagons">
              <h4 class="card-title">Calendar
                <span class="danger">-Events</span>
              </h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="card-content collapse show bg-hexagons">
              <div class="card-body pt-0">

                <div class="" id='calendar'></div>

              </div>
            </div>
          </div>
        </div>
      </div>
             
    </div>


































    {{-- TABLES --}}
    <div class="row">  
      
    </div>


  {{-- Others --}}
  @else
   

  @endif













      
      

  




  
@endsection
@section('scripts')
 


  <!-- SETTING COUNT FOR CONTRACT EXPRED THIS MONTH -->
  <script>
    $(function()
    {
      var ct = $('#count').val();
      $('#count_ex_mo').html(ct);

      //for deadline      
      var dl = $('#deadline').val();
      $('#dead_past').html(dl);

      //for pending      
      var ct_pend = $('#ct').val();
      $('#ct_pend').html(ct_pend);
    });
  </script>


    <script>

      document.addEventListener('DOMContentLoaded', function() 
      {
          // 

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          editable:true,
          headerToolbar: {
            left: 'prev, next today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, timeGridDay'
          },

          eventSources:{
            url: '{{url('getEventData')}}',
            color: 'purple',
            textColor: 'white'
          },

          // events: function(info, successCallback, failureCallback)
          // {
          //   let eventsArr = [{'title': 'First Title', 'start': '2021-03-29'}, {'title': 'Second Title', 'start': '2021-03-29'} ];
          //   successCallback(eventsArr);
          // },


          selectable:true,
          selectHelper:true,

          select:function(start, end, allDay)
          {
            $(document).ready(function() 
            {
              var title = prompt('Event Title');
              
              var start = calendar.formatDate(start, 'Y-MM-DD');
              var end = calendar.formatDate(end, 'Y-MM-DD');
              alert(start);  return;

                  formData = 
                  {
                      title:title,
                      start:start,
                      end:end,
                      type:'add',
                      _token:'{{csrf_token()}}'
                  }
                  $.post('{{route('action')}}', formData, function(data, status, xhr)
                  {
                    calendar.FullCalendar('refetchEvents');  return toastr.success('Success');                         
                  });

            });
          }
        });
        calendar.render();
      });



      $(function()
      {
          //$ajaxSetup({
          //   header:{
          //     'XCSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          //   }
          // });

          //var calendar - $('#calendar').FullCalendar();
      });
      

    </script>









<script>



     var optionsPerc = 
     {
        tooltips: { enabled: true },
        plugins: {   precision: 0, datalabels: { formatter: (value, ctx) => {  return value + '%';  },     color: '#fff', }  }
     };

     var optionsData = 
     {
        tooltips: { enabled: true },
        plugins: {  precision: 0, datalabels: { formatter: (value, ctx) => {  return value;  },     color: '#fff', }  }
     };

     var optionsTrans = 
     {
        tooltips: { enabled: true },
        plugins: {  precision: 0, datalabels: { formatter: (value, ctx) => {  return value;  },     color: 'transparent', }  }
     };

     var optionsNoLegend = 
     {
        tooltips: { enabled: true },
        plugins: {  precision: 0, datalabels: { formatter: (value, ctx) => {  return value;  },     color: 'transparent', }  },
        legend: { display: false }
     };

     var optionsStartAtZero = 
     {
        tooltips: { enabled: true },
        plugins: {  precision: 0, datalabels: { formatter: (value, ctx) => {  return value;  },     color: 'transparent', }  },
        scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
     };





    //COMPLIANCE 
    var ctx = document.getElementById('contractPieChart').getContext('2d');
    var chart = new Chart(ctx, 
    {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data: 
        {
            labels: [ @if($contract_chart) @foreach($contract_legend as $legend)"{{$legend}}", @endforeach @endif],
            datasets: 
            [          
                {
                    label: "Complaince Report", 
                    backgroundColor: ['#ED872D', '#FFEF00', '#00CC99'],  
                    borderColor: '#ffffff',
                    data: [@forelse($contract_chart as $contract) "{{$contract}}", @empty @endforelse],
                },             
           ]
        },

        // Configuration options go here
        options: optionsPerc
    }); 

</script>

    


@endsection
