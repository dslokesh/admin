<?php

namespace App\Exports;
use App\Models\VoucherActivity;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class SOAExport implements FromView
{
    use Exportable;
	
	protected $records;


    public function __construct($records)
    {
		$this->records = $records;
        dd($this->records);
    }
	
	public function view(): View
    {
		
        return view('exports.soa-export', [
            'records' => $this->records
        ]);
    }
	
    
}
