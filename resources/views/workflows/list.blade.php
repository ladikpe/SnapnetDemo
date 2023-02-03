@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bootstrap-toggle-master/css/bootstrap-toggle.min.css')}}">
  <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.min.css')}}">
@endsection
@section('content')

    
<div class="row">
      <div class="col-md-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                  <h3 class="card-title" id="basic-layout-form">
                      <div class="row" style="margin-top: -10px">
                          <div class="col-md-12" style=""> 
                            <div class="badge badge-primary round text-white" style="padding: 5px 10px; font-size: 15px"> Workflows {{$workflows->count()}} </div>
                             {{--  <a href="{{route('workflows.create')}}" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right btn-sm" title="Create New Workflow"><i class="la la-plus"></i></a> --}}
                          </div>
                      </div>
                  </h3>
                  <div class="media d-flex">                    

                    <table class="table table-sm table-striped" id="">
                      <thead class="thead-dark">
                        <tr>
                          <th>Name</th>
                          <th>Active</th>
                          <th>No. of Stages</th>
                          <th>Created At</th>
                          <th style="text-align: right;">Action </th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($workflows as $workflow)
                            <tr>
                              <td>{{ $workflow->name }}</td>
                              <td><input type="checkbox" class="active-toggle" id="{{$workflow->id}}" {{$workflow->status==1?'checked':''}} data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger"></td>
                              <td><span class="badge">{{ $workflow->stages_count }}</span></td>
                              <td>{{ $workflow->created_at }}</td>
                              <td style="text-align: right;">
                                <span  data-toggle="tooltip" title="Edit"><a class="my-btn btn-sm text-info" id="{{$workflow->id}}" href="{{ route('workflows.edit',$workflow->id) }}"><i class="la la-pencil" aria-hidden="true"></i></a></span>

                                <span  data-toggle="tooltip" title="View"><a href="{{ route('workflows.view',$workflow->id) }}"  class="my-btn   btn-sm text-success"><i class="la la-eye-open" aria-hidden="true"></i></a></span>
                              </td>
                            </tr>
                          @endforeach
                      </tbody>

                    </table>
                  </div>
                  {!! $workflows->render() !!}
            </div>
          </div>
          </div>

        </div>

      {{-- <div class="col-md-3">
          <div class="card pull-up">
              <div class="card-content">
                  <div class="card-body">
                      <h3 class="panel-title">Filters</h3>

                      <form class="" action="{{route('workflows')}}" method="get">

                          <div class="form-group">
                              <label for="">Name Contains</label>
                              <input type="text" name="name_contains" class="form-control col-md-12" id="name_contains" placeholder="" value="{{ request()->name_contains }}">
                          </div>

                          <div class="form-group" >
                              <label for="">Stages</label> <br>
                              <select id="role_f" class=" select2 form-control col-md-12" name="stage_id" >
                                  <option value="">Select Stage</option>
                                  @forelse ($stages as $stage)
                                      <option value="{{$stage->id}}">{{$stage->name}}</option>
                                  @empty
                                      <option value="">No Stages Created</option>
                                  @endforelse
                              </select>
                          </div>
                          <br>
                          <br>

                          <div class="form-group">
                              <button type="submit" class="btn btn-outline-success btn-glow pull-right btn-sm" >Filter</button>
                              <button type="reset" class="btn btn-outline-default btn-glow pull-right btn-sm pull-right" >Clear Filters</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>

      </div> --}}

</div>







      
@endsection
@section('scripts')
  {{-- <script type="text/javascript" src="{{ asset('datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('datatables/datatables.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('toastr/toastr.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('.input-daterange').datepicker({
    autoclose: true
});
$('.select2').select2();
    var selected = [];
     var table =$('#gtable').DataTable();
     $('.active-toggle').change(function() {
       var id = $(this).attr('id');
        var isChecked = $(this).is(":checked");
        console.log(isChecked);
        $.get(
          '{{ route('workflows.alter-status') }}',
          { id: id, status: isChecked },
          function(data) {
            if(data=="enabled"){
              toastr.success('Enabled!', 'Workflow Status');
            }
            if(data=="disabled"){
              toastr.error('Disabled!', 'Workflow Status')
            }else{
              toastr.error(data, 'Workflow Status');

            }


          }
        );

    });
{{--
    $('#gtable tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);

        // if ( index === -1 ) {
        //     selected.push( id );
        // } else {
        //     selected.splice( index, 1 );
        // }

        $(this).toggleClass('selected');
    }); --}}
} );


  </script>





    @if(Session::has('success'))
        <script>
            $(function()
            {
                toastr.success('{{session('success')}}', {timeOut:100000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function()
            {
                toastr.error('{{session('error')}}', {timeOut:100000});
            });
        </script>
    @endif

@endsection
