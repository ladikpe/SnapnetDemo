<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractSignature extends Model
{
    //
 	protected $fillable = ['contract_id', 'signature', 'signable_id', 'signable_type'];

    public function signable()
    {
        return $this->morphTo();
    }
}
