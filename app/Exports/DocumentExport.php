<?php

namespace App\Exports;

use App\NewDocument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        if (\Auth::user()->department_id == 1) 
        {
            return NewDocument::select('requisition_id', 'document_type_id', 'name', 'expire_on', 'stage_id', 'workflow_id', 'grace_end', 'created_by')
                            ->with(['document_type', 'author', 'workflow']);
        } 
        else
        {
            return NewDocument::select('requisition_id', 'document_type_id', 'name', 'expire_on', 'stage_id', 'workflow_id', 'grace_end', 'created_by')
                            ->where('created_by', \Auth::user()->id)->with(['document_type', 'author', 'workflow']);
        }
    }


    public function headings(): array
    {
    	return [
    		'Document Name',
            'Document Type',
            'Expiry Date',
    		'Grace End on',
            'Document Duration',
    		'Active Status',
            'Requestor',
            'Assigned To',
            'Priority',
            'Sensitivity',
            'Document Stage'
    	];
    }


    public function map($document): array
    {
    	return [
    		$document->name,
            $document->document_type ? $document->document_type->name : null,
            date("M j, Y", strtotime($document->expire_on)),
            date("M j, Y", strtotime($document->grace_end)),
            $this->getDuration($document),
            $this->getExpirationDate($document),
            $document->author ? $document->author->name : null,
            $this->getAssignmentDetails($document, 'assigned_to'),
            $this->getClassificationDetails($document, 'priority'),
            $this->getClassificationDetails($document, 'sensitivity'),
            $this->getTaskStatus($document)
    	];
    }



    public function getClassificationDetails($document, $type)
    {
        $info = \App\RequisitionClassification::where('requisition_id', $document->requisition_id)->first();
        if($info) return $info->$type;
    }

    public function getAssignmentDetails($document, $type)
    {
        $info = \App\AssignContractToUser::where('requisition_id', $document->requisition_id)->first();
        if($info) return $info->user->name;
    }

    public function getTaskStatus($document)
    {
        $position = \App\Position::where('requisition_id', $document->requisition_id)->first();
        if ($position) {
            $stage = \App\Stage::where('position', $position->position_id)->where('workflow_id', $document->workflow_id)->first();
            if ($stage) {
                return $stage['name'];
            }
        } else {
            return 'N\A';
        }
    }

    public function getDuration($document)
    {
        $detail = \App\NewDocument::where('requisition_id', $document->requisition_id)->first();
        if ($detail) {
            $start = strtotime($detail->created_at);
            $end = strtotime($detail->expire_on);
            $duration_in_days = ceil(abs($end - $start) / 86400);
            return $duration_in_days . ' day(s)';
        } else {
            return 'N/A';
        }
    }


    public function getExpirationDate($document)
    {
        $detail = \App\NewDocument::where('requisition_id', $document->requisition_id)->first();
        if ($detail) 
        {
            $today = date('Y-m-d'); 
            $expire_on = date('Y-m-d', strtotime($detail->expire_on));
            $grace_end = date('Y-m-d', strtotime($detail->grace_end));
            
            //null
            if ($expire_on == null) 
            {
                return 'N/A';
            }
            //grace period
            elseif (($today >= $expire_on) && ($today <= $grace_end)) 
            {
                return 'Grace Period';
            }
            //Active
            elseif ($expire_on >= $today) 
            {
                return 'Active';
            }
            //Expired
            else 
            {
                return 'Expired';
            }
        } else return 'N/A';


        // if($detail){ return $expire_on; }else{ return 'N/A'; }
    }


}

