<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidSubmissionFile extends Model
{
    //
 	protected $fillable=['bid_submission_id', 'bid_id', 'vendor_id', 'file_path', 'file_name'];
   
    
    
    public function submission()
    {
    	return $this->belongsTo('\App\BidSubmission','bid_submission_id');
    }
    
    public function bid()
    {
    	return $this->belongsTo('\App\Bid','bid_id');
    }
    
    public function vendor()
    {
    	return $this->belongsTo('\App\Vendor','vendor_id');
    }
}
