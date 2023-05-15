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
use Illuminate\Http\Request;
use DB;


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
			'customer_id'=>'required',
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

        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
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
        return view('vouchers.view', compact('voucher','voucherHotel'));
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
        return view('vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines]);
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
			'customer_id'=>'required',
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
		
        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
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
		$record->status = $request->input('status');
        $record->save();
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
        $record->delete();
        return redirect('vouchers')->with('success', 'Voucher Deleted.');
    }
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
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
	
}
