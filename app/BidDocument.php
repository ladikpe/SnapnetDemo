<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidDocument extends Model
{
    //
 	protected $fillable=['bid_id', 'name', 'doc_name', 'path', 'status_id', 'created_by'];
   
    
    
    public function bid()
    {
    	return $this->belongsTo('\App\Bid','bid_id');
    }
    
    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
}
