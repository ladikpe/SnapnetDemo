<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    //fillable
 	protected $fillable=['name','description','created_by'];

    
    
    public function ContractType()
    {
    	return $this->hasMany('\App\ContractType','contract_type');
    }
}
