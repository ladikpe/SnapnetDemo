<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentDecline extends Model
{
    //
 	protected $fillable=['document_id', 'comment', 'status_id', 'created_by'];
   
    
    
    public function document()
    {
    	return $this->belongsTo('\App\NewDocument','document_id');
    }
    
    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }

}
