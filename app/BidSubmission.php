<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidSubmission extends Model
{
    //
 	protected $fillable=['bid_id', 'vendor_id', 'note', 'status_id'];
   
    
    
    public function bid()
    {
    	return $this->belongsTo('\App\Bid','bid_id');
    }
    
    public function vendor()
    {
    	return $this->belongsTo('\App\Vendor','vendor_id');
    }
}
