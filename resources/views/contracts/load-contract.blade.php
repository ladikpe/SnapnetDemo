
                  <table class="table table-sm mb-0" id="old-table">
                    <thead class="thead-dark">
                      <tr>
                        <th class="sortColumn" id="name">Name <i class="la la-arrows-v" style=""></i></th>
                        {{-- <th>Contract Category</th> --}}
                        <th class="sortColumn" id="status">Status <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="vendor_id">Vendor <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="expires">Expiry Date <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="user_id">Created By <i class="la la-arrows-v" style=""></i></th>
                        <th class="sortColumn" id="created_at">Created At <i class="la la-arrows-v" style=""></i></th>
                        <th>Action <a href="{{url('contracts/new')}}" class="pull-right" style="color:#fff !important"><i class="la la-plus"></i></a></th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($contracts as $contract)
                        <tr>
                          <td> {{ $contract->name }}</td>
                          {{-- <td>{{ $contract->contract_category?$contract->contract_category->name:'' }}</td> --}}
                          <td>
                            @if($contract->status == 0)
                              <span class="badge badge-pill badge-warning" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @elseif($contract->status == 1)
                              <span class="badge badge-pill badge-success" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @elseif($contract->status == 2)
                              <span class="badge badge-pill badge-danger" style="color:#fff">
                                {{ $contract->Status ? $contract->Status->name : 'N/A' }}</span>
                            @endif
                          </td>
                          
                          <td>{{ $contract->vendor ? $contract->vendor->name : 'N/A' }}</td>
                          <td>{{date("M j, Y", strtotime($contract->expires))}}</td>
                          <td>{{ $contract->user->name }}</td>
                          <td>{{date("M j, Y, g:i A", strtotime($contract->created_at))}}</td>
                          <td>

                          <span  data-toggle="tooltip" title="View"><a href="{{ url('contracts/show/'.$contract->id) }}" class="my-btn btn-sm text-dark">  <i class="la la-eye" aria-hidden="true"></i></a></span>
                            <!-- Legal Officers Role -->
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                              @if($contract->ContractPerformance->isNotEmpty())                                  
                                <span title="View Ratings">
                                <a id="{{$contract->id}}" class="my-btn btn-sm text-success view" data-toggle="modal" data-target="#viewRatingModel">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @else                                  
                                <span title="Rate Contract Performance">
                                <a id="star_{{$contract->id}}" class="my-btn btn-sm text-warning" data-toggle="modal" data-target="#ratingModel" onclick="putId({{ $contract->id }})">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @endif
                              
                            <!-- Manager view -->
                            @elseif(Auth::user()->role_id == 5)
                              @if($contract->ContractPerformance->isNotEmpty())                                  
                                <span title="View Legal Officer Ratings">
                                <a id="{{$contract->id}}" class="my-btn btn-sm text-success view_mgr" data-toggle="modal" data-target="#viewRatingMgrModel">   <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @else                                  
                                <span title="Rate Legal Officers Performance">
                                <a id="star_{{$contract->id}}" class="my-btn btn-sm text-warning rate_user" data-toggle="modal" data-target="#ratingMgrModel" onclick="mgrPutId({{ $contract->id }})"> <i class="la la-star-half-empty" aria-hidden="true"></i></a>
                                </span>
                              @endif
                            @endif
                            <!-- Managerial Role -->
                            @if($contract->status==1)
                              {{-- <span  data-toggle="tooltip" title="View"><a href="{{ url('download_contract/'.$contract->id) }}" class="my-btn btn-sm text-dark"><i class="la la-download" aria-hidden="true"></i></a></span> --}}
                              <span  data-toggle="tooltip" title="Download"><a href="{{ url('contracts/final/'.$contract->id) }}" class="my-btn btn-sm text-dark"><i class="la la-download" aria-hidden="true"></i></a></span>   
                            @endif
                            
                          </td>
                        </tr>
                      @empty
                        
                      @endforelse
                     </tbody>
                  </table>
                  
                  {{-- {!! $contracts->appends(Request::capture()->except('page'))->render() !!} --}}