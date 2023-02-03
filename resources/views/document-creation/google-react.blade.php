@extends('layouts.app')
@section('stylesheets')
{{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" /> --}}

<style type="text/css">
  body {
    margin: 0;
    font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.45;
    color: #6B6F82;
    text-align: left;
    background-color: #F9FAFD;
  }

  .table thead th {
    border-bottom: none !important;
  }
</style>

@endsection
@section('content')

<script>
  var updateDocId = '{{ route('update-documentid') }}';
  var _token = '{{ csrf_token() }}';
</script>


<div class="" id="app">   

</div>







<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>


@endsection
@section('scripts')





@endsection