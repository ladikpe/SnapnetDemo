<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    //    
    protected $fillable=['workorder_code', 'requisition_id', 'name', 'description', 'header', 'comment', 'content', 'content_complete', 'status_id', 'vat', 'created_by', 'approved_by', 'approved_at'];



    public function requisition()
    {
        return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

    public function approver()
    {
        return $this->belongsTo('\App\User','approved_by');
    }
}
