{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
<link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

<style>
    .sortColumn {
        cursor: pointer;
    }

    .la la-arrows-v {
        font-size: 13px !important;
    }

    html body .la {
        font-size: 13px !important;
        /* font-size: 1.4rem; */
    }

    .container {
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
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        border: thin solid #ccc;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #0a6aa1;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 8px;
        left: 8px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: white;
    }

    .font-size-17 {
        font-size: 17px;
        padding: 10px 15px 5px 15px;
        text-align: center;
    }
</style>

@endsection
@section('content')






<div class="row">

    <div class="col-xl-4 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="info"> {{$all_assignments->count()}} </h3>
                            <h6>Tasks</h6>
                        </div>
                        <div>
                            <i class="la la-file info font-large-2 float-right" style="font-size: 35px!important"></i>
                        </div>
                    </div>
                    {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <i class="la la-exclamation info font-large-2 float-right"
                                style="font-size: 35px!important"></i>
                        </div>
                    </div>
                    {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <h3 class="info"> {{$appr_assignments->count()}} </h3>
                            <h6>Approved</h6>
                        </div>
                        <div>
                            <i class="la la-check info font-large-2 float-right" style="font-size: 35px!important"></i>
                        </div>
                    </div>
                    {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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

                    <h3 class="card-title" id="basic-layout-form"> Task Assignments List
                                  
                        <a href="{{ url('download-requisition-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download task assignments in excel" style=""><i class="la la-download"></i> Download</a>

                       {{--  <a href="#" class="btn btn-outline-primary btn-glow btn-sm" data-toggle="modal"
                            data-target="#assignRequisition" title="Assign Task to Users" style="float: right;"><i
                                class="la la-plus"></i> Assign Users</a>

                        <div class="col-md-12 row" style="margin-top: -10px">
                            <div class="col-md-2">
                                Assign Task to User
                            </div>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-purple round btn-min-width mb-1 rd pull-right"
                                    style="margin-right: -50px">
                                    <i class="la la-check"></i> Approved {{$appr_assignments->count()}}
                                </button>
                                <button type="button"
                                    class="btn btn-danger round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-exclamation"></i> Pending {{$pend_assignments->count()}}
                                </button>
                                <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-file"></i> Tasks {{$all_assignments->count()}}
                                </button>
                            </div>
                        </div>
                    </h3> --}}

                    <div class="" id="">
                        <table class="table table-sm mb-0 dtable" id="assignment_table">
                            <thead class="thead-bg">
                                <tr>
                                    <th style="color: #fff">#</th>
                                    {{-- <th>Code</th> --}}
                                    <th>Task</th>
                                    <th>Document Type</th>
                                    {{-- <th>Department</th> --}}
                                    <th>Deadline</th>
                                    <th>Priority</th>
                                    <th>Assigned</th>
                                    <th>Assigned to</th>
                                    <th>Clarity Sent</th>
                                    <th>Response Sent</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    {{-- <th>Created At</th> --}}
                                    <th style="text-align: right">Action </th>
                                </tr>
                            </thead>
                            <tbody> @php $i = 1; @endphp
                                @if($assignments != null)
                                    @forelse ($assignments as $assignment)
                                    <tr>
                                        {{-- <td>{{ $i }}</td> --}}
                                        <td style="color: #fff">{{ $assignment->id }}</td>
                                        {{-- <td>{{ $assignment->requisition_code }}</td> --}}
                                        <td>{{ $assignment->name }}</td>
                                        <td>{{ $assignment->type?$assignment->type->name:'' }}</td>
                                        {{-- <td>{{ $assignment->department?$assignment->department->name:'' }}</td> --}}
                                        <td>{{date("M j, Y", strtotime($assignment->deadline))}}</td>
                                        <td>
                                            @if($controllerName->getRequisitionPriority($assignment->id) == 'High')
                                            <div class="badge badge-danger text-white"> High </div>
                                            @elseif($controllerName->getRequisitionPriority($assignment->id) == 'Medium')
                                            <div class="badge badge-warning text-white"> Medium </div>
                                            @elseif($controllerName->getRequisitionPriority($assignment->id) == 'Low')
                                            <div class="badge badge-primary text-white"> Low </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignment->assigned == 0) <div class="badge badge-warning text-white"> No
                                            </div>
                                            @elseif($assignment->assigned == 1) <div class="badge badge-success text-white">
                                                Yes </div> @endif
                                        </td>
                                        <td>
                                            @if($assignment->assigned == 0)
                                            <div class=""> Pending Assignment by Legal Head </div>
                                            @elseif($assignment->assigned == 1)
                                            <div class=""> {{$controllerName->getDocumentCreator($assignment->id)}} </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($controllerName->getClarity($assignment->id) == null)
                                            <div class="badge badge-secondary"> No </div>
                                            @elseif($controllerName->getClarity($assignment->id) == 'Yes')
                                            <a class="badge badge-success text-white" data-toggle="modal"
                                                data-target="#requisitionClarity"
                                                onclick="getRequisitionClarity({{$assignment->id}})"> Yes </a>
                                            @endif
                                        </td>

                                        <td>
                                            @if($controllerName->getResponse($assignment->id) == 'N/A')
                                            <div class="badge badge-secondary"> N/A </div>
                                            @elseif($controllerName->getResponse($assignment->id) == 'No')
                                            <div class="badge badge-secondary"> No </div>
                                            @elseif($controllerName->getResponse($assignment->id) == 'Yes')
                                            <div class="badge badge-success"> Yes </div>
                                            @endif
                                        </td>
                                        <td> {{$controllerName->getRequisitionStage($assignment->id,
                                            $assignment->workflow_id)}}</td>
                                        <td>{{$assignment->author?$assignment->author->name:''}}</td>
                                        {{-- <td>{{date("j-M, Y, g:i a", strtotime($assignment->created_at))}}</td> --}}
                                        {{-- <td>
                                            @if($assignment->status_id == 0)
                                            <div class="badge badge-warning"> {{$assignment->status->name}} </div>
                                            @elseif($assignment->status_id == 1)
                                            <div class="badge badge-warning"> {{$assignment->status->name}} </div>
                                            @elseif($assignment->status_id == 2)
                                            <div class="badge badge-warning"> {{$assignment->status->name}} </div>
                                            @elseif($assignment->status_id == 3)
                                            <div class="badge badge-success"> {{$assignment->status->name}} </div>
                                            @endif
                                        </td> --}}
                                        <td style="text-align: center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-info dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="padding :0.3rem 0.4rem !important;"></button>
                                                <div class="dropdown-menu">

                                                    @if($assignment->assigned == 0)
                                                        <a href="#" class="btn pull-left btn-sm dropdown-item"
                                                            data-toggle="modal" data-target="#assignRequisition"
                                                            onclick="getRequisition({{$assignment->id}})"
                                                            style="padding :1rem 0.4rem !important;"><i
                                                                class="la la-angle-double-right" aria-hidden="true"
                                                                style="font-weight: bold"></i> Assign Task
                                                        </a>

                                                        <div class="dropdown-divider"></div>

                                                        @if(\Auth::user()->id != $assignment->user_id)
                                                            <a href="#" class="btn pull-left btn-sm dropdown-item"
                                                                data-toggle="modal" data-target="#requisitionClarity"
                                                                onclick="getRequisitionClarity({{$assignment->id}})"
                                                                style="padding :1rem 0.4rem !important;"><i class="la la-question"
                                                                    aria-hidden="true" style="font-weight: bold"></i> Request For Clarity
                                                            </a>
                                                        @endif
                                                    @elseif($assignment->assigned == 1)
                                                    <a href="#" class="my-btn btn-sm pull-left dropdown-item"
                                                        style="padding :0.3rem 0.4rem !important;" data-toggle="modal"
                                                        data-target="#viewassignment" disabled><i class="la la-check"
                                                            aria-hidden="true" style="font-weight: bold;"></i> Task Assigned
                                                    </a>

                                                    <div class="dropdown-divider"></div>

                                                    {{-- <a href="{{ url('requisition-clarity', $controllerName->getClarityId($assignment->id)) }}"
                                                        class="my-btn text-warning pull-left btn-sm" data-toggle="tooltip" title="View Clarity Request / Response" target="_blank"><i class="la la-reply" aria-hidden="true" style="font-weight: bold"></i> View Clarity
                                                    </a> --}}

                                                    <div class="dropdown-divider"></div>
                                                    @elseif($assignment->assigned == 1 && Auth::user()->id == 11)
                                                    <a href="#" class="my-btn btn-sm pull-left dropdown-item"><i class="la la-plus" aria-hidden="true" 
                                                        style="font-weight: bold"></i> Task Assigned to User
                                                    </a>

                                                    <div class="dropdown-divider"></div>
                                                    @endif
                                                    @if($controllerName->getClarity($assignment->id) == 'Yes')
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{ url('requisition-clarity', $controllerName->getClarityId($assignment->id)) }}"
                                                            class="btn pull-left btn-sm dropdown-item" data-toggle="tooltip"
                                                            style="padding :1rem 0.4rem !important;"><i class="la la-reply" a-hidden="true" style="font-weight: bold"></i> View Clarity
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr> @php $i++; @endphp
                                    @empty
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                        {{-- {!! $assignments->render() !!} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>











{{-- Add MODAL --}}
<div class="modal fade text-left" id="assignRequisition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Assigning Task to User</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="assignRequisitionForm" action="{{ route('assignments.store') }}" method="POST">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id">
                <input type="hidden" class="form-control" name="requisition_id" id="requisition_id">
                <input type="hidden" class="form-control" name="created_by" id="created_by">
                <input type="hidden" class="form-control" name="class_id" id="class_id">

                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="ass_name" class="col-form-label"> Task Name </label>
                            <input type="text" placeholder="Task Name" class="form-control name" name="name"
                                id="ass_name" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="user_id" class="col-form-label"> Assign Document Creator </label>
                            <select class="form-control user_id" id="user_id" name="user_id" required="">
                                <option value=""></option>
                                @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="reviewer_id" class="col-form-label"> Document Reviewer </label>
                            <select class="form-control reviewer_id" id="reviewer_id" name="reviewer_id" required="">
                                <option value="@if($legal_head){{$legal_head->id}}@endif">@if($legal_head){{$legal_head->name}}@endif</option>
                                @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="approver_id" class="col-form-label"> Document Approver </label>
                            <select class="form-control approver_id" id="approver_id" name="approver_id" required="">
                                <option value="@if($legal_head){{$legal_head->id}}@endif">@if($legal_head){{$legal_head->name}}@endif</option>
                                @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>



                    <div class="form-group row" id="contractTypeDiv" style="display: none;">

                        <div class="col-md-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Contract Type </legend>
                                <div class="card-body no-pad">
                                    <div class="d-inline-block custom-control custom-radio mr-1" style="">
                                        <div class="input-group">
                                            @forelse($contract_types as $contract_type)
                                                <div class="d-inline-block custom-control custom-radio mr-1">
                                                    <label class="container"> <span style="font-size: 13px !important;"> {{$contract_type->name}} </span>
                                                        <input type="radio" class="contract_type" name="contract_type" id="con_type_{{$contract_type->id}}"
                                                         value="{{$contract_type->id}}"> <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="contract_type" id="contract_type" value="">
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        {{-- <div class="col-md-3">
                            <label for="name" class="col-form-label"> Priority </label>
                        </div> --}}

                        <div class="col-md-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Priority & Sensitivity </legend>
                                <div class="card-body no-pad">

                                    <div class="d-inline-block custom-control custom-radio mr-1" style="">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;">
                                                        High </span>
                                                    <input type="radio" class="priority" name="priority" id="prio_hig"
                                                        value="High"> <span class="checkmark"
                                                        style="background: #E52B50"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;">
                                                        Medium </span>
                                                    <input type="radio" class="priority" name="priority" id="prio_mid"
                                                        value="Medium"> <span class="checkmark"
                                                        style="background: #FFD12A"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;"> Low
                                                    </span>
                                                    <input type="radio" class="priority" name="priority" id="prio_low"
                                                        value="Low"> <span class="checkmark"
                                                        style="background: #00FF6F"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="priority" id="priority" value="">  <br>


                                    <div class="d-inline-block custom-control custom-radio mr-1" style="">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;">
                                                        Confidential </span>
                                                    <input type="radio" class="sensitivity" name="sensitivity"
                                                        id="sens_con" value="Confidential"> <span class="checkmark"
                                                        style="background: #E52B50"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;">
                                                        General </span>
                                                    <input type="radio" class="sensitivity" name="sensitivity"
                                                        id="sens_gen" value="General"> <span class="checkmark"
                                                        style="background: #FFD12A"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <div class="input-group">
                                            <div class="d-inline-block custom-control custom-radio mr-1">
                                                <label class="container"> <span style="font-size: 13px !important;">
                                                        Internal </span>
                                                    <input type="radio" class="sensitivity" name="sensitivity"
                                                        id="sens_int" value="Internal"> <span class="checkmark"
                                                        style="background: #00FF6F"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="sensitivity" id="sensitivity" value="">
                                </div>

                            </fieldset>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
                    <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Assign Task">
                </div>
            </form>

        </div>
    </div>
</div>



{{-- Clarity MODAL --}}
<div class="modal fade text-left" id="requisitionClarity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Request For Clarity</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="requisitionClarityForms" action="{{ route('requisition-clarity') }}" method="POST">
                @csrf
                <input type="hidden" class="form-control" name="id" id="c_id">
                <input type="hidden" class="form-control" name="requisition_id" id="c_requisition_id" required>
                <input type="hidden" class="form-control" name="created_by" id="c_created_by" required>

                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="name" class="col-form-label"> Task Name </label>
                            <input type="text" placeholder="Task Name" class="form-control name" name="name" id="c_name"
                                required readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="requestor_id" class="col-form-label"> Requestor </label>
                            <input type="text" placeholder="Requestor Name" class="form-control name"
                                name="requestor_id" id="c_requestor_id" value="{{Auth::user()->name}}" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="message" class="col-form-label"> Enter Message </label>
                            <textarea rows="4" class="form-control" id="message" name="message"
                                placeholder="Request for Clarity Here ... " required=""></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-outline-danger" data-dismiss="modal" value="Close">
                    <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Submit">
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
                //Set values
                $('#requisition_id').val(data.id);
                $('#ass_name').val(data.name);
                $('#created_by').val(data.user_id);


                //hide or show Contract Type
                if(data.requisition_type_id == 1){ $('#contractTypeDiv').show(); }else{ $('#contractTypeDiv').hide(); }
            });
            
        });
    }

    function getRequisitionClarity(id)
    {
        clearClarityForm();
        $(function()
        {            
            $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#c_requisition_id').val(data.id);
                $('#c_name').val(data.name);
                $('#c_created_by').val(data.user_id);
                // $('#c_requestor_id').val(data.author.name);
            });
            
        });
    }

    
    $(".contract_type").on('click', function(e){         $('#contract_type').val($(this).val());   }); 
    $(".priority").on('click', function(e){         $('#priority').val($(this).val());   }); 
    $(".sensitivity").on('click', function(e){      $('#sensitivity').val($(this).val());   }); 
    // $(".urgency").on('click', function(e){          $('#urgency').val($(this).val());   }); 
   


    //ADD FORM
    $("#assignRequisitionForms").on('submit', function(e)
    {   
        //clearForm();
        e.preventDefault();
        var requisition_id = $('#requisition_id').val();
        var name = $('#ass_name').val();
        var user_id = $('#user_id').val();
        var reviewer_id = $('#reviewer_id').val();
        var approver_id = $('#approver_id').val();
        var priority = $('#priority').val();
        var sensitivity = $('#sensitivity').val();
        // var urgency = $('#urgency').val();
        var requestor_id = $('#created_by').val();
        var created_by = $('#created_by').val();

        formData = 
        {
            requisition_id:requisition_id,
            name:name,
            user_id:user_id,
            reviewer_id:reviewer_id,
            approver_id:approver_id,
            priority:priority,
            sensitivity:sensitivity,
            // urgency:urgency,
            requestor_id:requestor_id,
            created_by:created_by,
            _token:'{{csrf_token()}}'
        }
        $.post('{{route('assignments.store')}}', formData, function(data, status, xhr)
        {
            if(data.status=='ok')
            {
                $('#assignRequisition').modal('hide');  
                toastr.success(data.info, {timeOut:10000});
                setInterval(function(){ window.location.replace("{{ route('assignments.index') }}"); }, 1000);
                clearForm();
                return;
            }
            else{   toastr.error(data.error, {timeOut:10000});   }
        }); 
    });


    //ADD FORM
    $("#requisitionClarityForm").on('submit', function(e)
    { 
        e.preventDefault();
        var id = $('#c_id').val();
        var requisition_id = $('#c_requisition_id').val();
        // var name = $('#c_name').val();
        // var user_id = $('#c_created_by').val();
        var message = $('#message').val();

        formData = 
        {
            id:id,
            requisition_id:requisition_id,
            // name:name,
            // user_id:user_id,
            message:message,
            _token:'{{csrf_token()}}'
        }
        $.post('{{route('requisition-clarity')}}', formData, function(data, status, xhr)
        {
            var details = data.details;
            if(data.status=='ok')
            {
                $('#requisitionClarity').modal('hide');
                // toastr.success(data.info, {timeOut:10000});
                alert(data.info);
                setInterval(function(){ window.location.replace("{{ route('assignments.index') }}"); }, 1000);
                clearClarityForm();
                return;
            }
            else{   alert(data.error);  }
        }); 
    });



    function clearForm()
    {
        $(function()
        {            
            //Set values
            $('#id').val('');
            $('#requisition_id').val('');
            $('#ass_name').val('');
            $('#created_by').val('');
            $('#user_id').prop('value', 0);               
        });
    }

    function clearClarityForm()
    {
        $(function()
        {            
            //Set values
            $('#c_id').val('');
            $('#c_requisition_id').val('');
            $('#c_name').val('');
            $('#c_created_by').val('');
            $('#clarity').val('');  
            $('#c_requestor').val('');             
        });
    }

</script>


<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>





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