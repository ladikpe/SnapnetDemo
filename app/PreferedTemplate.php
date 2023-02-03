<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferedTemplate extends Model
{
    //
    protected $fillable=['requisition_id', 'template_name', 'template_path', 'template_contents', 'user_id', 'created_by'];


    public function requisition()
    {
        return $this->belongsTo('\App\Requisition','requisition_id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User','user_id');
    }

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }
}
