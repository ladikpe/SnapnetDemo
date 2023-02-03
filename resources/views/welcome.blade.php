<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Unauthorized Access
                </div>

                <div class="links">

                    <a href="{{route('home')}}">Return to your Dashboard</a>

                </div>
            </div>
        </div>
    </body>
</html>






 <!-- eCommerce statistic -->
  @if(Auth::user()->role_id==1||Auth::user()->role_id==2)
    <!-- <div class="row">
      <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="info">{{$users_count}}</h3>   <h6>Users</h6>
                </div>
                <div>  <i class="la la-users info font-large-2 float-right"></i>   </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="success">{{$documents_count}}</h3> <h6>Files</h6>
                </div>
                <div>
                  <i class="la la-file success font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 65%" 
                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="warning">{{$pending_reviews_count}}</h3>   <h6>Unreviewed Files</h6>
                </div>
                <div>
                  <i class="la la-pencil text-success warning font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 75%"
                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="danger">
                    @if ($size_count<1000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024,2)}}KB</h2>
                    @elseif ($size_count<1000000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024,2)}}MB</h2>
                    @elseif ($size_count<1000000000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024/1024,2)}}GB</h2>
                    @else
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024/1024/1024,2)}}TB</h2>
                    @endif</h3>
                  <h6>Storage Used</h6>
                </div>
                <div>
                  <i class="la la-inbox danger font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%"
                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    


    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Latest Documents in Review</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Current Stage</th>
                    <th>Workflow</th>
                    <th>Checkin User</th>
                    <th>Time in stage</th>
                    <th>My Review</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($latest_pending_reviews as $review)
                    <tr>
                      <td><a href="{{route('documents.view',$review->document->id)}}">{{$review->document->filename}}</a></td>
                      <td>{{$review->stage->name}}</td>
                      <td>{{$review->stage->workflow->name}}</td>
                      <td>{{$review->document->user->name}}</td>
                      <td>{{ $review->created_at==$review->updated_at?\Carbon\Carbon::parse($review->created_at)->diffForHumans():\Carbon\Carbon::parse($review->created_at)->diffForHumans($review->updated_at) }}</td>
                      <td> {!! $review->stage->user->id==Auth::user()->id?'<span class="label label-info"> Yes</span>' :'<span class="label label-warning"> No</span>'!!} </td>
                      <td>{{date("F j, Y, g:i a", strtotime($review->created_at))}}</td>
                      <td><a href="{{route('documents.showreview',$review->document->id)}}" title="Review"><i class="la la-pencil text-success"></i></a> </td>
                    </tr>
                  @empty
                    No pending review.
                  @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">My Reviews</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Current Stage</th>
                    <th>Workflow</th>
                    <th>Checkin User</th>
                    <th>Time in Stage</th>
                    <th>My Review</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($myreviews as $myreview)
                      <tr>
                        <td><a href="{{route('documents.view',$myreview->document->id)}}">{{$myreview->document->filename}}</a></td>
                        <td>{{$myreview->stage->name}}</td>
                        <td>{{$myreview->stage->workflow->name}}</td>
                        <td>{{$myreview->document->user->name}}</td>
                        <td>{{ $myreview->created_at==$myreview->updated_at?\Carbon\Carbon::parse($myreview->created_at)->diffForHumans():\Carbon\Carbon::parse($myreview->created_at)->diffForHumans($myreview->updated_at) }}</td>
                        <td> {!! $myreview->stage->user->id==Auth::user()->id?'<span class="label label-info"> Yes</span>' :'<span class="label label-warning"> No</span>'!!} </td>
                        <td>{{date("F j, Y, g:i a", strtotime($myreview->created_at))}}</td>
                        <td><a href="{{route('documents.showreview',$myreview->document->id)}}" title="Review"><i class="la la-pencil text-success"></i></a> </td>
                      </tr>
                    @empty
                      No pending review.
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>

        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Document Tree view</h3>  </div>
            <div class="card-content collapse show">
              <div id="folder" class="demo">
                  <ul>
                    <li data-jstree='{ "opened" : true }'>Root node
                      <ul>
                        <li data-jstree='{ "selected" : true }'>Child node 1</li>
                        <li>Child node 2</li>
                      </ul>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
        </div>

        
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Recently Updated</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Download</th>
                    <th>Assigned User</th>
                    <th>Updated</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($latestdocuments as $doc)
                      <tr>
                        <td><a href="{{ route('documents.view',$doc->id) }}">{{$doc->filename}}</a></td>
                        <td>No link available</td>
                        <td>{{$doc->user->name}}</td>
                        <td>{{date("F j, Y, g:i a", strtotime($doc->created_at))}}</td>
                      </tr>
                      @empty
                        No document Available
                      @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
    </div> -->





  @elseif (Auth::user()->role_id==3)





    <!-- <div class="row">
      <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="info">{{$users_count}}</h3>   <h6>Users</h6>
                </div>
                <div>  <i class="la la-users info font-large-2 float-right"></i>   </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="success">{{$documents_count}}</h3> <h6>Files</h6>
                </div>
                <div>
                  <i class="la la-file success font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 65%" 
                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="warning">{{$pending_reviews_count}}</h3>   <h6>Unreviewed Files</h6>
                </div>
                <div>
                  <i class="la la-pencil text-success warning font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 75%"
                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h3 class="danger">
                    @if ($size_count<1000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024,2)}}KB</h2>
                    @elseif ($size_count<1000000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024,2)}}MB</h2>
                    @elseif ($size_count<1000000000000)
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024/1024,2)}}GB</h2>
                    @else
                      <h2><span class="fa fa-hdd-o" aria-hidden="true"></span>{{round($size_count/1024/1024/1024/1024,2)}}TB</h2>
                    @endif</h3>
                  <h6>Storage Used</h6>
                </div>
                <div>
                  <i class="la la-inbox danger font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%"
                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!--/ eCommerce statistic -->

    


    <!-- <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Documents To be reviewed by Me</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Current Stage</th>
                    <th>Workflow</th>
                    <th>Checkin User</th>
                    <th>My Review</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($myreviews as $review)
                    <tr>
                      <td><a href="{{route('documents.view',$review->document->id)}}">{{$review->document->filename}}</a></td>
                      <td>{{$review->stage->name}}</td>
                      <td>{{$review->stage->workflow->name}}</td>
                      <td>{{$review->document->user->name}}</td>
                      <td> {!! $review->stage->user->id==Auth::user()->id?'<span class="label label-info"> Yes</span>' :'<span class="label label-warning"> No</span>'!!} </td>
                      <td>{{date("F j, Y, g:i a", strtotime($review->created_at))}}</td>
                      <td><a href="{{route('documents.showreview',$review->document->id)}}" title="Review"><i class="la la-pencil text-success"></i></a> </td>
                    </tr>
                  @empty
                    No pending review.
                  @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>

        </div>
    </div> -->


    <!-- <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">My Documents to be reviewed by others</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Current Stage</th>
                    <th>Workflow</th>
                    <th>Checkin User</th>
                    <th>My Review</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($myfilesinreviews as $review)
                      <tr>
                        <td><a href="{{route('documents.view',$review->document->id)}}">{{$review->document->filename}}</a></td>
                        <td>{{$review->stage->name}}</td>
                        <td>{{$review->stage->workflow->name}}</td>
                        <td>{{$review->document->user->name}}</td>
                        <td> {!! $review->stage->user->id==Auth::user()->id?'<span class="label label-info"> Yes</span>' :'<span class="label label-warning"> No</span>'!!} </td>
                        <td>{{date("F j, Y, g:i a", strtotime($review->created_at))}}</td>
                        <td><a href="{{route('documents.showreview',$review->document->id)}}" title="Review"><i class="la la-pencil text-success"></i></a> </td>
                      </tr>
                    @empty
                      No pending review.
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>

        </div>
    </div> -->


    <!-- <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Document Tree view</h3>  </div>
            <div class="card-content collapse show">
              <div id="folder" class="demo">
                  <ul>
                    <li data-jstree='{ "opened" : true }'>Root node
                    <ul>
                      <li data-jstree='{ "selected" : true }'>Child node 1</li>
                      <li>Child node 2</li>
                    </ul>
                  </li>
                  </ul>
                </div>
            </div>
          </div>
        </div>

        
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">     <h3 class="card-title">Recently Updated</h3>  </div>
            <div class="card-content collapse show">
              <div class="table-responsive">
                <table class="table table mb-0">
                  <thead>
                  <tr>
                    <th>Filename</th>
                    <th>Download</th>
                    <th>Assigned User</th>
                    <th>Updated</th>
                  </tr>
                  </thead>
                  <tbody>
                     @forelse ($latestdocuments as $doc)
                    <tr>
                      <td><a href="{{ route('documents.view',$doc->id) }}">{{$doc->filename}}</a></td>
                      <td>No link available</td>
                      <td>{{$doc->user->name}}</td>
                      <td>{{date("F j, Y, g:i a", strtotime($doc->created_at))}}</td>
                    </tr>
                    @empty
                      No document Available
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
    </div> -->


    @endif