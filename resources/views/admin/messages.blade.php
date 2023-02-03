{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

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


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px;  padding: 0px 15px">
                                <div class="col-md-12" style="">  
                                    <div class="badge badge-primary round text-white" style="padding: 5px 10px; font-size: 15px"> Email Messages {{$messages->count()}} </div>
                                    {{-- <a href="" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" onclick="clearForm()" data-toggle="modal" data-target="#addForm" data-toggle="tooltip" title="Create New Email Message"><i class="la la-plus"></i> New</a> --}}
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="requisition_table">
                                <thead class="">
                                <tr>
                                    <th style="color: transparent;">#</th>
                                    <th>Header</th>
                                    <th>Description</th>
                                    {{-- <th>Message Body</th> --}}
                                    <th>Author</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>  
                                @forelse ($messages as $message)
                                    <tr>
                                        <td style="color: transparent;">{{ $message->id }}</td>
                                        <td>{{ $message->header }}</td>
                                        <td>{{ $message->title }}</td>
                                        {{-- <td>{!! $message->message !!}</td> --}}
                                        <td>{{ $message->author?$message->author->name:''}}</td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Edit Message">
                                                <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#addForm" 
                                                onclick="getMessage({{$message->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="Delete Message">
                                                <a href="#" class="my-btn btn-sm text-danger deleteBtn" id="{{$message->id}}" 
                                                ><i class="la la-trash" aria-hidden="true"></i>
                                                </a>
                                            </span>

                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $messages->render() !!} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 75% !important;">
          <div class="modal-content">
            <div class="modal-header bg-blue white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33">New Message</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">X</span>
              </button>
            </div>

            <form id="addMessageForms" action="{{ route('messages.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control _id" name="id" id="msg_id" required>

              <div class="modal-body">
                <label>Title / Header </label>
                <div class="form-group">
                  <select class="form-control _header" name="header" id="header" required>
                    <option value=""></option>
                    <option value="Send Task Requisition Email">Send Task Requisition Email</option>
                    <option value="Task Assignment Email">Task Assignment Email</option>
                    <option value="Send Clarity Email">Send Clarity Email</option>
                    <option value="Send Clarity Response Email">Send Clarity Response Email</option>
                    <option value="Send Share Link Email">Send Share Link Email</option>
                    <option value="Send Executed Email">Send Executed Email</option>
                    <option value="request_approval_notification">Request Approval Notification</option>
                  </select>
                </div>

                <label>Message Description </label>
                <div class="form-group">
                  <input type="text" placeholder="Message Description" class="form-control _title" name="title" id="title" required>
                </div>

                <label class="panel-title">Message Body</label>
                <fieldset class="form-group">
                    <textarea class="form-control _message" cols="30" rows="8" name="message" id="message" required></textarea>
                </fieldset>

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning" data-dismiss="modal" value="Clear">
                <input type="submit" class="btn btn-primary" value="Save">
              </div>
            </form>

          </div>
        </div>
    </div>













@endsection

@section('scripts')

    <script>

        //ADD FORM
        function getMessage(id)
        {  
            clearForm();
            $(function()
            {            
                $.get('{{url('get-message-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#msg_id').val(data.id);
                    $('#header').val(data.header);
                    $('#title').val(data.title);
                    CKEDITOR.instances['message'].setData(data.message);
                    
                    $('#header').attr("style", "pointer-events: none;");
                    $('#title').attr("readonly", true);
                });                
            });
        }


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('._id').val('');
                $('._header').val('');
                $('._title').val('');
                CKEDITOR.instances['message'].setData();
                    
                    $('#header').attr("style", "pointer-events: auto;");
                    $('#title').attr("readonly", false);               
            });
        }



        


      CKEDITOR.replace( 'message' , 
      {
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [  ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [  'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField', 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
       
        // { name: 'basicstyles', groups: [  ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'insert', items: [ 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Styles', 'Format', 'Font', 'FontSize'  ] },
      
        // { name: 'styles', items: [] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
        { name: 'others', items: [ '-' ] }
        ]

      }).on('cut copy paste',function(e){e.cancel();});

      CKEDITOR.config.extraPlugins = "base64image";
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
