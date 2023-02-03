<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequirementFilingHeader implements WithTitle, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function headings(): array
    {
        $table = collect($this->getTableColumns('requirement_and_filings'))->filter(function ($value) 
        {
            if (in_array($value, ['id', 'start_time', 'end_time', 'quarterly', 'bi_annually', 'yearly', 'document_path', 'created_by', 'created_at', 'updated_at'])) 
            {
                return false;
            }
            return $value;
        });       

        return $table->toArray();
    }

    public function title() : string
    {
        return 'Requirement & Filing';  
    }


   
    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

}
