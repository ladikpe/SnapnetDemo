<?php

namespace App\Imports;

use App\Recurring;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class RecurringSheet implements FromQuery, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function query()
    {
        return Recurring::select('id', 'name');
    }

    public function title() : string
    {
    	return 'Recurring';  
    }
}
