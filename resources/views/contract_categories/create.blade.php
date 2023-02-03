@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')

    
<div class="row">
  <div class="col-md-12">      
    <div class="card pull-up">
      <div class="card-content">
        <div class="card-body">
          <h4>Contract Categories </h4>
          <div class="media d-flex">



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
            <form class="form-horizontal" method="POST" action="{{ route('contract_categories.save') }}">
              {{ csrf_field() }}
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">Contract Categories Details</h3>
                </div>

                <div class="panel-body">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Workflow</label>
                    <select class="form-control " name="workflow_id" >
                      @forelse ($workflows as $workflow)
                        <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                      @empty
                        <option value="">No Workflow Created</option>
                      @endforelse
                    </select>
                    <!-- <p class="help-block">Help text here.</p> -->
                  </div>
                 
                </div>
                <div class="panel-footer">
                  <button type="submit" class="btn btn-primary">
                      Create Contract Categories
                  </button>

                </div>
                </div>
                </form>





              <!-- Latest Users -->

          </div>


          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Contract Categories</h3>
              </div>
              <div class="panel-body">
                <div id="data" class="demo"></div>

              </div>
              </div>
          </div>


        </div>

      </div>
    </div>
  </div>
</div>

</div>


@endsection
@section('scripts')
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">

</script>
@endsection
