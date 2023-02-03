


    <script> 
        function pullEmailListId(id)
        {  
            $.get('{{url('get-email-list-by-id')}}?id=' +id, function(data)
            { 
                $('#b_id').val(id); 
                $('#bid_id').val(data.bid_id);
                $('#user_id').prop('value', data.user_id);
                $('#title').html('Edit Bid Email Distribution List');
                $('#create').html('Update');  
            });    
        }

        function setDeleteId(id)
        {  
            $.get('{{url('get-email-list-by-id')}}?id=' +id, function(data)
            { 
                $('#delete_id').val(id);   
            });    
        }
    </script>

    <script>  

        // Add / Update
        $("#bidEmailListForm").on('submit', function(e)
        { 
            e.preventDefault();

            var id = $('#b_id').val();
            var bid_id = $('#bid_id').val();
            var user_id = $('#user_id').val();

            formData = 
            {
                id:id,
                bid_id:bid_id,
                user_id:user_id,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('add-bid-email-list')}}', formData, function(data, status, xhr)
            {
                $('#b_id').val('');
                $('#bid_id').val('');
                $('#user_id').val(0) 

                $('#email-div').load("{{url('load-email-list-table')}}?bid_id="+bid_id);
                return toastr.success(data.info);
            });
        });

        // Delete
        $("#deleteForm").on('submit', function(e)
        { 
            e.preventDefault();

            var id = $('#delete_id').val();
            var bid_id = $('#bids_id').val();

            formData = 
            {
                id:id,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('delete-email-list')}}', formData, function(data, status, xhr)
            {
                $('#delete_id').val('');

                $('#email-div').load("{{url('load-email-list-table')}}?bid_id="+bid_id);
                return toastr.success(data.info);
            });
        });


        $(function()
        {
            $('#no_btn').click(function(){  $('.modal').modal('hide');  });
            $('#ok_btn').click(function(){  $('.modal').modal('hide');  });

            $('#email_table').DataTable( {  responsive: true } );
            $('#sub_bid_table').DataTable( {  responsive: true } );
        });




        // Add / Update Bid Message
        $("#bidPackageForm").on('submit', function(e)
        { 
            e.preventDefault();

            var id = $('#eb_id').val();
            var bid_id = $('#email_bid_id').val();
            var message = CKEDITOR.instances['message'].getData();

            formData = 
            {
                id:id,
                bid_id:bid_id,
                message:message,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('bid-message')}}', formData, function(data, status, xhr)
            {
                $('#eb_id').val('');
                // $('#email_bid_id').val('');
                $('#message').val('');

                if(data.status == 'ok'){ return toastr.success(data.info); }
                // else if(data.status == 'error'){ return toastr.error(data.info); }                
            });
        });





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