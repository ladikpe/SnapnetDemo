<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class RequirementFilingTemplate implements  WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;


    public function sheets() : array
    {
        $sheets = [];

        for ($sheet=1; $sheet <= 2; $sheet++) 
        {
            if($sheet == 1) 
            {
                $sheets[] = new RequirementFilingHeader();
            }
            if($sheet == 2) 
            {
                $sheets[] = new RecurringSheet();
            }
        }

        return $sheets;
    }

}

