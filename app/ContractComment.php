<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractComment extends Model
{

 	protected $fillable=['contract_id','comment','commentable_id','commentable_type'];
   
    public function contract()
    {
    	return $this->belongsTo('\App\Contract','contract_id');
    }
    // public function author()
    // {
    // 	return $this->belongsTo('\App\User','user_id');
    // }
    public function commentable()
    {
        return $this->morphTo();
    }
    
    
    
}
