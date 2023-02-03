@extends('layouts.app')
@section('stylesheets')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />
@endsection
@section('content')

	

    
<div class="row">
  <div class="col-md-12">      
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
				  <h4>Folders</h4>
              <div class="media d-flex">


                @forelse ($folders as $folder)
                <div id="container" role="main">
                	<div id="tree"></div>

                </div>
                @empty
                There  are no Folders yet. <a href="{{route('folders.create')}}">Create One</a>
                @endforelse
              </div>
            </div>


          </div>>

          </div>
          </div>



      </div>
@endsection
@section('scripts')
  <script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script type="text/javascript">

		$(function () {
			$(window).resize(function () {
				var h = Math.max($(window).height() - 0, 420);
				$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
			}).resize();

			$('#tree')
				.jstree({
					'core' : {
						'data' : {
							'url' : '{{url('folders/get_node')}}',
							'data' : function (node) {
								return { 'id' : node.id };
							}
						},
						'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
					},
					'force_text' : true,
					'plugins' : ['state','dnd','contextmenu','wholerow']
				})
				.on('delete_node.jstree', function (e, data) {
					$.get('{{url('folders/delete_node')}}', { 'id' : data.node.id })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('create_node.jstree', function (e, data) {
					$.get('{{url('folders/create_node')}}', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
						.done(function (d) {
							data.instance.set_id(data.node, d.id);
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('rename_node.jstree', function (e, data) {
					$.get('{{url('folders/rename_node')}}', { 'id' : data.node.id, 'text' : data.text })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('move_node.jstree', function (e, data) {
					$.get('{{url('folders/move_node')}}', { 'id' : data.node.id, 'parent' : data.parent, 'position' : data.position })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('copy_node.jstree', function (e, data) {
					$.get('{{url('folders/copy_node')}}', { 'id' : data.original.id, 'parent' : data.parent, 'position' : data.position })
						.always(function () {
							data.instance.refresh();
						});
				})
				.on('changed.jstree', function (e, data) {
					if(data && data.selected && data.selected.length) {
						$.get('{{url('folders/get_content')}}&id=' + data.selected.join(':'), function (d) {
							$('#data .default').text(d.content).show();
						});
					}
					else {
						$('#data .content').hide();
						$('#data .default').text('Select a file from the tree.').show();
					}
				});
		});
		</script>

@endsection
