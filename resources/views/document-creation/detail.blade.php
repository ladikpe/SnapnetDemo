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
                                        <th style="padding-left: 25%; width: 30%;">Document Details</th>
                                        <th style="padding-left: 15%; width: 70%">
                                            @if($requisition->contract_created == 0){{-- TEST AGAINST ASSIGNED USER ID --}}
                                                @if($controllerName->getDocumentCreator($requisition->id) == \Auth::user()->id )
                                                    <button type="button" class="btn btn-outline-dark btn-glow pull-right btn-sm" data-toggle="modal" data-target="#SetupDocumentModal" onclick="setRequisitionDetails({{$requisition->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-file-text-o" aria-hidden="true" style="font-weight: bold;"></i> Setup 
                                                    </button> 
                                                @endif                                                
                                            @elseif($requisition->contract_created == 1)
                                                @if($requisition->google_doc_id == null)
                                                    <span data-toggle="tooltip" title="Create Document">
                                                        <a href="{{ route('google-react', $requisition->id) }}"
                                                            class="btn btn-outline-primary btn-glow pull-right btn-sm" style="padding :0.3rem 0.4rem !important;"><i class="la la-plus" aria-hidden="true" style="font-weight: bold;"></i> Create
                                                        </a>
                                                    </span>
                                                @else
                                                    {{-- FOR DEPARTMENT HEAD --}}
                                                    @if(\Auth::user()->department->department_head_id == \Auth::user()->id)
                                                        <button type="button" class="btn btn-outline-success btn-glow pull-right btn-sm" data-toggle="modal" data-target="#approveModal" onclick="setDetails({{$requisition->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-check" aria-hidden="true" style="font-weight: bold;"></i> Approve </button>
                                                    @endif
                                                @endif
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                   {{--  <tr>
                                        <td style="width: 30%; text-align: right; padding-right: 20px">Code</td>
                                        <td style="width: 70%; text-align: left; padding-left: 20px">{{$requisition->document_code}}</td>
                                    </tr> --}}
                                    <tr>
                                        <td style="width: 30%; text-align: right; padding-right: 20px">Name</td>
                                        <td style="width: 70%; text-align: left; padding-left: 20px">{{$requisition->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Category</td>
                                        <td style="text-align: left; padding-left: 20px">{{$requisition->type?$requisition->type->name:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Contract Type</td>
                                        <td style="text-align: left; padding-left: 20px">{{$requisition->contractType?$requisition->contractType->name:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Expiration Date</td>
                                        <td style="text-align: left; padding-left: 20px">{{date("j-M, Y g:i a", strtotime($detail->expire_on))}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Grace Period</td>
                                        <td style="text-align: left; padding-left: 20px">{{$detail->grace_period}} day(s)</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Contract Duration</td>
                                        <td style="text-align: left; padding-left: 20px">{{$controllerName->getDuration($detail->id)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Task Requestor</td>
                                        <td style="text-align: left; padding-left: 20px">{{$requisition->author?$requisition->author->name:''}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Assigned to</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            {{$controllerName->getDocumentUsers($requisition->id, 'user_id') ? $controllerName->getDocumentUsers($requisition->id, 'user_id') : 'N/A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Assigned by </td>
                                        <td style="text-align: left; padding-left: 20px">
                                            {{$controllerName->getDocumentUsers($requisition->id, 'created_by') ? $controllerName->getDocumentUsers($requisition->id, 'created_by') : 'N/A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 20px">Attached Document</td>
                                        <td style="text-align: left; padding-left: 20px">
                                            @if($requisition->document_name != null)
                                                <a class="pull-left" data-toggle="tooltip" 
                                                    title="Download {{$requisition->author?$requisition->author->name:''}}'s Document" href="{{URL::asset($requisition->document_path.'/'.$requisition->document_name)}}" download="{{URL::asset($requisition->document_path.'/'.$requisition->document_name)}}"><i class="la la-file-pdf-o"></i> {{$requisition->document_name}} 
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
                                <input type="text" placeholder="Task Name" class="form-control name" name="name" id="name" value="{{$detail->name}}" 
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
