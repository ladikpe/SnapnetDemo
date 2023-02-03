<?php

namespace App\Exports;

use App\RequirementAndFiling;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequirementFilingExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        return RequirementAndFiling::select('title', 'description', 'start', 'end', 'recurring', 'monthly', 'quarterly', 'bi_annually', 'yearly', 'document_name');
    }


    public function headings(): array
    {
    	return [
    		'Title',
    		'Description',
    		'Start Date',
    		'End Date',
            'Recurring',
            'Monthly',
            'Quarterly',
            'Bi Annually',
            'Yearly',
            'Document'
    	];
    }


    public function map($calendar): array
    {
    	return [
    		$calendar->title,
            $calendar->description,
            date("M j, Y", strtotime( $calendar->start )),
            date("M j, Y", strtotime( $calendar->end )),
            $calendar->recurring,
            $calendar->monthly,
            $calendar->quarterly,
            $calendar->bi_annually,
            $calendar->yearly,
    		$calendar->document_name
    	];
    }
}
