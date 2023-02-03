<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewDocumentVersion extends Model
{
    //
 	protected $fillable=['version_number', 'document_id', 'requisition_id', 'name', 'document_type_id', 'cover_page', 'content', 'workflow_id', 'expire_on', 'grace_period', 'vendor_id', 'stage_id', 'created_by'];
   
    
    public function document()
    {
    	return $this->belongsTo('\App\NewDocument','document_id');
    }
    
    public function requisition()
    {
        return $this->belongsTo('\App\Requisition','requisition_id');
    }
    
    public function workflow()
    {
    	return $this->belongsTo('\App\Workflow','workflow_id');
    }
    
    public function document_type()
    {
    	return $this->belongsTo('\App\RequisitionType','document_type_id');
    }
    
    public function vendor()
    {
    	return $this->belongsTo('\App\Vendor','vendor_id');
    }
    
    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }
}
