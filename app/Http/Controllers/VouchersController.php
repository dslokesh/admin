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

class VouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $records = Voucher::orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('vouchers.index', compact('records'));

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
			
        return view('vouchers.create', compact('countries','airlines','customerTBA'));
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
            'agent_id'=>'required',
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
			'customer_name'=>'required',
			'customer_mobile'=>'required',
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
		$record->guest_name = $request->input('customer_name');
		$record->status = $request->input('status');
        $record->save();
		$code = 'V-'.date("Y")."-00".$record->id;
		$recordUser = Voucher::find($record->id);
		$recordUser->code = $code;
		$recordUser->save();
		
		if ($request->has('save_and_hotel')) {
			if($record->is_hotel == 1){
			return redirect()->route('voucher.add.hotels',$record->id)->with('success', 'Voucher Created Successfully.');
			}
			else
			{
				return redirect()->route('vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} else {
        return redirect()->route('vouchers.index')->with('success', 'Voucher Created Successfully.');
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	
		$voucherStatus = config("constants.voucherStatus");
        return view('vouchers.view', compact('voucher','voucherHotel','voucherActivity','voucherStatus'));
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
        return view('vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
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
            'agent_id'=>'required',
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'customer_name'=>'required',
			'customer_mobile'=>'required',
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
		$record->guest_name = $request->input('customer_name');
		$record->status = $request->input('status');
        $record->save();
		if($record->is_hotel != 1)
		{
		$voucherHotel = VoucherHotel::where('voucher_id',$record->id)->delete();
		}
		if($record->is_activity != 1)
		{
		$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->delete();
		}
		
        return redirect('vouchers')->with('success','Voucher Updated.');
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
		$voucherHotel = VoucherHotel::where('voucher_id',$id)->delete();
		$voucherActivity = VoucherActivity::where('voucher_id',$id)->delete();
		
        $record->delete();
        return redirect('vouchers')->with('success', 'Voucher Deleted.');
    }
	
	public function statusChangeVoucher(Request $request,$id)
    {
		$data = $request->all();
		
        $record = Voucher::find($id);
		$record->status_main = $data['statusv'];
		$record->payment_date = $data['payment_date'];
		$record->save();
		if($data['statusv'] == 4)
		{
		$code = 'INV-100'.$record->id;
		$recordUser = Voucher::find($record->id);
		$recordUser->invoice_number = $code;
		$recordUser->save();
		}
        return redirect()->back()->with('success', 'Status Change Successfully.');
    }
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
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
         $response[] = array("value"=>$user->id,"label"=>$user->_full_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	  
        return response()->json($response);
    }
	
	public function autocompleteCustomer(Request $request)
    {
		$search  = $request->get('search');
        $customers = Customer::where('status', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($customers as $customer){
		  $cusDetails = '<b>Email:</b>'.$customer->email.' <b>Mobile No:</b>'.$customer->mobile.' <b>Address:</b>'.$customer->address. " ".$customer->zip_code;
         $response[] = array("value"=>$customer->id,"label"=>$customer->name.'('.$customer->mobile.')','cusDetails'=>$cusDetails);
      }
        return response()->json($response);
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addHotelsList(Request $request,$vid)
    {
        $data = $request->all();
		
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Hotel::with(['country', 'state', 'city', 'hotelcategory']);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $query->where('country_id', $data['country_id']);
        }
        if (isset($data['state_id']) && !empty($data['state_id'])) {
            $query->where('state_id', $data['state_id']);
        }
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
       
        $query->where('status', 1);
          
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        $hotelcategories = HotelCategory::where('status', 1)->orderBy('name', 'ASC')->get();
		$voucher = Voucher::find($vid);
		
        return view('vouchers.hotels', compact('records', 'countries', 'states', 'cities', 'hotelcategories','vid','voucher'));
    }
	
	
	/**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function addHotelsView($hid,$vid)
    {
		$query = Hotel::with(['country', 'state', 'city', 'hotelcategory']);
		$query->where('id', $hid);
		$hotel = $query->where('status', 1)->first();
		$voucher = Voucher::find($vid);
       return view('vouchers.hotel-add-view', compact('hotel','hid','vid','voucher'));
    }
	
	public function newRowAddmore(Request $request)
    {
		$hotel_id = $request->input('hotel_id');
		$v_id = $request->input('v_id');
		$rowCount = $request->input('rowCount');
		$view = view("vouchers.addmore_markup_hotel",['rowCount'=>$rowCount,'hotel_id'=>$hotel_id,'v_id'=>$v_id])->render();
         return response()->json(['success' => 1, 'html' => $view]);
    }
	
	 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
	public function hotelSaveInVoucher(Request $request)
    {
		
		//print_r($request->all());
		//exit;
		
		$voucher_id = $request->input('v_id');
		$hotel_id = $request->input('hotel_id');
		$check_in_date = $request->input('check_in_date');
		$check_out_date = $request->input('check_out_date');
	
		$room_type = $request->input('room_type');
		$nom_of_room = $request->input('nom_of_room');
		
		$nop_s = $request->input('nop_s');
		$nop_d = $request->input('nop_d');
		$nop_eb = $request->input('nop_eb');
		$nop_cwb = $request->input('nop_cwb');
		$nop_cnb = $request->input('nop_cnb');
		
		$nr_s = $request->input('nr_s');
		$nr_d = $request->input('nr_d');
		$nr_eb = $request->input('nr_eb');
		$nr_cwb = $request->input('nr_cwb');
		$nr_cnb = $request->input('nr_cnb');
		
		$ppa_s = $request->input('ppa_s');
		$ppa_d = $request->input('ppa_d');
		$ppa_eb = $request->input('ppa_eb');
		$ppa_cwb = $request->input('ppa_cwb');
		$ppa_cnb = $request->input('ppa_cnb');
		
		$markup_p_s = $request->input('markup_p_s');
		$markup_p_d = $request->input('markup_p_d');
		$markup_p_eb = $request->input('markup_p_eb');
		$markup_p_cwb = $request->input('markup_p_cwb');
		$markup_p_cnb = $request->input('markup_p_cnb');
		
		$markup_v_s = $request->input('markup_v_s');
		$markup_v_d = $request->input('markup_v_d');
		$markup_v_eb = $request->input('markup_v_eb');
		$markup_v_cwb = $request->input('markup_v_cwb');
		$markup_v_cnb = $request->input('markup_v_cnb');
		
		$data = [];
		foreach($room_type as $k => $v)
		{
			
			$data[] = [
					'room_type' => $v,
                    'nom_of_room' => $nom_of_room[$k],
					'nop_s' => $nop_s[$k],
                    'nop_d' => $nop_d[$k],
					'nop_eb' => $nop_eb[$k],
					'nop_cwb' => $nop_cwb[$k],
					'nop_cnb' => $nop_cnb[$k],
					'nr_s' => $nr_s[$k],
					'nr_d' => $nr_d[$k],
					'nr_eb' => $nr_eb[$k],
					'nr_cwb' => $nr_cwb[$k],
					'nr_cnb' => $nr_cnb[$k],
					'ppa_s' => $ppa_s[$k],
					'ppa_d' => $ppa_d[$k],
					'ppa_eb' => $ppa_eb[$k],
					'ppa_cwb' => $ppa_cwb[$k],
					'ppa_cnb' => $ppa_cnb[$k],
					'markup_p_s' => $markup_p_s[$k],
					'markup_p_d' => $markup_p_d[$k],
					'markup_p_eb' => $markup_p_eb[$k],
					'markup_p_cwb' => $markup_p_cwb[$k],
					'markup_p_cnb' => $markup_p_cnb[$k],
					'markup_v_s' => $markup_v_s[$k],
					'markup_v_d' => $markup_v_d[$k],
					'markup_v_eb' => $markup_v_eb[$k],
					'markup_v_cwb' => $markup_v_cwb[$k],
					'markup_v_cnb' => $markup_v_cnb[$k],
					
                ];
		}
		
		$dataInsert = [
			'voucher_id' => $voucher_id,
			'hotel_id' => $hotel_id,
			'check_in_date' => $check_in_date,
			'check_out_date' => $check_out_date,
			'hotel_other_details' => json_encode($data),
		];
		
		if(count($dataInsert) > 0)
		{
			VoucherHotel::insert($dataInsert);
		}
		
		if ($request->has('save_and_continue')) {
         return redirect()->route('voucher.add.hotels',$voucher_id)->with('success', 'Hotel added Successfully.');
		} else {
        return redirect('vouchers')->with('success', 'Hotel Added Successfully.');
		}
		
      
    }
	
	public function destroyHotelFromVoucher($id)
    {
        $record = VoucherHotel::find($id);
        $record->delete();
        return redirect()->back()->with('success', 'Hotel Deleted Successfully.');
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
		
        $query = Activity::with('prices')->where('status',1)->where('is_price',1);
	
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
		
        return view('vouchers.activities-list', compact('records','typeActivities','vid','voucher'));
		
       
    }
	
	public function addActivityView($aid,$vid)
    {
		$query = Activity::where('id', $aid);
		$activity = $query->where('status', 1)->first();
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		

		$activityPrices = ActivityPrices::where('activity_id', $aid)->get();
//->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->get();

		
		$typeActivities = config("constants.typeActivities"); 
		
			
			
       return view('vouchers.activities-add-view', compact('activity','aid','vid','voucher','typeActivities','activityPrices'));
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
		
		$data = [];
		foreach($activity_select as $k => $v)
		{
			
			$data[] = [
			'voucher_id' => $voucher_id,
			'activity_id' => $activity_id,
			'activity_vat' => $activity_vat,
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
					
                ];
		}
		
		if(count($data) > 0)
		{
			VoucherActivity::insert($data);
		}
		
		if ($request->has('save_and_continue')) {
         return redirect()->route('voucher.add.activity',$voucher_id)->with('success', 'Activity added Successfully.');
		} else {
        return redirect('vouchers')->with('success', 'Activity Added Successfully.');
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
				'hhotelActName' => $activity->title.'-'.$ap->variant_name.'-'.$ap->variant_code,
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
			$subTotalGrand = $subTotal;
			$vatGrand = '1.05';
			$vatTotal = $subTotalGrand/$vatGrand;
			$grandWithVatTotal = ($vatTotal+$subTotal) - $discountTotal;
			
       
//return view('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','subTotalGrand','grandWithVatTotal','vatTotal'));
        $pdf = SPDF::loadView('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','subTotalGrand','grandWithVatTotal','vatTotal'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download('Invoice'.$vid.'.pdf');
		
	
	
	return \Response::make($content,200, $headers);
    }
	
}
