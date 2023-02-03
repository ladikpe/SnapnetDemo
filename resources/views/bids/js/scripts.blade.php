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
    
    </script>

    <script> 
        function resolveBidId(id)
        {
          $('#bidId').val(id); 
        }
        
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