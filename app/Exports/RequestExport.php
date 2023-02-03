<?php

namespace App\Exports;

use App\TaskRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        if (\Auth::user()->department_id == 1) 
        {
            return TaskRequest::select('department_id', 'department_head_id', 'purpose', 'description', 'request_type', 'status_id', 'created_by')
                            ->with(['type', 'department', 'department_head', 'author']);
        } 
        else 
        {
            return TaskRequest::select('department_id', 'department_head_id', 'purpose', 'description', 'request_type', 'status_id', 'created_by')
                            ->where('created_by', \Auth::user()->id)
                            ->with(['type', 'department', 'department_head', 'author']);
        }
    }


    public function headings(): array
    {
    	return [
    		'Purpose',
    		'Description',
    		'Request Type',
    		'Department',
            'Requestor',
            'To Approve',
            'Status'
    	];
    }


    public function map($request): array
    {
    	return [
    		$request->purpose,
            $request->description,
            $request->type ? $request->type->name : null,
            $request->department ? $request->department->name : null,
            $request->author ? $request->author->name : null,
            $request->department_head ? $request->department_head->name : null,
            ($request->status_id == 2) ? 'Approved' : 'Pending'
    	];
    }
}
