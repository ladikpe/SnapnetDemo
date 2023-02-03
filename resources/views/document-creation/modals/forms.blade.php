
    <!-- Review Document with Comments -->
    <form class="" action="{{route('document-review-comment')}}" method="post">
     @csrf
        <div class="modal fade text-left" id="reviewModel" tabindex="-1" role="dialog" aria-labelledby="reviewModel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark white">
                <h4 class="modal-title text-text-bold-600" id="myModalLabel1">Comment on Document Before Review</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color: red">X</span>
                </button>
              </div>
              <div class="modal-body">
                
                  <div class="card-block">
                      <label for="" class="col-md-12 col-form-label" style="font-size: 16px; padding: 15px 0px"> Email Recipient(s) </label>
                      <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">
                      <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}" />
                      <input type="hidden" class="form-control" id="name" placeholder="Contract Name" name="name" value="{{$document->name}}" />

                    <div class="form-group row"> @php $i = 1; @endphp
                      @if($version_users)
                        @forelse($version_users as $version_user)
                          <div class="col-md-3">
                              <label class="container"> <div style="margin-left: 10%;"> {{$version_user->author->name}} </div>
                                <input type="checkbox" class="recip" name="user_{{$version_user->created_by}}" id="{{$i}}" value="{{$version_user->created_by}}"> 
                                <span class="checkmark"></span>
                              </label>
                              <input type="hidden" name="recipient_{{$i}}" id="recipient_{{$i}}" value="">
                          </div> @php $i++; @endphp
                        @empty
                        @endforelse 
                      @endif  

                      <div class="col-md-3">

                        <div class="row">
                          <div class="col-md-4"> <label class="label"> Others</label> </div>
                          <div class="col-md-8">
                            <select class="form-control input-sm" name="recipient_user" id="recipient_user">
                              <option value=""></option>
                              @forelse($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                              @empty
                              @endforelse 
                            </select>
                          </div>
                        </div>                         
                          
                      </div>

                      <input type="hidden" name="count" id="count" value="{{$i - 1}}">
                    </div>  <hr>

                      <div class="col-xs-12">
                          <label for="comment" class="col-form-label"> Comment </label>
                          <textarea rows="4" class="form-control" name="comment" id="comment" placeholder="Comment Here ..." required></textarea>
                      </div>  
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-glow btn-sm mr-1" data-dismiss="modal" >Close</button>
                <button type="submit" class="btn btn-outline-info btn-glow btn-sm">Save Comment</button>
              </div>
            </div>
          </div>
        </div>
    </form> 




    <!-- Signature Modal -->
    <form class="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark white">
            <label class="modal-title" id="rate_model"> Your Signature</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="card-block">
                  <div class="card-body" id="view_rated">

                    <input name="signature" id="signature" type="hidden">
                      @if($signature)
                        <div class="sign-container" style="text-align: center">
                           {!! $signature->signature !!}
                        </div>
                      @else
                        <div id="signArea">
                            <h2 class="tag-ingo">Put signature below</h2>
                            <div class="sig sigWrapper" id="holder" style="height:auto;">
                                <div class="typed"></div>
                                <canvas class="sign-pad" id="sign-pad" width="300" height="100"> </canvas>
                            </div>
                        </div>
                      @endif  

                  </div>
                </div>
          </div>
          <div class="modal-footer" style="text-align: center">
            @if(!$signature) 
              <button type="button" id="btnSaveSign" class="btn btn-outline-success btn-glow">Save</button>
              <button id="btnCleared" class="btn btn-outline-warning btn-glow">Clear</button> 
            @endif
          </div>
        </div>
      </div>
    </div>
    </form>





    <!-- Confirm  modal -->
    <form class="form-horizontal" method="POST" action="{{ route('review-document') }}" enctype="multipart/form-data">
      @csrf
        <div id="confirmModal" class="modal fade" role="dialog" style="margin-top: 10%">
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


                    <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}">
                    <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">     
                    {{-- {{request()->route()->parameters['id']}} --}}
                    <input type="hidden" class="form-control" id="name" placeholder="Contract Name" name="name" value="{{$document->name}}" />

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Are you sure you have reviewed document </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="no_btn" id="no_btn" class="btn btn-outline-warning btn-glow mr-1"> No </button>

                            <button type="submit" name="yes_btn" id="yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#yesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


        





    <!-- Cancel  modal -->
    <div id="noModal" class="modal fade" role="dialog" style="margin-top: 10%">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark white" style="border-bottom: none;">                    
                    <div class="swal-icon swal-icon--error">
                      <div class="swal-icon--error__x-mark">
                        <span class="swal-icon--error__line swal-icon--error__line--left"></span>
                        <span class="swal-icon--error__line swal-icon--error__line--right"></span>
                      </div>
                    </div>
                </div>

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style=""> You cancelled the operation </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="cancel_btn" id="cancel_btn" class="btn btn-outline-danger btn-glow" data-dismiss="modal"> Close </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                    <center> <h2 class="swal3-title" style="">Document Reviewed </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Confirm Push For Approval modal -->
    <form class="form-horizontal" method="POST" action="{{ route('push-for-approval') }}" enctype="multipart/form-data">
      @csrf
        <div id="pushForApprovalModal" class="modal fade" role="dialog" style="margin-top: 10%">
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


                    <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}">
                    <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">     
                    {{-- {{request()->route()->parameters['id']}} --}}
                    <input type="hidden" class="form-control" id="name" placeholder="Contract Name" name="name" value="{{$document->name}}" />

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Are you sure you want to push for approval? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="push_no_btn" id="push_no_btn" class="btn btn-outline-warning btn-glow mr-1"> No </button>

                            <button type="submit" name="push_yes_btn" id="push_yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#pushForApprovalYesModal"> Yes </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Success  modal -->
    <div id="pushForApprovalYesModal" class="modal fade" role="dialog" style="margin-top: 10%">
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
                    <center> <h2 class="swal3-title" style="">Approval request was sent </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="push_ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!--  Approve modal -->
    <form class="form-horizontal" method="POST" action="{{ route('approve-document') }}" enctype="multipart/form-data">
      @csrf
        <div id="approveModal" class="modal fade" role="dialog" style="margin-top: 10%">
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


                    <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}">
                    <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">     
                    {{-- {{request()->route()->parameters['id']}} --}}
                    <input type="hidden" class="form-control" id="name" placeholder="Contract Name" name="name" value="{{$document->name}}" />

                    <div class="modal-body">
                        <center> <h3 class="swal3-title" style="">Approve this document? </h3> </center>
                        <br>

                        <div class="" style="text-align: center!important">
                            <button type="button" name="app_no_btn" id="app_no_btn" class="btn btn-outline-warning btn-glow mr-1" data-dismiss="modal"> No </button>

                            <button type="submit" name="app_yes_btn" id="app_yes_btn" class="btn btn-outline-success btn-glow" data-toggle="modal" data-target="#approveYesModal"> Yes </button>
                        </div>


                        <div class="" style="display: none !important;">
                        <textarea rows="10" class="form-control" name="signatures" id="signatures">
                          <div class="row" style="">
                            <div class="col-md-6" style="padding: 0px">

                              <table class="table table-sm table-striped">
                                <tbody>
                                  @forelse($signatures as $signature)
                                    <tr>
                                      <td>{{$signature->name}}</td>
                                      <td style="max-height: 30% !important; max-width: 65% !important">{!! $signature->signature !!}</td>
                                      <td>{{date('F, j Y', strtotime($document->updated_at))}}</td>
                                    </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </textarea>
                      </div>


                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Success  modal -->
    <div id="approveYesModal" class="modal fade" role="dialog" style="margin-top: 10%">
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
                    <center> <h2 class="swal3-title" style="">Document Approved </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="ok_btn" id="app_ok_btn" class="btn btn-outline-success btn-glow" data-dismiss="modal"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--  Decline modal -->
    <form class="form-horizontal" method="POST" action="{{ route('decline-document') }}" enctype="multipart/form-data">
      @csrf
        <div id="declineModal" class="modal fade" role="dialog" style="margin-top: 10%">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-dark white">
                      <h4 class="modal-title text-text-bold-600" id="myModalLabel1"> Decline Document Approval </h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: red">X</span>
                      </button>
                    </div>

                    <div class="modal-body"> 
                        <center> <h3 class="swal3-title" style="">
                        Decline approval of this document <i class="fa fa-question" style="color: red"></i> </h3> </center>
                        
                    <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}">
                    <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition->id}}">     
                    {{-- {{request()->route()->parameters['id']}} --}}
                    <input type="hidden" class="form-control" id="name" placeholder="Contract Name" name="name" value="{{$document->name}}" />


                        <div class="col-xs-12" style="padding: 25px">
                            <label for="comment" class="col-form-label"> Comment </label>
                            <textarea rows="4" class="form-control" name="comment" id="comment" placeholder="Comment Here ..." required></textarea>
                        </div> 

                        <div class="" style="text-align: center!important">
                            <button type="button" name="" id="" class="btn btn-outline-default btn-glow mr-1" data-dismiss="modal"> Cancel </button>

                            <button type="submit" name="dec__btn" id="dec__btn" class="btn btn-outline-danger btn-glow" data-toggle="modal" data-target="#decNoModal"> Decline </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Cancel modal -->
    <div id="decNoModal" class="modal fade" role="dialog" style="margin-top: 10%">
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

                <div class="modal-body">
                    <center> <h2 class="swal3-title" style=""> Notification Sent </h2> </center>
                    <br>

                    <div class="" style="text-align: center!important">
                        <button type="submit" name="" id="d_btn" class="btn btn-outline-danger btn-glow" data-dismiss="modal"> Close </button>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <!-- Share Docu with Client -->
    <form class="" action="{{route('share-link-url')}}" method="post" enctype="multipart/form-data">
     @csrf
        <div class="modal fade text-left" id="shareWithUserModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark white">
                <h4 class="modal-title text-text-bold-600" id="myModalLabel1">Share Document With User/Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color: red">X</span>
                </button>
              </div>
              <div class="modal-body">

                  <fieldset class="scheduler-border">
                      <legend class="scheduler-border"> User - Requestor </legend>

                      <div class="card-block">
                        <input type="hidden" name="id" id="link_id" />

                        <div class="row">
                          <div class="col-md-3"> <label class="label"> Email Recipient(s)</label> </div>
                          <div class="col-md-9">
                            <select class="form-control" name="user_id" id="recipient_user">
                              <option value=""></option>
                              @forelse($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                              @empty
                              @endforelse 
                            </select>
                          </div>
                        </div>
                      </div>

                  </fieldset>

                  <fieldset class="scheduler-border">
                      <legend class="scheduler-border"> Client </legend>
                      <div class="card-block">

                        <div class="row">
                          <div class="col-md-3"> <label class="label"> Client Email</label> </div>
                          <div class="col-md-9">
                            <input type="text" class="form-control" name="vendor_email" id="vendor_email" value="">
                          </div>
                        </div>
                      </div>
                  </fieldset>



                  <fieldset class="scheduler-border">
                      <legend class="scheduler-border"> Documents & Links </legend>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="file" class="col-form-label"> Upload Document </label>
                          <input type="file" class="form-control" name="file" id="file">
                        </div>

                        <div class="col-md-6">
                          <label for="link_url" class="col-form-label"> Share Link Url</label>
                          <input type="url" class="form-control" name="link_url" id="link_url">
                        </div>
                      </div>
                  </fieldset>

                  <div class="col-xs-12">
                      <label for="comment" class="col-form-label"> Comment </label>
                      <textarea rows="4" class="form-control" name="comment" id="comment" placeholder="Comment Here ..." required></textarea>
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-glow btn-sm mr-1" data-dismiss="modal" >Close</button>
                <button type="submit" class="btn btn-outline-info btn-glow btn-sm">Share</button>
              </div>
            </div>
          </div>
        </div>
    </form> 









