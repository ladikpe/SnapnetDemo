<?php

namespace App\Exports;

use App\Vendor;
// use App\Exports\VendorPerSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\Exportable;

class VendorExportTemplate implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // use Exportable;

    // public function sheets(): array
    // {
    // 	$sheets = [];   $sheets[] = new VendorPerSheet();
    // 	return $sheets;
    // }
    
    public function query()
    {
        return Vendor::select('name', 'email', 'password', 'phone', 'category', 'contact_name', 'address', 'address_2', 'state_id', 'country_id', 'website', 'vat_number', 'fax_number', 'bank_name', 'account_number', 'company_info')->with(['state', 'country']);
    }


    public function headings(): array
    {
    	return [
    		'Name',
    		'Email',
    		'Phone',
    		'Category',
    		'Contact Name',
    		'Address',
    		'Address_2',
    		'State',
    		'Country',
    		'Website',
    		'VAT Number',
    		'FAX Number',
    		'Bank Name',
    		'Account Number',
    		'Company Info',
    	];
    }


    public function map($vendor): array
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
    		'',
    		'',
    		'',
    		'',
    		'',
    	];
    }
}
