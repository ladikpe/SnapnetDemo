<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDocument extends Model
{
    //
 	protected $fillable=['vendor_id', 'type_id', 'name', 'document_path', 'file_name', 'expiry_date', 'created_by'];
    
    
    public function vendor()
    {
    	return $this->belongsTo('\App\Vendor', 'vendor_id');
    }
    
    public function type()
    {
    	return $this->belongsTo('\App\VendorDocumentType', 'type_id');
    }

}
