<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable=['document_id', 'name', 'comment', 'user_id', 'created_by'];

//    public function document()
//    {
//        return $this->belongsTo('\App\User','document_id');
//    }

    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

    public function recipient()
    {
        return $this->belongsTo('\App\User','user_id');
    }
}
