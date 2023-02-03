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
      <div class="col-md-6 no-pad">
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
                                            <i class="la la-list mt-1"></i> All Tasks 
                                            <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($task_docs)}} </span> 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>
                      </div>

                      <div class="col-md-6">
                          <a class="" href="#">
                            <div class="card bg-danger text-white">
                                <div class="card-body no-pad">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate" style="font-size: 15px;">
                                               <i class="la la-exclamation mt-1"></i> Pending Task Assignment
                                               <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($pending_assignment)}} </span>
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
                              <th>Deadline</th>
                              <th>Status</th>
                              <th>Source</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($pending_assignment)
                              @forelse($pending_assignment as $task)  @php $ct++;  @endphp                              
                                  <tr>
                                    <td>{{ $task->title}}</td>
                                    <td>{{ date("d M, Y", strtotime($task->deadline))}}</td>
                                    <td><span class="badge badge-warning text-white"> Pending Assignment </span></td>
                                    <td>{{ $task->author?$task->author->name:'' }}</td>
                                    <td style="text-align: right;">
                                      {{-- if user is department head --}}
                                        <a class="btn-sm pull-right" href="{{route('assignments.index')}}"> <i class="la la-eye" data-toggle="tooltip" title="View Task" style="font-size:12px !important; color:#0047AB; padding:0px!important" target="_black"></i>  
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



      <div class="col-md-6 no-pad">
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
                                            <i class="la la-list mt-1"></i> Task Due this Month
                                            <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($task_docs)}} </span> 
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
                                               <i class="la la-exclamation mt-1"></i> Task Exceeded Deadline
                                               <span class="badge badge-pill badge-dark badge-up badge-glow" style=""> {{count($past_deadline)}} </span>
                                             </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>
                      </div>
                    </div>



                    {{-- <h4> All Expired Statutory Documents
                      <span id="ct_pend" class="badge badge-pill badge-warning badge-up badge-glow" style="margin-right:15px; margin-top: 8%">  </span>
                    </h4> --}}
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:130px; max-height:130px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Name</th>
                              <th>Deadline</th>
                              <th>Status</th>
                              <th>Source</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($past_deadline)
                              @forelse($past_deadline as $task)  @php $ct++;  @endphp                              
                                  <tr>
                                    <td>{{ $task->title}}</td>
                                    <td>{{ date("d M, Y", strtotime($task->end))}}</td>
                                    <td><span class="badge badge-danger text-white"> Deadline Exceeded </span></td>
                                    <td>{{ $task->author?$task->author->name:'' }}</td>
                                    <td style="text-align: right;">
                                      {{-- if user is department head --}}
                                        <a class="btn-sm pull-right" href="{{route('requisitions.index')}}"> <i class="la la-eye" data-toggle="tooltip" title="View Task" style="font-size:12px !important; color:#0047AB; padding:0px!important" target="_black"></i>  
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
    </div>




    <div class="row">
        
      <div class="col-md-4 no-pad">
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body"> <h4> Task Pending Assignment Chart </h4>

                    <div class="frame" style=""><canvas id="pendPieChart"></canvas></div> 

                  </div>
                </div>
              </div>
          </div>
      </div>
        



      <div class="col-12 col-md-4">
        <div class="card pull-up">
          <div class="card-header">
            <h4 class="card-title">Task Compliant </h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="reload"> <span class="badge badge-pill badge-success badge-up badge-glow text-white" style="margin-top: -15px; margin-right: -8px;"> {{ $all }} </span></a></li>
              </ul>
            </div>
          </div>
          <div class="card-content collapse show">
            <div class="card-body pt-0">
              <p class="pt-1">Valid   @php $validDoc = ( $all - ($past_dead) ); @endphp 
                <span class="float-right text-bold-600">
                  @if($all > 0) {{ number_format( ($validDoc * 100) / $all, 0) }}%
                  @else 0% @endif
                </span>
              </p>
              <div class="progress progress-sm mb-1 box-shadow-1">
                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: @if($all > 0) {{ number_format( ($validDoc * 100) / $all, 0) }}% @else 0% @endif" 
                  aria-valuenow="@if($all > 0) {{ number_format( ($validDoc * 100) / $all, 0) }}%
                  @else 0% @endif" aria-valuemin="0" aria-valuemax="100"></div>
              </div>


              <p class="pt-1">Exceeded Deadline 
                <span class="float-right text-bold-600">
                  @if($all > 0) {{ number_format( ($past_dead * 100) / $all, 0) }}%
                  @else 0% @endif
                </span>
              </p>
              <div class="progress progress-sm mb-1 box-shadow-1">
                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: @if($all > 0) {{ number_format( ($past_dead * 100) / $all, 0) }}% @else 0% @endif" 
                  aria-valuenow="@if($all > 0) {{ number_format( ($past_dead * 100) / $all, 0) }}%
                  @else 0% @endif" aria-valuemin="0" aria-valuemax="100"></div>
              </div>


              <p> Pending Assignment
                <span class="float-right text-bold-600">
                  @if($all > 0) {{ number_format( ($pending * 100) / $all, 0) }}%
                  @else 0% @endif
                </span>
              </p>
              <div class="progress progress-sm mb-1 box-shadow-1">
                <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: @if($all > 0) {{ number_format( ($pending * 100) / $all, 0) }}% @else 0% @endif" 
                  aria-valuenow="@if($all > 0) {{ number_format( ($pending * 100) / $all, 0) }}%
                  @else 0% @endif" aria-valuemin="0" aria-valuemax="100"></div>
              </div>


              <p> Assigned  @php $assign = ($all - $pending); @endphp
                <span class="float-right text-bold-600">
                  @if($all > 0) {{ number_format( ($assign * 100) / $all, 0) }}%
                  @else 0% @endif
                </span>
              </p>
              <div class="progress progress-sm mb-1 box-shadow-1">
                <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width: @if($all > 0) {{ number_format( ($assign * 100) / $all, 0) }}% @else 0% @endif" 
                  aria-valuenow="@if($all > 0) {{ number_format( ($assign * 100) / $all, 0) }}%
                  @else 0% @endif" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>






        
      <div class="col-md-4 no-pad">
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body"> <h4> Task  Chart </h4>

                    <div class="frame" style=""><canvas id="pastDeadlinLineChart"></canvas></div> 

                  </div>
                </div>
              </div>
          </div>
      </div>

                   

    </div>






























    {{-- TABLES --}}
    {{-- <div class="row">  
      <div class="col-md-12 no-pad">
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
    </div> --}}


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
    var ctx = document.getElementById('pendPieChart').getContext('2d');
    var chart = new Chart(ctx, 
    {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data: 
        {
            labels: [ @if($chart_legends) @foreach($chart_legends as $legend)"{{$legend}}", @endforeach @endif],
            datasets: 
            [          
                {
                    label: "Tasks", 
                    backgroundColor: ['#00CC99', '#FFEF00', '#ED872D'],  
                    borderColor: '#ffffff',
                    data: [@forelse($chart_data as $chart_data) "{{$chart_data}}", @empty @endforelse],
                },             
           ]
        },

        // Configuration options go here
        options: optionsPerc
    }); 

    //COMPLIANCE 
    var ctx = document.getElementById('pastDeadlinLineChart').getContext('2d');
    var chart = new Chart(ctx, 
    {
        type: 'bar',

        data: 
        {
            labels: [ @if($chart_past_legends) @foreach($chart_past_legends as $legend)"{{$legend}}", @endforeach @endif],
            datasets: 
            [ 
                {
                    label: "Tasks", 
                    backgroundColor: ['#00CC99', '#FFEF00', '#ED872D'],  
                    borderColor: '#ffffff',
                    data: [@forelse($chart_past_deadline as $chart_past_deadline) "{{$chart_past_deadline}}", @empty @endforelse],
                },          
           ]
        },
        options: optionsStartAtZero
    }); 


</script>

    


@endsection
