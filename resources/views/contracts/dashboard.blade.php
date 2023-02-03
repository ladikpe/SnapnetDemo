@extends('layouts.app')
@section('stylesheets')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />
@endsection
@section('content')
  
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">


    
                <div class="page-content container-fluid">
                    <iframe width="100%" height="800" src="https://app.powerbi.com/view?r=eyJrIjoiYzQ3MmM4ZmMtOWVmYi00MDQwLTlmYTctMjk3NjIwOWRjMzRiIiwidCI6ImJhMTMwZWNhLTMwMzAtNDhlMS05MDg5LWM5NzkyOTNhZWI3MCIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                </div>
     
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

     
   
   
@endsection
@section('scripts')
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script type="text/javascript">
$('#folder')
  .jstree({
    'core' : {
      'data' : {
        'url' : '{{url('folders/get_node')}}',
        'data' : function (node) {
          return { 'id' : node.id };
        }
      },
      'check_callback' : true,
      'themes' : {
        'responsive' : false
      }
    }
  });
</script>

@endsection
