<?php

namespace App\Exports;

use App\Bid;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BidExportTemplate implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Bid::select('bid_code', 'name', 'description', 'instruction', 'bid_type', 'start_date', 'end_date', 'industry_id', 'countdown', 'submission_after')->with(['industry'])->first();
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
    	];
    }


    public function map($bid): array
    {
    	return [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
    		'',
    	];
    }
}