<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewDocument extends Model
{
    // 
 	protected $fillable=['google_doc_id', 'document_code', 'requisition_id', 'name', 'document_type_id', 'cover_page', 'content', 'workflow_id', 'expire_on', 'grace_period', 'grace_end', 'vendor_id', 'stage_id', 'reviewed_approved', 'title', 'start', 'end', 'created_by'];
   
    
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
    
    public function stage()
    {
        return $this->belongsTo('\App\Stage','stage_id');
    }
}
