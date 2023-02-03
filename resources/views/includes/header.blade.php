<style type="text/css">
  .search-dropdown{
    min-height: 200px;
   position: absolute;
    top: 100%;
    z-index: 100;
    left: 0px;
    right: auto;
    display: block;
    width: 600px;
   
    background-color: #fff;
    border: 2px solid rgba(228, 228, 228, 0.6);
    border-top-width: 0;
    font-family: 'Montserrat', sans-serif;
   
    margin-top: 10px;
    box-shadow: 4px 4px 0 rgba(241, 241, 241, 0.35);
    font-size: 11px;
    border-radius: 4px;
    box-sizing: border-box;
    display:none;
  }

  .searchtype-box{
    display: inline-block;
     width: 49%; 
     vertical-align: top;
  }
  .searchtype-header{
    text-transform: uppercase;
    border-bottom: 2px solid rgba(228, 228, 228, 0.6);
    border-top: 2px solid rgba(228, 228, 228, 0.6);
     padding: 10px;
     color: #a9a9a9;
     padding: 6px 12px;
     text-align: left;
  }
  .search-suggestions-container{
    display: block;
  }

   .search-suggestions{
    padding: 6px 12px!important;
    border-bottom: 0!important;
    font-size: 1rem!important;
    cursor: pointer;
    -webkit-transition: .2s;
    transition: .2s;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
  }

</style>


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
        <li class="{{ isActiveRoute('auditlogs') }}"><a href="{{route('auditlogs')}}"><i class="fa fa-book"></i>&nbsp;Audit Logs</a></li>
        <li class="{{ areActiveRoutes(['documents.create','documents','documents.view']) }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i>&nbsp;Documents<b class="caret"></b></a>
        <ul class="dropdown-menu">
          {{-- <li><a href="#">Batch Upload</a></li> --}}
          <li class="{{ isActiveRoute('documents.create') }}"><a href="{{ route('documents.create') }}"><i class="fa fa-plus-square"></i>&nbsp;Create</a></li>
          <li class="{{ isActiveRoute('documents') }}"><a href="{{ route('documents') }}"><i class="fa fa-list-alt"></i>&nbsp;List</a></li>
          {{-- <li><a href="#">Revisions</a></li> --}}
        </ul>
      </li>
        <li class="{{ isActiveRoute('documents.reviews') }}"><a href="{{route('documents.reviews')}}"><i class="fa fa-check-square-o"></i>&nbsp;Reviews</a></li>
        {{-- <li class="{{ isActiveRoute('template.index') }}"><a href="{{route('template.index')}}"><i class="fa fa-file"></i>&nbsp;Templates</a></li> --}}
        <li class="{{ areActiveRoutes(['template.index','contracts.index','contracts.reviews','contracts.reviews','contracts.show','contracts.dashboard']) }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i>&nbsp;Contracts<b class="caret"></b></a>
        <ul class="dropdown-menu">
          {{-- <li><a href="#">Batch Upload</a></li> --}}
          <li class="{{ isActiveRoute('contracts.index') }}"><a href="{{ url('contracts') }}"><i class="fa fa-file"></i>&nbsp;Contracts</a></li>

           <li class="{{ isActiveRoute('contracts.reviews') }}"><a href="{{ url('contract_approvals') }}"><i class="fa fa-file"></i>&nbsp;Contract Approvals</a></li>
           <li class="{{ isActiveRoute('contracts.requisitions') }}"><a href="{{ url('contracts/requisitions') }}"><i class="fa fa-file"></i>&nbsp;Contract Requests</a></li>
            <li class="{{ isActiveRoute('contracts.dashboard') }}"><a href="{{ url('contracts/dashboard') }}"><i class="fa fa-file"></i>&nbsp;Contract Dashboard</a></li>
          <li class="{{ isActiveRoute('template.index') }}"><a href="{{ route('template.index') }}"><i class="fa fa-file"></i>&nbsp;Templates</a></li>
          {{-- <li><a href="#">Revisions</a></li> --}}
        </ul>
      </li>
        <li class="{{ areActiveRoutes(['folders','folders.create','groups','groups.create','groups.edit','groups.view','users','users.create','users.edit','users.view','workflows','workflows.create','workflows.edit','workflows.view','tags'])  }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i>&nbsp;Settings<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="{{ route('folders') }}"><i class="fa fa-folder"></i>&nbsp;Folders</a></li>
          <li><a href="{{ route('groups') }}"><i class="fa fa-object-group"></i>&nbsp;Groups</a></li>
          <li><a href="{{ route('contract_categories') }}"><i class="fa fa-object-group"></i>&nbsp;Contract Categories</a></li>
          <li><a href="#"><i class="fa fa-tags"></i>&nbsp;Tags</a></li>
          <li><a href="{{ route('users') }}"<i class="fa fa-users"></i>&nbsp;Users</a></li>
          <li><a href="{{ route('workflows') }}"><i class="fa  fa-forward"></i>&nbsp;Workflows</a></li>
          <li><a href="{{ route('performance.index') }}"><i class="fa fa-align-center"></i>&nbsp;Performance Settings</a></li>
        </ul>
      </li>
      </ul>
      <div class="col-sm-3 col-md-3">
    <form class="navbar-form" role="search" action="{{route('search')}}" method="get">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Documents" name="q" value="{{ request()->q }}" autocomplete="off">
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </div>
    <div  class="search-dropdown">
 
    
    <div style="" class="searchtype-box" >
     <div style=" " class="searchtype-header">Documents</div>
     <span style="" class="search-suggestions-container">
       <div style="" class="search-suggestions">
      Document name
    </div>
    <div style="" class="search-suggestions">
       Another Document name
    </div>
     </span> 

    </div>
    

    <div style="" class="searchtype-box" >
     <div style=" " class="searchtype-header">Contracts</div>
     <span style="" class="search-suggestions-container">
       <div style="" class="search-suggestions">
      Contract name
    </div>
     </span> 

    </div>
    
  
 
    

  </div>
  

    </form>
</div>
      <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i><span class="badge badge-light">{{ Auth::user()->notifications->count() }}</span>
            <b class="caret"></b></a>
            <ul class="dropdown-menu">
              @foreach (Auth::user()->notifications as $notification)
                @if ($notification->data['type']=="Review")
                  <div class=" noti-div">


                <li class="noti-item"><a href="{{ $notification->data['action'] }}"><i class="fa fa-edit"></i> &nbsp;{{ $notification->data['subject'] }}</a></li>
                </div>
                @endif

              @endforeach

              </ul>
        </li>
        <li class="{{ isActiveRoute('users.profile') }}"><a href="{{route('users.profile')}}"><i class="fa fa-user"></i>&nbsp;{{ Auth::user()->name }}</a></li>
        <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>&nbsp;
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
