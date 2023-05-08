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
        return view('vouchers.create', compact('countries','airlines'));
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
			'arrival_airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
		]);
		
		
		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input

        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->status = $request->input('status');
        $record->save();
		
		if ($request->has('save_and_hotel')) {
			if($record->is_hotel == 1){
			return redirect()->route('voucher.add.hotels',$record->id)->with('success', 'Voucher Created Successfully.');
			}
			else
			{
				return redirect('vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} else {
        return redirect('vouchers.index')->with('success', 'Voucher Created Successfully.');
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
        return view('vouchers.view', compact('voucher'));
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
			'arrival_airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
		]);

		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		
        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
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

        return view('vouchers.hotels', compact('records', 'countries', 'states', 'cities', 'hotelcategories','vid'));
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
       return view('vouchers.hotel-add-view', compact('hotel','hid','vid'));
    }
	
}
