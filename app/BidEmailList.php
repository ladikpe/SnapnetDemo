<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidEmailList extends Model
{
    //
 	protected $fillable=['bid_id', 'user_id', 'created_by'];
   
    
    
    public function bid()
    {
    	return $this->belongsTo('\App\Bid','bid_id');
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
