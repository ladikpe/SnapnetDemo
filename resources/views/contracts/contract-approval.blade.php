{{-- template index --}}
@extends('layouts.app')
  @section('stylesheets')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
  @endsection
@section('content')

<style>
  html body .la
  {
    font-size: 13px; padding: 0px 2px;
  }
</style>

<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<div class="row">
  <div class="col-md-12">  
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">     
              <h3 class="card-title" id="basic-layout-form"> 
                <div class="row" style="margin-top: -10px">
                  <div class="col-md-9" style="">
                    Contract For Approvals 
                  </div> 
                  <div class="col-md-3" style="">
                    <form method="get" action="{{ route('contracts.reviews') }}">
                      <fieldset>
                        <div class="input-group">
                          <input type="text" class="form-control" name="search" placeholder="Search ... " value="{{ Request::get('search') }}">
                          <div class="input-group-append">
                            <button class="btn btn-default btn-sm" type="submit"><i class="la la-search"></i></button>
                          </div>
                        </div>
                      </fieldset>
                    </form>                    
                  </div>                  
                </div>

               </h3>
              <div class="media d-flex">

                <div class="table-responsive">
                  <table class="table table-sm mb-0">
                    <thead class="thead-dark">
                      <tr>
                        <th>Name</th>
                        <th>Stage</th>
                        <th>Position</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($reviews as $review)
                        <tr>
                          <td>{{$review->contract->name}}</td>
                          <td>{{$review->stage->name}}</td></td>
                          <td>{{$review->stage->position+1}}</td></td>
                          <td>{{$review->contract->user->name}}</td>
                          <td>{{date('M, j Y h:i:s a',strtotime($review->contract->created_at))}}</td>
                          <td>
                            <a class="btn btn-sm" href="{{url('approve_contract/'.$review->id)}}" style="font-size:11px">
                            <i class="la la-check-square-o" data-toggle="tooltip" title="Go To Approval"></i>  </a>
                          </td>
                        </tr>
                      @empty
                        No Record                        
                      @endforelse
                  </tbody> 
                  </table>                 
                </div>                

              </div>
            </div>
          </div>
        </div>
    </div>
</div>








@endsection

@section('scripts')
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tag-inputs/bootstrap-tagsinput.min.js')}}"></script>
{{-- <script src="{{asset('dropzone/dropzone.js')}}"></script> --}}
<script type="text/javascript">
</script>
@endsection
