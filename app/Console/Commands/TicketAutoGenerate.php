<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\TicketLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SiteHelpers;

class TicketAutoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketAutoGenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ticket Auto Generated Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$voucherActivities = VoucherActivity::with("activity")->where("ticket_generated","0")->where("status","3")->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       })->get();
	   
		foreach($voucherActivities as $voucherActivity){
			
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
		$totalTicketNeed = $adult+$child;
		$countTotalTicketNeed = $totalTicketNeed;
		$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date);
		
		$totalTickets =$ticketQuery->get();
		$totalTicketCount =$totalTickets->count();
		$tcArray = [];
		if($totalTicketCount >= $totalTicketNeed)
		{
			
			foreach($totalTickets as $ticket){
				
				if(($ticket->ticket_for == 'Adult') && ($adult > 0)){
						$tcArray[$ticket->id] = $ticket->id;
						$adult--;
						$totalTicketNeed--;
						
				}
				if(($ticket->ticket_for == 'Child') && ($child > 0)){
					
						$tcArray[$ticket->id] = $ticket->id;
						$child--;
						$totalTicketNeed--;
					
				}if(($ticket->ticket_for == 'Both') && ($totalTicketNeed > 0)){
					
						$tcArray[$ticket->id] = $ticket->id;
						$totalTicketNeed--;
				}
				
				
			}
			
			if(($totalTicketNeed == 0) && (count($tcArray) == $countTotalTicketNeed)){
				$tcCountEx = Ticket::where("voucher_id",'=',$voucherActivity->voucher_id)->where("voucher_activity_id",'=',$voucherActivity->id)->count();
				if($tcCountEx > 0){
				return redirect()->route('ticket.dwnload',$voucherActivity->id);	
				} else {
				foreach($tcArray as $ta){
					$tc = Ticket::find($ta);
					$tc->voucher_activity_id = $voucherActivity->id;
					$tc->ticket_generated = 1;
					$tc->ticket_generated_by = Auth::user()->id;
					$tc->generated_time = date("d-m-Y h:i:s");
					$tc->voucher_id = $voucherActivity->voucher_id;
					$tc->save();
				}
				
				$voucherActivity->ticket_generated = 1;
				$voucherActivity->supplier_ticket = '947d43d9-c999-446c-a841-a1aee22c7257';
				$voucherActivity->status = 4;
				$voucherActivity->save();
				}
			}
			
				$log = new TicketLog();
				$log->total_record = $countTotalTicketNeed;
				$log->save();
					
		}
	}
		
	$this->line('Ticket Auto Generated Successfully.');
	exit;
    }
}
