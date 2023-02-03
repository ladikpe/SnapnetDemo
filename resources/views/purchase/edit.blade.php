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

        #newComment:hover
        {
            border: #e0e0e0 thin solid !important;
            /*border-radius: 50%;*/
        }

        .version_div
        {
            border: thin dotted #eee;
        }
        .version_div:hover
        {
            border: thin solid #1E9FF2;
            border-radius: 4px;
        }
    </style>
@endsection
@section('content')


    <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>



    <div class="row">
        <form id="purchaseOrderForm" action="{{route('purchase-order.store')}}" enctype="multipart/form-data" method="POST">  @csrf
            <input type="hidden" name="edit_id" id="edit_id" value="{{$purchase_order->id}}">
            <input type="hidden" class="form-control" name="requisition_id" id="requisition_id" value="{{$purchase_order->requisition_id}}">
            <div class="row">
                <div class="col-md-8">



                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-7" style=""> New Purchase Orders
                                        <a href="{{ route('vendor-shortlist',[$purchase_order->id]) }}" class="btn btn-float btn-outline-dark btn-round btn-sm ml-2" data-toggle="tooltip"
                                           title="Vendor Shortlisting & Selection"> Shortlist Vendor </a>
                                    </div>

                                    <div class="col-md-5" style="">
                                        <fieldset class="form-group no-pad">

                                            <select class="form-control tokenizationSelect2" name="name" id="order_name" style="width: 80%; float: right">
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
                                    <textarea name="contents" id="contents" oncopy="return false;" cols="100%" rows="15">{!! $purchase_order->contents !!}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content" id="comment-div" style="display: none">
                            <div class="card-body">
                                <h3 class="card-title" id="basic-layout-form">
                                    <div class="row" style="margin-top: -10px">
                                        <div class="col-md-12" style=""> Comments
                                            <a href="{{url('shortlisted-vendors/'.$purchase_order->id)}}" class="btn btn-float btn-outline-primary btn-round btn-sm pull-right" id="shareBtn"
                                               data-toggle="tooltip" title="Share With Shortlisted Vendors" target="_blank"><i class="la la-share"></i> </a>

                                            <a href="{{url('purchase-order-view/'.$purchase_order->id)}}" class="btn btn-float btn-outline-success btn-round btn-sm pull-right mr-1" id="viewBtn"
                                               data-toggle="tooltip" title="Click to Preview this Document" target="_blank"><i class="la la-eye"></i> </a>

                                            <button type="button" class="btn btn-float btn-outline-info btn-round btn-sm pull-right mr-1 commentBtn" id="" data-toggle="tooltip"
                                                    title="View All Comment"><i class="la la-comments"></i> </button>
                                        </div>
                                    </div>
                                </h3>

                                <div class="media d-flex" id="po_form">
                                    <table class="table table-sm mb-0" id="comment_row">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Comments</th>
                                            <th>By</th>
                                            <th style="text-align: right">
                                                <a href="#" class="my-btn btn-sm" style="color: #fff !important;" id="newComment" data-toggle="modal"
                                                   data-target="#new_comment" title="Add Comment"><i class="la la-plus"></i> </a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($purchase_order_comments as $comment)
                                            <tr class="_row">
                                                <td>{{ $comment->comment }}</td>
                                                <td>{{$comment->author->name}}</td>
                                                <td style="text-align: right">
                                                    <a onclick="removeComment({{ $comment->id }}, {{ $comment->document_id }})" href="#"
                                                       style="cursor: pointer; color:red; font-size:10px" data-toggle="tooltip" id="{{$comment->id}}"
                                                       class="btn-sm pull-right removeBtn" title="Remove Comment"> <i class="la la-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                    {!! $purchase_order_comments->render() !!}
                                </div>

                            </div>
                        </div>

                        <div class="card-content" id="search-div">
                            <div class="card-body">
                                <h3 class="card-title" id="basic-layout-form">
                                    <div class="row" style="margin-top: -10px">
                                        <div class="col-md-12" style=""> Details
                                            <a href="{{url('shortlisted-vendors/'.$purchase_order->id)}}" class="btn btn-float btn-outline-primary btn-round btn-sm pull-right" id="shareBtn"
                                               data-toggle="tooltip" title="Share With Shortlisted Vendors" target="_blank"><i class="la la-share"></i> </a>

                                            <a href="{{url('purchase-order-view/'.$purchase_order->id)}}" class="btn btn-float btn-outline-success btn-round btn-sm pull-right mr-1" id="viewBtn"
                                               data-toggle="tooltip" title="Click to Preview this Document" target="_blank"><i class="la la-eye"></i> </a>

                                            <button type="button" class="btn btn-float btn-outline-info btn-round btn-sm pull-right mr-1 commentBtn" id="" data-toggle="tooltip"
                                                    title="View All Comment"><i class="la la-comments"></i> </button>
                                        </div>
                                    </div>

                                </h3>

                                <div class="media d-flex row" id="po_form">
                                    <div class="col-md-12">
                                        <fieldset class="form-group no-pad">
                                            <small class="text-muted"><span>Order Name <i class="mand">*</i> </span></small>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $purchase_order->name }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Description </span></small>
                                            <textarea rows="3" class="form-control" name="description" id="description">{{ $purchase_order->description }}</textarea>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Assigned to <i class="mand">*</i> </span></small>
                                            <select class="form-control" name="assigned_to" id="assigned_to">
                                                <option value="{{ $purchase_order->assigned_to }}">{{ $purchase_order->assign?$purchase_order->assign->name:"" }}</option>
                                                @forelse($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Deadline</span></small>
                                            <input type="date" class="form-control" name="deadline" id="deadline" value="{{ $purchase_order->deadline }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Shortlisted Vendors</span></small>
                                            <input type="date" class="form-control" name="deadline" id="deadline" value="{{ $purchase_order->deadline }}">
                                        </fieldset>
                                    </div>


                                    {{-- versions--}}
                                    <div class="col-md-12">
                                        <fieldset class="form-group col-md-12 no-pad">
                                            <small class="text-muted"><span>Versions</span></small> <hr>
                                            @forelse($purchase_order_versions as $purchase_order_version)
                                                <div class="col-md-6 pull-left version_div" data-toggle="tooltip" title="Click To Use The Version">
                                                    <a href="#" id="id_{{ $purchase_order_version->id }}" onclick="useVersion({{ $purchase_order_version->id }})">
                                                        {{ $purchase_order_version->version_no }}
                                                    </a>
                                                </div>
                                            @empty
                                            @endforelse
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 15px;">
                <button type="submit" id="saveBtn" class="btn btn-dark btn-sm pull-right" onclick="return confirm('Are you sure you want to UPDATE Purchase Order?')">
                    <i class="fa fa-save"></i> Save </button>
            </div>
        </form>
    </div>





    <form id="commentForm" action="{{route('store-comment')}}" enctype="multipart/form-data" method="POST">  @csrf
        <input type="hidden" class="form-control" name="document_id" id="document_id" value="{{ $purchase_order->id }}" required>
        <input type="hidden" class="form-control" name="comment_name" id="comment_name" value="{{ $purchase_order->name }}" required>

        <!-- Modal -->
        <div class="modal animated zoomIn text-left" id="new_comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">New Comment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12">
                            <fieldset class="form-group col-md-12 no-pad">
                                <small class="text-muted"><span>Comment <i class="mand">*</i> </span></small>
                                <textarea rows="4" class="form-control" name="comment" id="comment" required></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn grey btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Are you sure you want to save comment?')">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>





















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


        //SWITCHING VERSIONS
        function useVersion(id)
        {
            $(function ()
            {
                $.get('{{url('getPurchaseOrderVersion')}}?id=' +id, function(data)
                {
                    CKEDITOR.instances['contents'].setData(data.contents);
                });
            });
        }


        //COMMENTS TOGGLE
        $(function ()
        {
            $('.commentBtn').click(function()
            {
                $('#comment-div').fadeToggle();
            });
        });



        //Adding Comments
        $('#commentForm').on('submit', function(e)
        {
            e.preventDefault();

            document_id = $('#document_id').val();
            comment_name = $('#comment_name').val();
            comment = $('#comment').val();

            formData =
            {
                document_id:document_id,
                comment_name:comment_name,
                comment:comment,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('store-comment')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    toastr.success(data.info);

                    $('#comment').val('');
                    $('#new_comment').modal('hide');
                    reloadComments(document_id);
                }
                else{ toastr.error(data.error); }
            });

        });

        //REMOVE COMMENT
        function  removeComment(id, document_id)
        {
            if(confirm('Are you sure you want to delete this comment?'))
            {
                formData =
                {
                    id:id,
                    document_id:document_id,
                    _token:'{{csrf_token()}}'
                }

                $.post('{{url('remove-comment')}}?id=' +id, formData, function(data, status, xhr)
                {
                    if(data.status=='ok')
                    {
                        toastr.success(data.info);
                        //reloading comment table
                        reloadComments(document_id);
                    }
                    else{ toastr.error(data.error); }
                });
            }
        }

        //reload comment list
        function reloadComments(document_id)
        {
            $(function ()
            {
                $('._row').remove();
                $.get('{{url('getComments')}}?document_id=' +document_id, function(data)
                {
                    $.each(data, function(index, Comment)
                    {
                        $('#comment_row').append('<tr class="_row">  <td> '+Comment.comment+' </td>  <td> '+Comment.author.name+' </td> <td style="text-align: right">  <a onclick="removeComment('+Comment.id+', '+Comment.document_id+')" href="#" style="cursor: pointer; color:red; font-size:10px" tooltip="true" id="" class="btn-sm pull-right removeBtn" title="Remove Comment"> <i class="la la-trash"></i>    </a>  </td>   </tr>');
                    });
                });
            });
        }

    </script>

    <script src="{{asset('jstree/dist/jstree.min.js') }}"></script>
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

