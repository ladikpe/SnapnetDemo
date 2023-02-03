{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<style type="text/css">
  * {
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

    border: 1px #252a32 solid;
    padding-bottom: 15px;
  }

  .content-user {

    background-color: #252a32;
    width: 100%;
    color: #fff;


    border: 1px #252a32 solid;
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
      padding-bittom: 0px !important;
    }


  }
</style>
@endsection
@section('content')


<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<div class="row">

  <div class="col-md-9 pull-left">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">

              @if (session('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span> </button>
                {{ session('success') }}
              </div>
              @endif

              <div class="panel panel-default" style="width:100%; border:thin dotted #e1e1e1">
                <div class="panel-heading main-color-bg panel-heading-with-action">
                  <!-- <h3 class="panel-title">Contracts </h3> -->
                  <div class="panel-actions pull-right">
                    @if($operation!='view')
                    <button class="btn btn-primary btn-sm" style="color:#000;background: #fff !important" data-target="#addCommentModal" data-toggle="modal">Add Comment</button>
                    <button type="button" class="btn btn-primary btn-sm" style="color:#000;background: #fff !important" id="toggle_comments">Hide Comments</button>
                    @endif
                  </div>
                </div>

                <div class="panel-body">
                  <div class="{{ $operation!='view'?'col-md-9':''}}" id="content_area">

                    <div class="form-group">
                         <h3>
                          Name
                        </h3>
                          <input class="form-control border-primary" type="email" placeholder="email" id="userinput5">
                        </div>



                    <div class="row">
                      <div class="col-xs-12" style="width:100%;">
                        <h3>
                          Name
                        </h3>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-12">
                        <input type="text" id="name" value="{{$contract->name}}" class="form-control" {{$operation=='view'?'disabled':''}} placeholder="Template Name" name="name" />
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-xs-12">
                        <h3>
                          Cover Page
                        </h3>
                      </div>
                    </div>

                    <div class="row">

                      @if($operation=='view')
                      <div class="col-xs-12">

                        <div style="
                                            width: 100%;
                                            border: 1px solid #999;
                                            padding: 11px;
                                            /* margin-left: 15px; */
                                            margin-bottom: 14px;
                                            height: 200px;
                                            overflow-y: scroll;
                                            overflow-x: scroll;
                                            /* margin-right: 15px; */
                                        ">
                          {!!$detail->cover_page!!}
                        </div>


                      </div>
                      @else
                      <div class="col-xs-12">
                        <textarea name="cover_page" id="cover_page" {{$operation=='view'?'disabled':''}} cols="30" rows="10" class="form-control">{{$detail->cover_page}}</textarea>
                      </div>
                      @endif

                    </div>



                    <div class="row">
                      <div class="col-xs-12">
                        <h3>
                          Content
                        </h3>
                      </div>
                    </div>
                    <div class="row">
                      @if($operation=='view')
                      <div class="col-xs-12">

                        <div style="
                                            width: 100%;
                                            border: 1px solid #999;
                                            padding: 11px;
                                            /* margin-left: 15px; */
                                            margin-bottom: 14px;
                                            height: 200px;
                                            overflow-y: scroll;
                                            overflow-x: scroll;
                                            /* margin-right: 15px; */
                                        ">
                          {!!$detail->content!!}
                        </div>


                      </div>
                      @else
                      <div class="col-xs-12">
                        <textarea name="content" id="content" {{$operation=='view'?'disabled':''}} cols="30" rows="10" class="form-control">{{$detail->content}}</textarea>
                      </div>
                      @endif
                    </div>

                    <!-- <div class="row">
                                                  <div class="col-xs-12" style="margin-top: 12px;">
                                                  <button id="btn_save" class="btn btn-success">Create</button>
                                                  <button type="button" id="btn_cancel" class="btn btn-warning">Cancel</button>
                                                  </div>
                                          </div> -->






                    @if($operation!='view')
                    {{ method_field('PUT') }}
                    <input type="hidden" name="parent_id" value="{{$detail->id}}">
                    <input type="hidden" name="review_id" value="{{$review->id}}">
                    <script>
                      CKEDITOR.replace('cover_page');
                      CKEDITOR.replace('content');
                    </script>
                    @endif
                  </div>
                  @if($operation!='view')
                  <div class="col-md-3 pull-right" id="comment_area" style="border:thin dotted red">
                    <div class="timeline">
                      @foreach($contract->comments as $comment)
                      <div class="conta left">
                        <div class="content">


                          <p>{{$comment->comment}}</p>
                          <hr style="margin-top: 0px;margin-bottom: 0px;">
                          <span>{{$comment->author->name}}</span><br>
                          <span>{{date('F,j Y h:i:s a',strtotime($comment->updated_at))}}</span>
                          @if($comment->user_id==\Auth::user()->id)
                          <a href="{{url('contracts/delete_comment?contract_comment_id='.$comment->id)}}" class="btn btn-sm btn-danger pull-right" title="Delete comment"><i class="fa fa-trash"></i></a>
                          @endif
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  @endif
                </div>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">


            
              @if($operation!='view')
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg ">
                  <h3 class="panel-title"> Contract Approval</h3>
                </div>



                <div class="panel-body" style="max-height: 1000px; overflow: auto;">

                  {{-- <form method="POST" action="" style="border: thin solid #eee; border-radius:5px"> --}}
                  <div class="row" style="padding: 7px;">
                    <div class="col-xs-12 mb-2">
                      <label class="form-label">Select Action</label>
                      <select class="form-control" name="action" id="" required>

                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                      </select>
                    </div>

                    <div class="col-xs-12 mb-2" style="margin-top: 10px">
                      <label class="form-label">Comment</label>
                      <textarea rows="4" class="form-control" placeholder="Your Comment" name="comment" id="" required></textarea>
                    </div>

                    <div class="col-xs-12 mb-2">
                      <button type="submit" class="btn btn-primary btn-sm pull-right" id="" style="margin-top: 10px">Save Changes</button>
                    </div>

                  </div>



                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">Tags</h3>
                </div>
                <div class="panel-body">

                  <div class="form-group">
                    <label for="">Tags</label>
                    <input type="text" value="" id="tags" name="tags" data-role="tagsinput" />

                  </div>

                </div>
              </div>
              @endif


              @if($operation=='view')
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">Tags</h3>
                </div>
                <div class="panel-body">
                  @foreach($contract->tags as $tag)
                  <span class="label label-primary">{{$tag->name}}</span>
                  @endforeach
                </div>
              </div>
              @endif
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg panel-heading-with-action">
                  <h3 class="panel-title"> Change Histories</h3>
                  <div class="panel-actions pull-right">


                    <a href="{{url('contracts/download_version_history/').'/'.$contract->id}}" class="btn btn-primary btn-sm" style="color:#000;background: #fff !important">Download in Excel</a>

                  </div>
                </div>

                <div class="row" style="padding: 7px;">
                  <div class="col-xs-12 mb-2">
                    {{-- <ul class="list-group">
                                      @php
                                        $i=1;
                                      @endphp
                                      @foreach($contract->contract_details as $detail)
                                      <li class="list-group-item"> <a href="{{$operation=='approve'?url("approve_contract/".$review->id."/".$detail->id) :url("contracts/show/".$contract->id."/".$detail->id)}}">Version {{$i}}.0</a> </li>
                    @php
                    $i++;
                    @endphp
                    @endforeach

                    </ul> --}}
                    <div class="panel-body table-responsive">
                      <table class="table table-stripped" id="">
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
                            <td>{{$detail->user->name}}</td>
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

                <div class="panel panel-default">
                  <div class="panel-heading main-color-bg panel-heading-with-action">
                    <h3 class="panel-title"> Approval Histories</h3>
                    <div class="panel-actions pull-right">


                      <a href="{{url('contracts/download_approval_history/').'/'.$contract->id}}" class="btn btn-primary btn-sm" style="color:#000;background: #fff !important">Download in Excel</a>

                    </div>
                  </div>

                  <div class="row">
                    <div class="panel-body ">
                      <table class="table table-stripped" id="">
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
        </div>
      </div>
    </div>
  </div>

            <form method="POST" id="frm" action="{{ route('contracts.update',['id'=>$contract->id]) }}">
                    @csrf




            </form>










            {{-- add modal --}}
            <div class="modal fade in modal-3d-flip-horizontal modal-info" id="addCommentModal" aria-hidden="true" aria-labelledby="addCommentModal" role="dialog">
              <div class="modal-dialog ">
                <form class="form-horizontal" id="addCommentForm" method="POST" action="{{url('contracts/add_comment')}}">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title" id="comment_title">Add New Comment</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row ">
                        <div class="col-xs-12">
                          @csrf

                          <div class="form-group">
                            <h4 class="example-title">Comment</h4>
                            <textarea class="form-control" name="comment" id="contract_comment" required></textarea>
                          </div>


                          <input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
                          <input type="hidden" name="contract_id" value="{{$contract->id}}">
                          <input type="hidden" name="contract_comment_id" value="">
                        </div>
                        <div class="clearfix hidden-sm-down hidden-lg-up"></div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="col-xs-12">

                        <div class="form-group">

                          <button type="submit" class="btn btn-info pull-left">Save</button>
                          <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        </div>
                        <!-- End Example Textarea -->
                      </div>
                    </div>
                  </div>
                </form>
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
  <script type="text/javascript">
    $(document).ready(function() {

      $('#tags').tagsinput('add', '@foreach($contract->tags as $tag) @if($loop->last){{$tag->name}} @else {{$tag->name}}, @endif @endforeach');
      $('#toggle_comments').on('click', function() {

        // alert($('#toggle_comments').text());
        // console.log($('#toggle_comments').text());

        if ($('#toggle_comments').text() == "Hide Comments") {
          $('#toggle_comments').html("Show Comments");
        }
        if ($('#toggle_comments').text() == "Show Comments") {
          $('#toggle_comments').html("Hide Comments");
        }
      });
    });
  </script>
  @endsection