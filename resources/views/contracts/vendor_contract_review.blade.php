{{-- template index --}}
@extends('layouts.vendorapp')
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
</style>
@endsection
@section('content')


<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<form class="form" id="frm" method="POST" action="{{ route('contract.vendor_save_review') }}">
  <div class="row">

    <div class="col-md-8">
      <div class="card" style="height: 962px;">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">Contract</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
             

            </ul>
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body">
@csrf

            <div class="form-body">
              <div class="form-group">
                <label for="companyName">Name</label>
                <input type="text" id="name" class="form-control" placeholder="Contract Name" value="{{$contract->name}}" class="form-control" {{$operation=='view'?'disabled':''}} name="name">
              </div>
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

              <div class="form-group">
                <label for="cover_page">Cover Page</label>
                <textarea id="cover_page" rows="5" class="form-control" {$operation=='view' ?'disabled':''}} name="cover_page">{{$detail->cover_page}}</textarea>
              </div>
              @endif
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
       
                    <input type="hidden" name="parent_id" value="{{$detail->id}}">
                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
      <div class="card" ">
                <div class=" card-header">
        <h4 class="card-title" id="basic-layout-form">Comments</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a class="btn " style="color:#fff;background: #000 !important" data-target="#addCommentModal" data-toggle="modal">Add Comment</a></li>
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>

          </ul>
        </div>
      </div>
      <div class="card-content collapse "  style="min-height:400px">
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
                          @if($comment->commentable_id==$vendor->id)
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
    <div class="card" ">
                <div class=" card-header">
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
            <option value="1">Approve</option>
            <option value="2">Reject</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Comment</label>
          <textarea rows="4" class="form-control" placeholder="Your Comment" name="comment" id="" required></textarea>
        </div>
        <div class="form-actions">

          <button type="submit" class="btn btn-primary">
            <i class="la la-check-square-o"></i> Save
          </button>
        </div>



      </div>
    </div>
  </div>

  

  @endif
 
 
 

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
          <input type="hidden" name="user_id" value="{{$vendor->id}}">
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