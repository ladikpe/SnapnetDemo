{{-- template index --}}
@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('tag-inputs/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endsection
@section('content')



<script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>

<div class="row">   
        <div class="card">
          <div class="card-content">
            <div class="card-body"> <h4 class="title"> Templates </h4> 
              <div class="media d-flex">

                <!-- <h3 class="panel-title">Template Lists</h3> -->
                        
                      <div class="col-md-12" style="">                        
                              
                              @foreach ($data as $item)
                              <a href="#">
                              <div class="col-md-4 col-xl-3 col-sm-6 pull-left">

                                  <div data-hover="{{ $item->id }}" class="row" style="padding: 7px;">
                                      <div class="col-xs-12 mb-2" style="
                                      border: 1px solid #bbb;
                                      height: 194px;
                                      font-size: 7px;
                                      box-shadow: 4px 5px #aba0a0;
                                      position: relative;
                                      /* overflow-y: hidden; */
                                      width: 64%;
                                      padding: 5px;
                                      margin-left: 16%;">
                                      

                                        
                                        <div data-tool id="tool{{ $item->id }}" style="position: absolute;top: 46%;left: 25%; display: none">
                                            <a href="{{url('contracts/create?template='.$item->id.'&requisition='.request()->requisition_id)}}"  class="btn btn-sm btn-info" title="Use Template">
                                                <i class="fa fa-pencil">Use</i>
                                            </a>
                                                  
                                            <a id="workflow" href="#" class="btn btn-sm btn-success" style="color: #fff;" title="Preview template">
                                                  <i class="fa fa-eye">View</i>    
                                            </a>        
                                        </div>

                                        <div style="overflow: hidden;height: 177px;">
                                              {!! $item->cover_page !!}                           
                                        </div>


                                      </div>

                                  </div>

                                  <span style="padding: 5px;
                                      margin-left: 16%;font-weight: 800;">{{$item->name}}</span>                                  
                                  </div>
                                  </a>
                                  <script>
                                    var templateList = templateList || [];
                                    templateList[{{ $item->id }}] = ({!! $item->toJson() !!});

                                    var updateUrls = updateUrls || [];
                                    updateUrls[{{ $item->id }}] = "{{ route('template.update',[$item->id]) }}";

                                  </script>                       
                              @endforeach

                              <div class="row" style="padding: 7px;">
                                  <div class="col-xs-12 mb-2">
                                      {{ $data->links() }}
                                  </div>
                              </div>       

                              {{-- data --}}

                              <script type="text/html" id="put">
                                  @method('PUT')
                              </script>

                              <script>
                                (function($){

                                    function initDelete(){
                                        //remove-btn
                                        $('.remove-btn').each(function(){
                                            $(this).on('click',function(){
                                                return confirm('Do you want to remove this document?');
                                            });
                                        });
                                    }

                                    function exportHTML($html,$a,name){
                                      var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                                              "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                                              "xmlns='http://www.w3.org/TR/REC-html40'>"+
                                              "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
                                      var footer = "</body></html>";
                                      var sourceHTML = header+$html+footer;
                                      
                                      var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
                                      // var fileDownload = document.createElement("a");
                                      // document.body.appendChild(fileDownload);
                                      $a.get(0).href = source;
                                      $a.get(0).download = name + '.doc';
                                      // fileDownload.click();
                                      // document.body.removeChild(fileDownload);
                                  }                      


                                    $(function(){

                                        var $indicator = $('#indicator');
                                        var edit = false;
                                        var $frm = $('#frm');
                                        var $save = $('#btn_save');
                                        var $cancel = $('#btn_cancel');
                                        var $put = $('#put');


                                        $cancel.hide();

                                        var createUrl = '{{ route('template.store') }}';    

                                        var $formObj = {
                                          name:$('#name'),
                                          cover_page:{
                                              val:function(vl){
                                                  CKEDITOR.instances['cover_page'].setData( vl );
                                              }
                                          },
                                          content:{
                                              val:function(vl){
                                                  CKEDITOR.instances['content'].setData( vl );
                                              }
                                          }
                                        };

                                        //CKEDITOR.instances.editor1.setData( '<p>This is the editor data.</p>' );

                                        function linktoForm($data){
                                          $formObj.name.val($data.name);
                                          $formObj.cover_page.val($data.cover_page);
                                          $formObj.content.val($data.content);
                                          changeToUpdate($data.id);
                                        }

                                        function resetForm(){
                                          $formObj.name.val('');
                                          $formObj.cover_page.val('');
                                          $formObj.content.val('');
                                        }

                                        function removePut(){
                                            //<input type="hidden" name="_method" value="PUT">                
                                            $('[name=_method]').remove();
                                        }

                                        function addPut(){
                                            $frm.append($put.html());
                                        }

                                        function changeToUpdate(id){
                                          $frm.attr('action',updateUrls[id]);
                                          $save.html('Save');
                                          $cancel.show();
                                          $indicator.html('Edit Template');
                                          addPut();
                                        }

                                        function changeToCreate(){
                                          $frm.attr('action',createUrl); 
                                          $save.html('Create');
                                          $cancel.hide();
                                          resetForm();
                                          $indicator.html('Create Template');
                                          removePut();
                                        }

                                        $cancel.on('click',function(){
                                            changeToCreate();
                                        });
                                        

                                      
                                      $('[data-hover]').each(function(){
                                          
                                          var $this = $(this);
                                          var vl = $this.data('hover');
                                          var $tool = $('#tool' + vl);
                                          var $edit = $tool.find('#edit');

                                          

                                          $this.on('mouseover',function(){
                                              $tool.show();
                                          });

                                          $this.on('mouseout',function(){
                                            $tool.hide();
                                          });

                                          $edit.on('click',function(){
                                              linktoForm(templateList[vl]);
                                          });




                                      });

                                      initDelete();


                                    });
                                })(jQuery);
                              </script>

                      
                      </div>

                      <script>
                       (function($){
                         $(function(){
                             $('[data-tool]').each(function(){
                               let $this = $(this);

                               $(this).on('mouseover',function(){
                                  $this.show();
                               });

                               $(this).on('mouseout',function(){
                                  $this.hide();
                               });


                             });
                         });
                       })(jQuery);
                      </script>



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
