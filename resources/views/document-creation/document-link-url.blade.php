{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')

    <style>
        .sortColumn
        {
            cursor: pointer;
        }

        .la la-arrows-v
        {
            font-size: 13px!important;
        }

        html body .la
        {
            font-size: 13px!important;  /* font-size: 1.4rem; */
        }

        .container
        {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container input
        {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark
        {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            border: thin solid #ccc;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark
        {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked ~ .checkmark
        {
            background-color: #0a6aa1;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after
        {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked ~ .checkmark:after
        {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after
        {
            top: 8px;
            left: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: white;
        }
        .font-size-17
        {
            font-size: 17px;
            padding: 5px 15px 5px 15px;
            text-align: center;
        }
    </style>

@endsection
@section('content')


    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start"> <span class="badge badge-primary"> <i class="fa fa-file"></i> Documents and Links Shared <span></span> </div>

                            <div class="col-md-6 d-flex justify-content-end"> 
                                <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm pull-right" data-toggle="modal" data-target="#addForm" onclick="clearForm()" data-toggle="tooltip" title="Share Document URL & Link"><i class="la la-plus"></i> New</a>
                            </div>
                        </div>


                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                    <tr>
                                        <th style="color: transparent;">#</th>
                                        <th>Employee</th>
                                        <th>Vendor</th>
                                        <th>Document</th>
                                        <th>Link Url</th>
                                        <th>Comment</th>
                                        <th style="text-align: right">Action </th>
                                    </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($link_urls as $link_url)
                                    <tr>
                                        <td style="color: transparent;">{{ $link_url->id }}</td>
                                        <td>{{ $link_url->user?$link_url->user->name:'' }}</td>
                                        <td>{{ $link_url->vendor_email }}</td>
                                        <td>{{ substr($link_url->file_name, 0, 50)}} ...</td>
                                        <td>{{ substr($link_url->link_url, 0, 50)}} ...</td>
                                        <td>{{ substr($link_url->comment, 0, 50)}} ...</td>
                                        <td style="text-align: right">
                                            <span  data-toggle="tooltip" title="Download Document">
                                                <a class="btn btn-sm text-dark" data-toggle="tooltip" title="Download {{$link_url->file_name}}" href="{{URL::asset($link_url->file_path.'/'.$link_url->file_name)}}" download="{{URL::asset($link_url->filepath.'/'.$link_url->filename)}}"><i class="la la-download"></i> {{$link_url->filename}} </a>
                                            </span>

                                            <span  data-toggle="tooltip" title="View Uploaded Link">
                                                <a href="{{$link_url->link_url}}" class="my-btn btn-sm text-info" data-toggle="tooltip" title="View Link"><i class="la la-link" aria-hidden="true"></i>
                                                </a>

                                                {{-- <a href="#" class="my-btn btn-sm text-info" data-toggle="modal" data-target="#addForm" onclick="getDelegate({{$link_url->id}})"><i class="la la-pencil" aria-hidden="true"></i>
                                                </a> --}}
                                            </span>
                                        </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>















{{-- Add MODAL --}}
<div class="modal fade text-left" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header bg-blue white">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Share Document or Link</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="" action="{{ route('share-link-url') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id">

                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="user_id" class="col-form-label"> Employee </label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value=""></option>
                                @forelse($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="vendor_email" class="col-form-label"> External User </label>
                            <input type="email" placeholder="External User" class="form-control" name="vendor_email" id="vendor_email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="file" class="col-form-label"> Upload File </label>
                            <input type="file" placeholder="" class="form-control" name="file" id="file">
                        </div>

                        <div class="col-md-6">
                            <label for="link_url" class="col-form-label"> Document Link </label>
                            <input type="text" placeholder="Document Link to be shared" class="form-control" name="link_url" id="link_url">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="comment" class="col-form-label"> Comment </label>
                            <textarea rows="4" placeholder="Comment / Message" class="form-control" name="comment" id="comment"></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-outline-warning" value="Clear" data-dismiss="modal">
                    <input type="submit" class="btn btn-outline-primary btn-glow pull-right" value="Share">
                </div>
            </form>

        </div>
    </div>
</div>







@endsection

@section('scripts')

    <script>

        function getDelegate(id)
        {  
            clearForm();           
            $.get('{{url('get-delegate-by-id')}}?id=' +id, function(data)
            {
                //Set values
                $('#id').val(id);
                $('#department_id').prop('value', data.department_id);
                $('#user_id').prop('value', data.user_id);
                $('#end_date').val(data.end_date);
            });
        }


        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('#id').val('');
                $('#document_id').prop('value', '');
                $('#user_id').prop('value', '');
                $('#end_date').val('');
            });
        }

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
