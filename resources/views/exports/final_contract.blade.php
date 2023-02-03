@php
  $pdetails=unserialize($detail->details);
  // $num=count($days);
@endphp
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$contract->name}}</title>
   
    
      <style>
        body 
        {
              background: white;
              display: block;
              margin: 0 auto;
              margin-bottom: 0.5cm;
              margin-top:10px;
              /*box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);*/
              width: 18cm;
              height: 29.7cm; 
              padding: 0px;
              font-family: arial, sans-serif;
            }
           
              table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .small-font{
              font-size: 12px;
            }

             td,  th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

             /*tr:nth-child(even) {
                background-color: #dddddd;
            }*/
            h1,h4 {
                  font-family: arial,sans-serif;
              }
              #header td, #header th {
                border: 0px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            header {
                  position: fixed;
                  top: -40px;
                  float:right;
                  height: 50px;

                
              }
             
              #watermark {
                  position: fixed;

                  /** 
                      Set a position in the page for your image
                      This should center it vertically
                  **/
                 top:10%;
                 width :100%;
                 height :100%;
                  @if($contract->status==1)
                 opacity:0.1;
                 @else
                 opacity:0.1;
                  @endif
                 -ms-transform: rotate(310deg);  /*IE 9 */
                -webkit-transform: rotate(310deg);  /*Safari 3-8 */
                transform: rotate(310deg);
                padding:200px;

                  /** Your watermark should be behind every content**/
                  z-index:  -1000;
              }
          
      </style>
  </head>
  <body>
      <div id="watermark">
        {{-- @if($contract->status==1) --}}
        {{-- <h1 style="font-size: 200px">Final</h1> --}}
        {{-- @else
        <h1 style="color: #960e04;font-size: 200px;">Draft</h1>
        @endif --}}
            {{-- <img src="{{ public_path("logo.png")  }}" /> --}}
      </div>
     <header style="float: right;">
      <img src="{{ public_path("logo.png") }}" style="height: 2rem;background-color:#fff; width: auto;">
    </header>
  <div>
   {!!$detail->cover_page!!}
    {!!$detail->content!!}
    <br>
    <br>
    
     <table> 
      <tr>
        <th>Approved By</th>
         <th>Signature</th>
         <th>Date</th>
      </tr>
      @foreach ($contract->contract_signatures as $signature)
         <tr>
           <td>{{$signature->signable?$signature->signable->name:''}}</td>
           <td><img src="{{ public_path("storage/e-signature/".$signature->signature) }}" width="100px" height="auto"></td>
           {{-- <td><img src="{{ public_path("storage/".$signature->approver->signature) }}" width="100px" height="auto"></td> --}}
           {{-- <td>
            <img src="{{ public_path('/assets/e-signature/doc_signs/'.$signature->approver->signature)}}" width="100px" height="auto"></td> --}}
           <td>{{date('F, j Y', strtotime($signature->updated_at))}}</td>
         </tr>
      @endforeach
     </table>
     
  </div>
  </body>
</html>

