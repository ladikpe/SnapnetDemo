@extends('layouts.app')
@section('stylesheets')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

  <style media="screen">
    .form-cont
    {
      border: 1px solid #cccccc;
      padding: 10px;
      border-radius: 5px;
    }
    #stgcont 
    {
      list-style: none;
    }
    #stgcont li
    {
      margin-bottom: 10px;
    }
  </style>
  
@endsection
@section('content')

    
<form class="form-horizontal" method="POST" action="{{ route('workflow.update', $workflow->id) }}">
{{ csrf_field() }}
@method('PUT')
<div class="row">
  <div class="col-md-10 offset-md-1">      
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <h4>Workflows </h4>
          <div class="media d-flex">

            

              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{$workflow->name}}" placeholder="">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>


                <h4 class="panel-title">Stage Details</h4>



                <ul id="stgcont" style="padding: 0px">
                  @foreach ($workflow->stages as $stage)
                    <li>
                      <div class="form-cont">

                        <div class="row" style="padding: 5px 0px 20px 0px">
                          <div class="col-md-3" style="">
                            <input type="hidden" name="stage_id[]" value="{{$stage->id}}">
                            <div class="form-group">
                              <label for="">Name</label>
                              <input type="text" class="form-control" name="stagename[]" id="" placeholder="" value="{{$stage->name}}" required>
                            </div>
                          </div>                         


                          <div class="col-md-3" style="">                            
                            <div class="form-group">
                              <label for="">Users</label>
                              <select class="form-control users" name="user_id[]" >
                                @forelse ($users as $user)
                                  <option value="{{$user->id}}" {{ $user->id==$stage->user->id? 'selected':'' }}>{{$user->name}}</option>
                                @empty
                                  <option value="">No Users Created</option>
                                @endforelse
                              </select>
                            </div>
                          </div>

                          <div class="col-md-3" style="">
                            <div class="form-group">
                             <label for="">Appends Signature</label>
                              <select class="form-control users" name="signable[]" >
                                <option value="1" {{$stage->signable==1?'selected':''}}>Yes</option>
                                 <option value="0" {{$stage->signable==0?'selected':''}}>No</option>  
                              </select>
                            </div>
                          </div>


                          <div class="col-md-3" style="">      
                            <div class="form-group">
                             <label for="">Can Appriase</label>
                              <select class="form-control users" name="appraisal[]" >
                                <option value="1" {{$stage->appraisal==1?'selected':''}}>Yes</option>
                                 <option value="0" {{$stage->appraisal==0?'selected':''}}>No</option>  
                               </select>
                            </div>
                          </div>

                        </div>


                        {{-- <div class="form-group">
                          <button type="button" class="btn btn-outline-danger btn-glow pull-right btn-sm" id="remStage" 
                          style="margin-top: -10px">Remove Stage</button>
                        </div> --}}
                      </div>
                    </li>
                  @endforeach
                </ul>

                {{-- <button type="button" id="addStage" name="button" class="btn btn-outline-info btn-glow btn-sm pull-left ">New Stage</button>            --}}

                {{-- <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right ">  Save Changes </button> --}}

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>


  
</div>
</form>
@endsection


@section('scripts')
  {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
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
          $('<li> <div class="form-cont"> <div class="row" style="padding: 5px 0px 20px 0px"> <div class="col-md-3" style=""> <input type="hidden" name="stage_id[]" value="{{$stage->id}}"> <div class="form-group"> <label for="">Name</label> <input type="text" class="form-control" name="stagename[]" id="" placeholder="" value="" required> </div> </div>  <div class="col-md-3" style="">  <div class="form-group"> <label for="">Users</label> <select class="form-control users" name="user_id[]" > <option value=""></option>  @forelse ($users as $user) <option value="{{$user->id}}">{{$user->name}}</option> @empty <option value="">No Users Created</option>  @endforelse </select> </div>  </div> <div class="col-md-3" style=""> <div class="form-group"> <label for="">Appends Signature</label> <select class="form-control users" name="signable[]" > <option value=""></option>  <option value="1">Yes</option>  <option value="0">No</option>  </select> </div>  </div> <div class="col-md-3" style="">   <div class="form-group"> <label for="">Can Appriase</label> <select class="form-control users" name="appraisal[]" > <option value=""></option>  <option value="1">Yes</option> <option value="0">No</option>   </select> </div> </div>  </div> <div class="form-group"> <button type="button" class="btn btn-outline-danger btn-glow pull-right btn-sm" id="remStage"  style="margin-top: -10px">Remove Stage</button> </div>  </div> </li>').appendTo(stgcont);
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
