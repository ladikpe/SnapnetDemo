<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends  Authenticatable
{
    use Notifiable;

    protected  $guard = 'vendor';


    //
 	protected $fillable=['vendor_code', 'name', 'email', 'password', 'phone', 'category', 'contact_name', 'address', 'address_2', 'state_id', 'country_id', 'website', 'vat_number', 'fax_number', 'bank_name', 'account_number', 'company_info', 'status', 'remember_token', 'created_by', 'approved_by', 'approved_at'];
    
    
    public function author()
    {
    	return $this->belongsTo('\App\User', 'created_by');
    }

    public function Contract()
    {
    	return $this->hasMany('\App\Contract', 'vendor_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
    public function details()
    {
        return $this->morphMany('App\ContractDetail', 'updatable');
    }

    public function signatures()
    {
        return $this->morphMany('App\ContractSignature', 'signable');
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function VendorShortlist()
    {
        return $this->hasMany('\App\VendorShortlist', 'vendor_id');
    }
}
