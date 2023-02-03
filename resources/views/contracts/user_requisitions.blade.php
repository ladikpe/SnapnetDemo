{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <style type="text/css">
    
   /* .panel-title 
   {
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
              <h3> 
                <div class="row" style="margin-top: -10px">
                  <div class="col-md-9" style="">
                    Requisitions 
                  </div> 
                  <div class="col-md-3" style="">
                    <form method="get" action="{{ route('contracts.user_requisitions') }}">
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
                        <th>Requisition</th>
                        <th>Deadline</th>
                        <th>Assigned To</th>
                        <th>Contract Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($requisitions_assigned_to_users as $requisition_assigned_to_user)
                      <tr>
                        <td>{{ $requisition_assigned_to_user->requisition ? $requisition_assigned_to_user->requisition->name : 'N/A' }}</td>
                        <td>{{ $requisition_assigned_to_user->requisition ? $requisition_assigned_to_user->requisition->deadline : 'N/A' }}</td>
                        <td>{{ $requisition_assigned_to_user->user ? $requisition_assigned_to_user->user->name : 'N/A' }}</td>
                        <td>
                          <div class="badge badge-{{ $requisition_assigned_to_user->requisition->contract?($requisition_assigned_to_user->requisition->contract->status==0?'warning':($requisition_assigned_to_user->requisition->contract->status==1?'success':($requisition_assigned_to_user->requisition->contract->status==2?'danger':'N/A'))):'N/A' }}"> {{ $requisition_assigned_to_user->requisition->contract?($requisition_assigned_to_user->requisition->contract->status==0?'Pending':($requisition_assigned_to_user->requisition->contract->status==1?'Approved':($requisition_assigned_to_user->requisition->contract->status==2?'Rejected':''))):'N/A' }}                            
                          </div>
                        </td>
                        <td>{{ $requisition_assigned_to_user->requisition->author?$requisition_assigned_to_user->requisition->author->name:'N/A'}}</td>
                        <td>{{ date("F j, Y, g:i a", strtotime($requisition_assigned_to_user->requisition->created_at))}}</td>
                        <td>
                          @if(Auth::user()->role_id!=4) 
                            @if($requisition_assigned_to_user->requisition->contract_created == 0) 
                              <span  data-toggle="tooltip" title="Create Contract"><a href="{{ url('contracts/new?requisition_id='.$requisition_assigned_to_user->requisition->id) }}" class="my-btn btn-sm text-dark"><i class="la la-plus" aria-hidden="true"></i></a></span>
                            @else
                              
                            @endif
                          @elseif(Auth::user()->role_id == 5)
                            <span  data-toggle="tooltip" title="Delete"><a href="#" class="my-btn btn-sm text-danger" onclick="return confirm('Are you sure you want to UPDATE Requisition?')"><i class="la la-trash" aria-hidden="true"></i></a></span>
                          @endif
                        </td>
                      </tr>
                      @empty
                      
                      @endforelse
                    </tbody>
                  </table>
                      {!! $requisitions_assigned_to_users->appends(Request::capture()->except('page'))->render() !!}
                               

              </div>
            </div>
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
