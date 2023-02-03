
@extends('layouts.app')
@section('stylesheets')
<!-- <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" /> -->

<style>
</style>

@endsection
@section('content')





<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-content">
                <div class="card-body">

                    <h3 class="card-title" id="basic-layout-form" style="margin-bottom: 0px !important">
                        <div class="row" style="margin-top: -10px">
                            <div class="col-md-2" style="">
                                Create Document
                            </div>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 rd pull-right">
                                    <i class="la la-file"></i> Tasks 
                                </button>
                            </div>
                        </div>
                    </h3>
                   
                    <div class="" id="">
                        <table class="table table-sm table-striped mb-0 dtable" id="doc_table">
                            <thead class="thead-bg">
                                <tr>
                                    <th style="color: white">#</th>
                                    {{-- <th>Code</th> --}}
                                    <th>Tasks</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{-- {!! $document_creations->render() !!} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>















@endsection

@section('scripts')



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