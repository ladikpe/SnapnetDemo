<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractReview extends Model
{

 	protected $fillable=['contract_id','stage_id','status','comment','approved_by'];
    public function stage()
    {
    	return $this->belongsTo('\App\Stage','stage_id');
    }
    public function contract()
    {
    	return $this->belongsTo('\App\Contract','contract_id');
    }
    public function approver()
    {
    	return $this->belongsTo('\App\User','approved_by');
    }
    
}
