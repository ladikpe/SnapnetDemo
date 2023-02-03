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







    <form id="templateForm" action="{{route('workorder.store')}}" enctype="multipart/form-data" method="POST">  @csrf
        <input type="hidden" name="id" id="id" value="{{$workorder->id}}">
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
                                        <small class="text-muted"><span>Workorder Name <i class="mand">*</i> </span></small>
                                        <input type="text" class="form-control" name="name" id="name" value="{{$workorder->name}}" required>
                                        {{-- <select class="form-control tokenizationSelect2" name="name" id="order_name">
                                            <option value=""></option>
                                            @forelse($purchase_templates as $purchase_template)
                                                <option value="{{$purchase_template->name}}">{{$purchase_template->name}}</option>
                                            @empty
                                            @endforelse
                                        </select> --}}
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <fieldset class="form-group col-md-12 no-pad">
                                        <small class="text-muted"><span>Description </span></small>
                                        <textarea rows="3" class="form-control" name="description" id="description">{{$workorder->description}}</textarea>
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
                                    <div class="col-md-12" style=""> Edit  {{$workorder->workorder_code}}
                                        <a href="{{ route('workorder.show', $workorder->id) }}" class="btn btn-float btn-outline-dark btn-round btn-sm ml-2 pull-right" data-toggle="tooltip" title="View Workorder"> View</a>
                                    </div>
                                </div>
                            </h3>


                            <div id="smartwizard">
                                <ul class="nav">
                                    <li> <a class="nav-link" href="#step-1"> Header </a> </li>
                                    {{-- <li> <a class="nav-link" href="#step-2"> Header </a> </li> --}}
                                    <li> <a class="nav-link" href="#step-2"> Parts & Materials </a> </li>
                                    <li> <a class="nav-link" href="#step-3"> Services & Labour </a> </li>
                                    <li> <a class="nav-link" href="#step-4"> VAT </a> </li>
                                    <li> <a class="nav-link" href="#step-5"> Signatures & Instruction </a> </li>
                                    <li> <a class="nav-link" href="#step-6"> Save </a> </li>
                                </ul>

                                <div class="tab-content" style="height: auto !important;"> 

                                    {{-- Header DETAILS --}}
                                    <div id="step-1" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show">
                                            <div class="card-body card-border">
                                                <div class="form-group row">
                                                    <label for="header" class="col-md-12 col-form-label"> <h4> Header </h4> </label>
                                                    <div class="col-md-12">
                                                        <textarea name="header" oncopy="return false;" id="header_ed" cols="100%" rows="20">{{$workorder->header}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                    </div>

                                    {{-- Header DETAILS --}}
                                    {{-- <div id="step-2" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show">
                                            <div class="card-body card-border">

                                                <table class="table table-sm" border="0">
                                                    <tr>
                                                        <td style="width: 15%"> Company Name </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                        <td style="width: 20%">  </td>

                                                        <td style="width: 15%"> Workorder Title </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 15%"> Workorder NO </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                        <td style="width: 20%">  </td>

                                                        <td style="width: 15%"> RFQ NO </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 15%"> Issue Date </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                        <td style="width: 20%">  </td>

                                                        <td style="width: 15%"> Delivery Date </td>
                                                        <td style="width: 25%">
                                                            <input class="form-control input-sm" type="text" name="" id="">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 15%"> Vendor Info </td>
                                                        <td style="width: 25%">
                                                            <textarea rows="2" class="form-control input-sm" name="" id=""></textarea>
                                                        </td>
                                                        <td style="width: 20%">  </td>

                                                        <td style="width: 15%"> Delivery Info </td>
                                                        <td style="width: 25%">
                                                            <textarea rows="2" class="form-control input-sm" name="" id=""></textarea>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                          </div>
                                    </div> --}}


                                    {{-- Part & Materials DETAILS --}}
                                    <div id="step-2" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show" style="max-height: 80%; overflow: auto">
                                            <div class="card-body card-border" id="form_row">
                                                

                                                <div class="form-group row">
                                                    <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right ml-1" id="newRow" style="padding :0.3rem 0.4rem !important;"><i class="la la-plus" aria-hidden="true"> New</i>
                                                    </a>
                                                </div>


                                                    @php $i = 1; @endphp
                                                    @forelse($details as $k => $detail)
                                                        @if($detail->type == 'Parts & Materials')
                                                            <div class="form-group row" id="row{{$i}}">    <div class="col-md-6">    <label for="pm_item{{$i}}" style="padding-left: 0px"> Item List </label>    <input type="text" class="form-control" id="pm_item{{$i}}" placeholder="Parts / Materials" name="pm_item{{$i}}" value="{{$detail->item}}" />     </div>    <div class="col-md-2">      <label for="quantity{{$i}}" style="padding-left: 0px"> Qty </label>    <input type="number" class="form-control qty" id="quantity{{$i}}" name="quantity{{$i}}" value="{{$detail->colume_1}}" onkeyup="calcTotal({{$i}})" min="1" />    </div>    <div class="col-md-2">     <label for="unit_price{{$i}}" style="padding-left: 0px"> Unit Price </label>    <input type="number" step="0.02" class="form-control u_price" id="unit_price{{$i}}" placeholder="Unit Price" name="unit_price{{$i}}" onkeyup="calcTotal({{$i}})" min="1" value="{{$detail->colume_2}}" />    </div>    <div class="col-md-2 row">   <div class="col-md-7 no-pad">   <label for="line_total{{$i}}" style="padding-left: 0px"> Line Total </label>    </div>    <div class="col-md-5 no-pad">    <a onclick="" class="btn btn-float btn-outline-danger btn-round btn-sm pull-right remove" data-toggle="tooltip" title="Remove Item" id="{{$i}}" style="right: 0px !important; padding: 2px">    <i class="la la-remove" aria-hidden="true"></i></a>    </div>    <input type="number" step="0.02" class="form-control line_total" id="line_total{{$i}}" placeholder="Total" name="line_total{{$i}}" value="{{$detail->line_total}}" readonly />    <input type="hidden" class="form-control" id="pm_count{{$i}}" name="pm_count" value="{{$i}}" />  </div>    </div> @php $i++; @endphp
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                    
                                                {{-- <a href="" class="btn btn-outline-success btn-glow btn-sm pull-right mb-1" style="padding :0.3rem 0.4rem !important;"><i class="la la-arrow-right" aria-hidden="true"> Next</i>
                                                </a> --}}
                                            </div>
                                          </div>
                                    </div>


                                    {{-- Service & Labour DETAILS --}}
                                    <div id="step-3" class="tab-pane" role="tabpanel">
                                         <div class="card-content collapse show" style="max-height: 80%; overflow: auto">
                                            <div class="card-body card-border" id="form_sl_row">

                                                <div class="form-group row">
                                                    <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right ml-1" id="newSLRow" style="padding :0.3rem 0.4rem !important;"><i class="la la-plus" aria-hidden="true"> New</i>
                                                    </a>                                                  
                                                </div>


                                                    @php $j = 1; @endphp
                                                    @forelse($details as $k => $detail)
                                                        @if($detail->type == 'Service & Labour')
                                                            <div class="form-group row" id="row_{{$j}}">    <div class="col-md-6">    <label for="sl_item{{$j}}" style="padding-left: 0px"> Item List </label>    <input type="text" class="form-control" id="sl_item{{$j}}" placeholder="Service / Labour" name="sl_item{{$j}}" value="{{$detail->item}}" />     </div>    <div class="col-md-2">      <label for="hour{{$j}}" style="padding-left: 0px"> Hours </label>    <input type="number" class="form-control hour" id="hour{{$j}}" placeholder="hour" name="hour{{$j}}" value="{{$detail->colume_1}}" onkeyup="calcSLTotal({{$j}})" min="1" />    </div>    <div class="col-md-2">     <label for="rate{{$j}}" style="padding-left: 0px"> Hourly Rate </label>    <input type="number" class="form-control rate" id="rate{{$j}}" placeholder="Hourly Rate" name="rate{{$j}}" onkeyup="calcSLTotal({{$j}})" min="1" value="{{$detail->colume_2}}" />    </div>    <div class="col-md-2 row">   <div class="col-md-7 no-pad">   <label for="line_total_sl{{$j}}" style="padding-left: 0px"> Line Total </label>    </div>    <div class="col-md-5 no-pad">    <a class="btn btn-float btn-outline-danger btn-round btn-sm pull-right remove_sl" data-toggle="tooltip" title="Remove Item" id="{{$j}}" style="right: 0px !important; padding: 2px">    <i class="la la-remove" aria-hidden="true"></i></a>    </div>    <input type="number" class="form-control line_total_sl" id="line_total_sl{{$j}}" placeholder="Total" name="line_total_sl{{$j}}" readonly value="{{$detail->line_total}}" />    <input type="hidden" step="0.02" class="form-control" id="sl_count{{$j}}" name="sl_count" value="{{$j}}" />  </div>    </div> @php $j++; @endphp
                                                        @endif
                                                    @empty
                                                    @endforelse  

                                            </div>
                                          </div>
                                    </div> 

                                    {{-- VAT DETAILS --}}
                                    <div id="step-4" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show">
                                            <div class="card-body card-border">
                                                <div class="form-group row">
                                                    <label for="vat" class="col-md-12 col-form-label"> <h4> VAT / TAX </h4> </label>
                                                    <div class="col-md-12">
                                                        <input type="number" step="0.02" class="form-control" name="vat" id="vat" value="{{$workorder->vat}}">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                    </div>


                                    {{-- Comments & Signatures DETAILS --}}
                                    <div id="step-5" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show">
                                            <div class="card-body card-border">
                                                <div class="form-group row">
                                                    <label for="comment" class="col-md-12 col-form-label"> <h4> Comment & Signatures </h4> </label>
                                                    <div class="col-md-12">
                                                        <textarea oncopy="return false;" name="comment" id="comment_ed" cols="100%" rows="20">{{$workorder->comment}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                    </div>


                                    {{-- FINISH --}}
                                    <div id="step-6" class="tab-pane" role="tabpanel">
                                          <div class="card-content collapse show">
                                            <div class="card-body card-border">
                                              {{-- @if($requisition->contract_created == 1 && $document->reviewed_approved <= 2) --}}
                                                <div class="form-group row">
                                                    <label for="content" class="col-md-12 col-form-label" style="text-align: center;"> <h4> Save Document Below </h4> </label>
                                                    <div class="col-md-12" style="text-align: center;">
                                                        <button type="submit" class="btn btn-outline-success btn-glow btn-sm" onclick="return confirm('Are you sure you want to save document?')" name="SaveBtn" value="1"> Save Document </button>
                                                    </div>
                                                </div>
                                              {{-- @else
                                                <div class="form-group row">
                                                    <label for="content" class="col-md-12 col-form-label" style="text-align: center;"> 
                                                      <h4 style="color: #ccc"> Document has been approved </h4> </label>
                                                </div>
                                              @endif --}}
                                            </div>
                                          </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

           {{--  <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 15px;">
                <button type="submit" id="saveBtn" class="btn btn-dark btn-sm pull-right mt-1 mr-3"> <i class="fa fa-save"></i> Save </button>
            </div> --}}

        </div>
    </form>
























@endsection

@section('scripts')



    <script>
        $(function()
        {
            var i = '{{$pm_count}}';      var c = 0;
            $('#newRow').on('click', function(e)
            {
                $('#form_row').append('<div class="form-group row" id="row'+i+'">    <div class="col-md-6">    <label for="pm_item'+i+'" style="padding-left: 0px"> Item List </label>    <input type="text" class="form-control" id="pm_item'+i+'" placeholder="Parts / Materials" name="pm_item'+i+'" />     </div>    <div class="col-md-2">      <label for="quantity'+i+'" style="padding-left: 0px"> Qty </label>    <input type="number" class="form-control qty" id="quantity'+i+'" placeholder="quantity" name="quantity'+i+'" value="1" onkeyup="calcTotal('+i+')" min="1" />    </div>    <div class="col-md-2">     <label for="unit_price'+i+'" style="padding-left: 0px"> Unit Price </label>    <input type="number" step="0.02" class="form-control u_price" id="unit_price'+i+'" placeholder="Unit Price" name="unit_price'+i+'" onkeyup="calcTotal('+i+')" min="1" />    </div>    <div class="col-md-2 row">   <div class="col-md-7 no-pad">   <label for="line_total'+i+'" style="padding-left: 0px"> Line Total </label>    </div>    <div class="col-md-5 no-pad">    <a onclick="" class="btn btn-float btn-outline-danger btn-round btn-sm pull-right remove" data-toggle="tooltip" title="Remove Item" id="'+i+'" style="right: 0px !important; padding: 2px">    <i class="la la-remove" aria-hidden="true"></i></a>    </div>    <input type="number" step="0.02" class="form-control line_total" id="line_total'+i+'" placeholder="Total" name="line_total'+i+'" readonly />    <input type="hidden" class="form-control" id="pm_count'+i+'" name="pm_count" value="'+i+'" />  </div>    </div>');

                i++;

                // getVendor(i);
            });



            var j = '{{$sl_count}}';      var ct = 0;
            $('#newSLRow').on('click', function(e)
            {
                $('#form_sl_row').append('<div class="form-group row" id="row_'+j+'">    <div class="col-md-6">    <label for="sl_item'+j+'" style="padding-left: 0px"> Item List </label>    <input type="text" class="form-control" id="sl_item'+j+'" placeholder="Service / Labour" name="sl_item'+j+'" />     </div>    <div class="col-md-2">      <label for="hour'+j+'" style="padding-left: 0px"> Hours </label>    <input type="number" class="form-control hour" id="hour'+j+'" placeholder="hour" name="hour'+j+'" value="1" onkeyup="calcSLTotal('+j+')" min="1" />    </div>    <div class="col-md-2">     <label for="rate'+j+'" style="padding-left: 0px"> Hourly Rate </label>    <input type="number" class="form-control rate" id="rate'+j+'" placeholder="Hourly Rate" name="rate'+j+'" onkeyup="calcSLTotal('+j+')" min="1" />    </div>    <div class="col-md-2 row">   <div class="col-md-7 no-pad">   <label for="line_total_sl'+j+'" style="padding-left: 0px"> Line Total </label>    </div>    <div class="col-md-5 no-pad">    <a class="btn btn-float btn-outline-danger btn-round btn-sm pull-right remove_sl" data-toggle="tooltip" title="Remove Item" id="'+j+'" style="right: 0px !important; padding: 2px">    <i class="la la-remove" aria-hidden="true"></i></a>    </div>    <input type="number" class="form-control line_total_sl" id="line_total_sl'+j+'" placeholder="Total" name="line_total_sl'+j+'" readonly />    <input type="hidden" step="0.02" class="form-control" id="sl_count'+j+'" name="sl_count" value="'+j+'" />  </div>    </div>');

                j++;

                // getVendor(i);
            });
        
        
            $(document).on('click', '.remove', function ()
            {
                var button_id = $(this).attr("id");
                $('#row'+button_id+"").remove();          
            }); 
        
            $(document).on('change', '.u_price', function ()
            {
                var line_total = 0;   var qty = 1;  var u_price = 0; var line_id = '';

                _id = $(this).attr("id");  line_id = _id.substr(10);
                qty = $('#quantity'+line_id).val();
                u_price = $('#unit_price'+line_id).val();
                line_total = parseFloat((qty * u_price));
                $('#line_total'+line_id).val(line_total);           
            });
        
            $(document).on('change', '.qty', function ()
            {
                var line_total = 0;   var qty = 1;  var u_price = 0; var line_id = '';

                _id = $(this).attr("id");  line_id = _id.substr(8);
                qty = $('#quantity'+line_id).val();
                u_price = $('#unit_price'+line_id).val();
                line_total = parseFloat((qty * u_price));
                $('#line_total'+line_id).val(line_total);           
            }); 



            //service and labour        
            $(document).on('click', '.remove_sl', function ()
            {
                var button_id = $(this).attr("id");
                $('#row_'+button_id+"").remove();          
            }); 
        
        
            $(document).on('change', '.rate', function ()
            {
                var line_total = 0;   var hour = 1;  var rate = 0; var line_id = '';

                _id = $(this).attr("id");  line_id = _id.substr(4);
                hour = $('#hour'+line_id).val();
                rate = $('#rate'+line_id).val();
                line_total = parseFloat((hour * rate));
                $('#line_total_sl'+line_id).val(line_total);           
            });
        
            $(document).on('change', '.hour', function ()
            {
                var line_total = 0;   var hour = 1;  var rate = 0; var line_id = '';

                _id = $(this).attr("id");  line_id = _id.substr(4);
                hour = $('#hour'+line_id).val();
                rate = $('#rate'+line_id).val();
                line_total = parseFloat((hour * rate));
                $('#line_total_sl'+line_id).val(line_total);           
            }); 
            
        });

        function calcTotal(n)
        {
            $(function()
            {
                var line_total = 0;   var qty = 1;  var u_price = 0;

                qty = $('#quantity'+n).val();
                u_price = $('#unit_price'+n).val();
                line_total = parseFloat((qty * u_price));
                $('#line_total'+n).val(line_total);
            });
        }


        function calcSLTotal(n)
        {
            $(function()
            {
                var line_total = 0;   var hour = 1;  var rate = 0;

                hour = $('#hour'+n).val();
                rate = $('#rate'+n).val();
                line_total = parseFloat((hour * rate));
                $('#line_total_sl'+n).val(line_total);
            });
        }

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
        CKEDITOR.replace( 'header_ed' , {
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
        CKEDITOR.replace( 'header_ed' ).on('paste',function(e){e.cancel();});
        // CKEDITOR.instances.editor1.on('copy',function(e){e.cancel();});
        // $('body').bind('copy',function(e){e.preventDefault(); return false;});
    </script>

    <script>
        CKEDITOR.replace( 'comment_ed' , {
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
        CKEDITOR.replace( 'comment_ed' ).on('paste',function(e){e.cancel();});
        // CKEDITOR.instances.editor1.on('copy',function(e){e.cancel();});
        // $('body').bind('copy',function(e){e.preventDefault(); return false;});
    </script>




    @if(Session::has('info'))
        <script>
            $(function()
            {
                toastr.success('{{session('info')}}', {timeOut:50000});
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

