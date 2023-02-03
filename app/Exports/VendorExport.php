<?php

namespace App\Exports;

use App\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        return Vendor::select('vendor_code', 'name', 'email', 'password', 'phone', 'category', 'contact_name', 'address', 'address_2', 'state_id', 'country_id', 'website', 'vat_number', 'fax_number', 'bank_name', 'account_number', 'company_info')->with(['state', 'country']);
    }


    public function headings(): array
    {
    	return [
    		'Code',
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
    		$vendor->vendor_code,
    		$vendor->name,
    		$vendor->email,
    		$vendor->phone,
    		$vendor->category,
    		$vendor->contact_name,
    		$vendor->address,
    		$vendor->address_2,
    		$vendor->state_id,
    		$vendor->country_id,
    		$vendor->website,
    		$vendor->vat_number,
    		$vendor->fax_number,
    		$vendor->bank_name,
    		$vendor->account_number,
    		$vendor->company_info,
    	];
    }
}
