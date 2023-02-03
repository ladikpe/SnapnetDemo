@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  <style type="text/css">
    .perm {margin-bottom: 20px; background-color: #fff; border: 1px solid #ddd; border-radius: 4px;padding-top: 10px;padding-bottom: 5px;}
  </style>
@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="fa fa-file" aria-hidden="true"></span>&nbsp; Upload Document <small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">View Contract</li>
        </ol>
      </div>
    </section>

    <section id="main"  style="min-height:480px;">
      <div class="container">
        <div class="row">
  <form class="form-horizontal" method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data" >
          <div class="col-md-9">
            <!-- Website Overview -->

            @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                        {{ session('success') }}
                    </div>
                @endif
          
              {{ csrf_field() }}
                    
        

                <div class="panel panel-default">
                  <div class="panel-heading main-color-bg">
                    <h3 class="panel-title">Create New Contract</h3>
                  </div>
                  <div class="panel-body">
               <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            Template Name
                        </h3>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" id="name" class="form-control" placeholder="Template Name" name="name" value="{{$template->id!=1?$template->name:''}}" />
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
                    <div class="col-xs-12">
                        <textarea name="cover_page" id="cover_page" cols="30" rows="10">{{isset($template)?$template->cover_page:''}}</textarea>
                    </div>
                </div>
    


                    <div class="row">
                        <div class="col-xs-12">
                            <h3>
                                Content
                            </h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <textarea name="content" id="content" cols="30" rows="10">{{isset($template)?$template->content:''}}</textarea>
                        </div>
                    </div>

                    
        
    

                 
            
          
            <script>
                    CKEDITOR.replace( 'cover_page' );
                    CKEDITOR.replace( 'content' );
            </script>
              

             

                
                      
                    </div>
                    <div class="panel-footer">
                      
                      <button type="submit" class="btn btn-primary ">
                          Save Contract
                      </button>
                    </div>
                  </div>
              <!-- Latest Users -->
                





              <!-- Latest Users -->

          </div>
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading main-color-bg">
              <h3 class="panel-title">Create New Contract</h3>
            </div>
            <div class="panel-body">
              
              <div class="panel panel-default">
                  <div class="panel-heading main-color-bg">
                    <h3 class="panel-title">Tags</h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="">Tags</label>
                      <input type="text" value="" data-role="tagsinput" name="tags" />

                    </div>

                  </div>
                  </div>

                  <div class="panel panel-default">
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
                    </div>
                    

                      <div class="panel panel-default">
                        <div class="panel-heading main-color-bg">
                          <h3 class="panel-title">Group Access Control</h3>
                        </div>
                        <div class="panel-body">
                          <div id="grp-perm-cont"></div>
                          <a href="#" id="addGrpPerm">New Group Permission</a>
                         



                        </div>
                      </div>
            </div>
            </div>
        </div>
        </form>
        </div>



      </div>
    </section>
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
                $('<div class="row perm"> <div class="col-md-12">  <div class="form-group">     <select class="form-control select2" name="group_id[]">  @forelse($groups as $group)<option value="{{$group->id}}">{{$group->name}}</option> @empty<option value="">No Groups Created</option>    @endforelse  </select> </div> </div> <div class="col-md-12">   <div class="form-group"> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio1" value="1"> Forbidden </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio2" value="2"> View </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio3" value="3"> Download </label><br> <label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio4" value="4"> Write </label> <br><label class="radio-inline"> <input type="radio" name="perm[]" id="inlineRadio5" value="5"> Admin </label> </div>    </div>    <div class="col-md-12">  <a href="#" id="remGrpPerm" class="btn btn-sm btn-danger pull-right">X</a>  </div>  </div>').prependTo(stgcont);
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
                        $(this).parents('div .perm').remove();
                        i--;
                }
                return false;
  	});
});
</script>
@endsection
