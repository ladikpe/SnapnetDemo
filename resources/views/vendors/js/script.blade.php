<script>

    function pullDocumentDetails(id)
    {
        $.get('{{url('get-document-by-id')}}?id=' +id, function(data)
        {
            //Set values
            $('#document_id').val(data.id);
            $('#vendor_id').val(data.vendor_id);
            $('#doc_name').val(data.name);
            $('#type_id').val(data.type_id);
            $('#file').val(data.file);
            $('#expiry_date').val(data.expiry_date);
        });
    }


    function pullDocumentId(id, v_id)
    {   
        $('#document_id').val(id);
        $('#v_id').val(v_id);
    }

</script>

<script>
    function getDocument(id)
    {
        clearForm();
        $(function()
        {            
            $.get('{{url('get-document-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#id').val(data.id);
                $('#vendor_id').val(data.vendor_id);
                $('#name').val(data.name);
                $('#type_id').val(data.type_id);
                $('#file').val(data.file);
                $('#expiry_date').val(data.expiry_date);
            });
            
        });
    }


    $("#deleteDocumentForm").on('submit', function(e)
    { 
        e.preventDefault();

        var document_id = $('#document_id').val();
        var vendor_id = $('#v_id').val();

        formData = 
        {
            document_id:document_id,
            vendor_id:vendor_id,
            _token:'{{csrf_token()}}'
        }
        $.post('{{route('delete-document')}}', formData, function(data, status, xhr)
        {
            return toastr.success(data.info);
            $('#document_id').val(0);
            $('#v_id').val(0) 

            $('#docu_table').remove();
            $('#document-div').load("{{url('load-document-table')}}?vendor_id="+vendor_id);
        });
    });


    //ADD FORM
    $("#uploadDocumentForm").on('submit', function(e)
    { 
        // clearForm();
        e.preventDefault();

        var name = $('#name').val();
        var vendor_id = $('#vendor_id').val();
        var type_id = $('#type_id').val();
        var expiry_date = $('#expiry_date').val();

        // var type = getRes(type_id);

        const formData = new FormData(document.querySelector('#uploadDocumentForm'));  

        fetch('{{route('upload-document')}}', {
            method:'POST',
            body:formData
        }).then((data)=>{

            // var details = data.details;
            toastr.success('Vendor document uploaded successfully', {timeOut:10000});

            
            // $('#docu_table').remove();
            $('#document-div').load("{{url('load-document-table')}}?vendor_id="+vendor_id);
        });
    });


    //APROVE FORM
    $("#approveVendorForm").on('submit', function(e)
    { 
        e.preventDefault();
        var vendor_id = $('#vendorId').val();
        formData = 
        {
            vendor_id:vendor_id,
            _token:'{{csrf_token()}}'
        }
        $.post('{{route('approve-vendor')}}', formData, function(data, status, xhr)
        {
            if(data.status=='ok')
            {
                toastr.success(data.info, {timeOut:10000});
                return;
            }
            else{   toastr.error(data.error, {timeOut:10000});   }
        }); 
    });



    function clearForm()
    {
        $(function()
        {            
            //Set values
            $('#id').val('');
            $('#name').val('');
            $('#type_id').prop('value', 0);
            $('#file').val('');              
            $('#expiry_date').val('');               
        });
    }


    function getRes(type_id)
    {
        $.get('{{url('get-doc_type-by-id')}}?id=' +type_id, function(res)
        {
            //Set values
            return res.name;
        });
    }


    //delete FORM
    
    // Datatable
    $(function()
    {
        $('#doc_yes_btn').click(function()
        {
            $('.modal').modal('hide');
        }); 


        $('#ok_app_btn').click(function()
        {
            $('.modal').modal('hide');
            setInterval(function(){ window.location.reload(); }, 3000);
        });           
    });


    //DATATABLE
    $(function (){     $('#docu_table').DataTable();    $('#submitted_table').DataTable();      });





    //displaying bid documents
    function displayBidDocuments(id)
    {  
        $.get('{{url('/get-submitted-bid-docs')}}?bid_submission_id='+id, function(data)
        {
            $('#sub_bid_div').empty();
            $('#sub_bid_div').load("{{url('load-bid-documents')}}?bid_submission_id="+id);
        });
    }





  CKEDITOR.replace( 'company_info' , 
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
</script>
    

<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>




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