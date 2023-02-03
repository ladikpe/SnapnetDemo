<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementAndFiling extends Model
{
    //    protected $table = 'contract_to_users';

    protected $fillable = ['title', 'description', 'start', 'end', 'start_time', 'end_time','recurring', 'monthly', 'quarterly', 'bi_annually', 'yearly', 'document_name', 'document_path',  'created_by'];


    public function author()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
