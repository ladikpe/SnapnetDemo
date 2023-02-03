<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
    //
    protected $fillable = ['department_id', 'department_head_id', 'purpose', 'description', 'request_type', 'document_path', 'document_name', 'status_id', 'created_by'];



    public function type()
    {
        return $this->belongsTo('\App\RequisitionType', 'request_type');
    }

    public function department()
    {
        return $this->belongsTo('\App\Department', 'department_id');
    }

    public function department_head()
    {
        return $this->belongsTo('\App\User', 'department_head_id');
    }

    public function author()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }
}
