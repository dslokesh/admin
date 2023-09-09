<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Customer;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\AgentAmount;
use App\Models\Supplier;
use App\Models\Ticket;
use DB;
use Illuminate\Support\Facades\Auth;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VoucherActivityExport;
use App\Exports\SOAExport;

class ReporsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherReport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = Supplier::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = Supplier::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_ref_no', '=', $data['reference']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.index', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
        $data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = VoucherActivity::with(["voucher",'activity','voucher.customer','supplierticket','suppliertransfer'])->where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		
		if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_ref_no', '=', $data['reference']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
		});
		
        $records = $query->orderBy('created_at', 'DESC')->get();
   // return Excel::download(new VoucherActivityExport(['records' => $records]), 'users.xlsx');

return Excel::download(new VoucherActivityExport($records), 'logistic_records'.date('d-M-Y s').'.csv');        //return Excel::download(new VoucherActivityExport($records), 'records.csv');
    }
	
	public function voucherReportSave(Request $request)
    {
		$data = $request->all();
		
		$record = VoucherActivity::find($data['id']);
        $record->{$data['inputname']} = $data['val'];
        $record->save();
		$response[] = array("status"=>1);
        return response()->json($response);
	}


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function soaReport(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', $data['booking_status']);
			});
		}
		
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		
		$agetid = '';
		$agetName = '';
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.soa-report', compact('records','voucherStatus','agetid','agetName'));

    }
	
	 public function soaReportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$query = VoucherActivity::with(["voucher",'activity','transferZone'])->where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', $data['booking_status']);
			});
		}
		
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		
		$agetid = '';
		$agetName = '';
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        $records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new SOAExport($records), 'accounts_receivables_records'.date('d-M-Y s').'.csv');

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReport(Request $request)
    {
		//$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$s = 0;
		$query = AgentAmount::where('is_vat_invoice','=', '0');
		if(Auth::user()->role_id == '3')
		{
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
			}
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->paginate($perPage);	
		}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
        return view('reports.agent-ledger-report', compact('records','voucherStatus','agetid','agetName'));

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReportWithVat(Request $request)
    {
		$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$s = 0;
		$query = AgentAmount::where('id','!=', null);
		if(Auth::user()->role_id == '3')
		{
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
		}
		
		
		
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->paginate($perPage);	
		}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
        return view('reports.agent-with-vat-ledger-report', compact('records','voucherStatus','agetid','agetName'));

    }
	
	public function voucherActivtyCanceledReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = Supplier::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = Supplier::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', '=', $data['reference']);
			});
		}
		
		$query->where('status', '=', 1);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-canceled-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function activityRefundSave(Request $request)
    {
		$data = $request->all();
		
		$record = VoucherActivity::where("id",$data['id'])->where('status', '=', 1)->first();
		if($data['val'] <= $record->totalprice){
			if(!empty($record)){
				
			$record->refund_amount = $data['val'];
			$record->status = 2;
			$record->refund_by = Auth::user()->id;
			
			$voucher = Voucher::where('id',$record->voucher_id)->select(['agent_id','vat_invoice','invoice_number'])->first();
			$agent = User::find($voucher->agent_id);
			if(!empty($agent))
			{
				
				$agent->agent_amount_balance += $data['val'];
				$agent->save();
				
				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $agent->id;
				$agentAmount->amount = $data['val'];
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Credit";
				$agentAmount->transaction_from = 2;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->receipt_no = $voucher->invoice_number;
				$agentAmount->is_vat_invoice = $voucher->vat_invoice;
				$agentAmount->save();
				$record->save();
				$response[] = array("status"=>1);
			}else{
			$response[] = array("status"=>2);
			}
			
			}
			else{
			$response[] = array("status"=>3);
			}
			
		}
		else{
			$response[] = array("status"=>4);
		}
		
        return response()->json($response);
	}

	public function ticketStockReport(Request $request)
    {
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		$query = Ticket::with(['activity','voucheractivity'])
            ->select(
                'activity_id',
                'activity_variant',
                'valid_till',
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "adult" THEN 1 ELSE 0 END) as stock_uploaded_adult'),
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "child" THEN 1 ELSE 0 END) as stock_uploaded_child'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "adult" THEN 1 ELSE 0 END) as stock_allotted_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "child" THEN 1 ELSE 0 END) as stock_allotted_child'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "adult" THEN 1 ELSE 0 END) as stock_left_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "child" THEN 1 ELSE 0 END) as stock_left_child')
            );
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate =  date("Y-m-d",strtotime($data['to_date']));
				 $query->whereDate('valid_till', '>=', $startDate);
				 $query->whereDate('valid_till', '<=', $endDate);
		}
		
		if (isset($data['activity_id']) && !empty($data['activity_id'])) {
				 $query->where('activity_id',  $data['activity_id']);
		}
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
				
            $query->groupBy('activity_id', 'activity_variant', 'valid_till');
           $records = $query->paginate($perPage);
			
		
	//dd($records);
		return view('reports.ticket-report', compact('records','activities'));
	}
   
}
