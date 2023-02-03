
@extends('layouts.app')
@section('stylesheets')
<!-- <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" /> -->

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

    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="info"> {{$document_creations->count()}} </h3>
                            <h6>Documents</h6>
                        </div>
                        <div>
                            <i class="la la-file info font-large-2 float-right" style="font-size: 35px!important"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-12">
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
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="info"> {{$reviewed->count()}} </h3>
                            <h6>Reviewed</h6>
                        </div>
                        <div>
                            <i class="la la-refresh info font-large-2 float-right"
                                style="font-size: 35px!important"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-12">
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

                    <h3 class="card-title" id="basic-layout-form" style="margin-bottom: 0px !important">

                        <a href="{{ url('download-document-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download Contracts / Documents in excel" style=""><i class="la la-download"></i> Download</a>

                        {{-- <div class="row" style="margin-top: -10px">
                            <div class="col-md-2" style="">
                                Create Document
                            </div>
                            <div class="col-md-10">
                                <button type="button"
                                    class="btn btn-purple round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-check"></i> Approved {{$appr_assignments->count()}}
                                </button>
                                <button type="button"
                                    class="btn btn-warning round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-refresh"></i> Reviewing {{$reviewed->count()}}
                                </button>
                                <button type="button"
                                    class="btn btn-danger round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-exclamation"></i> Pending {{$pend_assignments->count()}}
                                </button>
                                <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-file"></i> Tasks {{$document_creations->count()}}
                                </button>
                            </div>
                        </div>
                    --}}
                    </h3>
                    <div class="" id="">
                        <table class="table table-sm table-striped mb-0 dtable" id="doc_table">
                            <thead class="thead-bg">
                                <tr>
                                    <th style="color: white">#</th>
                                    {{-- <th>Code</th> --}}
                                    <th>Tasks</th>
                                    <th>Document Type</th>
                                    {{-- <th>Department</th> --}}
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Duration</th>
                                    <th>Assigned</th>
                                    <th>Stage</th>
                                    <th>Requested By</th>
                                    <th>Assigned To</th>
                                    {{-- <th>Created At</th> --}}
                                    <th style="text-align: right">Action </th>
                                </tr>
                            </thead>
                            <tbody> @php $i = 1; @endphp
                                @forelse ($document_creations as $document_creation)

                                <tr>
                                    <td style="color: white">{{ $document_creation->id }}</td>
                                    {{-- <td>{{ $document_creation->requisition_code }}</td> --}}
                                    <td>{{ $document_creation->name }} </td>
                                    <td>{{ $document_creation->type?$document_creation->type->name:'' }}</td>
                                    {{-- <td>{{ $document_creation->department?$document_creation->department->name:''
                                        }}</td> --}}
                                    <td>{{date("M j, Y", strtotime($controllerName->getExpiresOn($document_creation->id)))}} </td>
                                    <td>   
                                        @php $expire_status = $controllerName->getExpirationDate($document_creation->id); @endphp
                                        
                                        @if($expire_status == 'Expired') <span class="badge badge-danger text-white"> Expired </span>
                                        @elseif($expire_status == 'Grace Priod') <span class="badge badge-warning text-white"> Grace Period </span>
                                        @elseif($expire_status == 'Active') <span class="badge badge-success text-white"> Active </span>
                                        @elseif($expire_status == 'N/A') <span class="badge badge-secondary text-white"> N/A </span>
                                        @else <span class="badge badge-secondary text-white"> {{$expire_status}} </span> @endif
                                    </td>
                                    <td>{{ $controllerName->getDuration($document_creation->id) }}</td>
                                    <td>
                                        @if($document_creation->assigned == 0) <div class="badge badge-striped"> No
                                        </div>
                                        @elseif($document_creation->assigned == 1) <div class="badge badge-success"> Yes
                                        </div> @endif
                                    </td>
                                    <td>
                                        {{$controllerName->getDocumentStage($document_creation->id,
                                        $document_creation->workflow_id)}}
                                    </td>
                                    <td>{{$document_creation->author?$document_creation->author->name:''}}</td>
                                    <td>{{$controllerName->getAssignee($document_creation->id)}}</td>
                                    {{-- <td>{{date("j-M, Y, g:i a", strtotime($document_creation->created_at))}}</td>
                                    --}}
                                    {{-- <td>
                                        @if($document_creation->status_id == 0)
                                        <div class="badge badge-warning"> {{$document_creation->status->name}} </div>
                                        @elseif($document_creation->status_id == 1)
                                        <div class="badge badge-warning"> {{$document_creation->status->name}} </div>
                                        @elseif($document_creation->status_id == 2)
                                        <div class="badge badge-warning"> {{$document_creation->status->name}} </div>
                                        @elseif($document_creation->status_id == 3)
                                        <div class="badge badge-success"> {{$document_creation->status->name}} </div>
                                        @endif
                                    </td> --}}
                                    <td style="text-align: right">
                                        <a href="#" class="btn btn-outline-warning btn-glow pull-left btn-sm mr-1"
                                            style="padding :0.3rem 0.4rem !important;" data-toggle="modal" data-target="#requisitionClarity"
                                            onclick="getRequisitionClarity({{$document_creation->id}})" title="Request for Clarity">
                                            <i class="la la-question" aria-hidden="true" style="font-weight: bold"></i>                                            
                                        </a>
                                        @if($controllerName->getClarity($document_creation->id) == 'Yes')
                                            <a href="{{ url('requisition-clarity', $controllerName->getClarityId($document_creation->id)) }}"
                                                class="btn btn-outline-warning btn-glow pull-left btn-sm mr-1" data-toggle="tooltip" title="View Clarity Request/Response"
                                                style="padding :0.3rem 0.4rem !important;"><i class="la la-reply" a-hidden="true" style="font-weight: bold"></i> 
                                            </a>
                                        @endif

                                        @if($controllerName->getDocPosition($document_creation->id) == 5){{-- TEST AGAINST ASSIGNED USER ID --}}
                                            <!-- <span data-toggle="tooltip" title="Document has already been approved ">
                                                <a href="{{ route('view-document', $document_creation->id) }}"
                                                    class="btn btn-outline-success btn-glow pull-right btn-sm"
                                                    style="padding :0.3rem 0.4rem !important;" target="_blank"><i
                                                        class="la la-eye" aria-hidden="true" style="font-weight: bold"></i>
                                                    View
                                                </a>
                                            </span> -->
                                        @elseif($document_creation->contract_created == 1){{-- TEST AGAINST ASSIGNED USER ID --}}
                                            @if($document_creation->google_doc_id == null)
                                                <span data-toggle="tooltip" title="Create Document">
                                                    <a href="{{ route('google-react', $document_creation->id) }}"
                                                        class="btn btn-outline-primary btn-glow pull-right btn-sm"
                                                        style="padding :0.3rem 0.4rem !important;"><i class="la la-plus"
                                                            aria-hidden="true" style="font-weight: bold;"></i> Create
                                                    </a>
                                                </span>
                                            @elseif($document_creation->status_id == 2)

                                                {{-- FOR DEPARTMENT HEAD --}}
                                                @if(\Auth::user()->department->department_head_id == \Auth::user()->id)
                                                    <button type="button" class="btn btn-outline-success btn-glow pull-right btn-sm ml-1" data-toggle="modal" data-target="#approveModal" onclick="setDetails({{$document_creation->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-check" aria-hidden="true" style="font-weight: bold;"></i> Approve </button>
                                                @endif

                                                <span data-toggle="tooltip" title="Edit Document">
                                                    <a href="{{ route('google-react', $document_creation->id) }}"
                                                        class="btn btn-outline-primary btn-glow pull-right btn-sm "
                                                        style="padding :0.3rem 0.4rem !important;"><i class="la la-pen"
                                                            aria-hidden="true" style="font-weight: bold;"></i> Edit
                                                    </a>
                                                </span>
                                                {{-- <span data-toggle="tooltip" title="Create Document">
                                                    <a href="{{ route('google-react', $document_creation->id) }}"
                                                        class="btn btn-outline-info btn-glow pull-right btn-sm"
                                                        style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil"
                                                            aria-hidden="true" style="font-weight: bold;"></i> Edit
                                                    </a>
                                                </span> --}}
                                            @endif
                                            @if($controllerName->checkIfDepartmentHead($document_creation->id) == true)
                                                
                                            @endif 


                                            <!-- <span data-toggle="tooltip" title="Document has already been created ">
                                                <a href="{{ route('create-document', [$document_creation->id,  $document_creation->id]) }}"
                                                    class="btn btn-outline-warning btn-glow pull-right btn-sm"
                                                    style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil"
                                                        aria-hidden="true" style="font-weight: bold"></i> Edit
                                                </a>
                                            </span> -->
                                        @elseif($document_creation->contract_created == 0)
                                            @if($controllerName->getDocumentCreator($document_creation->id) == \Auth::user()->id || 
                                                $controllerName->checkIfDepartmentHead($document_creation->id) == true)
                                                    <button type="button" class="btn btn-outline-dark btn-glow pull-right btn-sm" data-toggle="modal" data-target="#SetupDocumentModal" onclick="setRequisitionDetails({{$document_creation->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-file-text-o" aria-hidden="true" style="font-weight: bold;"></i> Setup 
                                                    </button>                                        
                                                {{-- <span data-toggle="tooltip" title="Create Document">
                                                    <a href="{{ route('new-document', $document_creation->id) }}"
                                                        class="btn btn-outline-primary btn-glow pull-right btn-sm"
                                                        style="padding :0.3rem 0.4rem !important;"><i class="la la-plus"
                                                            aria-hidden="true" style="font-weight: bold;"></i> Create
                                                    </a>
                                                </span>
                                                @else
                                                <span data-toggle="tooltip" title="Feature Disabled for This User">
                                                    <a href="#" class="btn btn-outline-danger btn-glow pull-right btn-sm"
                                                        style="padding :0.3rem 0.4rem !important; " disabled><i
                                                            class="la la-ban" aria-hidden="true" style="font-weight: bold;"></i>
                                                        Ban
                                                    </a>
                                                </span> --}}
                                            @endif
                                        @endif
                                    </td>
                                </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {!! $document_creations->render() !!} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>









    <!-- Add MODAL -->
    <div class="modal fade text-left" id="assignRequisition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">Assigning Task</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="assignRequisitionForm" action="{{ route('document-creations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="id" id="id" required>
                    <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" required>
                    <input type="hidden" class="form-control" name="created_by" id="created_by" required>

                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label"> Task Name </label>
                                <input type="text" placeholder="Task Name" class="form-control name" name="name" id="name"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="user_id" class="col-form-label"> Assign to </label>
                                <select class="form-control user_id" id="user_id" name="user_id" required="">
                                    <option value=""></option>
                                    @forelse($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-outline-warning btn-sm" value="Clear">
                        <input type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm" value="Assign">
                    </div>
                </form>

            </div>
        </div>
    </div>




    <!-- SETUP DOCUMENT MODAL -->
    <div class="modal fade text-left" id="SetupDocumentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Document Details</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form id="SetupDocumentForm" action="{{ route('document-creations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="id" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Document Name <i class="mand">*</i> </label>
                        <input type="text" placeholder="Tasks Name" class="form-control" name="name" id="_name">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="hidden" placeholder="Tasks Name" class="form-control" name="requisition_id" id="_requisition_id">
                        <input type="hidden" placeholder="Tasks Name" class="form-control" name="document_type_id" id="_document_type_id">
                        <input type="hidden" placeholder="" class="form-control" name="workflow_id" id="_workflow_id">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="expire_on" class="col-form-label"> Expiry Date </label>
                        <input type="date" class="form-control" id="_expire_on" name="expire_on" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="col-form-label"> Grace Period </label>
                        <select class="form-control" name="grace_period" id="_grace_period" required="">          
                          <option value=""></option> 
                          <option value="7">1 Week - (7 days)</option>
                          <option value="14">2 Weeks - (14 days)</option>
                          <option value="21">3 Weeks - (21 days)</option>
                          <option value="30">1 Month - (30 days)</option>
                          <option value="60">2 Months - (60 days)</option>
                        </select>
                    </div>
                </div>
                

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-outline-warning" data-dismiss="modal" value="Close">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Save" onclick="return confirm('Are you sure you want to save?')">
              </div>
            </form>

          </div>
        </div>
    </div>


    <!--  Approve modal -->
    <form class="form-horizontal" method="POST" action="{{ route('approve-document') }}" enctype="multipart/form-data">
      @csrf
        <div id="approveModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>


                    <input type="hidden" name="document_id" id="doc_document_id">
                    <input type="hidden" name="requisition_id" id="doc_requisition_id">     
                    {{-- {{request()->route()->parameters['id']}} --}}
                    <input type="hidden" class="form-control" id="doc_name" placeholder="Contract Name" name="name" />

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Approve this document? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="app_no_btn" id="app_no_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal"> No </button>

                            <button type="submit" name="app_yes_btn" id="app_yes_btn" class="btn btn-outline-primary btn-glow" data-toggle="modal" data-target="#approveYesModal"> Yes </button>
                        </div>

                      </div>


                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Success  modal -->
    <div id="approveYesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Document Approved </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="app_ok_btn" class="btn btn-outline-primary btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
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
                            <label for="requestor_id" class="col-form-label"> Sender </label>
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
                $('#name').val(data.name);
                $('#created_by').val(data.user_id);
            });
            
        });
    }

        
    function setDetails(id)
    {
        $(function()
        {            
            $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#doc_document_id').val(data.id);
                $('#doc_requisition_id').val(data.id);
                $('#doc_name').val(data.name);
            });
            
        });
    }


    //ADD FORM
    $("#addRequisitionForm").on('submit', function(e)
    { 
        clearForm();
        e.preventDefault();
        var requisition_id = $('#requisition_id').val();
        var name = $('#name').val();
        var user_id = $('#user_id').val();
        var created_by = $('#created_by').val();

        formData = 
        {
            requisition_id:requisition_id,
            name:name,
            user_id:user_id,
            created_by:created_by,
            _token:'{{csrf_token()}}'
        }
        $.post('{{route('document-creations.store')}}', formData, function(data, status, xhr)
        {
            var details = data.details;
            if(data.status=='ok')
            {

                $('#assignRequisition').modal('hide');
                toastr.success(data.info, {timeOut:10000});
                setInterval(function(){ window.location.replace("{{ route('document-creations.index') }}"); }, 1000);
                clearForm();
                return;
            }
            else{   toastr.error(data.error, {timeOut:10000});   }
        }); 
    });



    function clearForm()
    {
        $(function()
        {            
            //Set values
            $('#id').val('');
            $('#requisition_id').val('');
            $('#name').val('');
            $('#created_by').val('');
            $('#user_id').prop('value', 0);               
        });
    }


    
    function setRequisitionDetails(id)
    {  
        $(function()
        {       
            $.get('{{url('get-requisition-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#_id').val(data.id);
                $('#_requisition_id').val(data.id);
                $('#_name').val(data.name);
                $('#_document_type_id').val(data.requisition_type_id);
                // $('#_expire_on').val(data.expire_on);
                // $('#_grace_period').val(data.grace_period);
                $('#_workflow_id').val(data.workflow_id);
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


    //ADD FORM
    $("#requisitionClarityForm").on('submit', function(e)
    { 
        clearClarityForm();
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