<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractDetail extends Model
{
   protected $fillable=['contract_id', 'version_parent_id', 'version_comment', 'cover_page', 'content', 'updatable_id', 'updatable_type'];
   public function contract()
    {
    	return $this->belongsTo('\App\Contract','contract_id');
    }
    public function parent()
    {
    	return $this->belongsTo('\App\ContractDetail','version_parent_id');
    }
    // public function user()
    // {
    // 	return $this->belongsTo('\App\User','updated_by');
    // }
    public function updatable()
    {
        return $this->morphTo();
    }
}
