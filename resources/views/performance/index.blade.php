@extends('layouts.app')

@section('content')



    
<div class="row">     
                
    <div class="col-md-8"> 
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <h4>List Performance Settings</h4>

              <table class="table table-sm mb-0" id="">
                <thead class="thead-dark">
                  <tr>
                    <th>Metric Name</th>
                    <th>Weight</th>
                    <th>Created At</th>
                    <th style="text-align:right">Action </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($performance_metrics as $performance_metric)
                      <tr>
                        <td>{{ $performance_metric->metric_name }}</td>
                        <td>{{ $performance_metric->weight }}</td>
                        <td>{{date("F j, Y, g:i A", strtotime($performance_metric->created_at))}}</td> 
                        <td>
                          @if($performance_metric->status_id == 0)
                            <span title="Reactivate This Performnace Metric">
                              <a href="#" data-toggle="modal" data-target="#enable" onclick="setId({{$performance_metric->id}})" class="my-btn btn-sm text-success pull-right"> 
                              <i class="la la-check" aria-hidden="true" style="font-size:13px"></i></a>
                            </span>
                          @else
                          <span title="Disable This Performnace Metric"><a href="#" data-toggle="modal" data-target="#disable" onclick="putId({{$performance_metric->id}})" class="my-btn btn-sm text-danger pull-right"> <i class="la la-ban" aria-hidden="true" style="font-size:13px"></i></a>
                            </span>
                          @endif 

                          <a class="btn-sm text-info pull-right edit" data-toggle="tooltip" title="Edit Performnace Metric" id="{{$performance_metric->id}}"><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a>               
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
              {!! $performance_metrics->appends(Request::capture()->except('page'))->render() !!}

          </div>
        </div>
      </div>
    </div>
                
    <div class="col-md-4"> 
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <h4 id="title">New Performance Settings</h4>

              <form class="" action="{{url('performance')}}" method="post">
                {{ csrf_field() }}
                

                <div class="form-group">
                  <label for="">Performance Metric</label>
                  <input type="hidden" class="form-control" name="id" id="id">  
                  <input type="text" class="form-control" name="metric_name" id="metric_name" required>        
                </div>

                <div class="form-group">
                  <label for="">Metric Weight</label>
                  <input type="number" class="form-control" name="weight" id="weight"  min="0" max="5" placeholder="Maximun Weight : 5" required> 
                  <input type="hidden" class="form-control" name="type" id="" value="add_performance_metric">     
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-dark btn-sm pull-right" id="create">Create</button>        
                </div>

              </form>

          </div>
        </div>
      </div>
    </div>

</div>






<!-- DISABLE -->
<form class="" action="{{url('performance')}}" method="post">
  {{ csrf_field() }}
  <div id="disable" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header app_bg">
              <h4 class="modal-title">Disable This Metric</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>              
            </div>
                         
                  <input type="hidden" class="form-control" name="id" id="idd"> 
            <input type="hidden" class="form-control" name="type" id="" value="disable_metric">
            


         
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" name="" id="" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to DISABLE Details?')"> 
            <i class="fa fa-ban"></i> Disable </button>
          </div>
      </div>
      </div>  
  </div>
</form>

<!-- ENABLE -->
<form class="" action="{{url('performance')}}" method="post">
  {{ csrf_field() }}
  <div id="enable" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header app_bg">
              <h4 class="modal-title">Reactivate This Metric</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
                         
                  <input type="text" class="form-control" name="id" id="re_id"> 
            <input type="hidden" class="form-control" name="type" id="" value="enable_metric">
            


         
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" name="" id="" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to Reactivate Metric?')"> 
            <i class="fa fa-ban"></i> Reactivate </button>
          </div>
      </div>
      </div>  
  </div>
</form>

   
   
@endsection

@section('scripts')


<script>  
    //AJAX SCRIPT TO GET DETAILS FOR 
      $(function()
      {
        $('.edit').click(function(e)
        { 
          var id = this.id; 
          $.get('{{url('getPerformanceMetricDetials')}}?id=' +id, function(data)
          { 
            $('#id').val(id); 
            $('#metric_name').val(data.metric_name); 
            $('#weight').val(data.weight);  
            $('#title').html('Edit Performance Settings'); 
            $('#create').html('Update');  
          });       
        });
      });
    

    function setId(id)
    {
      $('#re_id').val(id); 
    }

    function putId(id)
    {
      $('#idd').val(id); 
    }

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
