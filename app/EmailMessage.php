<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model
{
    //
    //
    protected $fillable=['header', 'title', 'message', 'created_by'];


    public function author()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
