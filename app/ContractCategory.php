<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractCategory extends Model
{

 	protected $fillable=['name','workflow_id','created_by','updated_by'];
   
    public function contracts()
    {
    	return $this->hasMany('\App\Contract','contract_category_id');
    }
    public function workflow()
    {
        return $this->belongsTo('\App\Workflow','workflow_id');
    }
    
    
}
