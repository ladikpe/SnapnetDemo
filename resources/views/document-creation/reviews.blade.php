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
                                                  <p class="text-truncate font-size-17"> <i class="la la-file"></i> Documents {{$pending_reviews->count()}} 
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
                                                     <i class="la la-exclamation"></i> For Review {{$reviewing->count()}} 
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
                                                     <i class="la la-check"></i> For Approval {{$approving->count()}} 
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a class="" href="#">
                                  <div class="card bg-danger text-white">
                                      <div class="card-body no-pad">
                                          <div class="media">
                                              <div class="media-body overflow-hidden">
                                                  <p class="text-truncate font-size-17">
                                                     <i class="la la-ban"></i> Declined {{$declined->count()}} 
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                            </div>

                        </div>

                        <div class="" id="">
                            <table class="table table-sm mb-0" id="review_table">
                                <thead class="thead-dark">  {{-- thead-bg --}}
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Requisition</th>
                                    <th>Type</th>
                                    <th>Deadline</th>
                                    <th>Grace Period</th>
                                    <th>Stage</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($pending_reviews as $pending_review)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $pending_review->document_code }}</td>
                                        <td>{{ $pending_review->name }}</td>
                                        <td>{{ $pending_review->requisition?$pending_review->requisition->name:'' }}</td>
                                        <td>{{ $pending_review->document_type?$pending_review->document_type->name:'' }}</td>
                                        <td>{{ date("M j, Y", strtotime($pending_review->expire_on))}}</td>
                                        <td>{{ $pending_review->grace_period}} Day(s)</td>
                                        <td>
                                            {{$controllerName->getRequisitionStage($pending_review->id, $pending_review->workflow_id)}}
                                        </td>
                                        <td>{{ $pending_review->author?$pending_review->author->name:'' }}</td>
                                        <td>{{ date("M j, Y", strtotime($pending_review->created_at))}}</td>
                                        {{-- <td>
                                            @if($pending_review->assigned == 0) <div class="badge badge-striped"> No </div>
                                            @elseif($pending_review->assigned == 1) <div class="badge badge-success"> Yes </div> @endif
                                        </td> --}}
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Document">
                                                <a href="{{ route('view-document', $pending_review->id) }}" class="btn-sm text-info pull-right" data-toggle="tooltip" title="View Document" style="padding :0.3rem 0.4rem !important;" target="_blank"><i class="la la-eye" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            @if($pending_review->reviewed_approved == 1)
                                                <span>
                                                    <a href="{{ route('create-document', [$pending_review->id, $pending_review->id]) }}" class="btn-sm text-primary pull-right" data-toggle="tooltip" title="Review Document" style="padding :0.3rem 0.4rem !important;"><i class="la la-refresh" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            @elseif($pending_review->reviewed_approved == 2)
                                                <span>
                                                    <a href="{{ route('create-document', [$pending_review->id, $pending_review->id]) }}" class="btn-sm text-primary pull-right" data-toggle="tooltip" title="Approve Document" style="padding :0.3rem 0.4rem !important;"><i class="la la-check" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $pending_reviews->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>























@endsection

@section('scripts')

    
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
