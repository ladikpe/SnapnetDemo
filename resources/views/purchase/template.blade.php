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

        body {background:#ccc}

        .box h3{
            text-align:center;
            position:relative;
            top:80px;
        }
        .box {
            width:70%;
            height:200px;
            background:#FFF;
            margin:40px auto;
        }
        .card-1 {
            box-shadow: 0 1px 3px rgba(0,0,0,0.0), 0 1px 2px rgba(0,0,0,0.0);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        }

        .card-1:hover
        {
            box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);

        }

    </style>
@endsection
@section('content')


    <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>




{{--    <div class="row">--}}

{{--        <div class="col-md-12" style="">--}}
{{--            <div class="card" style="background: #eeeeee">--}}
{{--                <div class="card-content">--}}
{{--                    <div class="card-body">--}}
{{--                        <h3 class="card-title" id="">--}}
{{--                            <div class="row" style="margin-top: -10px">--}}
{{--                                <div class="col-md-12" style=""> Purchase Order Templates </div> <br> <br>--}}

{{--                                @forelse($purchase_templates as $template)--}}
{{--                                    <div class="col-xl-2 col-md-6 col-sm-12 card-1" >--}}
{{--                                        <div class="card" style="height: 250.875px; overflow: hidden">--}}
{{--                                            <div class="card-content">--}}
{{--                                                <div class="card-body">--}}
{{--                                                    <a href="#" class="btn btn-info btn-round btn-sm" title="View All Purchase Order"><i class="la la-pen"> Use</i></a>--}}

{{--                                                    <h4 class="card-title">{{$template->name}}</h4>--}}
{{--                                                    <h6 class="card-subtitle text-muted">Support card subtitle</h6>--}}
{{--                                                </div>--}}
{{--                                                <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Card image cap">--}}
{{--                                                <div class="card-body">--}}
{{--                                                    <p class="card-text">{!! $template->contents !!}</p>--}}
{{--                                                    <p class="card-text">Bear claw sesame snaps gummies chocolate.</p>--}}
{{--                                                    <a href="#" class="card-link pink">Card link</a>   <a href="#" class="card-link pink">Another link</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                @empty--}}
{{--                                @endforelse--}}

{{--                            </div>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}



    <form id="templateForm" action="{{route('store-template')}}" enctype="multipart/form-data" method="POST">  @csrf
        <div class="row">

            <div class="col-md-3" style="">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h3 class="card-title" id="">
                                <div class="row" style="margin-top: -10px">
                                    <div class="col-md-12" style=""> Details </div>
                                </div>
                            </h3>

                            <div class="row" id="po_form">
                                <div class="col-md-12">
                                    <fieldset class="form-group no-pad">
                                        <small class="text-muted"><span>Purchase Order Name <i class="mand">*</i> </span></small>
                                        <select class="form-control tokenizationSelect2" name="name" id="order_name">
                                            <option value=""></option>
                                            @forelse($purchase_templates as $purchase_template)
                                                <option value="{{$purchase_template->name}}">{{$purchase_template->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <fieldset class="form-group col-md-12 no-pad">
                                        <small class="text-muted"><span>Description </span></small>
                                        <textarea rows="3" class="form-control" name="description" id="description"></textarea>
                                    </fieldset>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9" style="">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h3 class="card-title" id="">
                                <div class="row" style="margin-top: -10px">
                                    <div class="col-md-12" style=""> New Purchase Orders
                                        <a href="{{ route('purchase-order.index') }}" class="btn btn-float btn-outline-dark btn-round btn-sm" data-toggle="tooltip" title="View All Purchase Order"><i class="la la-list"></i></a>
                                    </div>
                                </div>
                            </h3>

                            <div class="" id="">
                                <textarea name="contents" oncopy="return false;" id="contents" cols="100%" rows="15"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 15px;">
                <button type="submit" id="saveBtn" class="btn btn-dark btn-sm pull-right"> <i class="fa fa-save"></i> Save </button>
            </div>

        </div>
    </form>
























@endsection

@section('scripts')

    <script>
        $(function()
        {
            $(".tokenizationSelect2").select2({
                placeholder: "Search Template Name", //placeholder
                tags: true,
                tokenSeparators: ['/',',',';'," "]
            });
        });

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

