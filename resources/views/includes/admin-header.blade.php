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
        <li class="{{ isActiveRoute('home') }}"><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
        <li><a href="#"><i class="fa fa-book">&nbsp;Audit Logs</i></a></li>
        <li>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i>&nbsp;Documents<b class="caret"></b></a>
        <ul class="dropdown-menu">
          {{-- <li><a href="#">Batch Upload</a></li> --}}
          <li><a href="{{ route('documents.create') }}"><i class="fa fa-plus-square"></i>&nbsp;Create</a></li>
          <li><a href="{{ route('documents') }}"><i class="fa fa-list-alt"></i>&nbsp;List</a></li>
          {{-- <li><a href="#">Revisions</a></li> --}}
        </ul>
      </li>
      <li class="{{ areActiveRoutes(['template.index','contracts.index','contracts.reviews','contracts.dashboard','contracts.show']) }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i>&nbsp;Contracts<b class="caret"></b></a>
        <ul class="dropdown-menu">
          {{-- <li><a href="#">Batch Upload</a></li> --}}
          <li class="{{ isActiveRoute('contracts.index') }}"><a href="{{ url('contracts') }}"><i class="fa fa-file"></i>&nbsp;Contracts</a></li>
           <li class="{{ isActiveRoute('contracts.reviews') }}"><a href="{{ url('contract_approvals') }}"><i class="fa fa-file"></i>&nbsp;Contract Approvals</a></li>
           <li class="{{ isActiveRoute('contracts.dashboard') }}"><a href="{{ url('contracts/dashboard') }}"><i class="fa fa-file"></i>&nbsp;Contract Dashboard</a></li>
          <li class="{{ isActiveRoute('template.index') }}"><a href="{{ route('template.index') }}"><i class="fa fa-file"></i>&nbsp;Templates</a></li>
          {{-- <li><a href="#">Revisions</a></li> --}}
        </ul>
      </li>
        <li><a href="{{route('documents.reviews')}}"><i class="fa fa-check-square-o"></i>&nbsp;Reviews</a></li>
        <li class="{{ isActiveRoute('folders')||isActiveRoute('groups')||isActiveRoute('workflows') }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"</i>>&nbsp;Settings<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="{{ route('folders') }}"><i class="fa fa-folder"></i>&nbsp;Folders</a></li>
          <li><a href="{{ route('groups') }}"><i class="fa fa-object-group"></i>&nbsp;Groups</a></li>
          <li><a href="#"><i class="fa fa-tags"></i>&nbsp;Tags</a></li>
          <li><a href="{{ route('workflows') }}"><i class="fa  fa-forward"></i>&nbsp;Workflows</a></li>
        </ul>
      </li>
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
        <li>
            <a>
              <i class="fa fa-bell">Notifications</i>
            </a>

        </li>
        <li {{ isActiveRoute('users.profile') }}><a href="{{route('users.profile')}}"><i class="fa fa-user">&nbsp;{{ Auth::user()->name }}&nbsp;(Admin)</i></a></li>
        <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();"><i class="fa fa-sign-out">&nbsp;
                Logout</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
