<script> 
        function pullBidId(id)
        {  
            $.get('{{url('getBidDetails')}}?id=' +id, function(data)
            { 
                $('#id').val(id); 
                $('#label_code').html(' : ' + data.bid_code);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#instruction').val(data.instruction);
                if (data.bid_type == 0) {   $('#shortlisted_type').prop("checked", true);   }
                else if (data.bid_type == 1) {   $('#open_type').prop("checked", true);  }
                $('#bid_type').val(data.bid_type);
                $('#start_date').val(data.start_date);
                $("#end_date").prop('value', data.end_date);
                $('#industry_id').val(data.industry_id);
                $('#countdown').val(data.countdown);
                if (data.submission_after == 0) {   $('#no').prop("checked", true);   }
                else if (data.submission_after == 1) {   $('#yes').prop("checked", true);  }
                $('#title').html('Edit Bid');
                $('#create').html('Update');  
            });    
        }

        $('.addNew').click(function(e)
        {
            $('#id').val(''); 
            $('#label_code').html(' ');
            $('#name').val('');
            $('#description').val('');
            $('#instruction').val('');
            $('#bid_type').checked = false;
            $('#start_date').val('');
            $("#end_date").prop('value', '');
            $('#industry_id').val('');
            $('#countdown').val('');
            $('#submission_after').checked = false;
            $('#title').html('Add Bid');
            $('#create').html('Add');  
        });

        function setSubmittedDetail(bid_id)
        {  
            $.get('{{url('getSubmittedBidDetail')}}?bid_id=' +bid_id, function(data)
            {  
                $('#idd').val(data.submitted.id); 
                $('#bd_id').val(data.submitted.bid_id); 
                $('#note').val(data.submitted.note);  
            }); 

            $('#attachment_table').empty();
            $.get('{{url('getSubmittedBidAttachments')}}?bid_id=' +bid_id, function(Data)
            {     var i = 1; 
                $.each(Data, function(index, dataObj)
                {                
                   $('#attachment_table').append('<tr>  <td>'+i+'</td>  <td>'+dataObj.bid.name+'</td>   <td>'+dataObj.file_name+'</td>  <td>'+dataObj.created_at+'</td>   <td>  <a onclick="removeAttachment('+dataObj.id+')" class="btn-sm text-danger pull-right" data-toggle="modal" data-target="#deleteModal" title="Delete Document" id=""><i class="la la-close" aria-hidden="true" style="font-size:13px"></i></a>  </td>  </tr>'); i++;
                });


                // $('#idd').val(data.submitted.id); 
                // $('#bd_id').val(data.submitted.bid_id); 
                // $('#note').val(data.submitted.note);  
            });  
   
        }

    
    </script>

    <script> 
        function resolveBidId(id)
        {
          $('#bidId').val(id); 
        }


        function removeAttachment(id)
        {
            $(function(e)
            {
                if(confirm('Are you sure you want to remove bid attachment?'))
                { 
                    e.preventDefault();
                    formData = 
                    {
                        id:id,
                        _token:'{{csrf_token()}}'
                    }
                    $.post('{{route('remove-submitted-bid-attachment')}}', formData, function(data, status, xhr)
                    {
                        return toastr.success(data.info);
                    });
                }
            });
            
        }
        
    </script>


    

    @if(Session::has('ok'))
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
        $.post('{{route('delete-vendor-doc')}}', formData, function(data, status, xhr)
        {
            return toastr.success(data.info);
            $('#document_id').val(0);
            $('#v_id').val(0) 

            $('#docu_table').remove();
            $('#document-div').load("{{url('load-vendor-doc-table')}}?vendor_id="+vendor_id);
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

        fetch('{{route('upload-document-vendor')}}', {
            method:'POST',
            body:formData
        }).then((data)=>{

            // var details = data.details;
            toastr.success('Vendor document uploaded successfully', {timeOut:10000});

            $('#name').val('');
            // $('#type_id').val();
            $('#expiry_date').val('');

            // $('#docu_table').remove();
            $('#document-div').load("{{url('load-vendor-doc-table')}}?vendor_id="+vendor_id);
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
    });


    //DATATABLE
    $(function (){     $('#docu_table').DataTable();    $('#submitted_table').DataTable();      });





    //displaying bid documents
    function displayBidDocuments(id)
    {  
        $.get('{{url('/get-submitted-bid-documents')}}?bid_submission_id='+id, function(data)
        {   console.log(data);
            $('#sub_bid_div').empty();
            $.each(data, function(index, file)
            {
              $('#sub_bid_div').append('<div class="col-xl-6 col-md-6 col-sm-12" style="overflow: hidden;">  <div class="card" style="height: 150px;">   <div class="card-content">  <div class="card-body">  <h4 class="card-title">'+ file.file_name +'</h4>  <a href="'+  file.file_path+'\\'+file.file_name +'" download="'+  file.file_path+'\\'+file.file_name +'" class="btn btn-teal btn-sm pull-right"> <i class="la la-download"></i> </a> </div>  </div> </div> </div>');
            });

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