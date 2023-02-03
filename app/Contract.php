<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;



class Contract extends Model
{
	use LogsActivity;

    protected $fillable = ['name', 'expires', 'grace_period', 'length', 'started', 'status', 'workflow_id', 'user_id', 'contract_category_id', 'requisition_id', 'vendor_id','vendor_approved','vendor_key','vendor_key_expires'];
    protected static $logAttributes = ['*'];
    
    
    protected static $logOnlyDirty = true;

    public function contract_details()
    {
    	return $this->hasMany('\App\ContractDetail','contract_id');
    }
    public function contract_reviews()
    {
    	return $this->hasMany('\App\ContractReview','contract_id');
    }
    public function comments()
    {
        return $this->hasMany('\App\ContractComment','contract_id');
    }
    public function files()
    {
        return $this->hasMany('\App\File','contract_id');
    }
    public function workflow()
    {
    	return $this->belongsTo('\App\Workflow','workflow_id');
    }
    public function contract_category()
    {
        return $this->belongsTo('\App\ContractCategory','contract_category_id');
    }
    public function groups()
    {
        return $this->belongsToMany('\App\Group','contract_group_access','contract_id','group_id')->withPivot('permission_id');
    }
    public function user()
    {
       return $this->belongsTo('\App\User','user_id');
    }
    public function requisition()
    {
       return $this->belongsTo('\App\Requisition', 'requisition_id');
    }
     public function tags()
    {
      return $this->belongsToMany('App\Tag');
    }


    public function vendor()
    {
       return $this->belongsTo('\App\Vendor', 'vendor_id');
    }

    public function ContractPerformance()
    {
        return $this->hasMany('\App\ContractPerformance', 'contract_id');
    }


    public function contract_signatures()
    {
        return $this->hasMany('\App\ContractSignature','contract_id');
    }

    public function Status()
    {
       return $this->belongsTo('\App\Status', 'status');
    }

    // public function getCertainDateAttribute()
    // {
    //     //implent this method to return the difference you need
    //     //for example, return the difference between created timestamp and now
    //     $now = Carbon::now();
    //     return $this->created_at->diffInDays($now);
    // }
}
