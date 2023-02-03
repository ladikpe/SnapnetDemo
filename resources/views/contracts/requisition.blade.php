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


<form class="form-horizontal" method="POST" action="{{ route('contracts.save_requisitions') }}" enctype="multipart/form-data" >          
{{ csrf_field() }}
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">        <h3 class="panel-title">Create New Requisition</h3>
              <div class="media d-flex">

                <div class="col-md-6"> 

                  <div class="card-block" style="margin-bottom:-30px !important">
                    <div class="card-body">
                      <h3 class="panel-title">Contract Name </h3>
                      <fieldset class="form-group">
                        <input type="text" id="name"  class="form-control" placeholder="Contract Name" name="name" value="" required />
                      </fieldset>
                    </div>
                  </div>

                  <div class="card-block" style="margin-bottom:-30px !important">
                    <div class="card-body">
                      <h3 class="panel-title">Description </h3>
                      <fieldset class="form-group">
                        <textarea name="description" class="form-control" cols="30" rows="4" required></textarea>
                      </fieldset>
                    </div>
                  </div>

                  <div class="card-block" style="margin-bottom:-30px !important">
                    <div class="card-body">
                      <h3 class="panel-title">Contract Should Be Ready On  </h3>
                      <fieldset class="form-group">
                        <input type="text" id="deadline"  class="form-control datepicker" placeholder="Contract deadline" name="deadline"/>
                      </fieldset>
                    </div>
                  </div>



                  <br>
                  <div class="col-md-12">                      
                    <button type="submit" class="btn btn-dark">  Send Requisition Request </button>
                  </div>

                </div>


                <div class="col-md-5">

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
    startDate: '-3d',
    autoclose:true
});
  // $(window).resize(function () {
	// 			var h = Math.max($(window).height() - 0, 420);
	// 			$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
	// 		}).resize();
 
});
</script>
@endsection
