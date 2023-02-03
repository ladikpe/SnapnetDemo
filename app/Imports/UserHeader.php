<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserHeader
 implements WithTitle, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function headings(): array
    {
        $table = collect($this->getTableColumns('users'))->filter(function ($value) 
        {
            if (in_array($value, ['id', 'password', 'signature', 'signature_path', 'image', 'remember_token', 'status', 'api_token', 'created_at', 'updated_at'])) 
            {
                return false;
            }
            return $value;
        });       

        return $table->toArray();
    }

    public function title() : string
    {
        return 'Employees';  
    }


   
    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

}
