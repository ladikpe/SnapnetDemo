@extends('layouts.app')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ asset('datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('datatables/datatables.min.css')}}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.min.css')}}">
@endsection
@section('content')



    
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
				      <h4>Contract Categories</h4>
              <div class="media d-flex">

            <table class="table table-sm mb-0" id="gtable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Created At</th>
                  <th>Workflow</th>
                  <th>Action <a href="{{route('contract_categories.create')}}" class="pull-right" style="color:#202020 !important"><i class="la la-plus"></i></a></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($contract_categories as $contract_category)
                    <tr>
                      <td>{{ $contract_category->name }}</td>
                      <td>{{ $contract_category->created_at }}</td>
                      <td>{{ $contract_category->workflow->name }}</td>
                      <td><span  data-toggle="tooltip" title="Edit"><a  class="my-btn   btn-sm text-info" id="{{$contract_category->id}}" href="{{ route('contract_categories.edit',$contract_category->id) }}"><i class="la la-pencil" aria-hidden="true"></i></a></span>
            		        <span  data-toggle="tooltip" title="Delete"><a  id="{{$contract_category->id}}" class="my-btn   btn-sm text-danger" onclick="deletecategory(this.id)"><i class="la la-trash" aria-hidden="true"></i></a></span>                
                        </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
            {!! $contract_categories->appends(Request::capture()->except('page'))->render() !!}
          </div>
        </div>


          </div>
          
            
          </div>
          </div>

      </div>
      
@endsection
@section('scripts')
  {{-- <script type="text/javascript" src="{{ asset('datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('datatables/datatables.min.js')}}"></script>
  <script src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('datepicker/bootstrap-datepicker.min.js')}}"></script>

  <script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('.input-daterange').datepicker({
    autoclose: true
});



} );
  </script>


@endsection
