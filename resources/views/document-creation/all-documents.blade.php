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
                                                      <p class="text-truncate font-size-17"> <i class="la la-file"></i> Tasks {{$all_documents->count()}} 
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
                                        <i class="la la-file"></i> Tasks {{$all_documents->count()}} 
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
                                    <th>Tasks</th>
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
                                            <span  data-toggle="tooltip" title="Delete Requisition">
                                                <a href="#" class="btn-sm text-danger pull-right deleteBtn" id="{{$document->id}}" style="padding :0.3rem 0.4rem !important;" 
                                                ><i class="la la-remove" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Edit Document">
                                                <a href="{{ route('create-document', [$document->id, $document->id]) }}" class="btn-sm text-info pull-right" data-toggle="tooltip" title="Edit Document" style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                        </td>
                                    </tr> @php $i++; @endphp
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



        {{-- <div class="col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <form id="searchForm" action="{{route('all-documents')}}" method="get">

                                <div class="card-body" style="padding: 0px">

                                  <div class="form-body">
                                    <h5 class="form-section" style="border-bottom: 1px solid #d1d5ea !important; color: #666 !important;"><i class="la la-sort"></i> Search</h5>

                                <fieldset>
                                  <div class="input-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search ... " aria-label="Amount">
                                    <div class="input-group-append">
                                      <button class="btn btn-default" type="submit"><i class="la la-search"></i></button>
                                    </div>
                                </fieldset>
                            </div>
                            </form>

                            <form id="searchForm" class="form form-horizontal" action="{{route('all-documents')}}" method="get">


                                <div class="card-body" style="padding: 0px">

                                  <div class="form-body"> <br> <br> <br>
                                    <h5 class="form-section" style="border-bottom: 1px solid #d1d5ea !important; color: #666 !important;"><i class="la la-sort"></i> Sort</h5>

                                <div class="card-body" style="padding:0px;">
                                    <p>Sort By</p>

                                    <fieldset class="form-group position-relative">
                                      <select class="form-control tokenizationSelect2" name="column" id="column">
                                            <option value="">Select</option>
                                            <option value="name">Document Name</option>
                                            <option value="requisition_id">Requisition</option>
                                            <option value="document_type_id">Category</option>
                                            <option value="expire_on">Expiry Date</option>
                                            <option value="grace_period">Grace Period</option>
                                            <option value="stage_id">Stage</option>
                                        </select>
                                    </fieldset>
                                  </div>

                                    <div class="card-body" style="padding:0px;">
                                    <p>Order By</p>
                                      <div class="col-md-6">
                                        <div class="input-group">
                                          <div class="d-inline-block custom-control custom-radio mr-1">
                                            <label class="container"> <span style="margin-left: 20px"> <i class="la la-sort-alpha-asc"> ASC </i></span>
                                                <input type="radio" name="sort" id="asc" value="asc"> <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="input-group">
                                          <div class="d-inline-block custom-control custom-radio">
                                            <label class="container"> <span style="margin-left: 20px"> <i class="la la-sort-alpha-desc"> DESC </i> </span>
                                                <input type="radio" name="sort" id="desc" value="desc">  <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                              <div class="form-actions right">
                                <button type="reset" id="clearBtn" class="btn btn-out-warning btn-sm pull-left"> <i class="la la-sort"></i> Clear Filter </button>

                                <button type="submit" id="filterBtn" class="btn btn-outline-success btn-glow pull-right btn-sm pull-right"> <i class="la la-arrows-v"></i> Sort </button>
                              </div>



                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div> --}}
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
