@extends('layouts.vendorapp')

@section('content')


    

<!-- INCLUDING styles-->
@include('bids.css.styles')

    
<div class="row">     
                
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
           {{--  <h4> Reset Password </h4> --}}

                <form id="resetForm" action="{{ route('reset-vendor-password') }}" method="POST">
                    @csrf
                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Reset Password </legend>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label"> Email </label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" name="id" id="id" value="{{$vendor->id}}">
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" value="{{$vendor->email}}" readonly="" required="">
                        </div>
                    </div>   

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label"> Password </label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required>
                        </div>
                    </div> 

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-outline-success btn-glow btn-sm pull-right" onclick="return confirm('Are you sure you want to reset password?')"> Update</button>
                        </div>                                         
                    </div>

                </fieldset>
            </form>

          </div>
        </div>
      </div>
    </div>

</div>






<!-- INCLUDING Modals-->



   
   

   
   
@endsection

@section('scripts')


    

<!-- INCLUDING scripts-->

<script>
    $(function()
    {
         $("#resetForm").on('submit', function(e)
        { 
            e.preventDefault();
            var id = $('#id').val();
            var email = $('#email').val();
            var password = $('#password').val();
            formData = 
            {
                id:id,
                email:email,
                password:password,
                _token:'{{csrf_token()}}'
            }
            $.post('{{route('reset-vendor-password')}}', formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('vendor.login') }}"); }, 3000);                    
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });
    });
</script>

  
@endsection
