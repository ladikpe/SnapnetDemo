<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignContractToUser extends Model
{
    //
    protected $table = 'contract_to_users';

    protected $fillable = ['user_id', 'reviewer_id', 'approver_id', 'requisition_id', 'created_by'];

    public function user()
    {
    	return $this->belongsTo('\App\User', 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo('\App\User', 'reviewer_id');
    }

    public function approver()
    {
        return $this->belongsTo('\App\User', 'approver_id');
    }
    
    public function requisition()
    {
    	return $this->belongsTo('\App\Requisition', 'requisition_id');
    }
    
    public function author()
    {
    	return $this->belongsTo('\App\User', 'created_by');
    }
}
