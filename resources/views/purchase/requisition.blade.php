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

        .no-pad
        {
            padding: 2px !important;
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


    <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Purchase Orders Requisitions
                                    <a href="#" class="btn btn-float btn-outline-dark btn-round btn-sm pull-right addNew" data-toggle="modal" data-target="#new_requisition"
                                       title="Create New Requisition For Purchase Order"><i class="la la-plus"></i></a>
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm mb-0">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Requisition No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Assigned To</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
{{--                                    <th>Created By</th>--}}
{{--                                    <th>Created At</th>--}}
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody> @php $i = 1; @endphp
                                @forelse ($requisitions as $requisition)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $requisition->requisition_no }}</td>
                                        <td>{{ $requisition->name }}</td>
                                        <td>{{ $requisition->description }}</td>
                                        <td>{{ $requisition->assign->name }}</td>
                                        <td>{{ date("M j, Y", strtotime($requisition->deadline)) }}</td>
                                        <td>
                                            <div class="badge round badge-{{ $requisition->status_id==1?'warning':($requisition->status_id==2?'info':($requisition->status_id==0?'danger': $requisition->status_id==3?'success':'')) }}">
                                                {{ $requisition->status_id==1?'Pending':($requisition->status_id==2?'Created':($requisition->status_id==0?'Rejected':($requisition->status_id==3?'Approved':''))) }}
                                            </div>
                                        </td>
{{--                                        <td>{{$requisition->author->name}}</td>--}}
{{--                                        <td>{{date("F j, Y, g:i a", strtotime($requisition->created_at))}}</td>--}}
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Requisition no-pad">
                                                <a href="#" class="my-btn btn-sm text-info" onclick="getRequisitionDetails({{$requisition->id}})"
                                                   data-toggle="modal" data-target="#new_requisition"><b class="la la-pencil" aria-hidden="true"></b>
                                                </a>
                                            </span>

                                                <span  data-toggle="tooltip" title="Create Purchase Order from Requisition">
                                                    @if($requisition->status_id != 1)
                                                        <a href="#" class="my-btn btn-sm text-dark no-pad" disabled><b class="la la-check" aria-hidden="true"></b>
                                                        </a>
                                                    @else
                                                        <a href="{{ url('purchase-order-create/'.$requisition->id) }}" class="my-btn btn-sm text-dark no-pad">
                                                            <b class="la la-plus" aria-hidden="true"></b>
                                                        </a>
                                                    @endif
                                                </span>

                                            <span  data-toggle="tooltip" title="Delete Requisition">
                                                <a href="{{ url('contracts/delete_requisition/'.$requisition->id) }}" class="my-btn btn-sm text-danger no-pad"
                                                   onclick="return confirm('Are you sure you want to DELETE Purchase Order?')"><b class="la la-trash" aria-hidden="true"></b>
                                                </a>
                                            </span>

                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {!! $requisitions->appends(Request::capture()->except('page'))->render() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-2">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <form id="searchForm" action="{{route('purchase-order-requisition')}}" method="get">
                                <div class="row" style="margin-top: -10px">
                                    <p>Search </p>
                                    <fieldset>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ... " aria-describedby="button-addon2" id="search" name="search">
                                            <div class="input-group-append"> <button class="btn btn-secondary" type="submit"><i class="la la-search"></i> </button> </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </form>

                            <form id="searchForm" action="{{route('purchase-order-requisition')}}" method="get">
                                <div class="row" style="margin-top: 25px">
                                    <p>Sort By </p>

                                    <div class="form-group" style="width: 100%; float: right">
                                        <select class="form-control tokenizationSelect2" name="column" id="column">
                                            <option value="">Select</option>
                                            <option value="purchase_order_no">Purchase Order NO</option>
                                            <option value="name">Requisition Name</option>
                                            <option value="description">Description</option>
                                            <option value="deadline">Deadline</option>
                                            <option value="assigned_to">Assigned To</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 25px">
                                    <p>Order By </p>

                                    <div class="form-group" style="width: 100%; float: right">
                                        <table class="table table-condensed">
                                            <tr>
                                                <td>
                                                    <div class="form-group pull-left">
                                                        <label class="container"> <span style=""> <i class="la la-sort-alpha-asc"> ASC </i></span>
                                                            <input type="radio" name="sort" id="asc" value="asc"> <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group pull-left">
                                                        <label class="container"> <span style=""> <i class="la la-sort-alpha-desc"> DESC </i> </span>
                                                            <input type="radio" name="sort" id="desc" value="desc">  <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="form-group pull-left">
                                                        <button type="submit" id="filterBtn" class="btn btn-dark btn-sm pull-right"> <i class="la la-arrows-v"></i> Sort </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group pull-left">
                                                        <button type="reset" id="clearBtn" class="btn btn-warning btn-sm pull-left"> <i class="la la-circle-thin"></i> Clear Filter </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </form>

                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <form id="purchaseOrderForm" action="{{route('purchase-order-requisition-store')}}" enctype="multipart/form-data" method="POST">  @csrf
        <input type="hidden" class="form-control" name="id" id="id" required>
        <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="new_requisition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Requisition Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12">
                            <fieldset class="form-group no-pad">
                                <small class="text-muted"><span>Requisition Name <i class="mand">*</i> </span></small>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </fieldset>
                        </div>

                        <div class="col-md-12">
                            <fieldset class="form-group col-md-12 no-pad">
                                <small class="text-muted"><span>Description <i class="mand">*</i> </span></small>
                                <textarea rows="3" class="form-control" name="description" id="description" required></textarea>
                            </fieldset>
                        </div>

                        <div class="col-md-12">
                            <fieldset class="form-group no-pad">
                                <small class="text-muted"><span>Requisition Deadline <i class="mand"></i> </span></small>
                                <input type="date" class="form-control" name="deadline" id="deadline">
                            </fieldset>
                        </div>

                        <div class="col-md-12">
                            <fieldset class="form-group col-md-12 no-pad">
                                <small class="text-muted"><span>Assigned to <i class="mand">*</i> </span></small>
                                <select class="form-control" name="assigned_to" id="assigned_to" required>
                                    <option value=""></option>
                                    @forelse($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </fieldset>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn grey btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Are you sure you want to Add/Modify Requisition?')">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>













@endsection

@section('scripts')

    <script>
        function getRequisitionDetails(id)
        {
            $(function(e)
            {
                $.get('{{url('fetchRequisitionDetails')}}?id=' +id, function(data)
                {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#deadline').val(data.deadline);
                    $('#assigned_to').val(data.assigned_to);
                });
            });
        }

        $(function(e)
        {
            $('.addNew').mouseup(function()
            {
                $('#id').val('');
                $('#name').val('');
                $('#description').val('');
                $('#deadline').val('');
                $('#assigned_to').val(0);
            });
        });
    </script>

    <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
    {{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}

    <script>
        CKEDITOR.replace( 'top_section' , {
            toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-'] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'others', items: [ '-' ] }
            ]

        }).on('cut copy paste',function(e){e.cancel();});
        CKEDITOR.replace( 'content' ).on('paste',function(e){e.cancel();});
        // CKEDITOR.instances.editor1.on('copy',function(e){e.cancel();});
        // $('body').bind('copy',function(e){e.preventDefault(); return false;});
    </script>



    @if(Session::has('success'))
        <script>
            $(function()
            {
                toastr.success('{{session('success')}}', {timeOut:50000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function()
            {
                toastr.error('{{session('error')}}', {timeOut:50000});
            });
        </script>
    @endif

@endsection
