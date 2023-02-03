@extends('layouts.app')

@section('content')



    
<div class="row">     
                
    <div class="col-md-8">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <h4>List Vendors</h4>

              <table class="table table-sm mb-0" id="">
                <thead class="thead-dark">
                  <tr>
                    <th>Vendor Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Category</th>
                    <th style="text-align:right">Action </th>
                  </tr>
                </thead>
                <tbody>        
                    @forelse ($vendors as $vendor)                
                        <tr>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone }}</td> 
                            <td>{{ $vendor->category }}</td>
                            <td>
                              <a class="btn-sm text-info pull-right edit" data-toggle="tooltip" title="Edit Vendor" id="{{$vendor->id}}"><i class="la la-pencil" aria-hidden="true" style="font-size:13px"></i></a> 
                            </td>
                        </tr>
                    @empty
                        No Data Found 
                    @endforelse
                </tbody>
              </table>
              {!! $vendors->appends(Request::capture()->except('page'))->render() !!}

          </div>
        </div>
      </div>
    </div>
                
    <div class="col-md-4">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <h4 id="title">New Vendor</h4>

              <form class="" action="{{url('performance')}}" method="post">
                {{ csrf_field() }}                

                <div class="form-group">
                  <label for="name">Vendor Name</label>
                  <input type="hidden" class="form-control" name="id" id="id">  
                  <input type="text" class="form-control" name="name" id="name" required>        
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" required>      
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" name="phone" id="phone">  
                  <input type="hidden" class="form-control" name="type" id="" value="add_vendor">     
                </div>

                  <div class="form-group">
                      <label for="category">Category</label>
                      <select class="form-control" name="category" id="category">
                          <option value=""></option>
                          <option value="Goods">Goods</option>
                          <option value="Services">Services</option>
                          <option value="Others">Others</option>
                      </select>
                  </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-dark btn-sm pull-right" id="create" value="">Create</button>        
                </div>

              </form>

          </div>
        </div>
      </div>
    </div>

</div>






<!-- DISABLE -->
<form class="" action="{{url('performance')}}" method="post">
  {{ csrf_field() }}
  <div id="disable" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header app_bg">
              <h4 class="modal-title">Disable This Metric</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>              
            </div>
                         
                  <input type="text" class="form-control" name="id" id="idd"> 
            <input type="hidden" class="form-control" name="type" id="" value="disable_metric">
            


         
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" name="" id="" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to DISABLE Details?')"> 
            <i class="fa fa-ban"></i> Disable </button>
          </div>
      </div>
      </div>  
  </div>
</form>

<!-- ENABLE -->
<form class="" action="{{url('performance')}}" method="post">
  {{ csrf_field() }}
  <div id="enable" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header app_bg">
              <h4 class="modal-title">Reactivate This Metric</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
                         
                  <input type="text" class="form-control" name="id" id="re_id"> 
            <input type="hidden" class="form-control" name="type" id="" value="enable_metric">
            


         
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" name="" id="" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to Reactivate Metric?')"> 
            <i class="fa fa-ban"></i> Reactivate </button>
          </div>
      </div>
      </div>  
  </div>
</form>

   
   
@endsection

@section('scripts')


<script>  
    //AJAX SCRIPT TO GET DETAILS FOR       
    $(function()
    {
      $('.edit').click(function(e)
      {
        var id = this.id;  
        $.get('{{url('getVendorDetials')}}?id=' +id, function(data)
        { 
            $('#id').val(id); 
            $('#name').val(data.name); 
            $('#email').val(data.email);  
            $('#phone').val(data.phone);
            $("#category").prop('value', data.category);
            $('#title').html('Edit Vendor');
            $('#create').html('Update');  
        });       
      });
    });
    

    function setId(id)
    {
      $('#re_id').val(id); 
    }

    function putId(id)
    {
      $('#idd').val(id); 
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

   
@endsection
