<?php

namespace App\Exports;

use App\Requisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequisitionExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        if (\Auth::user()->department_id == 1) 
        {
            return Requisition::select('id', 'requisition_type_id', 'contract_type', 'name', 'deadline', 'user_id', 'assigned', 'status_id', 'executed_copy', 'workflow_id')
                            ->with(['type', 'contractType', 'author', 'assign', 'status', 'workflow']);
        } 
        else
        {
            return Requisition::select('id', 'requisition_type_id', 'contract_type', 'name', 'deadline', 'user_id', 'assigned', 'status_id', 'executed_copy', 'workflow_id')
                            ->where('user_id', \Auth::user()->id)->with(['type', 'contractType', 'author', 'assign', 'status', 'workflow']);
        }
    }


    public function headings(): array
    {
    	return [
    		'Name',
    		'Requisition Type',
    		'Contract Category',
    		'Deadline',
            'Requestor',
            'Priority',
            'Sensitivity',
            'Assigned To',
            'Executed Copy',
            'Status'
    	];
    }


    public function map($requisition): array
    {
    	return [
    		$requisition->name,
            $requisition->type ? $requisition->type->name : null,
            $requisition->contractType ? $requisition->contractType->name : null,
            date("M j, Y", strtotime($requisition->deadline)),
            $requisition->author ? $requisition->author->name : null,
            $this->getClassificationDetails($requisition, 'priority'),
            $this->getClassificationDetails($requisition, 'sensitivity'),
            $this->getAssignmentDetails($requisition, 'assigned_to'),
            ($requisition->executed_copy != null) ? 'Executed' : 'Pending Excuted',
            $this->getTaskStatus($requisition)
    	];
    }



    public function getClassificationDetails($requisition, $type)
    {
        $info = \App\RequisitionClassification::where('requisition_id', $requisition->id)->first();
        if($info) return $info->$type;
    }

    public function getAssignmentDetails($requisition, $type)
    {
        $info = \App\AssignContractToUser::where('requisition_id', $requisition->id)->first();
        if($info) return $info->user->name;
    }

    public function getTaskStatus($requisition)
    {
        $position = \App\Position::where('requisition_id', $requisition->id)->first();
        if ($position) {
            $stage = \App\Stage::where('position', $position->position_id)->where('workflow_id', $requisition->workflow_id)->first();
            if ($stage) {
                return $stage['name'];
            }
        } else {
            return 'N\A';
        }
    }


}

