<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchForBidder extends Model
{
    //
    protected $fillable = ['bid_id', 'vendor_id', 'category', 'proximity', 'rating', 'bid_invites', 'bid_submited', 'bid_awarded'];



    public function bid()
    {
      return $this->belongsTo('App\Bid', 'bid_id');
    }

    public function vendor()
    {
      return $this->belongsTo('App\Vendor', 'vendor_id');
    }
}
