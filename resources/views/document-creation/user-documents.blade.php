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
    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <a class="" href="#">
                                      <div class="card bg-primary text-white">
                                          <div class="card-body no-pad">
                                              <div class="media">
                                                  <div class="media-body overflow-hidden">
                                                      <p class="text-truncate font-size-17"> <i class="la la-file"></i> Requisitions {{$all_documents->count()}} 
                                                      </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="" href="#">
                                      <div class="card bg-warning text-white">
                                          <div class="card-body no-pad">
                                              <div class="media">
                                                  <div class="media-body overflow-hidden">
                                                      <p class="text-truncate font-size-17">
                                                         <i class="la la-exclamation"></i> Pending {{$pend_assignments->count()}} 
                                                       </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="" href="#">
                                      <div class="card bg-purple text-white">
                                          <div class="card-body no-pad">
                                              <div class="media">
                                                  <div class="media-body overflow-hidden">
                                                      <p class="text-truncate font-size-17">
                                                         <i class="la la-refresh"></i> Reviewing {{$reviewed->count()}} 
                                                      </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="" href="#">
                                      <div class="card bg-success text-white">
                                          <div class="card-body no-pad">
                                              <div class="media">
                                                  <div class="media-body overflow-hidden">
                                                      <p class="text-truncate font-size-17">
                                                         <i class="la la-check"></i> Approved {{$appr_assignments->count()}} 
                                                      </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                </div>

                            </div>


                        {{-- <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-2" style="font-size: 14px;"> Documents
                                </div>

                                <div class="col-md-10">
                                    <button type="button" class="btn btn-purple round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-check"></i> Approved {{$appr_assignments->count()}} 
                                    </button>
                                    <button type="button" class="btn btn-warning round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-refresh"></i> Reviewing {{$reviewed->count()}} 
                                    </button>
                                    <button type="button" class="btn btn-danger round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-exclamation"></i> Pending {{$pend_assignments->count()}} 
                                    </button>
                                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 rd pull-right">
                                        <i class="la la-file"></i> Requisitions {{$all_documents->count()}} 
                                    </button>
                                </div>
                            </div>
                        </h3> --}}

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <td style="color: #fff"></td>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Requisition</th>
                                    <th>Type</th>
                                    <th>Deadline</th>
                                    <th>Stage</th>
                                    {{-- <th>Created By</th> --}}
                                    {{-- <th>Created At</th> --}}
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($documents as $document)
                                    @if($controllerName->getUserTask($document->requisition_id) == true)
                                        <tr>
                                            {{-- <td>{{ $i }}</td> --}}
                                            <td style="color: #fff">{{ $document->id }}</td>
                                            <td>{{ $document->document_code }}</td>
                                            <td>{{ $document->name }}</td>
                                            <td>{{ $document->requisition?$document->requisition->name:'' }}</td>
                                            <td>{{ $document->document_type?$document->document_type->name:'' }}</td>
                                            <td>{{date("M j, Y", strtotime($document->expire_on))}}</td>
                                            {{-- <td>
                                                @if($document->assigned == 0) <div class="badge badge-striped"> No </div>
                                                @elseif($document->assigned == 1) <div class="badge badge-success"> Yes </div> @endif
                                            </td> --}}
                                            <td>
                                                {{$controllerName->getRequisitionStage($document->id, $document->workflow_id)}}
                                            </td>
                                            <td style="text-align: right">
                                                {{-- <span  data-toggle="tooltip" title="Delete Requisition">
                                                    <a href="#" class="btn-sm text-danger pull-right deleteBtn" id="{{$document->id}}" style="padding :0.3rem 0.4rem !important;" 
                                                    ><i class="la la-remove" aria-hidden="true"></i>
                                                    </a>
                                                </span> --}}

                                                <span  data-toggle="tooltip" title="Edit Document">
                                                    <a href="{{ route('create-document', [$document->id, $document->id]) }}" class="btn-sm text-info pull-right" data-toggle="tooltip" title="Edit Document" style="padding :0.3rem 0.4rem !important;"><i class="la la-edit" aria-hidden="true"></i>
                                                    </a>
                                                </span>

                                            </td>
                                        </tr> @php $i++; @endphp
                                    @endif
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $documents->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>















@endsection

@section('scripts')

    

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
