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
          <h4>Contract Categories  <a href="{{route('contract_categories.create')}}" class="btn btn-primary pull-right create">Create</a></h4>
          <div class="media d-flex">
      

          <div class="col-md-9">
            <!-- Website Overview -->

            @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
            <form class="form-horizontal" method="POST" action="{{ route('contract_categories.update',$contract_category->id) }}">
              {{ csrf_field() }}
              @method('PUT')
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">Contract categories Details</h3>
                </div>

                <div class="panel-body">


                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$contract_category->name}}";>
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
                        <option value="{{$workflow->id}}" {{ $contract_category->workflow->id==$workflow->id?'selected':'' }}>{{$workflow->name}}</option>
                      @empty
                        <option value="">No Workflow Created</option>
                      @endforelse
                    </select>
                    <!-- <p class="help-block">Help text here.</p> -->
                  </div>
                  
                </div>
                <div class="panel-footer">
                  <button type="submit" class="btn btn-primary">
                      Save Changes
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
