<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionType extends Model
{
    //
    
    public function RequisitionType()
    {
    	return $this->hasMany('\App\RequisitionType','requisition_type_id');
    }
}
