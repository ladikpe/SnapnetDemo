{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

    <style>
        .font-size-17
        {
            font-size: 17px;
            padding: 10px 15px 5px 15px;
            text-align: center;
        }
    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <h4>  </h4>

                        <div class="" id="">
                            <table class="table table-striped mb-0" id="">
                                <thead style="background: #eeeeee;" class="">  {{-- thead-bg --}}
                                    <tr>                                        
                                        <th style="padding-left: 1%; width: 30%;">Task Details</th>
                                        <th style="padding-left: 2%; width: 70%">
                                            @if($detail->assigned == 0)
                                                <a href="#" class="btn btn-sm btn-info pull-left mr-1" data-toggle="modal" data-target="#assignRequisition"
                                                    onclick="getRequisitionInfo({{$detail->id}})"> <i class="la la-arrow-circle-right" aria-hidden="true" style="font-weight: bold"></i> Assign Task
                                                </a>
                                            @endif

                                            @if(count($clarities) < 1 && \Auth::user()->id != $detail->user_id)
                                                <a href="#" class="btn btn-sm btn-info pull-left mr-1" data-toggle="modal" data-target="#requisitionClarity"
                                                    onclick="getRequisitionClarity({{$detail->id}})"><i class="la la-question" aria-hidden="true"></i> 
                                                    Request For Clarity
                                                </a>
                                            @elseif(count($clarities) > 0)
                                                <a href="{{ url('requisition-clarity', $controllerName->getClarityId($detail->id)) }}" target="_blank" 
                                                    class="btn btn-sm btn-info pull-left mr-1" data-toggle="tooltip"><i class="la la-comments-o" aria-hidden="true"></i> 
                                                    View/Reply Clarity
                                                </a>
                                            @endif

                                            @if(\Auth::user()->id == $detail->user_id && $detail->status_id < 2)
                                                <span  data-toggle="tooltip" title="Delete Tasks">
                                                    <a href="#" class="btn btn-sm btn-danger pull-right deleteBtn mr-1" id="{{$detail->id}}"><i class="la la-remove" aria-hidden="true"></i> Delete
                                                    </a>
                                                </span>

                                                <span  data-toggle="tooltip" title="Edit Tasks">
                                                    <a href="#" class="btn btn-sm btn-primary pull-right mr-1" data-toggle="modal" data-target="#editForm" onclick="getRequisition({{$detail->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                     Edit </a>
                                                </span>                                                
                                            @else
                                            @endif

                                            @if($detail->executed_copy != null)
                                                <span  data-toggle="tooltip" title="Download Executed Version of Document">
                                                    <a href="{{URL::asset($detail->executed_copy_path.'/'.$detail->executed_copy)}}" class="btn btn-sm btn-info pull-right mr-1" data-toggle="tooltip" title="View Link" target="_blank"><i class="la la-link" aria-hidden="true"></i>
                                                     Download</a>
                                                </span>
                                            @endif
                                            @if(\Auth::user()->department_id == 1 && $detail->status_id >= 2)
                                                <span  data-toggle="tooltip" title="Upload Executed Version of Document">
                                                    <a href="#" class="btn btn-sm btn-primary pull-right mr-1" data-toggle="modal" data-target="#UploadModal" onclick="setId({{$detail->id}})"><i class="la la-upload" aria-hidden="true"></i> Executed Copy
                                                    </a>
                                                </span>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                    {{-- <tr>
                                        <td style="width: 30%; text-align: right; padding-right: 20px">Code</td>
                                        <td style="width: 70%; text-align: left; padding-left: 20px">{{$detail->requisition_code}}</td>
                                    </tr> --}}
                                    <tr>
                                        <td style="width: 30%; text-align: right; padding-right: 20px">Name</td>
                                        <td style="width: 70%; text-align: left; padding-left: 20px">{{$detail->name ? $detail->name : 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Description</td>
                                        <td style="text-align: left; padding-left: 20px">{{$detail->description ? $detail->description : 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Category</td>
                                        <td style="text-align: left; padding-left: 20px">{{$detail->type?$detail->type->name:'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Contract Type</td>
                                        <td style="text-align: left; padding-left: 20px">{{$detail->contractType?$detail->contractType->name:'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Deadline</td>
                                        <td style="text-align: left; padding-left: 20px">{{date("j-M, Y g:i a", strtotime($detail->deadline))}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Priority</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            @if($controllerName->getRequisitionPriority($detail->id) == 'High') 
                                                <div class="badge badge-danger text-white"> High </div>
                                            @elseif($controllerName->getRequisitionPriority($detail->id) == 'Medium') 
                                                <div class="badge badge-warning text-white"> Medium </div>
                                            @elseif($controllerName->getRequisitionPriority($detail->id) == 'Low') 
                                                <div class="badge badge-primary text-white"> Low </div>
                                            @else
                                                <div class="badge badge-secondary text-white"> N/A </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Sensitivity</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            @if($controllerName->getRequisitionSensitivity($detail->id) == 'Confidential') 
                                                <div class="badge badge-danger text-white"> Confidential </div>
                                            @elseif($controllerName->getRequisitionSensitivity($detail->id) == 'Internal') 
                                                <div class="badge badge-warning text-white"> Internal </div>
                                            @elseif($controllerName->getRequisitionSensitivity($detail->id) == 'General') 
                                                <div class="badge badge-primary text-white"> General </div>
                                            @else
                                                <div class="badge badge-secondary text-white"> N/A </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Clarity Requests</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            @if($clarities != null)
                                                @forelse($clarities as $clarity)
                                                    <p> <span class="badge badge-primary"> {{$clarity->author?$clarity->author->name:''}} </span> : 
                                                        {{$clarity->message ? $clarity->message : 'N/A'}} 
                                                    </p>
                                                @empty @endforelse
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Clarity Responses</td>
                                        <td style="text-align: left; padding-left: 20px">   
                                            @php $clarities = $controllerName->getClarityMessage($detail->id, 'Response'); @endphp
                                            @if($clarities != null)
                                                @forelse($clarities as $clarity)
                                                    <p> <span class="badge badge-success"> {{$clarity->author?$clarity->author->name:''}} </span> : 
                                                        {{$clarity->message ? $clarity->message : 'N/A'}} 
                                                    </p>
                                                @empty @endforelse
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Task Requestor</td>
                                        <td style="text-align: left; padding-left: 20px">{{$detail->author?$detail->author->name:'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Assigned to</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            {{$controllerName->getDocumentUsers($detail->id, 'user_id') ? $controllerName->getDocumentUsers($detail->id, 'user_id') : 'N/A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Assigned by </td>
                                        <td style="text-align: left; padding-left: 20px">
                                            {{$controllerName->getDocumentUsers($detail->id, 'created_by') ? $controllerName->getDocumentUsers($detail->id, 'created_by') : 'N/A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Attached Document</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            @if($detail->document_name != null)
                                                <a class="pull-left" data-toggle="tooltip" 
                                                    title="Download {{$detail->author?$detail->author->name:''}}'s Document" href="{{URL::asset($detail->document_path.'/'.$detail->document_name)}}" download="{{URL::asset($detail->document_path.'/'.$detail->document_name)}}"><i class="la la-file-pdf-o"></i> {{$detail->document_name}} 
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>





{{-- Assignment MODAL --}}
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
    function getRequisitionInfo(id)
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



    //ADD FORM
    $("#requisitionClarityForm").on('submit', function(e)
    { 
        e.preventDefault();
        const formData = new FormData(document.querySelector('#requisitionClarityForm'));

        $.post('{{route('requisition-clarity')}}', formData, function(data, status, xhr)
        {
            var details = data.details;
            if(data.status == 'ok')
            {
                $('#requisitionClarity').modal('hide');
                // toastr.success(data.info, {timeOut:10000});
                alert(data.info);
                setInterval(function(){ window.reload(); }, 1000);
                clearClarityForm();
                return;
            }
            else{   alert(data.error);  }
        }); 
    });




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


    
    $(".contract_type").on('click', function(e){         $('#contract_type').val($(this).val());   }); 
    $(".priority").on('click', function(e){         $('#priority').val($(this).val());   }); 
    $(".sensitivity").on('click', function(e){      $('#sensitivity').val($(this).val());   }); 
    // $(".urgency").on('click', function(e){          $('#urgency').val($(this).val());   });       

</script>

    
    <script>
        $(function () 
        {
            $('#review_table').DataTable();
        } );
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
