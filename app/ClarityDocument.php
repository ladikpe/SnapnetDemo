<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClarityDocument extends Model
{
    //
    // protected $table='clarity_document';
    protected $fillable = ['clarity_request_id', 'clarity_response_id', 'document_name', 'document_path', 'uploaded_by'];



    public function clarity()
    {
        return $this->belongsTo('\App\RequisitionClarity', 'clarity_request_id');
    }

    public function uploader()
    {
        return $this->belongsTo('\App\User', 'uploaded_by');
    }
}
