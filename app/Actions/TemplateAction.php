<?php 

namespace App\Actions;

use Auth;

class TemplateAction{

    private $rpp = 5;

  

    function index($model){
      return [
          'data'=>$model->paginate($this->rpp)
      ];   

    }

     
    private function save($model,$request,$skip=false){
        $model->name = $request->name;
        $model->cover_page = $request->cover_page;
        $model->content = $request->content;
        if (!$skip)$model->created_by = Auth::user()->id;
        $model->updated_by = Auth::user()->id;
 
        $model->save(); 
    }


    function store($model,$request){

       $this->save($model,$request); 
    
       return [
           'message'=>'New Template Created',
           'data'=>$model
       ];
    }


    function update($model,$request){
        $this->save($model,$request,$skip=true);      
        return [
            'message'=>'Template Updated',
            'data'=>$model
        ];
 
    }

    function destroy($model){
      $model->delete();
      return [
          'data'=>$model,
          'message'=>'Template removed.'
      ];
    }

    function edit($model){


    }



       





}