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
  @if(Auth::user()->department_id == 1)
     
    {{-- CARDS --}}
    <div class="row">

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('requisitions.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="primary font-large-1" > {{count($your_requisitions)}} </h2>         <h6>Tasks</h6>
                  </div>
                  <div>
                    <i class="la la-file-text-o primary font-large-2 float-right"></i>
                  </div>
                </div>    
                  @if($all_requisitions->count() > 0)                
                      @php $percent = (( count($your_requisitions) * 100 ) / count($all_requisitions) ) @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width:{{$percent}}%" aria-valuenow="{{count($your_requisitions)}}" aria-valuemin="0" aria-valuemax="{{count($all_requisitions)}}"> </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('pending-reviews') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="warning font-large-1">  {{$review_docs}} <i> of {{count($your_documents)}} </i></h2>         
                    <h6>Documents in Review</h6>
                  </div>
                  <div>
                    <i class="la la-rotate-right warning font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($your_documents->count() > 0)                
                      @php $percent = (($review_docs * 100 ) / count($your_documents) )  @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$review_docs}}" aria-valuemin="0" aria-valuemax="{{$your_documents}}"></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('document-creations.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="success font-large-1">{{$approved_docs}} <i> of {{count($your_documents)}} </i> </h2>         
                    <h6> Approved Documents</h6>
                  </div>
                  <div>
                    <i class="la la-check text-success success font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($your_documents->count() > 0)                
                      @php $percent = (( $approved_docs * 100 ) / count($your_documents) )  @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2"> 
                  <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width:{{$percent}}%" aria-valuenow="{{$approved_docs}}" 
                  aria-valuemin="0" aria-valuemax="{{count($your_documents)}}"> </div>
                </div>  
              </div>
            </div>
          </div>
        </a>
      </div>
      
      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('document-creations.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="danger font-large-1"> {{$rejected}} <i> of {{$doc}} </i></h2>         <h6>Declined Documents</h6>
                  </div>
                  <div>
                    <i class="la la-ban text-danger danger font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($doc > 0)                
                      @php $percent = (( $rejected * 100 ) / $doc)   @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: {{$percent}}%"
                  aria-valuenow="{{$rejected}}" aria-valuemin="0" aria-valuemax="{{$doc}}"></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      
    </div>



    {{-- TABLES --}}
    <div class="row">  
      <div class="col-md-6 no-pad">
        @if(\Auth::user()->department->department_head_id == \Auth::user()->id)
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">    
                    <h4> Pending Task Assignments <i class="text-danger ml-3">in red - past deadline</i>
                      <span id="ct_pend" class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px">  </span>
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:180px; max-height:180px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Task</th>
                              <th>Proposed Deadline</th>
                              <!-- <th>Created By</th> -->
                              <th>Date Created</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($unassigned_requisitions)
                              @forelse($unassigned_requisitions as $your_requisition)  @php $ct++;  @endphp                              
                                  <tr @if($your_requisition->deadline < $today) style="color: red;" @endif>
                                    <td>{{ $your_requisition->name}}</td>
                                    <td>{{ date("d M, Y", strtotime($your_requisition->deadline))}}</td>
                                    <!-- <td>{{ $your_requisition->author ? $your_requisition->author->name:'N/A'}}</td> -->
                                    <td>{{ date("M j, Y, g:i a", strtotime( $your_requisition->created_at))}}</td>
                                    <td style="text-align: right;">
                                      {{-- if user is department head --}}
                                        <a class="btn-sm pull-right" href="{{ url('task-detail', $your_requisition->id) }}"> <i class="la la-angle-double-right" data-toggle="tooltip" title="View Task" style="font-size:12px !important; color:#0047AB; padding:0px 2px !important" target="_black"></i>  
                                        </a>
                                      {{-- else --}}
                                        
                                      {{-- endif --}}
                                    </td>
                                  </tr>
                              @empty
                                No Task Pending Review                         
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

          <div class="col-md-12"> 
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">    
                    <h4> Documents Pending Review & Approval 
                      <span class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px">
                      {{$revapping_docs}}</span> 
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:180px; max-height:180px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Name</th>
                              <th>Stage</th>
                              <th>Created By</th>
                              <th>Created At</th>
                              <th style="text-align: right;"><i class="la la-cog"></i></th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($reviewing_docs) @forelse($reviewing_docs as $review)
                              <tr>
                                <td>{{$review->requisition?$review->requisition->name:''}}</td>
                                <td>{{$controllerName->getReviewStage($review->requisition_id)}}</td>
                                <td>{{$controllerName->getRequisitor($review->requisition_id)}}</td>
                                <td>{{date('M, j Y h:i:s a',strtotime($review->created_at))}}</td>
                                <td style="text-align: right;">
                                  <a class="btn btn-sm" href="{{ route('create-document', [$review->requisition_id, 'temp']) }}"> <i class="la la-rotate-right" data-toggle="tooltip" title="Go To Reviews"></i>  </a>
                                </td>
                              </tr>
                            @empty
                              No Document Pending Review / Approval                         
                            @endforelse
                            @endif
                        </tbody> 
                        </table> 
                      </div>
                      

                    </div>
                  </div>
                </div>
              </div>
          </div>
        @else
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">    
                    <h4> Task Assigned to You <i class="text-danger ml-3">in red - past deadline</i>
                      <span id="ct_pend" class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px">  </span>
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:180px; max-height:180px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Task</th>
                              <th>Proposed Deadline</th>
                              <!-- <th>Created By</th> -->
                              <th>Date Created</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($unassigned_requisitions)
                              @forelse($unassigned_requisitions as $your_requisition)  @php $ct++;  @endphp                              
                                  <tr @if($your_requisition->deadline < $today) style="color: red;" @endif>
                                    <td>{{ $your_requisition->name}}</td>
                                    <td>{{ date("d M, Y", strtotime($your_requisition->deadline))}}</td>
                                    <!-- <td>{{ $your_requisition->author ? $your_requisition->author->name:'N/A'}}</td> -->
                                    <td>{{ date("M j, Y, g:i a", strtotime( $your_requisition->created_at))}}</td>
                                    <td style="text-align: right;">
                                        <a class="btn-sm pull-right" href="{{url('document-creations')}}"> <i class="la la-plus" data-toggle="tooltip" title="View Task" style="font-size:12px !important; color:#0047AB; padding:0px 2px !important" target="_black"></i>  
                                        </a>
                                    </td>
                                  </tr>
                              @empty
                                No Task Pending Review                         
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

          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">    
                    <h4> Your Last 10 Tasks <i class="text-danger ml-3">in red - past deadline</i>
                      <span id="ct_pend" class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px"> {{$all_user_requisitions->count()}} </span>
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:180px; max-height:180px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Task</th>
                              <th>Proposed Deadline</th>
                              <!-- <th>Created By</th> -->
                              <th>Date Created</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($all_user_requisitions)
                              @forelse($all_user_requisitions as $your_requisition)  @php $ct++;  @endphp                              
                                  <tr @if($your_requisition->deadline < $today) style="color: red;" @endif>
                                    <td>{{ $your_requisition->name}}</td>
                                    <td>{{ date("d M, Y", strtotime($your_requisition->deadline))}}</td>
                                    <!-- <td>{{ $your_requisition->author ? $your_requisition->author->name:'N/A'}}</td> -->
                                    <td>{{ date("M j, Y, g:i a", strtotime( $your_requisition->created_at))}}</td>
                                    <td style="text-align: right;">
                                        <a class="btn-sm pull-right" href="{{url('document-creations')}}"> <i class="la la-plus" data-toggle="tooltip" title="View Task" style="font-size:12px !important; color:#0047AB; padding:0px 2px !important" target="_black"></i>  
                                        </a>
                                    </td>
                                  </tr>
                              @empty
                                No Task Pending Review                         
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

        @endif
      </div>

      
      <div class="col-md-6 no-pad">
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


  {{-- Others --}}
  @else
   
    {{-- CARDS --}}
    <div class="row">

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('requests.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="primary font-large-1" > {{count($all_user_requests)}} </h2>         <h6>Your Request(s)</h6>
                  </div>
                  <div>
                    <i class="la la-file-text-o primary font-large-2 float-right"></i>
                  </div>
                </div>    
                  @if($all_user_requests->count() > 0)                
                      @php $percent = (( count($all_user_requests) * 100 ) / count($all_user_requests) ) @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width:{{$percent}}%" aria-valuenow="{{count($all_user_requests)}}" aria-valuemin="0" aria-valuemax="{{count($all_user_requests)}}"> </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('pending-reviews') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="warning font-large-1">  {{$pending_requests->count()}} <i> of {{count($all_user_requests)}} </i></h2>         
                    <h6>Your Pending Request(s)</h6>
                  </div>
                  <div>
                    <i class="la la-rotate-right warning font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($all_user_requests->count() > 0)                
                      @php $percent = (($pending_requests->count() * 100 ) / count($all_user_requests) )  @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$pending_requests->count()}}" aria-valuemin="0" aria-valuemax="{{$all_user_requests}}"></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('document-creations.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="success font-large-1">{{$approved_requests->count()}} <i> of {{count($all_user_requests)}} </i> </h2>         
                    <h6> Your Approved Request(s)</h6>
                  </div>
                  <div>
                    <i class="la la-check text-success success font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($all_user_requests->count() > 0)                
                      @php $percent = (( $approved_requests->count() * 100 ) / count($all_user_requests) )  @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2"> 
                  <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width:{{$percent}}%" aria-valuenow="{{$approved_requests->count()}}" 
                  aria-valuemin="0" aria-valuemax="{{count($all_user_requests)}}"> </div>
                </div>  
              </div>
            </div>
          </div>
        </a>
      </div>
      
      <div class="col-xl-3 col-lg-6 col-12">
        <a class="" href="{{ route('document-creations.index') }}">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h2 class="danger font-large-1"> {{$declined_requests->count()}} <i> of {{count($all_user_requests)}} </i></h2>         
                    <h6>Your Declined Request(s)</h6>
                  </div>
                  <div>
                    <i class="la la-ban text-danger danger font-large-2 float-right"></i>
                  </div>
                </div>
                  @if($all_user_requests->count() > 0)                
                      @php $percent = (( $declined_requests->count() * 100 ) / count($all_user_requests))   @endphp
                  @else  
                      @php $percent = 0; @endphp
                  @endif
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: {{$percent}}%"
                  aria-valuenow="{{$declined_requests->count()}}" aria-valuemin="0" aria-valuemax="{{count($all_user_requests)}}"></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      
    </div>



    {{-- TABLES --}}
    <div class="row">
      <div class="col-md-6 no-pad">
        
          <div class="col-md-12"> 
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">    
                    <h4> Your Pending Request(s) 
                      <span id="ct_pend" class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px">  </span>
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:250px; max-height:250px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Name</th>
                              <th>Category</th>
                              <!-- <th>Created By</th> -->
                              <th>Date Created</th>
                              <th style="text-align: right;"><i class="la la-list"></i></th>
                            </tr>
                          </thead>
                          <tbody>   
                            @php $ct = 0; @endphp
                            @if($pending_requests)
                              @forelse($pending_requests as $pending_request)  @php $ct++;  @endphp               
                                    <tr>
                                      <td>{{ $pending_request->purpose}}</td>
                                      <td>{{ $pending_request->type?$pending_request->type->name:''}}</td>
                                      <!-- <td>{{ $pending_request->author ? $pending_request->author->name:'N/A'}}</td> -->
                                      <td>{{ date("M j, Y, g:i a", strtotime( $pending_request->created_at))}}</td>
                                      <td style="text-align: right;">
                                          <a class="btn-sm pull-right" href="{{url('requests')}}"> <i class="la la-eye" data-toggle="tooltip" title="View Request" style="font-size:12px !important; color:#0047AB; padding:0px 2px !important" target="_black"></i>  
                                          </a>
                                      </td>
                                    </tr>
                              @empty   
                                No Request Pending Review                     
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

          <div class="col-md-12"> 
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">    
                    <h4> Your Declined Request(s)
                      <span class="badge badge-pill badge-primary badge-up badge-glow" style="margin-right:15px">
                      {{$declined_requests->count()}}</span> 
                    </h4>
                    <div class="media d-flex"> 

                      <div class="table-responsive" style="min-height:250px; max-height:250px">
                        <table id="recent-orders" class="table table-striped table-sm mb-0">
                          <thead class="" style="background: #ddd; color: black">
                            <tr>
                              <th>Name</th>
                              <th>Stage</th>
                              <th>Created By</th>
                              <th>Created At</th>
                              <th style="text-align: right;"><i class="la la-cog"></i></th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($declined_requests)
                            @forelse($declined_requests as $declined_request)
                              <tr>
                                <td>{{$declined_request->purpose}}</td>
                                <td><span class="badge badge-danger">Declined</span></td>
                                <td>{{$declined_request->author?$declined_request->author->name:''}}</td>
                                <td>{{date('M, j Y h:i:s a',strtotime($declined_request->created_at))}}</td>
                                <td style="text-align: right;">
                                  {{-- <a class="btn btn-sm" href="{{ route('create-document', [$declined_request->requisition_id, 'temp']) }}"> <i class="la la-rotate-right" data-toggle="tooltip" title="Go To Reviews"></i>  </a> --}}
                                </td>
                              </tr>
                            @empty    
                              No Declined Request                   
                            @endforelse
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

  @endif













      
      


<div class="row">

      {{-- <div class="col-md-6"> 
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">    
              <h4> Your Assigned Tasks Past Deadline
                <span id="dead_past" class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow" style="margin-right:15px">
                {{count($your_requisitions)}}</span> 
              </h4>
              <div class="media d-flex"> 

                <div class="table-responsive" style="min-height:180px; max-height:180px">
                  <table class="table table-sm mb-0">
                    <thead class="" style="background: green; color: white">
                      <tr>
                        <th>Name</th>
                        <th>Deadline</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th style="text-align: right;"><i class="la la-cog"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $today = date('Y-m-d');  $deadline = 0; @endphp
                        @forelse($your_requisitions as $your_requisition)
                          @if($your_requisition->requisition?$your_requisition->requisition->deadline < $today:'')       @php $deadline++;  @endphp
                            <tr>
                              <td>{{ $your_requisition->requisition ? $your_requisition->requisition->name : 'N/A'}}</td>
                              <td>{{ $your_requisition->requisition ? $your_requisition->requisition->deadline : 'N/A'}}</td>
                              <td>{{ $your_requisition->requisition ? $your_requisition->requisition->author->name:'N/A'}}</td>
                              <td>{{ date("F j, Y, g:i a", strtotime( $your_requisition->requisition->created_at))}}</td>
                              <td style="text-align: right;">
                                <a class="btn-sm pull-right" href="{{url('contracts/new/?requisition_id='.$your_requisition->id)}}"> <i class="la la-plus" data-toggle="tooltip" title="Go To Contract Templates" style="font-size:12px !important; color:#202020; padding:0px 2px !important"></i>  
                                </a>
                              </td>
                            </tr>
                          @endif
                      @empty
                        No Contracts Pending Review                         
                      @endforelse
                                <input type="hidden" class="form-control" id="deadline" value="{{$deadline}}" /> 
                    </tbody> 
                  </table> 
                </div>
                

              </div>
            </div>
          </div>
        </div>
      </div>
        
      
      
        
      <div class="col-md-6"> 
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">    
                  <h4> Rejected Contracts  
                    <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow" style="margin-right:15px">
                    {{count($rejected)}}</span> 
                  </h4>
                  <div class="media d-flex"> 

                    <div class="table-responsive" style="min-height:280px; max-height:280px">
                      <table class="table table-sm mb-0">
                        <thead class="" style="background: green; color: white">
                          <tr>
                            <th>Name</th>
                            <th>Stage</th>
                            <th>Position</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($rejected as $Rejected)
                            <tr>
                              <td>{{$Rejected->contract->name}}</td>
                              <td>{{$Rejected->stage->name}}</td></td>
                              <td>{{$Rejected->stage->position+1}}</td></td>
                              <td>{{$Rejected->contract->user->name}}</td>
                              <td>{{date('F, j Y h:i:s a',strtotime($Rejected->contract->created_at))}}</td>
                              <td>
                                <a class="btn btn-sm" href="{{url('approve_contract/'.$Rejected->id)}}"> <i class="la la-check-square-o" data-toggle="tooltip" title="Go To Approval"></i>  </a>
                              </td>
                            </tr>
                          @empty
                            No Contracts Rejected                         
                          @endforelse
                      </tbody> 
                      </table> 
                    </div>
                    

                  </div>
                </div>
              </div>
            </div>
        </div> --}}
   
    
    
 
    </div>

  




  
@endsection
@section('scripts')
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>

  <script>
    $('#folder')
      .jstree({
        'core' : {
          'data' : {
            'url' : '{{url('folders/get_node')}}',
            'data' : function (node) 
            {
              return { 'id' : node.id };
            }
          },
          'check_callback' : true,
          'themes' : {
            'responsive' : false
          }
        }
      });
  </script>


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
    


@endsection
