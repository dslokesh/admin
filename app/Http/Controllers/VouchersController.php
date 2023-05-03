<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\VoucherAirline;
use App\Models\VoucherHotel;
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
			'airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
			'depature_date' => 'required_if:is_flight,==,1',
        ], [
			'airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
		]);
		
		
		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input

        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->airlines_id = $request->input('airlines_id');
		$record->arrival_date = $arrival_date;
		$record->depature_date = $depature_date;
		$record->status = $request->input('status');
        $record->save();
        return redirect('vouchers')->with('success','Voucher Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
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
			'country_id'=>'required'
        ], [
			'agent_id.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $request->input('customer_id_select');
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
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
        $users = User::select("name", "lname", "id")
					->where('role_id', 3)
					->where('is_active', 1)
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
		$response = array();
      foreach($users as $user){
         $response[] = array("value"=>$user->id,"label"=>$user->_full_name);
      }
	  
        return response()->json($response);
    }
	
	public function autocompleteCustomer(Request $request)
    {
        $customers = Customer::where('status', 1)
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
		$response = array();
      foreach($customers as $customer){
		  $cusDetails = '<b>Email:</b>'.$customer->email.' <b>Mobile No:</b>'.$customer->mobile.' <b>Address:</b>'.$customer->address. " ".$customer->zip_code;
         $response[] = array("value"=>$customer->id,"label"=>$customer->name,'cusDetails'=>$cusDetails);
      }
        return response()->json($response);
    }
	
}
