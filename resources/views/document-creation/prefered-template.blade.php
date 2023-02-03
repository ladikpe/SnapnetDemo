{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <style>
        .sortColumn
        {
            cursor: pointer;
        }

        .la la-arrows-v
        {
            font-size: 13px!important;
        }

        html body .la
        {
            font-size: 13px!important;  /* font-size: 1.4rem; */
        }

        .container
        {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container input
        {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark
        {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            border: thin solid #ccc;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark
        {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked ~ .checkmark
        {
            background-color: #0a6aa1;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after
        {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked ~ .checkmark:after
        {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after
        {
            top: 8px;
            left: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: white;
        }
    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Prefered Templates
                                      <a href="{{ route('create-prefered-template') }}" class="btn btn-outline-info btn-glow btn-sm ml-2 pull-right" data-toggle="tooltip"  title="Create New Template"> <i class="la la-plus"></i> Create </a>
                                  </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm mb-0" id="">
                                <thead class="thead-bg">
                                    <tr>
                                        <th>#</th>
                                        <th>Requisition</th>
                                        <th>Template Name</th>
                                        <th>Assigned User</th>
                                        <th>Assigned by</th>
                                        <th>Date</th>
                                        <th style="text-align: right">Action  </th>
                                    </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($prefered_templates as $template)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $template->requisition?$template->requisition->name:'' }}</td>
                                        <td>{{ $template->template_name }}</td>
                                        <td>{{ $template->user?$template->user->name:'' }}</td>
                                        <td>{{ $template->author?$template->author->name:'' }}</td>  
                                        <td>{{date("M j, Y", strtotime($template->created_at))}}</td>                                 
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Template">
                                                <a href="#" class="my-btn btn-sm text-info pull-right" data-toggle="modal" data-target="#editModal" onclick="getTemlate({{$template->id}})"><i class="la la-pencil" aria-hidden="true" style="font-weight: bold"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $prefered_templates->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>










<!-- Review Document with Comments -->
    <form id="" action="{{ route('store-prefered-template') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="reviewModel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark white">
                <h4 class="modal-title text-text-bold-600" id="myModalLabel1">Comment on Document Before Review</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color: red">X</span>
                </button>
              </div>
              <div class="modal-body">
                                  
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="requisition_id" class="col-form-label"> Requisition Name </label>
                        <input type="hidden" class="form-control" id="_id" name="id">
                        <select class="form-control" id="requisition_id" name="requisition_id" required="">
                          <option value=""></option>
                            @forelse($requisitions as $requisition)
                                <option value="{{$requisition->id}}">{{$requisition->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="user_id" class="col-form-label"> Send Template to </label>
                        <select class="form-control" id="user_id" name="user_id" required="">
                          <option value=""></option>
                            @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="file" class="col-form-label"> Template Upload </label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-glow btn-sm mr-1" data-dismiss="modal" >Close</button>
                <button type="submit" class="btn btn-outline-info btn-glow btn-sm">Submit</button>
              </div>
            </div>
          </div>
        </div>
    </form> 









@endsection

@section('scripts')


    <script>        
        function getTemlate(id)
        {
            $(function()
            {            
                $.get('{{url('get-template-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#_id').val(data.id);
                    $('#requisition_id').val(data.requisition_id);
                    $('#user_id').val(data.user_id);
                });                
            });
        }
    </script>



    @if(Session::has('info'))
        <script>
            $(function()
            {
                toastr.success('{{session('info')}}', {timeOut:100000});
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
