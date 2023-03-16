<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use DB;
class AjexController extends Controller
{
   
    public function getCityByCountrySelect(Request $request)
    {
		$data = $request->all();
        $records = City::select('name','id')->where('country_id',$data['country_id'])->get();
		return response()->json($records, 200);
    }
	
	public function getCityByStateSelect(Request $request)
    {
		$data = $request->all();
        $records = City::select('name','id')->where('state_id',$data['state_id'])->get();
		return response()->json($records, 200);
    }
	
	public function getStateByCountrySelect(Request $request)
    {
		$data = $request->all();
        $records = State::select('name','id')->where('country_id',$data['country_id'])->get();
		return response()->json($records, 200);
    }
}
