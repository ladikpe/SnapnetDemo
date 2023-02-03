@extends('layouts.app')

@section('content')


    <div class="row">     
                    
        <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <h4>Bid Invitation
                    <a href="#" id="convertBtn" onclick="return false"  class="btn btn-outline-info btn-glow btn-sm pull-right" 
                       title="Download Bid Invitation" style="margin-top: -10px" id="add"><i class="la la-download"></i>  </a>
                </h4>

                    <div class=""> 
                        {!! $invitation->message !!}
                    </div>              

              </div>
            </div>
          </div>
        </div>

        <textarea rows="10" class="form-control" name="invitation_doc" id="invitation_doc" style="display: none">{{ $invitation->message }}</textarea>

    </div>





   
   
@endsection

@section('scripts')



  <script src="{{ asset('assets/convert-to-doc/FileSaver.js') }}"></script>
  <script src="{{ asset('assets/convert-to-doc/html-docx.js') }}"></script>
  
<script>
    document.getElementById('convertBtn').addEventListener('click', function(e)
    { 
        e.preventDefault();

        // for demo purposes only we are using below workaround with getDoc() and manual
        // HTML string preparation instead of simple calling the .getContent(). Becasue
        // .getContent() returns HTML string of the original document and not a modified
        // one whereas getDoc() returns realtime document - exactly what we need.
        var contentDocument = document.querySelector('#invitation_doc');
        var content = '<!DOCTYPE html>' + contentDocument.value;
        var orientation = 'portrait';
        var converted = htmlDocx.asBlob(content, {orientation: orientation});

        saveAs(converted, 'Bid Invitation.docx');
    });

</script>
   
@endsection