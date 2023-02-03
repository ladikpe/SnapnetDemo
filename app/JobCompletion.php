<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCompletion extends Model
{
    //  
    protected $fillable = ['completion_code', 'name', 'description', 'content', 'status_id', 'created_by', 'approved_by', 'approved_at'];


    
    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
    
    public function approver()
    {
    	return $this->belongsTo('\App\User','approved_by');
    }
}
