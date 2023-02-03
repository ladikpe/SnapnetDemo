<?php 

namespace App\Actions;

use Auth;

class ContractAction{

    private $rpp = 15;

  

    function index($model)
    {
      return [
          'contracts'=>$model->where('status',1)->orWhere('user_id',\Auth::user()->id)->orderBy('created_at','desc')->paginate($this->rpp)
      ];   

    }
    function create($model)
    {
      return [
         
          'template'=>$model
      ];   

    }

     
    private function save($model,$request,$skip=false){
      
       

       

       


    }


    function store($model,$request){

       $this->save($model,$request); 
    
       return [
           'message'=>'New Contract Created',
           'data'=>$model
       ];
    }


    function update($model,$request){
        $this->save($model,$request,$skip=true);      
        return [
            'message'=>'Contract Updated',
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