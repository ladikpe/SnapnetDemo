<table class="table table-sm mb-0" id="">
    <thead class="thead-light">
      <tr>
        <th>#</th>
        <th>Vendor Name</th>
        <th>Category</th>
        <th>Proximity</th>
        <th>Rating</th>
        <th>Bid Invites</th>
        <th>Bid Submitted</th>
        <th>Bid Awarded</th>
        <th style="text-align:right"> <span> * <input type="checkbox" class="form-control" name="" id="check_all"> </span> </th>
      </tr>
    </thead>
    <tbody>    @php $i = 1; @endphp     
        @forelse ($shortlist_vendors as $shortlist_vendor)                
            <tr id="sv_{{$shortlist_vendor->vendor_id}}">
                <td>{{ $i }}</td>
                <td>{{ $shortlist_vendor->vendor?$shortlist_vendor->vendor->name:'' }}</td>
                <td>{{ $shortlist_vendor->category }}</td>
                <td>{{ $shortlist_vendor->proximity }}</td>
                <td>{{ $shortlist_vendor->rating }}</td>
                <td>{{ $controllerName->getVendorBidInvites($bid_id, $shortlist_vendor->vendor_id) }}</td>
                <td>{{ $controllerName->getVendorBidSubmits($bid_id, $shortlist_vendor->vendor_id) }}</td>
                <td><input type="hidden" class="form-control" name="v_number[]" id="{{$i}}_{{$shortlist_vendor->vendor_id}}" value="{{$shortlist_vendor->vendor_id}}"></td>
                <td style="text-align:right">
                    <input del_vendor bid_id="{{$bid_id}}" vendor_id="{{$shortlist_vendor->vendor_id}}" type="checkbox" class="form-control del_vendor" name="" id="chk_{{$shortlist_vendor->vendor_id}}" onclick="removeVendor">
                </td>
            </tr>    @php $i++; @endphp  
        @empty
            No Bidders Yet ! 
        @endforelse
    <input type="hidden" class="form-control" name="bid_id" id="bid_id" value="{{$bid_id}}">
    </tbody>
  </table>



    <script>
        
        

        function removeVendor(e)
        {
            var bid_id = e.target.getAttribute('bid_id'), 
            vendor_id = e.target.getAttribute('vendor_id');

            console.log(e,'test',bid_id,vendor_id);

            $(function()
            {
                if(confirm('Are you sure you want to remove this vendor?'))
                {                        
                    e.preventDefault(); 

                    formData = {   bid_id:bid_id,   vendor_id:vendor_id,  _token:'{{csrf_token()}}'  }
                    $.post('{{route('remove-one-vendor')}}', formData, function(data, status, xhr)
                    {
                        $('#sv_'+vendor_id).remove();
                        if(data.status == 'ok'){ return toastr.success(data.info); }else{ return toastr.error(data.error); }
                    });
                    getShortlisted(bid_id); 
                    $('#bid-table-div').load("{{url('load-bidders-table')}}?bid_id="+bid_id);
                }
                else{ $(this).prop('checked', false); }
            });            
        }
    </script>