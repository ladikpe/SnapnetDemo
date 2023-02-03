<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    protected $fillable=['requisition_id', 'workflow_id', 'position_id'];

    public function requisition()
    {
        return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function workflow()
    {
        return $this->belongsTo('\App\Workflow','workflow_id');
    }

}
