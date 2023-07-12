<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Zone;
use App\Models\Hotel;
use App\Models\VoucherHotel;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;

class AgentVouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = Voucher::where('id','!=', null)->where("agent_id",Auth::user()->id);
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		
		if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', 'like', '%' . $data['code'] . '%');
        }
		
		if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 2);
			if ($data['status'] == 3)
                $query->where('status', 3);
			if ($data['status'] == 4)
                $query->where('status', 4);
			if ($data['status'] == 6)
                $query->where('status', 5);
			if ($data['status'] == 6)
                $query->where('status', 6);
        }
		
		if (isset($data['is_hotel']) && !empty($data['is_hotel'])) {
            if ($data['is_hotel'] == 1)
                $query->where('is_hotel', 1);
            if ($data['is_hotel'] == 2)
                $query->where('is_hotel', 0);
        }
		
		if (isset($data['is_flight']) && !empty($data['is_flight'])) {
            if ($data['is_flight'] == 1)
                $query->where('is_flight', 1);
            if ($data['is_flight'] == 2)
                $query->where('is_flight', 0);
        }
		
		if (isset($data['is_activity']) && !empty($data['is_activity'])) {
            if ($data['is_activity'] == 1)
                $query->where('is_activity', 1);
            if ($data['is_activity'] == 2)
                $query->where('is_activity', 0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        return view('agent-vouchers.index', compact('records','agetid','agetName'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		if(old('customer_id_select')){
		$customerTBA = Customer::where('id', old('customer_id_select'))->where('status', 1)->first();
		}else{
		$customerTBA = Customer::where('id', 1)->where('status', 1)->first();	
		}
		
        return view('agent-vouchers.create', compact('countries','airlines','customerTBA'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        $request->validate([
            
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);
		
		
		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',$request->input('customer_mobile'))->first();
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = $request->input('customer_mobile');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			$customer->name = $request->input('customer_name');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
			
		
        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $customer->id;
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->is_activity = $request->input('is_activity');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->travel_from_date = $request->input('travel_from_date');
		$record->travel_to_date = $request->input('travel_to_date');
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->status = 1;
		$record->created_by = Auth::user()->id;
        $record->save();
		$code = 'V-'.date("Y")."-00".$record->id;
		$recordUser = Voucher::find($record->id);
		$recordUser->code = $code;
		
		$recordUser->save();
		
		
		if ($request->has('save_and_activity')) {
			if($record->is_activity == 1){
			return redirect()->route('agent-vouchers.add.activity',$record->id)->with('success', 'Voucher Created Successfully.');
			}
			else
			{
				return redirect()->route('agent-vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} else {
        return redirect()->route('agent-vouchers.index')->with('success', 'Voucher Created Successfully.');
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show($vid)
    {
		$voucher = Voucher::find($vid);
		if($voucher->status_main  > 3)
		{
			return redirect()->route('agentVoucherView',$voucher->id);
		}
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.view', compact('voucher','voucherHotel','voucherActivity','voucherStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Voucher::find($id);
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		$customer = Customer::where('id',$record->customer_id)->first();
       return view('agent-vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
		
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
			'arrival_airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);

		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',$request->input('customer_mobile'))->first();
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = $request->input('customer_mobile');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			$customer->name = $request->input('customer_name');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		
        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $customer->id;
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->is_activity = $request->input('is_activity');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->travel_from_date = $request->input('travel_from_date');
		$record->travel_to_date = $request->input('travel_to_date');
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->status = 1;
		$record->updated_by = Auth::user()->id;
        $record->save();
		
		if($record->is_activity != 1)
		{
		$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->delete();
		}
		
        return redirect('agent-vouchers')->with('success','Voucher Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Voucher::find($id);
		//$voucherHotel = VoucherHotel::where('voucher_id',$id)->delete();
		$voucherActivity = VoucherActivity::where('voucher_id',$id)->delete();
		
        $record->delete();
        return redirect('agent-vouchers')->with('success', 'Voucher Deleted.');
    }
	
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
		$nameOrCompany  = ($request->get('nameorcom'))?$request->get('nameorcom'):'Company';
		if($nameOrCompany == 'Company'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('company_name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->company_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}
	elseif($nameOrCompany == 'Name'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->full_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}	  
        return response()->json($response);
    }
	
	
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addActivityList(Request $request,$vid)
    {
       $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucher = Voucher::find($vid);
		if($voucher->status_main  > 3)
		{
			return redirect()->route('agentVoucherView',$voucher->id);
		}
        $query = Activity::with('prices')->where('status',1)->where('is_price',1);
	
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
		if($voucher->status_main > 3){
		$voucherActivityCount = VoucherActivity::where('voucher_id',$vid)->count();
		} else { 
		$voucherActivityCount = 0;
		}
        return view('agent-vouchers.activities-list', compact('records','typeActivities','vid','voucher','voucherActivityCount'));
		
       
    }
	
	public function getActivityVariant(Request $request)
    {
		$data = $request->all();
		$aid = $data['act'];
		$vid = $data['vid'];
		$query = Activity::where('id', $data['act']);
		$activity = $query->where('status', 1)->first();
		$voucher = Voucher::find($data['vid']);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		

		$activityPrices = ActivityPrices::where('activity_id', $data['act'])->get();

		
		$typeActivities = config("constants.typeActivities"); 
		$returnHTML = view('agent-vouchers.activities-add-view', compact('activity','aid','vid','voucher','typeActivities','activityPrices'))->render();
		
		return response()->json(array('success' => true, 'html'=>$returnHTML));	
			
    }
	
	
	public function getPVTtransferAmount(Request $request)
    {
		$activity = Activity::where('id', $request->acvt_id)->where('status', 1)->first();
		$price = 0;
		$total = 0;
		$markupPer = $request->markupPer;
		//$activityPrices = ActivityPrices::where('activity_id', $aid)->get();
		if($activity->pvt_TFRS == 1)
		{
			$td = TransferData::where('transfer_id', $activity->transfer_plan)->where('qty', $request->adult)->first();
			if(!empty($td))
			{
				$price = $td->price;
			}
		}
		
		$totalPrice  = $price*$request->adult;
		$markup = (($markupPer/100) * $totalPrice);
		$total = ($markup + $totalPrice);
		return $total;
    }
	
	
	public function activitySaveInVoucher(Request $request)
    {
		
		$activity_select = $request->input('activity_select');
	if(isset($activity_select))
	{
		
		$voucher_id = $request->input('v_id');
		$activity_vat = $request->input('activity_vat');
		$activity_id = $request->input('activity_id');
		$variant_name = $request->input('variant_name');
		$variant_code = $request->input('variant_code');
		$transfer_option = $request->input('transfer_option');
		$tour_date = $request->input('tour_date');
		$pvt_traf_val_with_markup = $request->input('pvt_traf_val');
		$transfer_zone = $request->input('transfer_zone');
		$zonevalprice_without_markup = $request->input('zonevalprice');
		$adult = $request->input('adult');
		$child = $request->input('child');
		$infant = $request->input('infant');
		$markup_p_ticket_only = $request->input('markup_p_ticket_only');
		$markup_p_sic_transfer = $request->input('markup_p_sic_transfer');
		$markup_p_pvt_transfer = $request->input('markup_p_pvt_transfer');
		$adultPrice = $request->input('adultPrice');
		$childPrice = $request->input('childPrice');
		$infPrice = $request->input('infPrice');
		$discount = $request->input('discount');
		$totalprice = $request->input('totalprice');
		$pickup_location = $request->input('pickup_location');
		$variant_unique_code = $request->input('variant_unique_code');
		
		$data = [];
		$total_activity_amount = 0;
		foreach($activity_select as $k => $v)
		{
			if($totalprice[$k] > 0){
			$data[] = [
			'voucher_id' => $voucher_id,
			'activity_id' => $activity_id,
			'activity_vat' => $activity_vat,
			'variant_unique_code' => $variant_unique_code[$k],
			'variant_name' => $variant_name[$k],
			'variant_code' => $variant_code[$k],
			'transfer_option' => $transfer_option[$k],
			'tour_date' => $tour_date[$k],
			'pvt_traf_val_with_markup' => $pvt_traf_val_with_markup[$k],
			'transfer_zone' => $transfer_zone[$k],
			'zonevalprice_without_markup' => $zonevalprice_without_markup[$k],
			'adult' => $adult[$k],
			'child' => $child[$k],
			'infant' => $infant[$k],
			'markup_p_ticket_only' => $markup_p_ticket_only[$k],
			'markup_p_sic_transfer' => $markup_p_sic_transfer[$k],
			'markup_p_pvt_transfer' => $markup_p_pvt_transfer[$k],
			'adultPrice' => $adultPrice[$k],
			'childPrice' => $childPrice[$k],
			'infPrice' => $infPrice[$k],
			'discountPrice' => $discount[$k],
			'totalprice' => $totalprice[$k],
			//'pickup_location' => $pickup_location[$k],
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,	
                ];

				$total_activity_amount +=$totalprice[$k];
			}
		}
		
		if(count($data) > 0)
		{
			
			VoucherActivity::insert($data);
			$voucher = Voucher::find($voucher_id);
			$voucher->total_activity_amount = $total_activity_amount;
			$voucher->save();
			
		}

		
		
		if ($request->has('save_and_continue')) {
         return redirect()->back()->with('success', 'Activity added Successfully.');
		} else {
			return redirect()->back()->with('success', 'Activity added Successfully.');
        //return redirect('vouchers')->with('success', 'Activity Added Successfully.');
		}
	}
		
       return redirect()->back()->with('error', 'Please select activity variant.');
	   
    }
	
	public function destroyActivityFromVoucher($id)
    {
        $record = VoucherActivity::find($id);
        $record->delete();
        return redirect()->back()->with('success', 'Activity Deleted Successfully.');
    }
	
 public function voucherActivityItineraryPdf(Request $request, $vid)
    {
		$voucher = Voucher::find($vid);
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
       
        
        

        $pdf = SPDF::loadView('vouchers.ActivityItineraryPdf', compact('voucher','voucherHotel','voucherActivity'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download('Itinerary'.$vid.'.pdf');
		
	
	
	return \Response::make($content,200, $headers);
    }
	
	public function voucherInvoicePdf(Request $request, $vid)
    {
		$voucher = Voucher::find($vid);
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$agent = User::where('id',$voucher->agent_id)->first();
		$customer = Customer::where('id',$voucher->customer_id)->first();
		
       $voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	  
		
        $dataArray = [];
		$discountTotal = 0;
		$subTotal = 0;
		
		if(!empty($voucherActivity)){
					 foreach($voucherActivity as $kkh => $ap)
					 {
						
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$vat =  1 + $activity->vat;
					$vatPrice = $ap->totalprice/$vat;
					//$total = ($ap->totalprice+$ap->discountPrice) - ($vatPrice);
					$total = $ap->totalprice;
				$dataArray[$ap->variant_code.$kkh] = [
				'hhotelActName' => $activity->title.'-'.$ap->variant_name,
				'TouCheckInCheckOutDate' => $ap->tour_date,
				'adult' => $ap->adult,
				'child' => $ap->child,
				'NoofPax' => 0,
				'hotel' => 0,
				'totalprice' => $total,
				];
				$discountTotal += $ap->discountPrice;
				$subTotal+= $total ;
					 }
					
			}
			
		if(!empty($voucherHotel)){
					 foreach($voucherHotel as $kk => $vh)
					 {
					  $hotelData = json_decode($vh->hotel_other_details);
					  $noofPax = 0;
						$netRate = 0;
					  foreach($hotelData as $k => $hd)
					  {
						  
						  $noofPax+= $hd->nop_s;
						  $noofPax+= $hd->nop_d;
						  $noofPax+= $hd->nop_eb;
						  $noofPax+= $hd->nop_cwb;
						  $noofPax+= $hd->nop_cnb;
						  
						  $netRate+= $hd->nr_s;
						  $netRate+= $hd->nr_d;
						  $netRate+= $hd->nr_eb;
						  $netRate+= $hd->nr_cwb;
						  $netRate+= $hd->nr_cnb;
					  }
				$dataArray[$vh->hotel->name.$kk] = [
				'hhotelActName' => $vh->hotel->name,
				'TouCheckInCheckOutDate' =>$vh->check_in_date.' / '.$vh->check_out_date,
				'NoofPax' => $noofPax,
				'adult' => 0,
				'child' => 0,
				'hotel' => 1,
				'totalprice' => $netRate,
				];
				$subTotal+= $netRate;
					 }
					
			}
			$withVatTotalAmount = $subTotal;
			$vatGrand = '1.05';
			$grandWithOutVatTotal = ($withVatTotalAmount/$vatGrand) - $discountTotal;
			$grandWithVatTotal = ($withVatTotalAmount) - $discountTotal;
			$vatTotal = ($withVatTotalAmount) - $grandWithOutVatTotal;
			
			
       
//return view('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','grandWithVatTotal','grandWithOutVatTotal','vatTotal'));
        $pdf = SPDF::loadView('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','grandWithOutVatTotal','grandWithVatTotal','vatTotal'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download('Invoice'.$vid.'.pdf');
		
	
	
	return \Response::make($content,200, $headers);
    }
	

	public function autocompleteHotel(Request $request)
    {
		$search  = $request->get('search');
		$zone  = $request->get('zone');
		
        $hotels = Hotel::where('zone_id', $zone)
					->where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->get();
		$response = array();
		
      foreach($hotels as $hotel){
         $response[] = array("value"=>$hotel->name,"label"=>$hotel->name);
      }
	
        return response()->json($response);
    }
	
	public function statusChangeVoucher(Request $request,$id)
    {
		$data = $request->all();
		
		$record = Voucher::find($id);
		$paymentDate = date('Y-m-d', strtotime('-2 days', strtotime($record->travel_from_date)));
		if ($request->has('btn_paynow')) {
		$agent = User::find($record->agent_id);
		if(!empty($agent))
		{
			
			
			$agentAmountBalance = $agent->agent_amount_balance;
			
			if($agentAmountBalance >= $record->total_activity_amount)
			{
			
			if($record->vat_invoice == 1)
			{
			$code = 'VIN-100'.$record->id;
			}else{
			$code = 'WVIN-100'.$record->id;
			}
			
			$record->booking_date = date("Y-m-d");
			$record->guest_name = $data['fname'].' '.$data['lname'];
			$record->agent_ref_no = $data['agent_ref_no'];
			$record->remark = $data['remark'];
			$record->invoice_number = $code;
			$record->updated_by = Auth::user()->id;
			$record->status_main = 5;
			$record->payment_date = $paymentDate;
			$record->save();
			$agent->agent_amount_balance -= $record->total_activity_amount;
			$agent->save();
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $record->agent_id;
			$agentAmount->amount = $record->total_activity_amount;
			$agentAmount->date_of_receipt = date("Y-m-d");
			$agentAmount->transaction_type = "Debit";
			$agentAmount->transaction_from = 2;
			$agentAmount->created_by = Auth::user()->id;
			$agentAmount->updated_by = Auth::user()->id;
			$agentAmount->save();
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $code;
			$recordUser->is_vat_invoice = $record->vat_invoice;
			$recordUser->save(); 
			
			}else{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
			
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}
		else if ($request->has('btn_hold')) {
			$record->booking_date = date("Y-m-d");
			$record->guest_name = $data['fname'].' '.$data['lname'];
			$record->agent_ref_no = $data['agent_ref_no'];
			$record->remark = $data['remark'];
			$record->updated_by = Auth::user()->id;
			$record->status_main = 4;
			$record->payment_date = $paymentDate;
			$record->save();
		}
		
	
		
        return redirect()->route('agentVoucherView',$record->id)->with('success', 'Voucher Created Successfully.');
    }
	
	 public function agentVoucherView($vid)
    {
		$voucher = Voucher::find($vid);
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.bookedview', compact('voucher','voucherActivity','voucherStatus'));
    }
}
