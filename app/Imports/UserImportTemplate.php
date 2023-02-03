<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class UserImportTemplate implements  WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;


    public function sheets() : array
    {
        $sheets = [];

        for ($sheet=1; $sheet <= 3; $sheet++) 
        {
            if($sheet == 1) 
            {
                $sheets[] = new UserHeader();
            }
            elseif($sheet == 2) 
            {
                $sheets[] = new RoleSheet();
            }
            elseif($sheet == 3) 
            {
                $sheets[] = new DepartmentSheet();
            }
        }

        return $sheets;
    }

}

