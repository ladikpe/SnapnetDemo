<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderRequisition extends Model
{
    //
    protected $fillable=['requisition_no', 'name', 'description', 'deadline', 'assigned_to', 'status_id', 'created_by'];

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

    public function assign()
    {
        return $this->belongsTo('\App\User','assigned_to');
    }
}
