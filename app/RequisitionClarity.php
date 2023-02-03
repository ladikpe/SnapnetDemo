<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionClarity extends Model
{
    //
 	protected $fillable=['requisition_id', 'requestor_id', 'clarity', 'response', 'status_id', 'created_by'];
       
    
    public function requisition()
    {
    	return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function requestor()
    {
    	return $this->belongsTo('\App\User','requestor_id');
    }

    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
    
}
