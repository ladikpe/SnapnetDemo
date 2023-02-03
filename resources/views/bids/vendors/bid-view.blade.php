@extends('layouts.vendorapp')

@section('content')


    

<!-- INCLUDING styles-->
@include('bids.vendors.css.styles')

    
<div class="row">          
    <div class="col-md-12"> 


      <section class="row">
            <div class="col-xl-8 col-lg-8 col-md-12">
              <div class="card" style="zoom: 1;">
                <div class="card-head">
                  <div class="card-header">
                    <h4 class="card-title">Bid Code : {{$bid->bid_code}} </h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        @if($submitted == null)
                          <li>
                            <a href="#" class="btn btn-dark btn-sm pull-right addNew" data-toggle="modal" data-target="#responseToBidModel" title="Create New Bid" style="margin-top: -10px" id="add"><i class="la la-send"></i> Submit Bid</a>
                          </li>
                          @else
                          <li>
                            <a href="#" class="btn btn-warning btn-sm pull-right addNew" data-toggle="tooltip" title="You have sent a response for this bid" style="margin-top: -10px" id=""><i class="la la-exclamation"></i> Bid Submitted Already</a>
                          </li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div id="bug-pie-chart" class="echart-container" _echarts_instance_="1615293856985 row"> 
                      <table class="table">
                        <tr>
                          <td style="width: 15%"><label for="name" class="col-form-label no-pad-left"><i class="fa fa-user"></i> Name </label></td>
                          <td style="width: 35%"><input type="text" class="form-control vm" value="{{$bid->name}}" disabled></td>
                          <td style="width: 15%"><label for="name" class="col-form-label no-pad-left"><i class="fa fa-cube"></i> Category </label></td>
                          <td style="width: 35%"><input type="text" class="form-control vm" value="{{$bid->industry->name}}" disabled></td>
                        </tr>
                        <tr>
                          <td><label for="name" class="col-form-label no-pad-left"><i class="fa fa-calendar"></i> Start Date </label></td>
                          <td><input type="text" class="form-control vm" value="{{date("M j, Y", strtotime($bid->start_date))}}" disabled></td>
                          <td><label for="name" class="col-form-label no-pad-left"><i class="fa fa-calendar"></i> End Date </label></td>
                          <td><input type="text" class="form-control vm" value="{{date("M j, Y", strtotime($bid->end_date))}}" disabled></td>
                        </tr>
                      </table> 

                      <table><tr><td></td></tr></table>

                      <table class="table">
                        <tr>
                          <td style="width: 15%"><label for="name" class="col-form-label no-pad-left"><i class="fa fa-pencil"></i> Description </label></td>
                          <td style="width: 85%"><textarea rows="5" class="form-control vm" disabled>{{$bid->description}}</textarea></td>
                        </tr>
                        <tr>
                          <td><label for="name" class="col-form-label no-pad-left"><i class="fa fa-pencil"></i> Instruction </label></td>
                          <td><textarea rows="5" class="form-control vm" disabled>{{$bid->instruction}}</textarea></td>
                        </tr>
                      </table>

                    </div>
                </div>
              </div>
            </div>
            </div>
            <!--/ Task Progress -->
            
            <!-- Bug Progress -->
            <div class="col-xl-4 col-lg-4 col-md-12">
              <div class="card" style="zoom: 1;">
                <div class="card-header">
                  <h4 class="card-title">Bid Attachments</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div id="bug-pie-chart" class="height-400 echart-container" _echarts_instance_="1615293856985">
                        <table class="table mb-1" id="attach_table">
                          <thead class="">
                            <tr>
                              <th>#</th>
                              <th>Attachment Name</th>
                              {{-- <th>Path</th> --}}
                              {{-- <th>Created by</th> --}}
                              <th>Date</th>
                              <th style="text-align: right"><i class="la la-file"></i></th>
                            </tr>
                          </thead>
                          <tbody>    @php $i = 1; @endphp     
                              @forelse ($documents as $document)                
                                  <tr>
                                      <td>{{ $i }}</td>
                                      <td>{{ $document->name }}</td>
                                      {{-- <td>{{ $document->path }}</td> --}}
                                      {{-- <td>{{ $document->author?$document->author->name:'' }}</td> --}}
                                      <td>{{date("M j, Y", strtotime($document->created_at))}}</td>
                                      <td style="text-align: right">
                                        <a class="btn-sm text-info pull-right" href="{{URL::asset($document->path.'/'.$document->doc_name)}}" download="{{URL::asset($document->path.'/'.$document->doc_name)}}" style="">
                                          <i class="la la-download" aria-hidden="true" style="font-size:13px"></i>
                                        </a>
                                      </td>
                                  </tr>    @php $i++; @endphp  
                              @empty
                              @endforelse
                          </tbody>
                        </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!--/ Bug Progress -->
          </section>


      
  </div>

</div>






<!-- INCLUDING Modals-->
<!-- Review Document with Comments -->
    <form id="responseToBidForm" action="{{route('respond-to-bid')}}" method="post" enctype="multipart/form-data">
     @csrf
        <div class="modal fade text-left" id="responseToBidModel" tabindex="-1" role="dialog" aria-labelledby="reviewModel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark white">
                <h4 class="modal-title text-text-bold-600" id="myModalLabel1">Response to Bid</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color: red">X</span>
                </button>
              </div>
              <div class="modal-body">
                
                  <div class="card-block">
                      <input type="hidden" name="id" id="res_id" value="">
                      <input type="hidden" name="bid_id" id="res_bid_id" value="{{$bid->id}}" />

                      <div class="col-xs-12">
                          <label for="note" class="col-form-label"> Notes </label>
                          <textarea rows="4" class="form-control" name="note" id="note" placeholder="Note Here ..." required></textarea>
                      </div>  
                  </div>

                  <hr>
                
                  <div class="card-block">
                      <div class="col-xs-12">
                          <label for="note" class="col-form-label"> Attach Documents for Bid (Multiple file allowed) </label>
                          <input type="file" class="form-control" name="file[]" id="file" multiple="true">
                      </div>  
                  </div>

              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger btn-glow btn-sm mr-1">Clear</button>
                <button type="submit" class="btn btn-outline-info btn-glow btn-sm">Send Response</button>
              </div>
            </div>
          </div>
        </div>
    </form> 







    





   
   

   
   
@endsection

@section('scripts')


    

<!-- INCLUDING scripts-->
@include('bids.vendors.js.scripts')

  
@endsection
