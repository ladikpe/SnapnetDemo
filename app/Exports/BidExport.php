<?php

namespace App\Exports;

use App\Bid;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BidExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function query()
    {
        return Bid::select('bid_code', 'name', 'description', 'instruction', 'bid_type', 'start_date', 'end_date', 'industry_id', 'countdown', 'submission_after', 'status_id')->with(['industry'])->first();
    }


    public function headings(): array
    {
    	return [
    		'Code',
            'Name',
            'Description',
            'Instruction',
            'Bid Type',
            'Start Date',
            'End Date',
            'Industry',
            'Countdown',
            'Submission After',
    		'Status',
    	];
    }


    public function map($bid): array
    {
    	if ($bid->bid_type == 1) { $bid->bid_type = 'Shortlisted Only'; }elseif ($bid->bid_type == 2) { $bid->bid_type = 'All Vendor'; }
    	if ($bid->status_id == 0) { $bid->status = 'Closed'; }elseif ($bid->status_id == 1) { $bid->status = 'Open'; }

    	return [
    		$bid->bid_code,
    		$bid->name,
            $bid->description,
    		$bid->instruction,
    		$bid->bid_type,
    		$bid->start_date,
    		$bid->end_date,
            $bid->industry->name,
            $bid->countdown,
    		$bid->submission_after,
    		$bid->status,
    	];
    }
}