<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkorderDetail extends Model
{
    //    
    protected $fillable=['workorder_id', 'type', 'item', 'colume_1', 'colume_2', 'line_total', 'created_by'];



    public function workorder()
    {
        return $this->belongsTo('\App\Workorder','workorder_id');
    }
}
