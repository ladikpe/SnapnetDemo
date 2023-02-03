<html>
 <head>

 </head>
 <body>
   <h1>Test View</h1>
  <div id="status"></div>
  <button type="button" name="button" id="click" onclick="stats();">CLick Me</button>
 </body>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
 <script type="text/javascript">

   function stats(){
     $(document).ready(function() {
       var rt=1;
     $.get( "{{route('viewer')}}", function() {
   // alert( "success" );
   })
   .done(function(data) {
     console.log(data);

     $('#status').html(data);
   })
   .fail(function() {
     // alert( "error" );
   })
   .always(function() {
     // alert( "finished" );
   });
    });
   }


 </script>
</html>
