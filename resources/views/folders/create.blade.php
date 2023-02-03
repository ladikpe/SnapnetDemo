@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('multiselect/css/multi-select.css') }}" rel="stylesheet" />
  <style media="screen">
  .custom-header{
text-align: center;
padding: 3px;
background: #000;
color: #fff;
}


#ms-searchable.ms-container{
background-position: 168px 110px;
}

input.search-input{
box-sizing: border-box;
-moz-box-sizing:border-box;
width: 100%;
margin-bottom: 5px;
height: auto;
}
  </style>
@endsection
@section('content')
  <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h4><span class="glyphicon folder-open" aria-hidden="true"></span> Create Folder <small>Your Files, Anytime, Anywhere.....</small></h4>
          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Admin/Folders/Create</li>
        </ol>
      </div>
    </section>

    <section id="main"  style="min-height:480px;">
      <div class="container">
        <div class="row">

          <div class="col-md-9">
            <!-- Website Overview -->

            @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                        {{ session('success') }}
                    </div>
                @endif
            <form class="form-horizontal" method="POST" action="{{ route('folders.save') }}">
              {{ csrf_field() }}
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title">Folder Details</h3>
                </div>

                <div class="panel-body">


                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                  </div>

                  <div class="form-group">
                    <label for="">Folder Group Access</label>

                    <select id='groups'  multiple='multiple' name="group_id[]">
                      @forelse ($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                      @empty
                        <option value="">No Groups Created</option>
                      @endforelse
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Folder User Access</label>

                    <select id="users" multiple='multiple' name="user_id[]">
                      @forelse ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                      @empty
                        <option value="">No Users Created</option>
                      @endforelse
                    </select>
                  </div>


                                  </div>
                <div class="panel-footer">
                  <button type="submit" class="btn btn-primary">
                      Create Folder
                  </button>

                </div>
                </div>
                </form>





              <!-- Latest Users -->

          </div>
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading main-color-bg">
              <h3 class="panel-title">Folders</h3>
            </div>
            <div class="panel-body">
              <div id="data" class="demo"></div>

            </div>
            </div>
        </div>
        </div>



      </div>
    </section>
@endsection
@section('scripts')
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('multiselect/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('js/jquery.quicksearch.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.group-multiple').select2();

  $('#groups').multiSelect({
  selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=''>",
  selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=''>",
  selectableFooter: "<div class='custom-header'>Deny</div>",
  selectionFooter: "<div class='custom-header'>Allow</div>",
  afterInit: function(ms){
    var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
    .on('keydown', function(e){
      if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
});

$('#users').multiSelect({
selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=''>",
selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=''>",
selectableFooter: "<div class='custom-header'>Deny</div>",
selectionFooter: "<div class='custom-header'>Allow</div>",
afterInit: function(ms){
  var that = this,
      $selectableSearch = that.$selectableUl.prev(),
      $selectionSearch = that.$selectionUl.prev(),
      selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
      selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

  that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
  .on('keydown', function(e){
    if (e.which === 40){
      that.$selectableUl.focus();
      return false;
    }
  });

  that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
  .on('keydown', function(e){
    if (e.which == 40){
      that.$selectionUl.focus();
      return false;
    }
  });
},
afterSelect: function(){
  this.qs1.cache();
  this.qs2.cache();
},
afterDeselect: function(){
  this.qs1.cache();
  this.qs2.cache();
}
});
});
</script>
@endsection
