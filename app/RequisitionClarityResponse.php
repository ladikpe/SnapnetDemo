<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionClarityResponse extends Model
{
    //
 	protected $fillable=['requisition_id', 'type', 'user_id', 'message', 'created_by'];
       
    
    public function requisition()
    {
    	return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function requestor()
    {
    	return $this->belongsTo('\App\User','user_id');
    }

    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
    
}
