{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

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
    </style>

@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h3 class="card-title" id="basic-layout-form">
                            <div class="row" style="margin-top: -10px">
                                <div class="col-md-12" style=""> Regulatory & Statutory Requirements & Filings 

                                  
                                    <a href="{{ url('download-requirementfilings-excel') }}" class="btn btn-outline-success btn-glow btn-sm pull-right downloadExcel" data-toggle="tooltip" title="Download filings in excel" style=""><i class="la la-download"></i> Download</a>

                                    <a href="#" class="btn btn-outline-info btn-glow btn-sm pull-right uploadExcel mr-1" data-toggle="tooltip" onclick="showmodal('up_filings')" title="Upload filings using excel" style=""><i class="la la-upload"></i> Upload</a>

                                    <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm ml-2 mr-1" data-toggle="modal" data-target="#addModal" onclick="clearForm()"><i class="la la-plus" aria-hidden="true"></i> New
                                    </a>

                                    {{-- <a href="{{ route('calendar') }}" class="btn btn-outline-primary btn-glow pull-right btn-sm"><i class="la la-calendar" aria-hidden="true"></i> Calendar View
                                    </a> --}}
                                </div>
                            </div>
                        </h3>

                        <div class="" id="">
                            <table class="table table-sm table-striped mb-0 dtable" id="">
                                <thead class="thead-bg">
                                <tr>
                                    <th style="color: transparent">#</th>
                                    <th>Name / Title</th>
                                    <th>Description</th>
                                    <th>Document Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Recurring</th>
                                    <th>Reminder Me on</th>
                                    <th style="text-align: right">Action </th>
                                </tr>
                                </thead>
                                <tbody>  @php $i = 1; @endphp
                                @forelse ($calendars as $calendar)
                                    <tr>
                                        <th style="color: transparent">{{ $calendar->id }}</th>
                                        <td>{{ $calendar->title }}</td>
                                        <td>{{ $calendar->description }}</td>
                                        <td>{{ $calendar->document_name }} </td>
                                        <td>{{ date("M j, Y", strtotime($calendar->start)) }}</td>
                                        <td>{{ date("M j, Y", strtotime($calendar->end)) }}</td>
                                        <td>{{ $calendar->recurring }}</td>
                                        @if($calendar->recurring == 'Monthly')
                                            <td>{{ $calendar->monthly }} of every month</td>
                                        @elseif($calendar->recurring == 'Quartherly')
                                            <td>{{ $calendar->quarterly }}</td>
                                        @elseif($calendar->recurring == 'Bi-annually')
                                            <td>{{ $calendar->bi_annually }}</td>
                                        @elseif($calendar->recurring == 'Yearly') 
                                            <td>{{ date("M j, Y", strtotime($calendar->yearly)) }} yearly</td>
                                        @endif
                                        <td style="text-align: right">
                                            <span title="Delete Reminder Notifications">
                                                <a href="{{ route('delete', $calendar->id) }}" class="btn btn-outline-danger btn-glow pull-right btn-sm ml-1 del" id="{{$calendar->id}}" data-toggle="modal" data-target="#deleteModal" style="padding :0.3rem 0.4rem !important;"><i class="la la-remove" aria-hidden="true" style="font-weight: bold"></i>
                                                </a>
                                            </span>

                                            <span title="Edit Reminder Notifications">
                                                <a href="#" class="btn btn-outline-primary btn-glow pull-right btn-sm" data-toggle="modal" data-target="#addModal" onclick="getRequirementFilings({{$calendar->id}})" style="padding :0.3rem 0.4rem !important;"><i class="la la-pencil" aria-hidden="true" style="font-weight: bold"></i>
                                                </a>
                                            </span>
                                    </td>
                                    </tr> @php $i++; @endphp
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {!! $calendars->render() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>









    {{-- Add MODAL --}}
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue white">
              <label class="modal-title text-text-bold-600" id="myModalLabel33"><i class="la la-calendar"></i> Add Statutory Filings</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>

            <form id="addForm" action="{{ route('requirements-and-filings.store') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id" id="id" required>

              <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="title" class="col-form-label"> Name / Title </label>
                        <input type="text" placeholder="Event Title" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="col-md-6">
                        <label for="document" class="col-form-label"> Document </label>
                        <input type="file" placeholder="Event Title" class="form-control" name="document" id="document" required>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label for="description" class="col-form-label"> Description </label>
                        <textarea rows="2" placeholder="Description" class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="start" class="col-form-label"> Start Date </label>
                        <input type="date" placeholder="Start Date " class="form-control" name="start" id="start" required>
                    </div>

                    <div class="col-md-6">
                        <label for="end" class="col-form-label"> End Date </label>
                        <input type="date" placeholder="End Date " class="form-control" name="end" id="end" required>
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-6">
                        <label for="start_time" class="col-form-label"> Start Time </label>
                        <input type="time" placeholder="Start Time " class="form-control" name="start_time" id="start_time">
                    </div>

                    <div class="col-md-6">
                        <label for="end_time" class="col-form-label"> End Time </label>
                        <input type="time" placeholder="End Time " class="form-control" name="end_time" id="end_time">
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="reminder" class="col-form-label"> Recurring </label> <br>
                        <label for="recurring" class="col-form-label">  Monthly </label>
                        <input type="radio" class="recurring" name="recurr" id="mtly" value="Monthly">

                        <label for="recurring" class="col-form-label ml-2">  Quartherly </label>
                        <input type="radio" class="recurring" name="recurr" id="qtly" value="Quartherly">

                        <label for="recurring" class="col-form-label ml-2"> Bi-annually </label>
                        <input type="radio" class="recurring" name="recurr" id="bily" value="Bi-annually">

                        <label for="recurring" class="col-form-label ml-2"> Yearly </label>
                        <input type="radio" class="recurring" name="recurr" id="yrly" value="Yearly">

                        <input type="hidden" class="recurring" name="recurring" id="recurring">
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-12 no-pad" id="mtly-div" style="display: none;">
                            <label for="reminder" class="col-form-label"> Notify on the selected date, every month </label> <br>
                            <select class="form-control" name="monthly" id="monthly">
                                <option value="">Monthly</option>
                                <option value="1">1 of every Month</option>
                                <option value="2">2 of every Month</option>
                                <option value="3">3 of every Month</option>
                                <option value="4">4 of every Month</option>
                                <option value="5">5 of every Month</option>
                                <option value="6">6 of every Month</option>
                                <option value="7">7 of every Month</option>
                                <option value="8">8 of every Month</option>
                                <option value="9">9 of every Month</option>
                                <option value="10">10 of every Month</option>
                                <option value="11">11 of every Month</option>
                                <option value="12">12 of every Month</option>
                                <option value="13">13 of every Month</option>
                                <option value="14">14 of every Month</option>
                                <option value="15">15 of every Month</option>
                                <option value="16">16 of every Month</option>
                                <option value="17">17 of every Month</option>
                                <option value="18">18 of every Month</option>
                                <option value="19">19 of every Month</option>
                                <option value="20">20 of every Month</option>
                                <option value="21">21 of every Month</option>
                                <option value="22">22 of every Month</option>
                                <option value="23">23 of every Month</option>
                                <option value="24">24 of every Month</option>
                                <option value="25">25 of every Month</option>
                                <option value="26">26 of every Month</option>
                                <option value="27">27 of every Month</option>
                                <option value="28">28 of every Month</option>
                                <option value="29">29 of every Month</option>
                                <option value="30">30 of every Month</option>
                                <option value="31">31 of every Month</option>
                            </select>
                        </div>

                        <div class="col-md-12 no-pad" id="qtly-div" style="display: none;">
                            <label for="reminder" class="col-form-label"> Notify quarterly, counting from the selected date </label> <br>
                            <input type="date" class="form-control" placeholder="Recurring Quartherly" name="quarterly" id="quarterly">
                        </div>

                        <div class="col-md-12 no-pad" id="bily-div" style="display: none;">
                            <label for="reminder" class="col-form-label"> Notify every bi-annually from the selected date </label> <br>
                            <input type="date" class="form-control" placeholder="Recurring Bi-annually" name="bi_annually" id="bi_annually">
                        </div>

                        <div class="col-md-12 no-pad" id="yrly-div" style="display: none;">
                            <label for="reminder" class="col-form-label"> Notify every year from the selected date </label> <br>
                            <input type="date" class="form-control" placeholder="Recurring Yearly" name="yearly" id="yearly">
                        </div>
                    </div>
                </div>


                

              </div>
              <div class="modal-footer">
                <input type="reset" class="btn btn-outline-warning btn-sm" value="Clear">
                <input type="submit" class="btn btn-outline-primary btn-glow pull-right btn-sm" value="Save Details" onclick="return confirm('Are you sure you want to save details?')">
              </div>
            </form>

          </div>
        </div>
    </div>


    <!-- Confirm  modal -->
    <form id="deleteForm" class="form-horizontal" method="POST" action="{{ route('delete') }}">
      @csrf
        <div id="deleteModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">                    
                        <div class="swal-icon swal-icon--warning">
                          <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                          </span>
                        </div>
                    </div>


                    <input type="hidden" class="form-control" name="id" id="n_id" value="">

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Are you sure you have delete this notification? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_btn" id="no_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal"> No </button>

                            <button type="submit" name="yes_btn" id="yes_btn" class="btn btn-outline-success btn-glow"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Cancel  modal -->


    <!-- Success  modal -->
    <div id="yesModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="swal-icon swal-icon--success">
                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                    <div class="swal-icon--success__ring"></div>
                    <div class="swal-icon--success__hide-corners"></div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style="">Document Deleted </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="button" name="ok_btn" id="ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




{{-- upload --}}
<form id="excelForm" action="{{route('upload-requirementfiling')}}" enctype="multipart/form-data" method="POST">  @csrf
    <!-- Modal -->
    <div class="modal animated zoomIn text-left" id="up_filings" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document" style="">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="myModalLabel69" style="color: #ffffff">Upload using Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: #ffffff">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Upload</label>
                                <input type="file" class="form-control" name="file" id="file" required>

                                <a href="{{ url('download-requirementfiling-excel-template') }}" id="userTemplate" download="Sample Excel Excel Template" class="btn btn-sm pull-right text-muted"
                                   style="font-size: 12px; border:thin solid #808080" title="Download Sample Excel Excel Template"> <i class="fa fa-download"></i> Download Template</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-warning btn-glow btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-info btn-glow btn-sm" onclick="return confirm('Are you sure you want to upload?')">Upload</button>
                </div>
            </div>
        </div>
    </div>
</form>














@endsection

@section('scripts')

    <script>


  function showmodal(modalid, url=0, hrefid=0)
  {  
      $('#'+modalid).modal('show');
  }

        function getRequirementFilings(id)
        {   
            clearForm();
            $(function()
            {            
                $.get('{{url('get-requirement-and-filings-by-id')}}?id=' +id, function(data)
                {
                    //Set values
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#start').val(data.start);
                    $('#end').val(data.end);
                    $('#recurring').val(data.recurring);
                    $('#monthly').val(data.monthly);
                    $('#quarterly').val(data.quarterly);
                    $('#bi_annually').val(data.bi_annually);
                    $('#yearly').val(data.yearly);
                    if(data.recurring == 'Monthly')
                    { 
                        $('#mtly').prop('checked', true);  $('#mtly-div').show();  $('#qtly-div').hide();   $('#bily-div').hide();  $('#yrly-div').hide();
                    }
                    else if(data.recurring == 'Quarterly')
                    { 
                        $('#qtly').prop('checked', true);  $('#qtly-div').show();  $('#mtly-div').hide();   $('#bily-div').hide();  $('#yrly-div').hide();
                    }
                    else if(data.recurring == 'Bi-annualy')
                    { 
                        $('#bily').prop('checked', true);  $('#bily-div').show();  $('#qtly-div').hide();   $('#mtly-div').hide();  $('#yrly-div').hide();
                    }
                    else if(data.recurring == 'Yearly')
                    { 
                        $('#yrly').prop('checked', true);  $('#yrly-div').show();  $('#qtly-div').hide();   $('#bily-div').hide();  $('#mtly-div').hide();
                    }
                });
                
            });
        }

        $(".del").click(function(e)
        {
            var e_id = $(this).attr("id");
            $('#n_id').val(e_id);
        });



        //ADD FORM
        $("#addForm").on('submit', function(e)
        { 
            e.preventDefault();
            const formData = new FormData(document.querySelector('#addForm'));  

            fetch('{{route('requirements-and-filings.store')}}', {
                method:'POST',
                body:formData
            }).then(res=>res.json()).then((data)=>{
                if(data.status == 'ok')
                {   
                    $('#addModal').modal('hide');
                    setInterval(function(){ window.location.replace("{{ route('requirements-and-filings.index') }}"); }, 1000);
                    toastr.success(data.info, {timeOut:10000});
                    clearForm();
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
                // toastr.success('Datials Save');
            });
 
        });

        //ADD FORM
        $("#deleteForm").on('submit', function(e)
        { 
            e.preventDefault();
            var id = $('#n_id').val();

            formData = 
            {
                id:id,
                _token:'{{csrf_token()}}'
            }
            $.post("{{route('delete')}}?id=' +id", formData, function(data, status, xhr)
            {
                if(data.status=='ok')
                {

                    $('#addModal').modal('hide');
                    toastr.success(data.info, {timeOut:10000});
                    setInterval(function(){ window.location.replace("{{ route('requirements-and-filings.index') }}"); }, 1000);
                    // clearForm();
                    return;
                }
                else{   toastr.error(data.error, {timeOut:10000});   }
            }); 
        });



        function clearForm()
        {
            $(function()
            {            
                //Set values
                $('#id').val('');
                $('#title').val('');
                $('#description').val('');
                $('#start').prop('value', 0);  
                $('#end').prop('value', 0);  
                $('#recurring').val('');
                $('.recurring').prop('checked', false);
                $('#monthly').prop('checked', false);  
                $('#quarterly').prop('checked', false);   
                $('#bi_annually').val('');  
                $('#yearly').val('');           
            });
        }






        //MONTHLY
        $('#mtly').click(function()
        {
            $('#mtly-div').show();    $('#qtly-div').hide();    $('#bily-div').hide();    $('#yrly-div').hide();    $('#recurring').val('Monthly');
        });

        //QUARTERLY
        $('#qtly').click(function()
        {
            $('#qtly-div').show();    $('#mtly-div').hide();    $('#bily-div').hide();    $('#yrly-div').hide();    $('#recurring').val('Quarterly');
        });

        //BI-ANNUALLY
        $('#bily').click(function()
        {
            $('#bily-div').show();    $('#mtly-div').hide();    $('#qtly-div').hide();    $('#yrly-div').hide();    $('#recurring').val('Bi-annualy');
        });

        //YEARLY
        $('#yrly').click(function()
        {
            $('#yrly-div').show();    $('#mtly-div').hide();    $('#qtly-div').hide();    $('#bily-div').hide();    $('#recurring').val('Yearly');
        });

    </script>
    

    <script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>

    



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
