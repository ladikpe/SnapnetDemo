{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />

    <!-- Include SmartWizard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/smartwizard/dist/css/smart_wizard_all.min.css') }}" />
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
    </style>
@endsection
@section('content')


    <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>






    <div class="row">
        <form id="purchaseOrderForm" action="{{route('purchase-order.store')}}" enctype="multipart/form-data" method="POST">  @csrf
{{--            <input type="hidden" class="form-control" name="id" id="id" value="@if($purchase_order){{ $purchase_order->id}}@endif">--}}
            <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" value="{{$id}}">
            <div class="row">

                <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 15px;">
                    <button type="submit" id="saveBtn" class="btn btn-dark btn-sm btn-float pull-right" onclick="return confirm('Are you sure you want to Create Purchase Order?')"> <i class="fa fa-save"></i> Save </button>
                </div>

                <div class="col-md-9">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-5" style=""> New Purchase Orders
                                        <a href="{{ route('purchase-order.index') }}" class="btn btn-float btn-outline-dark btn-round btn-sm" data-toggle="tooltip" title="View All Purchase Order"><i class="la la-list"></i></a>
                                    </div>

                                    <div class="col-md-7" style="">
                                        <fieldset class="form-group no-pad">
                                            <select class="form-control tokenizationSelect2" name="name" id="order_name" style="width: 50%; float: right">
                                                <option value="">Pick a Template</option>
                                                @forelse($purchase_templates as $purchase_template)
                                                    <option value="{{$purchase_template->name}}">{{$purchase_template->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="" id="">
                                    <textarea name="contents" id="contents" oncopy="return false;" cols="100%" rows="15"></textarea>
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
                                    <div class="row" style="margin-top: -10px">
                                        <div class="col-md-12" style=""> Details </div>
                                    </div>

                                </h3>

                                <div class="media d-flex row" id="po_form">
                                    <div class="col-md-12">
                                        <fieldset class="form-group no-pad">
                                            <small class="text-muted"><span>Order Name <i class="mand">*</i> </span></small>
                                            <input type="text" class="form-control" name="name" id="name" value="" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Description </span></small>
                                            <textarea rows="3" class="form-control" name="description" id="description"></textarea>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Assigned to <i class="mand">*</i> </span></small>
                                            <select class="form-control" name="assigned_to" id="assigned_to">
                                                <option value=""></option>
                                                @forelse($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Deadline</span></small>
                                            <input type="date" class="form-control" name="deadline" id="deadline" value="">
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>






















@endsection

@section('scripts')

    <script>

        $(function()
        {
            $('#order_name').on('change', function(e)
            {
                var name = $('#order_name').val();
                $.get('{{url('getPurchaseOrderTemplate')}}?name=' +name, function(data)
                {
                    $('#description').val(data.description);
                    CKEDITOR.instances['contents'].setData(data.contents);
                });
            });
        });
    </script>

    <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
    {{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}

    <!-- Include SmartWizard JavaScript source -->
    <script src="{{ asset('assets/smartwizard/dist/js/jquery.smartWizard.min.js') }}"></script>

    <script>
        CKEDITOR.replace( 'contents' , {
            toolbar: [
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-'] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'others', items: [ '-' ] },

                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                // { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
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
