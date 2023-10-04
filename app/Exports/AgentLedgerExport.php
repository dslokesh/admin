<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class AgentLedgerExport implements FromView
{
    use Exportable;
	
	protected $records;


    public function __construct($records)
    {
		$this->records = $records;
    }
	
	
	public function view(): View
    {
		
        return view('exports.agent-ledger-export', [
            'records' => $this->records
        ]);

    }
	
    
}