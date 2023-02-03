<?php

namespace App\Exports;

use App\Contract;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ContractVersionExport implements FromView
{
     use Exportable;

    private $contract_id ;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$contract=Contract::find($this->contract_id);
        return view('exports.contract_version_history', [
            'contract' => $contract
        ]);
    }

    public function contract(int $contract_id)
    {
        $this->contract_id = $contract_id;
        
        return $this;
    }
}
