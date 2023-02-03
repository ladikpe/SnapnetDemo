<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        return User::select('name', 'email', 'role_id', 'department_id')->with(['roles', 'department']);
    }


    public function headings(): array
    {
    	return [
    		'Employees',
    		'email',
    		'Role',
    		'Department'
    	];
    }


    public function map($user): array
    {
    	return [
    		$user->name,
    		$user->email,
            $user->roles ? $user->roles->name : null,
    		$user->department ? $user->department->name : null
    	];
    }
}
