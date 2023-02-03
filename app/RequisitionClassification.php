<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionClassification extends Model
{
    //
 	protected $fillable=['requisition_id', 'priority', 'sensitivity', 'urgency', 'assigned_to', 'status', 'requestor_id', 'assigned_by'];
       
    
    public function requisition()
    {
    	return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function requestor()
    {
    	return $this->belongsTo('\App\User','requestor_id');
    }

    public function assigned()
    {
    	return $this->belongsTo('\App\User','assigned_to');
    }

    public function assignor()
    {
    	return $this->belongsTo('\App\User','assigned_by');
    }
}
