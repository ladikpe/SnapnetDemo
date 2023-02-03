@extends('layouts.vendorapp')
@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />
@endsection
@section('content')





        <div class="row">

            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h2 class="primary">  {{$bid_count}} </h2>         <h6>Your Submitted Bids</h6>
                                </div>
                                <div>
                                    <i class="la la-briefcase primary font-large-2 float-right"></i>
                                </div>
                            </div>
                            
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h2 class="success"> 0 of {{$bid_count}} </h2>         
                                    <h6>Bid Won</h6>
                                </div>
                                <div>
                                    <i class="la la-check text-success success font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width:0%" aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="0"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h2 class="warning"> {{$bid_doc_count}} </h2>         
                                    <h6>Bid Documents</h6>
                                </div>
                                <div>
                                    <i class="la la-file warning font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width:0%" aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="0"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h2 class="danger"> {{$expired_docs}} of {{$bid_doc_count}} </h2>         
                                    <h6> Documents past Expiry Date</h6>
                                </div>
                                <div>
                                    <i class="la la-ban text-danger danger font-large-2 float-right"></i>
                                </div>
                            </div>

                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 0%"
                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>








@endsection
@section('scripts')



    <!-- SETTING COUNT FOR CONTRACT EXPIRED THIS MONTH -->
    <script>
        $(function()
        {
            var ct = $('#count').val();
            $('#count_ex_mo').html(ct);

            //for deadline
            var dl = $('#deadline').val();
            $('#dead_past').html(dl);

            //for pending
            var ct_pend = $('#ct').val();
            $('#ct_pend').html(ct_pend);
        });
    </script>



@endsection
