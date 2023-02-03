{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

<!-- Font Awesome Css -->
<link href="{{ asset('assets/e-signature/css/font-awesome.min.css') }}" rel="stylesheet" />

<!-- Bootstrap Select Css -->
<link href="{{ asset('assets/e-signature/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Custom Css -->
<link href="{{ asset('assets/e-signature/css/app_style.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('assets/e-signature/css/jquery.signaturepad.css') }}" rel="stylesheet">

<style>
  * 
  {
    box-sizing: border-box;
  }

  /* Set a background color */


  /* The actual timeline (the vertical ruler) */
  .timeline {
    box-sizing: border-box;
    position: relative;
    max-width: 400px;
    margin: 0 auto;
  }

  /* The actual timeline (the vertical ruler) */
  .timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: #252a32;
    top: 0;
    bottom: 0;
    left: 90%;
    margin-left: -3px;
  }

  /* Container around content */
  .conta {
    padding: 10px 20px;
    position: relative;
    background-color: inherit;
    width: 89%;
  }

  /* The circles on the timeline */
  .conta::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: -17px;
    background-color: #61D4E8;
    border: 4px solid #2DA1E7;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
  }

  /* Place the container to the left */
  .left {
    left: 0;
  }

  /* Place the container to the right */
  .right {
    left: 0;
  }

  /* Add arrows to the left container (pointing right) */
  .left::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 18px;
    width: 0;
    z-index: 1;
    right: 10px;
    border: medium solid #252a32;
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent #252a32;
  }

  /* Add arrows to the right container (pointing left) */
  .right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid #252a32;
    border-width: 10px 10px 10px 0;
    border-color: transparent #252a32 transparent transparent;
  }

  /* Fix the circle for containers on the right side */
  .right::after {
    left: -16px;
  }

  /* The actual content */
  .content {
    padding: 5px 5px;
    background-color: white;
    position: relative;

    /* border: 1px #252a32 solid; */
    padding-bottom: 15px;
  }

  .content-user {

    background-color: #252a32;
    width: 100%;
    color: #fff;


    /* border: 1px #252a32 solid; */
  }

  /* Media queries - Responsive timeline on screens less than 600px wide */
  @media screen and (max-width: 600px) {

    /* Place the timelime to the left */
    .timeline::after {
      left: 31px;
    }

    /* Full-width containers */
    .conta {
      width: 100%;
      padding-left: 70px;
      padding-right: 25px;
    }

    /* Make sure that all arrows are pointing leftwards */
    .conta::before {
      left: 60px;
      border: medium solid white;
      border-width: 10px 10px 10px 0;
      border-color: transparent white transparent transparent;
    }

    /* Make sure all circles are at the same spot */
    .left::after,
    .right::after {
      left: 15px;
    }

    /* Make all right containers behave like the left ones */
    .right {
      left: 0%;
    }

    .content hr {
      padding-top: 0px !important;
      padding-bottom: 0px !important;
    }


  }

  .bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: white;
    /* color: #c2185b; */
    background-color: #1976d2;
  }

  .hov:hover
  {
    background-color: #eee !important;
  }




    
    #signArea
    {
      width:304px;
      margin: 15px auto;
    }
    .sign-container 
    {
      width: 90%;
      margin: auto;
    }
    .sign-preview 
    {
      width: 150px;
      height: 50px;
      border: solid 1px #CFCFCF;
      margin: 10px 5px;
    }
    .tag-ingo 
    {
      font-family: cursive;
      font-size: 12px;
      text-align: left;
      font-style: oblique;
    }
    .center-text 
    {
      text-align: center;
    }
</style>


@endsection
@section('content')


<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<form class="form" id="frm" action="{{ route('contracts.update',['id'=>$contract->id]) }}" method="Post">
@csrf
  <div class="row">

    <div class="col-md-8">

      
      @if (session('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
              {{ session('success') }}
          </div>
      @elseif (session('error'))
          <div class="alert alert-error alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
              {{ session('error') }}
          </div>
      @endif

      <div class="card" style="height: 962px;">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">Contract</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>{{$contract->vendor_approved==1?' Latest Version Approved By Vendor':($contract->vendor_approved==2?'Latest Version Rejected By Vendor':'Latest Version Not Reviewed By Vendor')}}</li>
              @if($operation!='view')
              @if($review->stage->shareable == 1)
            <li><a href="{{url('share_vendor_contract?contract_id='.$contract->id)}}" class="btn btn-success btn-round btn-sm" style="color:#fff;" data-toggle="tooltip" title="Share with vendor">
                <i class="la la-send"></i></a>
                </li>
              @endif
                @endif
            </ul>
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body">

            <div class="form-body">
              <div class="form-group">
                <label for="companyName">Name</label>
                <input type="text" id="name" class="form-control" placeholder="Contract Name" value="{{$contract->name}}" class="form-control" {{$operation=='view'?'disabled':''}} name="name">
              </div>
              @if($operation=='view')
              <div class="col-xs-12">

                <div style="width: 100%; border: 1px solid #999; padding: 11px; /* margin-left: 15px; */ margin-bottom: 14px; height: 200px;
                        overflow-y: scroll; overflow-x: scroll; /* margin-right: 15px; */ ">
                  {!!$detail->cover_page!!}
                </div>


              </div>
              @else

              <div class="form-group">
                <label for="cover_page">Cover Page</label>
                <textarea id="cover_page" rows="5" class="form-control" {$operation=='view' ?'disabled':''}} name="cover_page">{{$detail->cover_page}}</textarea>
              </div>
              @endif
              @if($operation=='view')
              <div class="col-xs-12">

                <div style="width: 100%; border: 1px solid #999; padding: 11px; /* margin-left: 15px; */ margin-bottom: 14px; height: 200px;
                                            overflow-y: scroll; overflow-x: scroll; /* margin-right: 15px; */ ">
                  {!!$detail->content!!}
                </div>


              </div>
              @else
              <div class="form-group">
                <label for="cover_page">Content</label>
                <textarea id="content" {{$operation=='view'?'disabled':''}} rows="5" class="form-control" name="content">{{$detail->content}}</textarea>
              </div>
              @endif
            </div>
            <div class="form-actions">

              <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Save
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>

    
    <div class="col-md-4">

       @if($operation!='view')
       {{ method_field('PUT') }}
       <input type="hidden" name="parent_id" value="{{$detail->id}}">
       <input type="hidden" name="review_id" value="{{$review->id}}">
      <div class="card">
                <div class=" card-header">
        <h4 class="card-title" id="basic-layout-form"><a class="btn btn-sm" style="color:#fff;background: #000 !important" data-target="#addCommentModal" data-toggle="modal">Add Comments</a>

          @if($review->stage->signable)
            <a id="" class="my-btn btn-sm pull-right" data-toggle="modal" data-target="#signature" style="background: #202020; color: #fff"> <i class="la la-flash" aria-hidden="true"> Sign</i></a>
          @endif
        </h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            @if($contract->user_id == Auth::user()->id)
              @if($contract->ContractPerformance->isNotEmpty()) 
                <li><a id="{{$contract->id}}" class="btn btn-sm btn-round hov view" style="color:#000;background: #fff; !important" data-target="#viewRatingModel" data-toggle="modal" title="View Contract Ratings"><i class="la la-eye"> </i></a></li>
              @else 
                <li><a class="btn btn-sm btn-round hov" style="color:#000;background: #fff; !important" data-target="#ratingModel" onclick="putId({{$contract->id}})" data-toggle="modal" title="Rate This Contract"><i class="la la-star"> </i></a></li>
              @endif                
            @endif
            
            @if($operation!='view')
              @if($review->stage->appraisal == 1)
                {{-- <li><a id="{{$review->contract->id}}" class="btn btn-sm btn-round hov rate_model fetch_rate" style="color:#000;background: #fff; !important" data-target="#rateModel" data-toggle="modal" title="Rate Contract Performance" onclick="PutMgrRateId({{$review->contract->id}})"><i class="la la-star">  </i></a></li> --}}
              @endif
            @endif

            <!-- <li><a id="" class="btn btn-sm btn-round hov" style="color:#fff;background: #000; !important" data-target="#rateModel" data-toggle="modal" title="Rate Contract"><i class="la la-star"> </i></a></li>
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->

          </ul>
        </div>
      </div>
      <div class="card-content collapse"  style="min-height:400px">
        <div class="card-body">
          
           @foreach($contract->comments as $comment)
            
            <div class="bs-callout-warning callout-round callout-bordered callout-transparent mt-1 pl-2">
              <div class="media align-items-stretch">
                <div class="media-body p-1">
                  <strong>{{$comment->commentable?$comment->commentable->name:''}}</strong>
                  <p>{{$comment->comment}}</p>
                  <strong>{{date('F,j Y h:i:s a',strtotime($comment->updated_at))}}</strong>
                </div>
                <div class="media-right media-middle bg-danger p-2">
                  @if($comment->user_id==\Auth::user()->id)
                <a href="" title="Delete comment">
                      <i class="la la-trash white font-medium-5 mt-1"></i>
                </a>
                  @endif
                </div>
              </div>
            </div>
         
          @endforeach



        </div>
      </div>
    </div>
    @endif
    @if($operation!='view')
    <div class="card">
                <div class="card-header">
      <h4 class="card-title" id="basic-layout-form">Contract Approval</h4>
      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">


        </ul>
      </div>
    </div>

    <div class="card-content collapse show">
      <div class="card-body">
        <div class="form-group">
          <label for="form-label">Select Action</label>
          <select class="form-control" name="action" required>
            <option value="approve">Approve</option>
            <option value="reject">Reject</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Comment</label>
          <textarea rows="4" class="form-control" placeholder="Your Comment" name="comment" id="" required></textarea>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-sm"> <i class="la la-check-square-o"></i> Save </button>
        </div>

      </div>
    </div>
  </div>

  <div class="card">
                <div class="card-header">
    <h4 class="card-title" id="basic-layout-form">Tags</h4>

  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="form-group">
        <label for="">Tags</label>
        <input type="text" value="" id="tags" class="form-control" name="tags" data-role="tagsinput" />
      </div>

    </div>
  </div>
  </div>

  @endif
  @if($operation=='view')
  <div class="card">
                <div class=" card-header">
    <h4 class="card-title" id="basic-layout-form">Tags</h4>

  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      @foreach($contract->tags as $tag)
      <span class="label label-primary">{{$tag->name}}</span>
      @endforeach

    </div>
  </div>
  </div>
  @endif
  <div class="card">
                <div class=" card-header">
    <h4 class="card-title" id="basic-layout-form">Change Histories</h4>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li><a href="{{url('contracts/download_version_history/').'/'.$contract->id}}" class="btn btn-primary btn-sm" style="color:#fff;background: #000 !important">Download in Excel</a></li>


      </ul>
    </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <table class="table table-sm mb-0" id="">
        <thead>
          <tr>
            <th>Version Number</th>
            <th>Created By</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach($contract->contract_details as $detail)
          <tr>
            <td><a href="{{$operation=='approve'?url("approve_contract/".$review->id."/".$detail->id) :url("contracts/show/".$contract->id."/".$detail->id)}}">Version {{$i}}.0</a></td>
            <td>{{$detail->updatable?$detail->updatable->name:''}}</td>
            <td>{{date("F j, Y, g:i a", strtotime($detail->created_at))}}</td>
          </tr>
          @php
          $i++;
          @endphp
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
  </div>
  <!--  -->
  <div class="card">
                <div class=" card-header">
    <h4 class="card-title" id="basic-layout-form">Approval Histories</h4>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li><a href="{{url('contracts/download_approval_history/').'/'.$contract->id}}" class="btn btn-primary btn-sm" style="color:#fff;background: #000 !important">Download in Excel</a></li>


      </ul>
    </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <table class="table table-sm mb-0" id="">
        <thead>
          <tr>
            <th>Stage</th>
            <th>Duration</th>
            <th>Approved By</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($contract->contract_reviews->sortByDesc('created_at') as $review)
          <tr>
            <td>{{$review->stage->name}}</td>
            <td>{{ $review->created_at==$review->updated_at?\Carbon\Carbon::parse($review->created_at)->diffForHumans():\Carbon\Carbon::parse($review->created_at)->diffForHumans($review->updated_at) }}</td>
            <td>{{$review->approver?$review->approver->name:''}}</td>
            <td> <span class="label label-{{$review->status==0?'warning':($review->status==1?'success':($review->status==2?'danger':''))}}">{{$review->status==0?'pending':($review->status==1?'approved':($review->status==2?'rejected':''))}}</span></td>
          </tr>
          @endforeach

        </tbody>

      </table>

    </div>
  </div>
  </div>

  </div>

  </div>
</form>








<script>
  CKEDITOR.replace('cover_page');
  CKEDITOR.replace('content');
</script>
{{-- add modal --}}
<div class="modal fade text-left" id="addCommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <form class="form-horizontal" id="addCommentForm" method="POST" action="{{url('contracts/add_comment')}}">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel19">Add New Comment</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="cover_page">Comment</label>
            <textarea id="contract_comment" required rows="5" class="form-control" name="comment"></textarea>
          </div>
          <input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
          <input type="hidden" name="contract_id" value="{{$contract->id}}">
          <input type="hidden" name="contract_comment_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>







        

<!-- Rate Performance -->
<form id="RateForm" action="{{url('performance')}}" method="post">
<input type="hidden" name="token" id="token" value="{{csrf_token()}}">
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
                        <thead class="thead-dark">
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
                    <thead class="thead-dark">
                      <tr>
                        <th>Metric Name</th>
                        <th>Rating</th>
                        <th>Weight</th>
                        <th>Rated By</th>
                      </tr>
                    </thead>
                    <tbody id="row">
                          
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
                        <thead class="thead-dark">
                          <tr>
                            <th>Metric Name</th>
                            <th>Previous Rating</th>
                            <th>Star</th>
                            <th>Rating</th>
                            <th>Weight</th>
                          </tr>
                        </thead>
                        <tbody id="row_mgr_rate">
                            @foreach ($performance_metrics as $performance_metric)
                              <tr>
                                <td> {{ $performance_metric->metric_name }} 
                                <input type="hidden" class="form-control" name="metric_{{$performance_metric->id}}" id="metric_{{$performance_metric->id}}" style="width:80%" value="{{$performance_metric->id}}">  
                                </td>
                                <td id="add"> 
                                  <input type="hidden" class="form-control" id="add_{{$performance_metric->id}}" style="width:10%; padding: 2px 10px">  
                                </td>
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
                          <input type="hidden" class="form-control" name="type" id="" value="rate_performances"> 
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


<!-- View Rate Rating -->            
<form class="viewRateForm" action="{{url('performance')}}" method="post">
<input type="hidden" name="token" id="token" value="{{csrf_token()}}">
<input type="hidden" class="form-control" name="type" id="" value="view_rate_performance"> 
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
                    <thead class="thead-dark">
                      <tr>
                        <th>Metric Name</th>
                        <th>Previous Rating</th>
                        <th>Weight</th>
                        <th>Rated By</th>
                        <th style="text-align:right">Your Rating</th>
                      </tr>
                    </thead>
                    <tbody id="row_mgr">
                          
                    </tbody>
                  </table>      
                  
                  <input type="hidden" class="form-control" name="contracted_id" id="mgr_contract_id" value="">  
                     
                  <input type="hidden" class="form-control" name="count" id="count" value="{{count($performance_metrics)}}">                  

              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" id="saveBtn">Save Ratings</button>
      </div>
    </div>
  </div>
</div>
</form> 


<!--  Rating Performance-->            
<form class="viewRatedForm" action="{{url('performance')}}" method="post">
@csrf
<input type="hidden" class="form-control" name="type" id="" value="rated_performance"> 
<div class="modal fade text-left" id="viewRateMgrModel" tabindex="-1" role="dialog" aria-labelledby="ratingMgrModel" aria-hidden="true">
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
              <div class="card-body" id="view_rate">

                  <table class="table table-sm mb-0" id="">
                    <thead class="thead-dark">
                      <tr>
                        <th>Metrics</th>
                        <th>Weight</th>
                        <th>Legal Officer Rating</th>
                        <th>Rated By</th>
                        <th>Manager Rating</th>
                        <th>Rated By</th>
                      </tr>
                    </thead>
                    <tbody id="row_mgrs">
                      @foreach ($metrics as $metric)
                        <tr>
                          <td> {{ $metric->metric_name }} 
                            <input type="hidden" class="form-control" name="metric_{{$metric->id}}" id="metric_{{$metric->id}}" style="width:40%" value="{{$metric->id}}"> </td>
                          <td> {{ $metric->weight }} </td>
                          <td> <input type="text" class="form-control" name="legal_{{$metric->id}}" id="legal_{{$metric->id}}" style="width:40%" class="legal">
                          </td>
                          <td> <div id="legal_rate_{{$metric->id}}" class=""> </div> </td>
                          <td> <input type="text" class="form-control" name="manager_{{$metric->id}}" id="manager_{{$metric->id}}" style="width:40%" class="manager">
                          </td>
                          <td> <div id="manager_rate_{{$metric->id}}"> </div> </td>
                          
                          <input type="hidden" class="form-control" name="idd_{{$metric->id}}" id="idd_{{$metric->id}}" style="width:40%">
                        </tr>
                      @endforeach
                    </tbody>
                  </table>      
                  
                  <input type="hidden" class="form-control" name="contract_id" id="all_contract_id" value="">                       
                  <input type="hidden" class="form-control" name="count" id="count" value="{{count($metrics)}}">                 
                  <input type="hidden" class="form-control" name="role" id="role" value="{{\Auth::user()->role_id}}">                 

              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" id="save_btn">Save Ratings</button>
      </div>
    </div>
  </div>
</div>
</form> 


<!--  Rating Performance-->            
<form class="RatedForm" action="{{url('performance')}}" method="post">
@csrf
<input type="hidden" class="form-control" name="type" id="" value="rated_performance"> 
<div class="modal fade text-left" id="rateModel" tabindex="-1" role="dialog" aria-labelledby="rateModel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="rate_model"> Performance Ratings</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <div class="card-block">
              <div class="card-body" id="view_rate">

                   <div class="row">
                    <div class="col-lg-12 col-xl-12" style="padding: 0px">
                      <!-- <div class="mb-1">
                        <h5 class="mb-0">Collapsible with Basic Color</h5>
                      </div> -->
                      <div class="card collapse-icon accordion-icon-rotate">

                        <div id="headingcol_0" class="bg-dark" style="padding:3px 10px; margin-bottom:8px">
                          <a data-toggle="collapse" href="#col_0" aria-expanded="true" aria-controls="collapse31" class="card-title lead white"> Contract Creator</a>
                        </div>

                            <div id="col_0" role="tabpanel" aria-labelledby="headingcol_0" class="card-collapse collapse" aria-expanded="true">
                              <div class="card-content">
                                <div class="card-body">
                                  
                                  <table class="table table-sm mb-0" id="">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th>Metric Name</th>
                                        <th>Weight</th>
                                        <th>Contract Creator Rating</th>
                                        <th>Rated By</th>
                                      </tr>
                                    </thead>
                                    <tbody id="row_mgrs">
                                      @foreach ($metrics as $metric)
                                        <tr>
                                          <td> {{ $metric->metric_name }} 
                                            <input type="hidden" class="form-control" name="metric_{{$metric->id}}" id="metric_{{$metric->id}}" style="width:40%" value="{{$metric->id}}"> </td>
                                          <td> {{ $metric->weight }} </td>
                                          <td> <div id="legals_{{$metric->id}}" class="legal"> </div> </td>
                                          <td> <div id="legals_rate_{{$metric->id}}" class=""> </div> </td>
                                          
                                          <input type="hidden" class="form-control" name="idd_{{$metric->id}}" id="idd_{{$metric->id}}" style="width:40%">
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

                        @foreach($contract->workflow->stages as $stage)
                          @if($stage->appraisal == 1 && $stage->user_id == \Auth::user()->id)
                            <div id="headingcol_{{$stage->id}}" class="bg-dark" style="padding:3px 10px; margin-bottom:8px">
                              <a data-toggle="collapse" href="#col_{{$stage->id}}" aria-expanded="true" aria-controls="collapse31" class="card-title lead white"> {{$stage->name}} </a>
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
                                          <td> <input type="number" class="form-control" name="manager_{{$stage->user_id}}_{{$metric->id}}" id="manager_{{$stage->user_id}}_{{$metric->id}}" style="width:40%" class="legal" min="0" max="{{ $metric->weight }}" placeholder="Max : {{ $metric->weight }}" required>
                                          </td>
                                          <td> <div id="manager_rate_{{$stage->user_id}}_{{$metric->id}}" class=""> </div> </td>
                                          
                                          <input type="hidden" class="form-control" name="idd_{{$stage->user_id}}_{{$metric->id}}" id="idd_{{$stage->user_id}}_{{$metric->id}}" style="width:40%">
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>      

                                </div>
                              </div>
                            </div>
                          @endif
                        @endforeach
                        
                      </div>
                    </div>
                  </div>               

              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" id="save_btn">Save Ratings</button>
      </div>
    </div>
  </div>
</div>
</form> 




<!-- Signature Modal -->
<form class="" method="post">
{{ csrf_field() }}
<div class="modal fade text-left" id="signature" tabindex="-1" role="dialog" aria-labelledby="signature" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="rate_model"> Sign Below</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
      <div class="modal-body">
        
          <div class="card-block">
              <div class="card-body" id="view_rated">

                <div id="signArea" >
                  <h2 class="tag-ingo">Put signature below,</h2>
                  <div class="sig sigWrapper" id="holder" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                  </div>
                </div> 

 
                    
                <div class="sign-container">
                @php
                  $image_list = glob("./doc_signs/*.png");
                  foreach($image_list as $image)
                  {
                    //echo $image;
                    @endphp
                    <img src="@php echo $image; @endphp" class="sign-preview" /> 
                    @php
                  }
                @endphp
                </div>     

              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSaveSign" class="btn btn-success btn-sm">Save</button>
        <button id="btnCleared" class="btn btn-warning btn-sm">Clear</button>
      </div>
    </div>
  </div>
</div>
</form>





@endsection

@section('scripts')
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}

<script type="text/javascript">
  $(document).ready(function() 
  {
    $('#tags').tagsinput('add', '@foreach($contract->tags as $tag) @if($loop->last){{$tag->name}} @else {{$tag->name}}, @endif @endforeach');
    $('#toggle_comments').on('click', function() {

      // alert($('#toggle_comments').text());
      // console.log($('#toggle_comments').text());

      if ($('#toggle_comments').text() == "Hide Comments") 
      {
        $('#toggle_comments').html("Show Comments");
      }
      if ($('#toggle_comments').text() == "Show Comments") 
      {
        $('#toggle_comments').html("Hide Comments");
      }
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

 
  });

  function putId(id)
  {
   	$('#contracted_id').val(id);     
  }

  function mgrPutId(id)
  {
   	$('#contract_mgr_id').val(id);     
  }

  function PutMgrId(id)
  {
   	$('#mgr_contract_id').val(id);     
  }

  function PutMgrRateId(id)
  {
   	$('#all_contracted_id').val(id);     
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
          $('#row_mgr').append('<tr class="table_row"> <td> '+dataObj.metric.metric_name+' </td>  <td><b> '+dataObj.rating+' </b> </td> <td><b> '+dataObj.metric.weight+' </b> </td> <td> '+dataObj.author.name+' </td>  <td> <input type="text" class="form-control pull-right" name="added_'+dataObj.metric.id+'" id="added_'+dataObj.metric.id+'" style="width:30%; padding: 3px 10px;" max-length="5" value="">  <input type="hidden" class="form-control" name="metric_'+dataObj.metric.id+'" id="metric_'+dataObj.metric.id+'" style="width:40%" value="'+dataObj.metric.id+'"> </td> </tr> ');  
        });
      });   

      $.get('{{url('getManagerRatingDetails')}}?id=' +id, function(data)
      {  
          $.each(data, function(index, mgrDataObj)
          {                  
            $('#added_'+mgrDataObj.performance_metric_id+'').val(mgrDataObj.rating); 
            $('#row_mgr').append(' <input type="hidden" class="form-control" name="id_" id="id_" value="'+mgrDataObj.id+'"> ');
          });
      });    
    });


    //WHEN THERE IS NOT RATINGS
    $('.rate_model').click(function(e)
    { 

      var id = this.id;        var role = $('#role').val();     var u_id = $('#u_id').val();
      if(role == 1)
      {
        $('.manager').hide();
      }
      $.get('{{url('getLegalRatings')}}?id=' +id, function(data)
      { 
        // $('.row_mgrs').remove();
        $.each(data, function(index, legalObj)
        {  
           $('#legals_'+legalObj.performance_metric_id+'').html(legalObj.rating);
           $('#legals_rate_'+legalObj.performance_metric_id+'').html(legalObj.author.name);
        });
      });  
      
      $.get('{{url('getManagerRatings')}}?id=' +id, function(data)
      {        
        // $('.row_mgrs').remove();
        $.each(data, function(index, managerObj)
        {           
           $('#manager_'+u_id+'_'+managerObj.performance_metric_id+'').val(managerObj.rating);
           $('#manager_rate_'+u_id+'_'+managerObj.performance_metric_id+'').html(managerObj.author.name);
           $('#idd_'+u_id+'_'+managerObj.performance_metric_id+'').val(managerObj.id);
        });
      });  
 
    });

  });




     

  function showmodal(modalid,url=0,hrefid=0)
  {
    if(url!=0)
    {
      $('#'+hrefid).attr('href',url);
    }
      $('#'+modalid).modal('show');
  } 

  //function to process form data
  function processForm(formid, route, modalid)
  {

    formdata= new FormData($('#'+formid)[0]);
    formdata.append('_token','{{csrf_token()}}');
    
      $.ajax(
      {
          // Your server script to process the upload
          url: route,
          type: 'POST',
          data: formdata,
          cache: false,
          contentType: false,
          processData: false,
          success:function(data, status, xhr)
          {
              if(data.status=='ok')
              {
                  $('#'+modalid).modal('hide');
                  toastr.success(data.success, {timeOut:10000});
                  return;
              }
            
              return toastr.error(data.error, {timeOut:10000});
          },
          // Custom XMLHttpRequest
          xhr: function() 
          {
              var myXhr = $.ajaxSettings.xhr();
              if (myXhr.upload) 
              {
                  // For handling the progress of the upload
                  myXhr.upload.addEventListener('progress', function(e) 
                  {
                      if (e.lengthComputable) 
                      {
                          percent=Math.round((e.loaded/e.total)*100,2);
                          $('#'+progress).css('width',percent+'%');
                          $('#'+progress+'_text').text(percent+'%');
                      }
                  }, false);
              }
              return myXhr;
          }
      });

  }


  $(function()
  {          
      $("#viewRateForm").on('submit', function(e)
      { 
          e.preventDefault();
          processForm('viewRateForm', "{{url('performance')}}", 'viewRatingMgrModel');
      });
               
      $("#viewRatedForm").on('submit', function(e)
      { 
          e.preventDefault();
          processForm('viewRatedForm', "{{url('performance')}}", 'viewRateMgrModel');
      });
  });

  $(function()
  {          
      $(".fetch_rating").on('click', function(e)
      { 
          var id = this.id;           
          var id = id.substring(6, 7);
          // alert(id);

          $.get('{{url('getRatingDetails')}}?id=' +id, function(data)
          { 
            // $('#add').remove(); 
            $.each(data, function(index, dataObj)
            {
              $('#add_'+dataObj.performance_metric_id+'').val(dataObj.rating);  
            });
          });
      });
  });

</script>





{{-- E-SIGNATURE --}}
  <script src="{{ asset('assets/e-signature/js/numeric-1.2.6.min.js') }}"></script> 
  <script src="{{ asset('assets/e-signature/js/bezier.js') }}"></script>
  <script src="{{ asset('assets/e-signature/js/jquery.signaturepad.js') }}"></script> 
  
  <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
  <script src="{{ asset('assets/e-signature/js/json2.min.js') }}"></script>

  <script>

    $(function(e)
    {

      $(function() 
      {
        $('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
      });
      
      $("#btnSaveSign").click(function(e)
      {
      
        html2canvas([document.getElementById('sign-pad')], {
          onrendered: function (canvas) 
          {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            
            
            $.ajax({
            url:'{{url('/save-signature')}}',
            data: { img_data:img_data,_token: '{{csrf_token()}}', contract_id: '{{$contract->id}}' },
            type: 'post',
            dataType: 'json',
            success: function (response) 
            {
              if(response.status == 1)
              {
                  alert('Signature Appended Successfully');
              }
              else
              {
                  alert("Failed To Append Signature, Please Try Again!");
              }
              // console.log(response); 
              $('#signature').trigger('click');
              $('#signArea').signaturePad().clearCanvas();
            }
          });
          }
        });
      });
      
      
      //clear signature   
      $("#btnCleared").click(function(e)
      {
         $('#signArea').signaturePad().clearCanvas();
      });

    });
  </script>

@endsection