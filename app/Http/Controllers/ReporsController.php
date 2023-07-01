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
use DB;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use App\Exports\VoucherActivityExport;
use App\Exports\SOAExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherReport(Request $request)
    {
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
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
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
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$query = AgentAmount::where('id','!=', null);
		
		$s = 0;
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$query->where('agent_id', '=', $data['agent_id_select']);
				$s = 1;
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
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
   
}
