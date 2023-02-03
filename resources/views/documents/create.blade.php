@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endsection
@section('content')





<form class="form-horizontal" method="POST" action="{{ route('documents.save') }}" enctype="multipart/form-data">
{{ csrf_field() }}

<div class="row">
  <div class="col-md-12"> 
      <div class="col-md-7 pull-left">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">

                <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">File</h3>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label for="">Select New File</label>
                    <input type="File" class="form-control" name="file[]" placeholder="" multiple>
                    {{-- <p class="help-block">Help text here.</p> --}}
                  </div>

                </div>
                

                  <div class="panel-heading main-color-bg">
                    <h3 class="panel-title">Details</h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="">Description</label>
                    <textarea name="description" class="form-control" ></textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="">Comment</label>
                    <textarea name="description" class="form-control" ></textarea>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="">Expires</label>
                      <input type="text" name="expires" class="form-control datepicker" value="">

                    @if ($errors->has('expires'))
                        <span class="help-block">
                            <strong>{{ $errors->first('expires') }}</strong>
                        </span>
                    @endif
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-5 pull-left">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">        
                                  
                  
                  <div class="panel panel-default">

                    <div class="panel-heading main-color-bg">
                      <h3 class="panel-title">Permissions</h3>
                    </div>

                    @if (Auth::user()->role_id!=3)
                      <div class="form-group">
                        <label for="">Assigned User</label>
                        <select class="form-control select2 pull-right" name="assigned_user">
                          @forelse ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                          @empty
                            <option value="">No Users Created</option>
                          @endforelse
                        </select>
                        <!-- <p class="help-block">Help text here.</p> -->
                      </div>
                    @else
                      <input type="hidden" name="assigned_user" value="{{Auth::user()->id}}">
                    @endif



                    <div class="panel-heading main-color-bg">
                      <h3 class="panel-title">Tags</h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="">Tags</label>
                        <input type="text" value="" data-role="tagsinput" name="tags" />
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                      </div>

                    </div>
                    

                      <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">Workflow</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="">Workflow</label>
                          <select class="form-control select2" name="workflow_id">
                            @forelse ($workflows as $workflow)
                              <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                            @empty
                              <option value="">No WorkFlows Created</option>
                            @endforelse
                          </select>
                          <!-- <p class="help-block">Help text here.</p> -->
                        </div>

                      </div>
                      

                      @if (Auth::user()->role_id!=3)
                      
                        <div class="panel-heading main-color-bg">
                          <h3 class="panel-title">Folder</h3>
                        </div>
                        <div class="panel-body">
                          <div id="data" class="demo"></div>

                        </div>
                        
                      @endif


                          <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Group Access </h3>
                          </div>
                          <div class="panel-body">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Group</th>
                                  <th>Permission</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="grp-perm-cont">
                                <tr>
                                  <td colspan="3"> <a href="#" id="addGrpPerm">New Group Permission</a> </td>
                                </tr>
                              </tbody>
                            </table>



                          </div>
                          
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary">  Upload Document </button>
                            </div>
                          </div>
                        
                <!-- Latest Users -->
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
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}
<script type="text/javascript">
$(document).ready(function() {
  $('.select2').select2();
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
});
  // $(window).resize(function () {
	// 			var h = Math.max($(window).height() - 0, 420);
	// 			$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
	// 		}).resize();
  $('#data')
  .jstree({
    'core' : {
      'multiple':false,
						'data' : {
							'url' : '{{url('folders/get_node')}}',
							'data' : function (node) {
								return { 'id' : node.id };
							}
						},
						'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
					},"checkbox" : {
            three_state : false, // to avoid that fact that checking a node also check others
            whole_node : false,  // to avoid checking the box just clicking the node
            tie_selection : false
	},"plugins":["checkbox"]
});
  $('#data').on('check_node.jstree', function (e, data) {

    //console.log(data.node.id);
    $.get('{{route('folders.ajax')}}', { 'id' : data.node.id })
      .fail(function () {
        data.instance.refresh();
      })
      .done(function(response){
        console.log(response);
      });
  });

  var stgcont = $('#grp-perm-cont');
        var i = $('#grp-perm-cont tr').length -1;

        $('#addGrpPerm').on('click', function() {
        	//console.log('working');
                $('<tr class="perm"><td ><div class="form-group"><select class="form-control select2" name="group_id[]"> @forelse($groups as $group)<option value="{{$group->id}}">{{$group->name}}</option> @empty<option value="">No Groups Created</option>@endforelse</select></div> </td> <td > <div class="form-group"> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio1" value="1"> Forbidden </label> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio2" value="2"> View </label> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio3" value="3"> Download </label> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio4" value="4"> Write </label> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio5" value="5"> Admin </label> </div> </td> <td > <a href="#" id="remGrpPerm">Remove</a> </td> </tr>').prependTo(stgcont);
                //console.log('working'+i);
                $( ".perm" ).each(function( index ) {

                  $( this).find( "input:radio" ).attr( "name", "perm_"+index );

                });
                i++;
                console.log(i);
                return false;
        });

        $(document).on('click',"#remGrpPerm",function() {
        	//console.log('working'+i);
                if( i >= 1 ) {
                	 console.log('working'+i);
                        $(this).parents('tr').remove();
                        i--;
                }
                return false;
  	});
});
</script>
@endsection
