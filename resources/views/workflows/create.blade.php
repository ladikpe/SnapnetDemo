@extends('layouts.app')
@section('stylesheets')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <style media="screen">
    .form-cont{
      border: 1px solid #cccccc;
      padding: 10px;
      border-radius: 5px;
    }
    #stgcont {
      list-style: none;
    }
    #stgcont li{
      margin-bottom: 10px;
    }
  </style>
@endsection
@section('content')

    
<form class="form-horizontal" method="POST" action="{{ route('workflows.save') }}">   @csrf
<div class="row">

  <div class="col-md-9">
      {{-- <div class="col-md-12 no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 30px;">
          <button type="submit" id="saveBtn" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right"> <i class="fa fa-save"></i> Create Workflow </button>
      </div> --}}
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <h2>New Workflow  

            <button type="submit" id="saveBtn" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right"> <i class="fa fa-save"></i> Create Workflow </button></h2>

{{--                  <h3 class="panel-title">Workflow Details</h3>--}}

                  <div class="form-group">
                    <label for="name">Workflow Name  </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>

                    <h3 class="panel-title">Stage Details</h3>

                    <ul id="stgcont" style="padding: 0px">
                      
                    </ul>

                    <button type="button" id="addStage" name="button" class="btn btn-outline-info btn-glow pull-left btn-sm mb-2">New Stage</button>
         
              <!-- Latest Users -->
          </div>



        </div>

          </div>

        </div>




        <div class="col-md-3">      
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <h4> <i class="la la-help"> </i> Help </h4> <hr>

                <h5>New Workflow </h5>
                <div class="media d-flex">      
                  <div class="panel-body">
                    How to create new workflow
                  </div>
                </div> <br>

                <h5>Edit Workflow </h5>
                <div class="media d-flex">      
                  <div class="panel-body">
                    How to edit workflow
                  </div>
                </div> <br>

                <h5>Delete Workflow </h5>
                <div class="media d-flex">      
                  <div class="panel-body">
                    How to delete workflow
                  </div>
                </div> <br>

              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
@endsection
@section('scripts')
  <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() 
{
  $('.users').select2();
  $('#stgcont').sortable();

  var stgcont = $('#stgcont');
        var i = $('#stgcont li').length + 1;

        $('#addStage').on('click', function() 
        {
        	//console.log('working');
                $('<li><div class="form-cont"> <div class="row"> <div class="form-group col-md-6"> <label for="stagename">Stage Name </label>  <input type="text" class="form-control" name="stagename[]" id="" placeholder="" required> </div> <div class="form-group col-md-6"> <label for="">Users</label> <select class="form-control users" name="user_id[]" > <option value=""></option> @forelse ($users as $user) <option value="{{$user->id}}">{{$user->name}}</option> @empty <option value="">No Users Created</option> @endforelse </select> </div> </div> <div class="row">      <div class="form-group col-md-4 pull-left"> <label for="">Appends Signature</label> <select class="form-control users" name="signable[]"> <option value=""></option> <option value="1">Yes</option> <option value="0">No</option>  </select> </div>  <div class="form-group col-md-4"> <label for="">Is Shareable</label> <select class="form-control users" name="shareable[]"> <option value=""></option> <option value="1">Yes</option> <option value="0">No</option>  </select> </div>  <div class="form-group col-md-4"> <label for="">Can Appraise </label> <select class="form-control users" name="appraisal[]">  <option value=""></option>  <option value="1">Yes</option> <option value="0">No</option>  </select> <button type="button" class="btn btn-danger btn-sm pull-right mt-1" id="remStage" data-toggle="tooltip" title="Remove this stage" style="margin-top:-4px; padding:2px"> <i class="la la-close"></i> </button> </div> </div>  </div> </li>').appendTo(stgcont);
                //console.log('working'+i);
                i++;
                return false;
        });

        $(document).on('click',"#remStage",function() 
        {
        	//console.log('working'+i);
                if( i > 1 ) 
                {
                	 console.log('working'+i);
                        $(this).parents('li').remove();
                        i--;
                }
                return false;
  	});
    // $( "#stgcont" ).on( "sortchange", function( event, ui ) {
    //   var listItems = $("#stgcont li");
    //   p=0;
    //   listItems.each(function() {
    //
    //     position=$(this).find('.stg-position');
    //     position.val(p);
    //     p++;
    //   });
    // } );
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
