{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

    <style>
        /*.thumb-card
        {
            border: thin solid #eee;
            border-radius: 4px;
        }*/
        body 
        {
            background: #e2e1e0;
            text-align: center;
        }

        .card-body 
        {
          background: #fff;
          border-radius: 2px;
          /*display: inline-block;*/
          margin: 1rem;
          position: relative;
        }

        .thumb-card 
        {
          min-height: 250px !important;
          max-height: 250px !important;
          border-radius: 5px;
          padding: 10px 12px;
          font-weight: bold !important;

          box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
          transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        }

        .thumb-card:hover 
        {
          box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);

          min-height: 250px;
          max-height: 250px;
          border-radius: 5px;
          padding: 10px 12px;
          cursor: pointer;
        }


        .head
        {
            text-align: center;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .category
        {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;   
            color: #0047AB;
        }

        .document-body
        {
            text-align: center;  
            margin-bottom: 25px;
            min-height: 100px;      
            max-height: 100px; 
            overflow: hidden;
        }

        .action
        {
            text-align: center;        
        }

    </style>
@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card-body row" style=""> 
                    <div class="col-md-12 pull-left mb-1">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="padding-left: 15px">
                                <h3 class="col-md-12" style="text-align: center; color: #666; padding: 0px"> 
                                    Prefered Templates for {{$template->name}} 
                                </h3>                                
                            </div>
                        </h3>
                    </div>

                    <div class="row col-md-12" style="">                            
                        <div class="col-md-4 offset-md-4 col-xs-12 mb-5" style="">
                            <div class="col-md-12 thumb-card" style="">
                                <div class="category"> {{$template->template_name}} </div>

                                <div class="document-body" style="font-size: 17px; color: #999"> Requisition Name : 
                                    {{substr($template->name, 0, 100)}} 
                                </div>

                                <div class="action" style="text-align: center;"> 
                                    <a href="{{ route('create-document', [$template->requisition, 'temp']) }}" class="btn btn-outline-success btn-glow btn-sm" style="padding :0.3rem 0.4rem !important; margin-right: 4px" target="_blank"><i class="la la-plus" aria-hidden="true" style=""> Use</i>
                                    </a>
                                    <a href="{{URL::asset($template->template_path.'/'.$template->template_name)}}" download="{{URL::asset($template->template_path.'/'.$template->template_name)}}" class="btn btn-outline-primary btn-glow btn-sm" style="padding :0.3rem 0.4rem !important; margin-left: 4px"><i class="la la-download" aria-hidden="true" style=""> Download</i>
                                    </a>
                                </div>
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
