<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorShortlist extends Model
{
    //
    protected $fillable=['vendor_id', 'document_id', 'status_id', 'created_by'];


    public function vendor()
    {
        return $this->belongsTo('\App\Vendor', 'vendor_id');
    }

    public function shortlist()
    {
        return $this->belongsTo('\App\VendorShortlist', 'vendor_id');
    }
}
