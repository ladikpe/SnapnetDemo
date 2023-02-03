<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable=['requisition_id', 'purchase_order_no', 'name', 'contents', 'description', 'deadline', 'assigned_to', 'status_id', 'created_by', 'approved_by', 'approved_at'];

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

    public function assign()
    {
        return $this->belongsTo('\App\User','assigned_to');
    }

}
