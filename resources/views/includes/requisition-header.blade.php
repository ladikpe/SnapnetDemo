<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="{{ asset('logo.png') }}" alt="pali365" style="height:30px; width:auto;">  </a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="{{ isActiveRoute('contracts.requisitions') }}"><a href="{{ route('contracts.requisitions') }}"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
        
        

      </ul>
      <div class="col-sm-3 col-md-3">
    <form class="navbar-form" role="search" action="{{route('search')}}" method="get">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Documents" name="q" value="{{ request()->q }}">
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </div>
    </form>
</div>
      <ul class="nav navbar-nav navbar-right">
        <li class="{{ isActiveRoute('users.profile') }}"><a href="{{route('users.profile')}}"><i class="fa fa-user"></i>&nbsp;{{ Auth::user()->name }}&nbsp;(User)</a></li>
        <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"><i class="fa fa-sign-out">&nbsp;
                                        </i>Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
