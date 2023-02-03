{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

<style>
    /*.thumb-card
        {
            border: thin solid #eee;
            border-radius: 4px;
        }*/
    body {
        background: #e2e1e0;
        text-align: center;
    }

    .card-body {
        background: #fff;
        border-radius: 2px;
        /*display: inline-block;*/
        margin: 1rem;
        position: relative;
    }

    .thumb-card {
        min-height: 250px !important;
        max-height: 250px !important;
        border-radius: 5px;
        padding: 10px 12px;
        font-weight: bold !important;

        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    }

    .thumb-card:hover {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);

        min-height: 250px;
        max-height: 250px;
        border-radius: 5px;
        padding: 10px 12px;
        cursor: pointer;
    }


    .head {
        text-align: center;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .category {
        text-align: center;
        font-size: 14px;
        margin-bottom: 25px;
        color: #0047AB;
    }

    .document-body {
        text-align: center;
        margin-bottom: 25px;
        min-height: 100px;
        max-height: 100px;
        overflow: hidden;
    }

    .action {
        text-align: center;
    }
</style>

@endsection
@section('content')



<div class="row">
    <div class="col-md-12">
        <div class="card-body row" style="">
            <div class="col-md-6 pull-left mb-1">
                <h3 class="card-title" id="basic-layout-form">
                    <div class="row" style="padding-left: 15px">
                        <div class="col-md-12" style="text-align: left; color: #666; padding: 0px">
                            Create Document from Existing Templates
                            <div class="badge badge-success round text-white" style="font-size: 15px">
                                {{$document_count->count()}} </div>
                        </div>
                    </div>
                </h3>
            </div>
            <div class="col-md-6 pull-right mb-1" style=" padding: 0px">
                <form action="{{ route('new-document', request()->route()->parameters['id']) }}" method="get">
                    <fieldset style="width: 40%; float: right; margin-top: -10px;">
                        <div class="input-group" style="padding-right: 45px">
                            <input type="text" class="form-control form-sm" id="search" name="search"
                                placeholder="Search Templates ... ">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-sm" type="submit"><i
                                        class="la la-search"></i></button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="row col-md-12" style="">
                <div class="col-xl-2 col-md-6 col-sm-6 col-xs-12 mb-5" style="">
                    <div class="col-md-12 thumb-card" style="">
                        <div class="category"> {{$default_document->name}} </div>
                        <div class="document-body" style="font-size: 25px; color: #999">
                            {{substr($text, 0, 100)}}
                        </div>

                        <div class="action" style="text-align: center;">
                            <a href="{{ route('create-document', [$param, 'temp']) }}"
                                class="btn btn-outline-success btn-glow btn-sm"
                                style="padding :0.3rem 0.4rem !important; margin-right: 4px"><i class="la la-plus"
                                    aria-hidden="true" style=""> Use</i>
                            </a>

                            <a href="{{ route('google-react', [$param, 'temp']) }}"
                                class="btn btn-outline-warning btn-glow btn-sm"
                                style="padding :0.3rem 0.4rem !important; margin-left: 4px"><i class="la la-file"
                                    aria-hidden="true" style=""> Use Doc</i>
                            </a>
                        </div>
                    </div>
                </div>
                @forelse($new_documents as $new_document)
                <div class="col-xl-2 col-md-6 col-sm-6 col-xs-12 mb-5" style="">
                    <div class="col-md-12 thumb-card" style="">
                        <div class="category"> {{$new_document->name}} </div>
                        {{-- <div class="category">
                            {{ $new_document->document_type?$new_document->document_type->name:'' }}
                        </div> --}}
                        <div class="document-body">
                            {!! $new_document->content?$new_document->content:'' !!}
                        </div>

                        <div class="action" style="text-align: center;">
                            {{-- <a href="{{ route('create-document', request()->route()->parameters['id']) }}"
                                class="btn btn-outline-success btn-glow btn-sm"
                                style="padding :0.3rem 0.4rem !important; margin-right: 4px"><i class="la la-plus"
                                    aria-hidden="true" style=""> Use</i>
                            </a> --}}
                            <a href="{{ route('create-document', [$param, $new_document->id]) }}"
                                class="btn btn-outline-success btn-glow btn-sm"
                                style="padding :0.3rem 0.4rem !important; margin-right: 4px"><i class="la la-plus"
                                    aria-hidden="true" style=""> Use</i>
                            </a>

                            <a href="{{ route('google-react', $new_document->id) }}"
                                class="btn btn-outline-warning btn-glow btn-sm"
                                style="padding :0.3rem 0.4rem !important; margin-left: 4px" target="_blank"><i
                                    class="la la-file" aria-hidden="true" style=""> Use Doc</i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12" style="text-align: center !important; color: #666 !important">
                    No Template Created Yet !

                    {{-- <a href="{{ route('create-document', request()->route()->parameters['id']) }}"
                        class="btn btn-outline-success btn-glow btn-sm ml-1"
                        style="padding :0.3rem 0.4rem !important; margin-right: 4px"><i class="la la-plus"
                            aria-hidden="true" style=""> Create One Now</i>
                    </a> --}}
                </div>
                @endforelse

            </div>
            {!! $new_documents->render() !!}

        </div>
    </div>


</div>









{{-- Add MODAL --}}














@endsection

@section('scripts')

<script>
    $(function()
        {      
            
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