@php
    use \App\Http\Controllers\PurchaseController;
    $controllerName = new PurchaseController;
@endphp

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
    </style>
@endsection
@section('content')


    <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Purchase Orders
                                {{-- <a href="{{ route('purchase-order.create') }}" class="btn btn-float btn-outline-dark btn-round btn-sm pull-right" data-toggle="tooltip" title="Create New Purchase Order"><i class="la la-plus"></i></a>--}}
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm mb-0">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>PO Number</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Deadline</th>
                                    <th>Versions</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Created By</th>
{{--                                    <th>Created At</th>--}}
                                    <th style="text-align: right">Action  </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($purchase_orders as $purchase_order)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $purchase_order->requisition_no }}</td>
                                        <td>{{ $purchase_order->name }}</td>
                                        <td>{{ $purchase_order->description }}</td>
                                        <td>{{date("M j, Y", strtotime($purchase_order->deadline))}}</td>
                                        <td>{{ $controllerName->no_of_versions($purchase_order->id) }}</td>
                                        <td>
                                            @if($purchase_order->status_id == 0) <img src="{{URL::asset('assets/images/red.png')}}" alt="" height="12" class="">
                                            @elseif($purchase_order->status_id == 1) <img src="{{URL::asset('assets/images/yellow.png')}}" alt="" height="12" class="">
                                            @elseif($purchase_order->status_id == 2) <img src="{{URL::asset('assets/images/yellow.png')}}" alt="" height="12" class="">
                                            @elseif($purchase_order->status_id == 3) <img src="{{URL::asset('assets/images/green.png')}}" alt="" height="12" class="">
                                            @endif

                                            <span style="color: #666; font-size: 12px"> {{ $purchase_order->status_id==1?'Pending':($purchase_order->status_id==2?'Created':($purchase_order->status_id==0?'Rejected':($purchase_order->status_id==3?'Approved':''))) }}</span>

{{--                                            <div class="badge round badge-{{ $purchase_order->status_id==1?'warning':($purchase_order->status_id==2?'info':($purchase_order->status_id==0?'danger': $purchase_order->status_id==3?'success':'')) }}">--}}
{{--                                                {{ $purchase_order->status_id==1?'Pending':($purchase_order->status_id==2?'Created':($purchase_order->status_id==0?'Rejected':($purchase_order->status_id==3?'Approved':''))) }}--}}
{{--                                            </div>--}}
                                        </td>
                                        <td>{{$purchase_order->assign->name}}</td>
                                        <td>{{$purchase_order->author->name}}</td>
{{--                                        <td>{{date("j-M, Y, g:i a", strtotime($purchase_order->created_at))}}</td>--}}
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Purchase Order">
                                                <a href="{{ url('purchase-order-edit/'.$purchase_order->id) }}" class="my-btn btn-sm text-info" ><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Purchase Order">
                                                <a href="{{ url('contracts/delete_requisition/'.$purchase_order->id) }}" class="my-btn btn-sm text-danger"
                                                   onclick="return confirm('Are you sure you want to DELETE Purchase Order?')"><i class="la la-trash" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {!! $purchase_orders->appends(Request::capture()->except('page'))->render() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <form id="searchForm" action="{{route('purchase-order.index')}}" method="get">
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

                            <form id="searchForm" action="{{route('purchase-order.index')}}" method="get">
                                <div class="row" style="margin-top: 25px">
                                    <p>Sort By </p>

                                    <div class="form-group" style="width: 100%; float: right">
                                        <select class="form-control tokenizationSelect2" name="column" id="column">
                                            <option value="">Select</option>
                                            <option value="purchase_order_no">Purchase Order NO</option>
                                            <option value="name">Purchase Order Name</option>
                                            <option value="description">Description</option>
                                            <option value="deadline">Deadline</option>
                                            <option value="assigned_to">Assigned To</option>
                                            <option value="created_by">Created By</option>
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

                        <div class="media d-flex" id="contract_table">



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>














@endsection

@section('scripts')

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
