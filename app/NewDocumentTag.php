<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewDocumentTag extends Model
{
    //
    protected $fillable=['document_id', 'tag', 'created_by'];

    public function document()
    {
        return $this->belongsTo('\App\NewDocument','document_id');
    }
}
