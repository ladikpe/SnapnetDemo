{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

    <style>

    </style>

@endsection
@section('content')


    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        
                        {{-- <div class="mt-4" id="example">
                            <div class="fr-view">
                              Here comes the HTML edited with the Froala rich text editor.
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>

    </div>















@endsection

@section('scripts')

    <script>

        const CLIENT_ID = "467096738315-fcib5m79sq62m507eaqmpm6iklsmjoia.apps.googleusercontent.com";
        const API_KEY = "AIzaSyAx2Fg9MneZMwW9-86kthfpFGr1x4suXO4";
        const SCOPES = "hhtps://www.googleapis.com/auth/drive";

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
