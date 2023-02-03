<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * 
 */
class VendorPerSheet implements FromQuery, WithTitle, WithHeadings
{
	
	function __construct()
	{
		# code...
	}


	public function query()
	{
		return \App\Vendor::query()->where('id');
	}


	public function title(): string
	{
		return 'State';
	}


    public function headings(): array
    {
    	return ['Id', 'Name',];
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