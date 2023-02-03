	
	@forelse($bid_docs as $bid_doc)
		<div class="col-xl-6 col-md-6 col-sm-12" style="overflow: hidden;">
			<a class="pull-right" data-toggle="tooltip" title="Click to Download Document" id="{{$bid_doc->id}}" 
				href="{{URL::asset($bid_doc->file_path.'/'.$bid_doc->file_name)}}" 
				download="{{URL::asset($bid_doc->file_path.'/'.$bid_doc->file_name)}}">
				{{-- <i class="la la-download" aria-hidden="true" style="font-size:13px"> </i> --}}  
					<div class="card pull-up" style="height: 150px; background: url({{ asset('assets/images/compress_doc.jpg') }});">   
						<div class="card-content">  
							<div class="card-body">  
								<h4 class="card-title">{{$bid_doc->file_name}}</h4>  
							</div>  
						</div> 
					</div> 
			</a> 
		</div>
	@empty

	@endforelse