<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\VoucherAirline;
use App\Models\HotelCategory;
use App\Models\State;
use App\Models\City;
use App\Models\Zone;
use App\Models\VoucherHotel;
use App\Models\Hotel;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use DB;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use App\Exports\VoucherActivityExport;
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
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			if($data['booking_type'] == 2) {
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
			 $query->whereDate('tour_date', '>=', $startDate);
			 $query->whereDate('tour_date', '<=', $endDate);
			}
			}
        }
		
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', $data['booking_status']);
			});
		}
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.index', compact('records','voucherStatus'));

    }
	
	public function voucherReportExport(Request $request)
    {
        $data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = VoucherActivity::with(["voucher",'activity','voucher.customer'])->where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			if($data['booking_type'] == 2) {
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
			 $query->whereDate('tour_date', '>=', $startDate);
			 $query->whereDate('tour_date', '<=', $endDate);
			}
			}
        }
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', $data['booking_status']);
			});
		}
        $records = $query->orderBy('created_at', 'DESC')->get();
   // return Excel::download(new VoucherActivityExport(['records' => $records]), 'users.xlsx');

return Excel::download(new VoucherActivityExport($records), 'records'.date('d-M-Y s').'.csv');        //return Excel::download(new VoucherActivityExport($records), 'records.csv');
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

   
}
