<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidMessage extends Model
{
    //
 	protected $fillable=['bid_id', 'message', 'created_by'];
   
    
    
    public function bid()
    {
    	return $this->belongsTo('\App\Bid','bid_id');
    }
}
