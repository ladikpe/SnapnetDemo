<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{

    protected $fillable = ['google_doc_id', 'requisition_code', 'requisition_type_id', 'contract_type', 'name', 'title', 'description', 'deadline', 'department_id', 'user_id', 'assigned', 'contract_created', 'status_id', 'workflow_id', 'start', 'end', 'template_path', 'template_name', 'document_path', 'document_name'];



    public function type()
    {
        return $this->belongsTo('\App\RequisitionType', 'requisition_type_id');
    }

    public function contractType()
    {
        return $this->belongsTo('\App\ContractType', 'contract_type');
    }

    public function department()
    {
        return $this->belongsTo('\App\Department', 'department_id');
    }

    public function author()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function assign()
    {
        return $this->belongsTo('\App\User', 'assigned');
    }

    public function status()
    {
        return $this->belongsTo('\App\Status', 'status_id');
    }

    public function workflow()
    {
        return $this->belongsTo('\App\Workflow', 'workflow_id');
    }



    public function contract()
    {
        return $this->hasOne('\App\Contract', 'requisition_id');
    }


    //function to return requisition stage
    // function getRequisitionStage()
    // {

    // }



}
