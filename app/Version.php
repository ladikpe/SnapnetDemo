<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    //
    protected $fillable=['document_id', 'version_no', 'name', 'contents', 'assigned_to', 'status_id', 'created_by'];

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

    public function assign()
    {
        return $this->belongsTo('\App\User','assigned_to');
    }
}
