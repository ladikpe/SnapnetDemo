<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
 	protected $fillable=['bid_code', 'name', 'description', 'instruction', 'bid_type', 'start_date', 'end_date', 'industry_id', 'countdown', 'submission_after', 'status_id', 'created_by'];
   
    
    
    public function industry()
    {
    	return $this->belongsTo('\App\BidIndustry','industry_id');
    }
    
    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
    
    public function Bid()
    {
    	return $this->hasMany('\App\Bid','bid_id');
    }
}
