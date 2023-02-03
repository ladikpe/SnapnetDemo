@extends('layouts.app')
@section('stylesheets')

<style type="text/css">
  
</style>

@endsection
@section('content')

<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Calendar</div>
                            </div>
                        </h3>

                        <div class="" id='calendar'></div>



                    </div>
                </div>
            </div>
        </div>

    </div>


  
@endsection
@section('scripts')


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
  
@endsection
  


 