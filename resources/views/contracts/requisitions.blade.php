{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <style type="text/css">
    
   /* .panel-title {
    display: block;
    margin-top: 0px;
    margin-bottom: 0px;
    font-size: 18px;
    padding: 20px 30px;
}*/
  </style>
@endsection

@section('content')




<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">       
              <h4 class="card-title" id="basic-layout-form"> Requisitions
              <button type="button" data-toggle="modal" data-target="#newRequisitionModal" class="btn btn-default btn-sm pull-right" style="color:#000 !important; background: #eee;"><i class="la la-plus"></i></button>
            </h4>
            
              {{-- <a href="#" data-toggle="modal" data-target="#newRequisitionModal" class="btn btn-float pull-right" style="color:#000 !important"><i class="la la-plus"></i></a> --}}
              <div class="media d-flex">

                  <table class="table table-sm mb-0">
                    <thead class="thead-dark">
                      <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Contract Status</th>
                        <th>Deadline</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($requisitions as $requisition)
                      <tr>
                        <td>{{ $requisition->name }}</td>
                        <td>{{ $requisition->description }}</td>
                        <td><div class="badge badge-{{ $requisition->contract?($requisition->contract->status==0?'secondary':($requisition->contract->status==1?'success':($requisition->contract->status==2?'danger':''))):'' }}"> 
                          {{ $requisition->contract?($requisition->contract->status==0?'Pending':($requisition->contract->status==1?'Approved':($requisition->contract->status==2?'Rejected':''))):'' }}</div>
                       </td>
                        <td>{{date("M j, Y", strtotime($requisition->deadline))}}</td>
                        <td>{{$requisition->author->name}}</td>
                        <td>{{date("F j, Y, g:i a", strtotime($requisition->created_at))}}</td>
                        <td>
                          @if(Auth::user()->role_id == 5)
                            @if($requisition->assigned == 0)
                            <span title="Assign Contract To A User">
                              <a class="my-btn btn-sm text-dark" data-toggle="modal" data-target="#assign" onclick="setId({{ $requisition->id }})">
                              <i class="la la-arrow-circle-right" aria-hidden="true"></i></a>
                            </span>
                            @endif
                          @endif
                          
                          <span  data-toggle="tooltip" title="Delete Requisition"><a href="{{ url('contracts/delete_requisition/'.$requisition->id) }}"  class="my-btn   btn-sm text-danger" onclick="return confirm('Are you sure you want to UPDATE Requisition?')"><i class="la la-trash" aria-hidden="true"></i></a></span>
                        </td>

                      </tr>
                      @empty
                      @endforelse
                  </tbody>
                  </table>               

              </div>
                  {!! $requisitions->render() !!} 
            </div>
          </div>
        </div>
    </div>
    
</div>










@if(Auth::user()->role_id == 5)
  <form class="" action="{{url('performance')}}" method="post">
  {{ csrf_field() }}
      <div class="modal fade text-left" id="newRequisitionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark white">
              <label class="modal-title text-text-bold-600" style="color:#fff">Assign To Legal Officers</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="card-block">
                    <div class="card-body">
                      <fieldset class="form-group">
                        <label for="user_id">Legal Officers</label>
                        <select class="form-control" name="user_id" id="user_id" required>
                          <option>Select Legal Officer</option>
                            @forelse($users as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                            @empty
                              <option>  </option>
                            @endforelse
                        </select>
                      </fieldset>

                        <h4 class="title">Rating Metrics</h4>
                        <table class="table table-stripped" id="">
                          <thead class="thead-dark">
                            <tr>
                              <!-- <th>Check</th> -->
                              <th>Metric Name</th>
                              <th>Weight</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($performance_metrics as $performance_metric)
                                <tr>
                                  <td> {{ $performance_metric->metric_name }}</td>
                                  <td>{{ $performance_metric->weight }}</td>
                                </tr>
                              @endforeach
                              <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" value=""> 
                              <input type="hidden" class="form-control" name="type" id="" value="assign_to_user"> 
                          </tbody>
                        </table>

                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-dark">Assign</button>
            </div>
          </div>
        </div>
      </div>
  </form>

@elseif(Auth::user()->role_id == 4)
  <form class="form-horizontal" method="POST" action="{{ route('contracts.save_requisitions') }}" enctype="multipart/form-data" >
  {{ csrf_field() }}
      <div class="modal fade text-left" id="newRequisitionModal" tabindex="-1" role="dialog" aria-labelledby="Label1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark white">
              <label class="modal-title text-text-bold-600" style="color:#fff">Create New Requisition</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="padding: 0px">
              
                <div class="card-block">
                    <div class="card-body">
                      
                      <label class="col-form-label">Requisition Name </label>
                      <fieldset class="form-group">
                        <input type="text" id="name"  class="form-control" placeholder="Requisition Name" name="name" value="" required />
                      </fieldset>


                      <div class="form-group row">
                        <label for="year_obli" class="col-sm-2 col-form-label"> Requisition Type </label>
                        <div class="col-sm-4">
                            <select class="form-control" id="requisition_type_id" name="requisition_type_id" required="">
                              <option value=""></option>
                              @forelse($requisition_types as $requisition_type)
                                <option value="{{$requisition_type->id}}">{{$requisition_type->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <label for="year_obli" class="col-sm-2 col-form-label"> Deadline </label>
                        <div class="col-sm-4">
                            <input type="text" id="deadline" class="form-control datepicker" placeholder="Contract deadline" name="deadline" readonly="" />
                        </div>
                      </div>

                      <label class="panel-title">Description </label>
                      <fieldset class="form-group">
                        <textarea name="description" class="form-control" cols="30" rows="4" required></textarea>
                      </fieldset>

                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-dark">Send Requisition Request</button>
            </div>
          </div>
        </div>
      </div>
  </form>
@endif    








@endsection

@section('scripts')

               
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}
<script>
    function setId(id)
    {
      $('#requisition_id').val(id);   
    }

    $(function() 
    {
      $('.select2').select2();
      $('.datepicker').datepicker(
        {
          format: 'yyyy-mm-dd',
          startDate: '-3d',
          autoclose:true
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
