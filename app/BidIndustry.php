<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidIndustry extends Model
{
    //
 	protected $fillable=['name', 'created_by'];
   
    
    
    public function bid()
    {
    	return $this->HasMany('\App\Bid','industry_id');
    }
}
