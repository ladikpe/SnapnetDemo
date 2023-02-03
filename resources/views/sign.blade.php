@extends('layouts.app')
@section('stylesheets')

<style>
  
</style>

@endsection
@section('content')

<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Sign</div>
                            </div>
                        </h3>

                        
                        <div class="row">
                          <div class="col-md-6">
                              <form id="signForm" action="{{route('save-signature')}}" enctype="multipart/form-data" method="POST">  @csrf
                                  <input name="signature" id="signature" type="hidden">
                                  <div id="signArea" >
                                      <h2 class="tag-ingo" style="font-size: 14px">Left click and hold to draw signature below,</h2>
                                      <div class="sig sigWrapper" id="holder" style="height:auto;">
                                          <div class="typed"></div>
                                          <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                                      </div>
                                  </div>


                                  <button type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right mt-2 ml-1" id="btnSaveSign">Save Signature</button>
                                  <button type="button" class="btn btn-outline-warning btn-glow pull-right btn-sm pull-right mt-2" id="btnCleared" >Clear</button>

                                  <div class="sign-container">

                                  </div>

                                  <div class="col-md-6">
                                      <div class="sign-container" style="text-align: center">
                                         <label for="name" class="col-form-label"> Current Signature </label>
                                         @if($signature) {!! $signature->signature !!} @else Null @endif
                                      </div>
                                  </div>
                              </form>

                              <form id="uploadForm" action="{{route('upload-signature')}}" enctype="multipart/form-data" method="POST">  @csrf
                                  <div class="for-group">                                    
                                    <label for="file" class="col-form-label"> Upload File </label>
                                    <input type="file" class="form-control" name="file" id="file" required>
                                  </div>

                                  <div class="for-group">                                    
                                    <button type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right mt-2 ml-1" id="btnUpload">Upload Signature</button>
                                  </div>
                              </form>
                          </div>

                          <div class="col-md-6">
                              <div class="sign-container" style="text-align: center">
                                 <label for="name" class="col-form-label"> Current Signature </label> <br>
                                 <img src="{{URL::asset($signature->signature_path.'/'.$signature->signature)}}" style="max-width: 100px; max-height: 35px">
                              </div>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


  
@endsection
@section('scripts')

  <script>
    $(function(e)
    {
      $(function()
      {
        $('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
      });

     $("#btnSaveSign").click(function(e)
     {
        e.preventDefault();
        html2canvas([document.getElementById('sign-pad')],
        {
          onrendered: function (canvas)
          {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            //ajax call to save image inside folder
            $.ajax({
              url: '{{route('save-signature')}}',
              data: { img_data:img_data, _token:'{{csrf_token()}}' },
              type: 'post',
              dataType: 'json',
              success: function (response)
              {
                  toastr.success('Signature Saved', {timeOut:10000});
                  setInterval(function(){ window.location.replace("{{ route('sign') }}"); }, 3000);
              }
            });
          }
        });
      });
  // */

      //clear signature
      $("#btnCleared").click(function(e)
      {
         $('#signArea').signaturePad().clearCanvas();
      });

    });
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
  


 