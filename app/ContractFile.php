<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractFile extends Model
{

 	protected $fillable=['contract_id','filename','path','user_id','size','type','description'];
   
    public function contract()
    {
    	return $this->belongsTo('\App\Contract','contract_id');
    }
    
    
    
}
