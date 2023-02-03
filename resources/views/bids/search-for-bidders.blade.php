@extends('layouts.app')

@section('content')


    

    
<div class="row"> 
    <div class="col-md-12">
      <div class="card no-pad">
        <div class="card-content">
          <div class="card-body">
            
            <form action="{{ route('list-search-bidders') }}" method="GET">
                <input type="hidden" class="form-control" name="b_id" id="b_id" value="{{$bid_id}}">
                <div class="form-group row no-pad" style="">

                    <button type="submit" class="btn btn-outline-success btn-glow btn-sm" style="position: fixed; z-index: 1000; right: 45px">
                        <i class="la la-search"></i>
                    </button>

                    <div class="col-md-3 row">
                        <label for="category" class="col-md-4 col-form-label"> <span class="req">*</span> Category </label>
                        <div class="col-md-8">
                            <select class="form-control input-sm" name="category" id="category">
                                {{-- @if($category)<option value="{{$category}}">{{$category}}</option>@endif                            --}}
                                <option value=""></option>                            
                                <option value="Goods">Goods</option>                            
                                <option value="Services">Services</option>                            
                                <option value="Others">Others</option>                            
                            </select>
                        </div>
                    </div>                     

                    <div class="col-md-3 row pull-right">
                        <label for="state_id" class="col-md-4 col-form-label"> <span class="req">*</span> State </label>
                        <div class="col-md-8">
                            <select class="form-control input-sm" name="state_id" id="state_id">
                                {{-- @if($state_id)<option value="{{$state_id}}">{{$state_name}}</option>@endif --}}
                                <option value=""></option>  
                                @forelse($states as $state)                          
                                    <option value="{{$state->id}}">{{$state->state_name}}</option>     
                                @empty
                                @endforelse                           
                            </select>
                        </div>
                    </div>                       

                    <div class="col-md-3 row pull-right">
                        <label for="address" class="col-md-4 col-form-label"> Proximity </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" placeholder="Address" name="address" id="address" 
                            >
                        </div>
                    </div>

                    <div class="col-md-3 row">
                        <label for="industry_id" class="col-md-4 col-form-label"> Industry </label>
                        <div class="col-md-8">
                            <select class="form-control input-sm" name="industry_id" id="industry_id">
                                {{-- @if($industry_id)<option value="{{$industry_id}}">{{$name}}</option>@endif --}}
                                <option value=""></option>  
                                @forelse($industries as $industry)                          
                                    <option value="{{$industry->id}}">{{$industry->name}}</option>     
                                @empty
                                @endforelse                       
                            </select>
                        </div>
                    </div>                       

                    {{-- <div class="col-md-3 row pull-right" style="">
                        <label for="name" class="col-md-4 col-form-label"> Vendor Name </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" name="name" id="name">                        
                        </div>
                    </div>  --}}                                            
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>




    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <button type="button" id="msg1" class="btn btn-success pulse msg" data-toggle="modal" data-target="#shortlistedVendorModal" 
                style="color: #fff; font-size: 13px" onclick="reloadShortlistedVendorsTable({{$bid_id}})">  </button>

            <button type="button" id="" class="btn btn-dark pulse pull-right" data-toggle="modal" data-target="#inviteVendorModal" 
                style="color: #fff; font-size: 13px"> Invite Bidders </button>

            <form id="allBidVendorForms" action="" method="POST"> @csrf
            <div id="email-div">
              <table class="table table-sm mb-0" id="sb_table">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    {{-- <th>Id</th> --}}
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
                    @forelse ($bid_vendors as $bid_vendor)                
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- <td>{{ $bid_vendor->id }}</td> --}}
                            <td>{{ $bid_vendor->name }}</td>
                            <td>{{ $bid_vendor->category }}</td>
                            <td>{{ $bid_vendor->address }}</td>
                            <td>{{ $bid_vendor->rating }}</td>
                            <td>{{ $controllerName->getVendorBidInvites($bid_id, $bid_vendor->id) }}</td>
                            <td>{{ $controllerName->getVendorBidSubmits($bid_id, $bid_vendor->id) }}</td>
                            <td>{{ $bid_vendor->bid_submited }}</td>
                            <td style="text-align:right">
                                <input type="checkbox" class="form-control chk_vendor" name="" id="chk_{{$bid_vendor->id}}">
                            </td>
                        </tr>    
                            <input type="hidden" class="form-control" name="v_number[]" id="{{$i}}_{{$bid_vendor->id}}" 
                            value="{{$bid_vendor->id}}">
                            @php $i++; @endphp  
                    @empty
                        No Bidders Yet ! 
                    @endforelse
                        <input type="hidden" class="form-control" name="bid_id" id="bid_id" value="{{$bid_id}}">
                </tbody>
              </table>
              {{-- {!! $bid_vendors->render() !!} --}}
            </div>

          </div>
        </div>
      </div>
    </div>
</div>







    <form id="shortlistedVendorForm" action="" enctype="multipart/form-data" method="POST">  @csrf
        <!-- Modal -->
        <div class="modal fade text-left" id="shortlistedVendorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel69" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 65% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Shortlisted Bidders 
                            {{-- <p id="msg2" class="badge badge-success msg" style="color: #fff; font-size: 13px">  </p> --}}

                        <span id="label_code" style="color: #fff; font-size: 15px"></span> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ffffff">X</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="bid-table-div">
                                
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 col-xs-12 pull-left no-pad" style="padding-left: 15px !important; position: fixed; z-index: 1000; right: 50px;">

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






    <!-- Confirm  modal -->
    <form class="form-horizontal" id="deleteForm" method="POST" action="{{ route('delete-email-list') }}">
      @csrf
        <div id="deleteEmailModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>


                    {{-- <input type="hidden" name="id" id="delete_id"> --}}
                    {{-- <input type="hidden" name="bid_id" id="bids_id" value=""> --}}

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Do you want to delete details ? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_btn" id="no_btn" class="btn btn-outline-warning btn-glow mr-1"> No </button>

                            <button type="submit" name="yes_btn" id="yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#yesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Success  modal -->
    <div id="yesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Details Removed </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Confirm  modal -->
    <form class="form-horizontal" id="inviteVemdorForm" method="POST" action="{{ route('invite-vendors-to-bid') }}">
      @csrf
        <div id="inviteVendorModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>

                    <input type="hidden" name="bid_id" id="inv_bid_id" value="{{$bid_id}}">

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Do you want to send an invitation to bid email ? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_inv_btn" id="no_inv_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal"> No </button>

                            <button type="submit" name="yes_inv_btn" id="yes_inv_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#invYesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Success  modal -->
    <div id="invYesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Invite email sent </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_inv_btn" id="ok_inv_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    





   
   

   
   
@endsection

@section('scripts')


    <script> 
        
        //CHECK ALL CHECKBOXES
        $(function()
        {
            //all checkboxes are check by default
            $('input:checkbox').prop('checked', this.checked); 

            bid_id = $('#bid_id').val();  
            getShortlisted(bid_id);


            $('#check_all').change(function (e) 
            {    
                if($(this).prop("checked") == true)
                {
                    if(confirm('Are you sure you want to shortlist all vendors?'))
                    {
                        $('input:checkbox').prop('checked', this.checked); 

                        e.preventDefault(); 
                        var form = $('#allBidVendorForms').get(0); // You need to use standard javascript object here
                        var formData = new FormData(form); 

                        fetch('{{route('shortlist-all-vendors')}}',{
                            method:'POST',
                            body:formData
                        }).then(res=>res.json()).then(data=>{
                            return toastr.success(data.info);     
                        });

                        bid_id = $('#bid_id').val();  
                        getShortlisted(bid_id);
                    }
                    else{ $("#check_all").prop('checked', false); }
                }
                else if($(this).prop("checked") == false)
                {
                    if(confirm('Are you sure you want to deselect/shortlist all vendors?'))
                    {
                        $('input:checkbox').prop('checked', this.checked); 
                        //
                        e.preventDefault(); 
                        var form = $('#allBidVendorForms').get(0); // You need to use standard javascript object here
                        var formData = new FormData(form); 

                        fetch('{{route('remove-all-vendors')}}',{
                            method:'POST',
                            body:formData
                        }).then(res=>res.json()).then(data=>{
                             return toastr.success(data.info);     
                        });

                        var bid_id = $('#bid_id').val();  
                        getShortlisted(bid_id);
                    }
                    else{ $("#check_all").prop('checked', true); }
                } 
            });




            $('.chk_vendor').change(function (e)
            {  
                if(confirm('Are you sure you want to shortlist this vendor?'))
                {
                    v_id = $(this).attr('id');     bid_id = $('#bid_id').val();    vendor_id = v_id.substring(4); 

                    if($(this).prop("checked") == true)
                    {
                        $(this).prop('checked', this.checked); 

                        e.preventDefault(); 

                        var formData_ = new FormData($('#allBidVendorForms').get(0));
                        
                        fetch('{{route('shortlist-one-vendor')}}',{
                            method:'POST',
                            body:formData_
                        }).then(res=>res.json()).then(data=>{

                            if(data.status == 'ok'){ return toastr.success(data.info); }else{ return toastr.error(data.error); }


                        });

                         return;   


                        formData = {   bid_id:bid_id,   vendor_id:vendor_id,  _token:'{{csrf_token()}}'  }
                        $.post('{{route('shortlist-one-vendor')}}', formData, function(data, status, xhr)
                        {
                            if(data.status == 'ok'){ return toastr.success(data.info); }else{ return toastr.error(data.error); }
                        });
                        getShortlisted(bid_id);
                    }
                    else if($(this).prop("checked") == false)
                    {
                        $(this).prop('checked', this.checked); 

                        e.preventDefault(); 

                        formData = {   bid_id:bid_id,   vendor_id:vendor_id,  _token:'{{csrf_token()}}'  }
                        $.post('{{route('remove-one-vendor')}}', formData, function(data, status, xhr)
                        {
                            if(data.status == 'ok'){ return toastr.success(data.info); }else{ return toastr.error(data.error); }
                        });
                        getShortlisted(bid_id);
                    }
                }
                else{ $(this).prop('checked', false); }
            });



            function removeVendor(e)
            {
                var bid_id = e.target.getAttribute('bid_id'), 
                vendor_id = e.target.getAttribute('vendor_id');

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

             $(document).on('click',function(e)
             {               
                 if (e.target.getAttribute('del_vendor') !== null){   removeVendor(e);    }
             });  


            //save searched vendor for bid
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




            //save searched vendor for bid
            $("#inviteVemdorForm").on('submit', function(e)
            { 
                e.preventDefault();

                bid_id = $('#inv_bid_id').val();

                formData = 
                {
                    bid_id:bid_id,
                    _token:'{{csrf_token()}}'
                }
                $.post('{{route('invite-vendors-to-bid')}}', formData, function(data, status, xhr)
                {
                    return toastr.success(data.info); 
                    // if(data.state == 'ok'){ return toastr.success(data.info); }else{ return toastr.error(data.info); }
                    
                });
            });


        });


        function getShortlisted(bid_id)
        {
            $.get('{{url('getShortlistedVendors')}}?bid_id=' +bid_id, function(data)
            {
                //Set values
                document.getElementById('msg1').innerHTML = data +' Vendor(s) already shortlisted';
                // document.getElementById('msg2').innerHTML = data +' Vendor(s) already shortlisted';
            });           
        }

        function reloadShortlistedVendorsTable(bid_id)
        {   
            $(function()
            {   
                $('#bid-table-div').load("{{url('load-bidders-table')}}?bid_id="+bid_id);
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

        $(function()
        {
            $('#no_btn').click(function(){  $('.modal').modal('hide');  });
            $('#ok_btn').click(function(){  $('.modal').modal('hide');  });
            $('#ok_inv_btn').click(function(){  $('.modal').modal('hide');  });

            // $('#sb_table').DataTable( {  responsive: true } );
            // $('#sbv_table').DataTable( {  responsive: true } );
        });
        
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
