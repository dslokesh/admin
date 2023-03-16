<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use DB;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = State::with('country');
		if(isset($data['name']) && !empty($data['name']))
        {
            $query->where('name','like', '%'.$data['name'].'%');
        }
		if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('status',1);
            if($data['status']==2)
            $query->where('status',0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		 
		
        return view('states.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		 $countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
        return view('states.create',compact('countries'));
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
            'name'=>'required|max:255|sanitizeScripts',
			'country_id'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
		]);
		
		
		$recordData = State::where('country_id',$request->input('country_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The state name has already been taken in this country.');
		}
        $record = new State();
		$record->country_id = $request->input('country_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('states')->with('success','State Created Successfully.');
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
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = State::find($id);
		$countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
        return view('states.edit')->with('record',$record)->with('countries',$countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name'=>'required|max:255|sanitizeScripts',
			'country_id'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
		]);
		
		$recordData = State::where('id','!=',$id)->where('country_id',$request->input('country_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The state name has already been taken in this country.');
		}
		
        $record = State::find($id);
		$record->country_id = $request->input('country_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('states')->with('success','State Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = State::find($id);
        $record->delete();
        return redirect('states')->with('success', 'State Deleted.');
    }
	
}
