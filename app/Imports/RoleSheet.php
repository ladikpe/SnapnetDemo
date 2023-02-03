<?php

namespace App\Imports;

use App\Role;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class RoleSheet implements FromQuery, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function query()
    {
        return Role::select('id', 'name');
    }

    public function title() : string
    {
    	return 'Roles';  
    }

}
