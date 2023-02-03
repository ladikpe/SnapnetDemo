<?php

namespace App\Imports;

use App\Department;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class DepartmentSheet implements FromQuery, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function query()
    {
        return Department::select('id', 'name');
    }

    public function title() : string
    {
    	return 'Departments';  
    }

}
