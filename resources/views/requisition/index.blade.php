{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

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
        .font-size-17
        {
            font-size: 17px;
            padding: 10px 15px 5px 15px;
            text-align: center;
        }

        .font-large-2
        {
            font-size: 30px!important;
        }
    </style>


        
  {{-- <script src="{{ asset('assets/ckscript.js') }}"></script> --}}
  

<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>


@endsection
@section('content')





    <div class="row">

        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                <div class="media d-flex">
                    <div class="media-body text-left">
                    <h3 class="info"> {{$requisitions->count()}} </h3>
                    <h6>Tasks</h6>
                    </div>
                    <div>
                    <i class="la la-file info font-large-2 float-right" style="font-size: 35px!important"></i>
                    </div>
                </div>
                {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div> --}}
                </div>
            </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                <div class="media d-flex">
                    <div class="media-body text-left">
                    <h3 class="info"> {{$pend_assignments->count()}} </h3>
                    <h6>Pending</h6>
                    </div>
                    <div>
                    <i class="la la-exclamation info font-large-2 float-right" style="font-size: 35px!important"></i>
                    </div>
                </div>
                {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div> --}}
                </div>
            </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                <div class="media d-flex">
                    <div class="media-body text-left">
                    {{--<h3 class="info"> @if($appr_assignments) {{$appr_assignments->count()}} @else 0 @endif </h3>--}}
                    <h3 class="info"> @if($appr_assignments) {{count($appr_assignments)}} @else 0 @endif </h3>
                    <h6>Approved</h6>
                    </div>
                    <div>
                    <i class="la la-check info font-large-2 float-right" style="font-size: 35px!important"></i>
                    </div>
                </div>
                {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div> --}}
                </div>
            </div>
            </div>
        </div>

    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        <h3 class="card-title" id="basic-layout-form" style="margin-top: -10px; padding: 0px 15px">  Tasks
                            {{-- <div class="col-md-12 row">   --}}
                                  
                                <a href="{{ url('download-requisition-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download task requisition in excel" style=""><i class="la la-download"></i> Download</a>

                                <a href="#" class="btn btn-outline-primary btn-glow btn-sm mr-1" data-toggle="modal" data-target="#addForm" title="Create New Tasks" style="float: right;"><i class="la la-plus"></i> New Task</a>
                               {{--  <div class="col-md-2">
                                   
                                </div>

                                <div class="col-md-10">
                                    <button type="button" class="btn btn-purple round btn-min-width mb-1 rd pull-right" style="margin-right: -50px">
                                        <i class="la la-check"></i> Approved {{$appr_assignments->count()}} 
                                    </button>
                                    <button type="button" class="btn btn-danger round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-exclamation"></i> Pending {{$pend_assignments->count()}} 
                                    </button>
                                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-file"></i> Tasks {{$requisitions->count()}} 
                                    </button>
                                </div> --}}
                            {{-- </div> --}}
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="requisition_table">
                                <thead class="thead-bg">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th style="color: transparent">#</th>
                                    <th>Tasks</th>
                                    <th>Document Type</th>
                                    {{-- <th>Department</th> --}}
                                    <th>Deadline</th>
                                    <th>Priority</th>
                                    <th>Assigned?</th>
                                    <th>Assigned to</th>
                                    <th>Clarity?</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Executed</th>
                                    {{-- <th>Created At</th> --}}
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($requisitions as $requisition)
                                    <tr>
                                        {{-- <td>{{ $i }}</td> --}}
                                        <th style="color: transparent">{{ $requisition->id }}</th>
                                        <td>{{ $requisition->name }}</td>
                                        <td>{{ $requisition->type?$requisition->type->name:'' }}</td>
                                        {{-- <td>{{ $requisition->department?$requisition->department->name:'' }}</td> --}}
                                        <td>{{date("M j, Y", strtotime($requisition->deadline))}}</td>
                                        <td>
                                            @if($controllerName->getRequisitionPriority($requisition->id) == 'High') 
                                                <div class="badge badge-danger text-white"> High </div>
                                            @elseif($controllerName->getRequisitionPriority($requisition->id) == 'Medium') 
                                                <div class="badge badge-warning text-white"> Medium </div>
                                            @elseif($controllerName->getRequisitionPriority($requisition->id) == 'Low') 
                                                <div class="badge badge-primary text-white"> Low </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($requisition->assigned == 0) <div class="badge badge-warning text-white"> No </div>
                                            @elseif($requisition->assigned == 1) <div class="badge badge-success text-white"> Yes </div> @endif
                                        </td>
                                        <td>
                                            @if($requisition->assigned == 0) 
                                                <div class=""> Pending Assignment </div>
                                            @elseif($requisition->assigned == 1) 
                                                <div class=""> {{$controllerName->getDocumentCreator($requisition->id)}} </div> 
                                            @endif
                                        </td>
                                        <td>
                                            @if($controllerName->getClarity($requisition->id) == 'Yes')
                                                <div class="badge badge-primary text-white">
                                                    <a href="{{ url('requisition-clarity', $controllerName->getClarityId($requisition->id)) }}"
                                                        class="" data-toggle="tooltip" style="">  {{$controllerName->checkClarityStatus($requisition->id)}}
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{$controllerName->getRequisitionStage($requisition->id, $requisition->workflow_id)}}
                                        </td>
                                        <td>{{$requisition->author?$requisition->author->name:''}}</td>
                                        {{-- <td>{{date("j-M, Y, g:i a", strtotime($requisition->created_at))}}</td> --}}
                                        {{-- <td>
                                            @if($requisition->status_id == 0) 
                                                <div class="badge badge-warning"> {{$requisition->status->name}} </div>
                                            @elseif($requisition->status_id == 1) 
                                                <div class="badge badge-warning"> {{$requisition->status->name}} </div>
                                            @elseif($requisition->status_id == 2) 
                                                <div class="badge badge-warning"> {{$requisition->status->name}} </div>
                                            @elseif($requisition->status_id == 3) 
                                                <div class="badge badge-success"> {{$requisition->status->name}} </div>
                                            @endif
                                        </td> --}}
                                        <td> 
                                            @if($requisition->executed_copy != null)                                            
                                                <div class="badge badge-success text-white"> Yes </div> 
                                            @else                          
                                                <div class="badge badge-secondary text-white"> No </div> 
                                            @endif
                                        </td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="View Full Detaile">
                                                <a href="{{ url('task-detail', $requisition->id) }}"
                                                    class="my-btn text-warning pull-right btn-sm" data-toggle="tooltip" title="View Clarity Request / Response" target="_blank"><i class="la la-eye" aria-hidden="true" style="font-weight: bold"></i> 
                                                </a>
                                            </span>

                                            @if(\Auth::user()->id == $requisition->user_id && $requisition->status_id < 2)
                                                <span  data-toggle="tooltip" title="Delete Tasks">
                                                    <a href="#" class="btn-sm text-danger pull-right deleteBtn" id="{{$requisition->id}}" style="padding :0.3rem 0.4rem !important;" 
                                                    ><i class="la la-remove" aria-hidden="true"></i>
                                                    </a>
                                                </span>

                                                <span  data-toggle="tooltip" title="Edit Tasks">
                                                    <a href="#" class="btn-sm text-info pull-right" data-toggle="modal" data-target="#editForm" onclick="getRequisition({{$requisition->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil" aria-hidden="true"></i>
                                                    </a>
                                                </span>                                                
                                            @else
                                                {{-- <span  data-toggle="tooltip" title="View Tasks">
                                                    <a href="#" class="btn-sm text-warning pull-right" data-toggle="modal" data-target="#viewForm" onclick="getRequisition({{$requisition->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-eye" aria-hidden="true"></i>
                                                    </a>
                                                </span> --}}
                                            @endif

                                            @if($requisition->executed_copy != null)
                                                <span  data-toggle="tooltip" title="Download Executed Version of Document">
                                                    <a href="{{URL::asset($requisition->executed_copy_path.'/'.$requisition->executed_copy)}}" class="my-btn btn-sm text-info pull-right" data-toggle="tooltip" title="View Link" target="_blank"><i class="la la-link" aria-hidden="true"></i>
                                                    </a>
                                                </span>

                                                {{-- <span  data-toggle="tooltip" title="Download Executed Version of Document">
                                                    <a class="btn-sm text-info pull-right" href="{{URL::asset($requisition->executed_copy_path.'/'.$requisition->executed_copy)}}"
                                                      download="{{URL::asset($requisition->executed_copy_path.'/'.$requisition->executed_copy)}}" style="color: #202020!important;"><i class="la la-download" aria-hidden="true"></i> 
                                                    </a>
                                                </span> --}}
                                            @endif
                                            @if(\Auth::user()->department_id == 1 && $requisition->status_id > 1)
                                                <span  data-toggle="tooltip" title="Upload Executed Version of Document">
                                                    <a href="#" class="my-btn btn-sm text-primary pull-right" data-toggle="modal" data-target="#UploadModal" onclick="setId({{$requisition->id}})"><i class="la la-upload" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            @endif
                                            @if($controllerName->getClarity($requisition->id) == 'Yes')
                                                <span  data-toggle="tooltip" title="View Clarity Request / Response">
                                                    <a href="{{ url('requisition-clarity', $controllerName->getClarityId($requisition->id)) }}"
                                                        class="my-btn text-warning pull-right btn-sm" data-toggle="tooltip" title="View Clarity Request / Response" target="_blank"><i class="la la-reply" aria-hidden="true" style="font-weight: bold"></i> 
                                                    </a>
                                                </span>
                                            @endif

                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $requisitions->appends(Request::capture()->except('page'))->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Tasks</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form id="addRequisitionForm-edit" action="{{ route('requisitions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="id" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Tasks Name <i class="mand">*</i> </label>
                        <input type="text" placeholder="Tasks Name" class="form-control _name" name="name" id="name" required>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <fieldset class="form-group">
                            <textarea class="form-control _description" cols="30" rows="2" name="description" id="description"></textarea>
                        </fieldset>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="requisition_type_id" class="col-form-label"> Task Category <i class="mand">*</i> </label>
                        <select class="form-control _requisition_type" id="requisition_type_id" name="requisition_type_id" required="">
                          <option value=""></option>
                            @forelse($requisition_types as $requisition_type)
                                <option value="{{$requisition_type->id}}">{{$requisition_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    {{-- <div class="col-md-6 contract_type_id" id="" style="display: none;">
                        <label for="contract_type" class="col-form-label"> Contract Type </label>
                        <select class="form-control contract_type" id="contract_type" name="contract_type">
                          <option value=""></option>
                            @forelse($contract_types as $contract_type)
                                <option value="{{$contract_type->id}}">{{$contract_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div> --}}
                </div>


                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="deadline" class="col-form-label"> Deadline </label>
                        <input type="date" class="form-control _deadline" id="deadline" name="deadline" placeholder="Contract deadline" value="YYYY-MM-DD" required>
                    </div>

                    <div class="col-md-6">
                        <label for="document" class="col-form-label"> Upload Task Document to support task request </label>
                        <input type="file" class="form-control _document" id="document" name="document">
                        {{-- <input type="hidden" class="form-control _document" id="document" name="document"> --}}
                    </div>

                    <input type="hidden" class="form-control" id="workflow_id" name="workflow_id" value="{{$workflow->id}}">

                   {{-- <div class="col-md-6">
                        <label for="workflow_id" class="col-form-label"> Workflow </label>
                        <select class="form-control _workflow_id" id="workflow_id" name="workflow_id" required="">
                            @forelse($workflows as $workflow)
                                <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Department </label>
                        <select class="form-control _department_id" id="department_id" name="department_id" required="">
                          <option value=""></option>
                            @forelse($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div> --}}
                </div>
                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Create New Task" onclick="return confirm('Are you sure you want to save?')">
              </div>
            </form>

          </div>
        </div>
    </div>




    {{-- Edit MODAL --}}
    <div class="modal fade text-left" id="editForm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600">Edit Tasks</label>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </a>
            </div>

            <form id="editRequisitionForm" action="{{ route('requisitions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="hidden" placeholder="Id" class="form-control _id" name="id" id="_id" required>
                        <label for="" class="col-form-label"> Tasks Name </label>
                        <input type="text" placeholder="Tasks Name" class="form-control" name="name" id="_name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="" class="col-form-label"> Description </label>
                        <fieldset class="form-group">
                            <textarea class="form-control _description" cols="30" rows="4" name="description" id="_description" required></textarea>
                        </fieldset>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="" class="col-form-label"> Task Category </label>
                        <select class="form-control requisition_type_edit" name="requisition_type_id" id="_requisition_type_id" required="">
                          {{-- <option value=""></option> --}}
                            @forelse($requisition_types as $requisition_type)
                                <option value="{{$requisition_type->id}}">{{$requisition_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>                    

                    {{-- <div class="col-md-6 " id="contract_type_id_edit" style="display: none;">
                        <label for="contract_type" class="col-form-label"> Contract Type </label>
                        <select class="form-control contract_type" id="contract_type" name="contract_type">
                          <option value=""></option>
                            @forelse($contract_types as $contract_type)
                                <option value="{{$contract_type->id}}">{{$contract_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                 

                    <div class="col-md-6">
                        <label for="workflow_id" class="col-form-label"> Workflow </label>
                        <select class="form-control _workflow_id" name="workflow_id" id="_workflow_id" required="">
                         
                            @forelse($workflows as $workflow)
                                <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Department </label>
                        <select class="form-control _department_id" name="department_id" id="_department_id" style="">                         
                            @forelse($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div> --}}
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="deadline" class="col-form-label"> Deadline </label>
                        <input type="date" class="form-control _deadline" name="deadline" id="_deadline" placeholder="Contract deadline" value="YYYY-MM-DD">
                        <input type="hidden" class="form-control _workflow_id" id="_workflow_id" name="workflow_id" value="{{$workflow->id}}">
                    </div>

                    <div class="col-md-6">
                        <label for="document" class="col-form-label"> Upload document to support this request </label>
                        <input type="file" class="form-control _document" id="document" name="document">
                        <input type="hidden" class="form-control _document" id="document" name="document">
                        <input type="hidden" class="form-control _template_content" id="_template_content" name="_template_content">
                    </div>
                </div>
                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-warning btn-sm" data-dismiss="modal" value="Close">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm" id="saveBtn" value="Update Task" onclick="return confirm('Are you sure you want to update task record?')">
              </div>
            </form>

          </div>
        </div>
    </div>


    {{-- View MODAL --}}
    <div class="modal fade text-left" id="viewForm" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600">View Tasks</label>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </a>
            </div>

            <form id="ViewRequisitionForm" action="#" method="POST">
            @csrf
              <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="" class="col-form-label"> Tasks Name </label>
                        <input type="text" placeholder="Requisition Name" class="form-control" name="name" id="v_name" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Task Category </label>
                        <select class="form-control _requisition_type_id" name="requisition_type_id" id="v_requisition_type_id" disabled>
                          {{-- <option value=""></option> --}}
                            @forelse($requisition_types as $requisition_type)
                                <option value="{{$requisition_type->id}}">{{$requisition_type->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Deadline </label>
                        <input type="date" class="form-control _deadline" name="deadline" id="v_deadline" placeholder="Contract deadline" value="YYYY-MM-DD" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Department </label>
                        <select class="form-control _department_id" name="department_id" id="v_department_id" disabled>
                          {{-- <option value=""></option> --}}
                            @forelse($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="workflow_id" class="col-form-label"> Workflow </label>
                        <select class="form-control _workflow_id" name="workflow_id" id="v_workflow_id" disabled>
                          {{-- <option value=""></option> --}}
                            @forelse($workflows as $workflow)
                                <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="col-form-label"> Description </label>
                        <fieldset class="form-group">
                            <textarea class="form-control _description" cols="30" rows="4" name="description" id="v_description" disabled></textarea>
                        </fieldset>
                    </div>
                </div>
                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" value="Close">
              </div>
            </form>

          </div>
        </div>
    </div>







    {{-- UPLOAD MODAL --}}
    <div class="modal fade text-left" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">Upload Executed Version</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form id="UploadForm" action="{{ route('upload-executed-copy') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="id" id="upid" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="executed_copy" class="col-form-label"> Executed Copy <i class="mand">*</i> </label>
                        <input type="file" placeholder="Executed Copy" class="form-control _name" name="executed_copy" id="executed_copy" required>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <fieldset class="form-group">
                            <textarea class="form-control _description" cols="30" rows="4" name="description" id="description"></textarea>
                        </fieldset>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Upload" onclick="return confirm('Are you sure you want to upload?')" >
              </div>
            </form>

          </div>
        </div>
    </div>







@endsection

@section('scripts')



    <script>
        function getRequisition(id)
        {
            clearForm();
            $(function()
            {            
                $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
                {   
                    //convert date format
                    // var date = data.deadline;    alert(date);
                    // var yyyy = date.substr(0, 4);   
                    // var mm = date.substr(, 5);  alert(mm);
                    // var dd = date.substr(8, 9);
                    // date = mm + '/' + dd + '/' + yyyy;
                    //Set values
                    $('#_id').val(data.id);
                    $('#_name').val(data.name);
                    $('#_requisition_type_id').prop('value', data.requisition_type_id);
                    $('#_department_id').prop('value', data.department_id);
                    $('#_deadline').val(data.deadline);
                    $('#_workflow_id').prop('value', data.workflow_id);
                    $('#_description').val(data.description);

                    $('#v_id').val(data.id);
                    $('#v_name').val(data.name);
                    $('#v_requisition_type_id').prop('value', data.requisition_type_id);
                    $('#v_department_id').prop('value', data.department_id);
                    $('#v_deadline').val(data.deadline);
                    $('#v_workflow_id').prop('value', data.workflow_id);
                    $('#v_description').val(data.description);
                });
                
            });
        }


        //ADD FORM
        $("#addRequisitionForm").on('submit', function(e)
        { 
            e.preventDefault();
            const formData = new FormData(document.querySelector('#addRequisitionForm')); 

            $.post('{{route('requisitions.store')}}', formData, function(data, status, xhr)
            {
                var details = data.details;
                if(data.status=='ok')
                {
                    $('#addForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    clearForm();
                    setInterval(function(){ window.location.replace("{{ route('requisitions.index') }}"); }, 1000);
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });


        //EIDT FORM
        $("#editRequisitionForms").on('submit', function(e)
        { 
            e.preventDefault();
            var id = $('#_id').val();
            var name = $('#_name').val();
            var requisition_type_id = $('#_requisition_type_id').val();
            var department_id = $('#_department_id').val();
            var deadline = $('#_deadline').val();
            var workflow_id = $('#_workflow_id').val();
            var description = $('#_description').val();

            formData = 
            {
                id:id,
                name:name,
                requisition_type_id:requisition_type_id,
                department_id:department_id,
                deadline:deadline,
                workflow_id:workflow_id,
                description:description,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('requisitions.store')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    $('#editForm').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('requisitions.index') }}"); }, 1000);
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});  }
            }); 
        });


        //DELETE FORM
        $(".deleteBtn").on('click', function(e)
        {  
            e.preventDefault();
            var id = $(this).attr("id"); 
            if(confirm('Are you sure you want to delete requisition?'))
            {   

                formData = 
                {
                    id:id,
                    _token:'{{csrf_token()}}'
                }
                $.post('{{url('delete-requisition')}}?id=' +id, formData, function(data, status, xhr)
                {
                    if(data.status=='ok')
                    {
                        $('#editForm').modal('hide');
                        toastr.success(data.info, {timeOut:10000});
                        setInterval(function(){ window.location.replace("{{ route('requisitions.index') }}"); }, 3000);
                        return;
                    }
                    else
                    {
                         toastr.error(data.error, {timeOut:10000});
                    }
                });
            }
        });


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('._id').val('');
                $('._name').val('');
                $('._requisition_type_id').prop('value', 0);
                $('._department_id').prop('value', 0);
                $('._deadline').val('');
                $('._workflow_id').prop('value', 0);
                $('._description').val('');                
            });
        }


        function setId(id)
        {
            $('#upid').val(id);
        }




        //contract type
        $(function ()
        {
            $("._requisition_type").on('change', function(e)
            {
                let type = $("._requisition_type").val();
                if(type == 1){ $('.contract_type_id').show(); }
                else{ $('.contract_type_id').hide(); }
            });

            $(".requisition_type_edit").on('change', function(e)
            {
                let type = $(".requisition_type_edit").val();
                if(type == 1){ $('#contract_type_id_edit').show(); }
                else{ $('#contract_type_id_edit').hide(); }
            });
        });
        

    </script>


    <script>

        ClassicEditor
        .create( document.querySelector( '#editor' ), {
           
        } )
        .then( editor => {
            // Execute track changes command here
            editor.execute( 'trackChanges' )
            editor.getData( { showSuggestionHighlights: true } );
        } );
    // .catch( error => console.error( error ) );


        const ClassicEditor = require( '@ckeditor/ckeditor5-build-classic' );
    </script>
    

    <script src="{{asset('jstree/dist/jstree.min.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
    {{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}





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
