<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Activity;
use App\Models\AgentPriceMarkup;
use App\Models\ActivityPrices;
use App\Models\AgentDetails;
use App\Models\AgentAdditionalUser;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use DB;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AgentsController extends Controller
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
        $query = User::with(['country', 'state', 'city']);
		$query->where('role_id', 3);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
       if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
		if (isset($data['cname']) && !empty($data['cname'])) {
            $query->where('company_name', 'like', '%' . $data['cname'] . '%');
        }
       
        if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', $data['code']);
        }
		
		 if (isset($data['mobile']) && !empty($data['mobile'])) {
            $query->where('mobile', $data['mobile']);
        }
		
		if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
		
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('is_active', 1);
            if ($data['status'] == 2)
                $query->where('is_active', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('agents.index', compact('records', 'countries', 'states', 'cities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('agents.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		$options['allow_img_size'] = 10;
        $request->validate([
           'first_name' => 'required|max:255|sanitizeScripts|alpha',
            'last_name' => 'required|max:255|sanitizeScripts|alpha',
            'mobile' => 'required',
            'address' => 'required',
			'email' => 'required|max:255|sanitizeScripts|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
			'password' => 'required|min:8|max:255|sanitizeScripts',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),  
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'postcode' => 'required',
			
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);


		$input = $request->all();
		
        $record = new User();
		
		$destinationPath = public_path('/uploads/users/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/users/thumb/'.$newName));

            $record->image = $newName;
		}
		
        $record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('postcode');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
        $record->is_active = $request->input('status');
		$record->agent_category = $request->input('agent_category');
		$record->agent_credit_limit = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
		$record->sales_person = $request->input('sales_person');
		$record->agent_amount_balance = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
        $record->created_by = Auth::user()->id;
		$record->role_id = 3; 
        $record->password = bcrypt($request['password']);
		$record->ticket_only = (!empty($request->input('ticket_only')))?$request->input('ticket_only'):0;
		$record->sic_transfer = (!empty($request->input('sic_transfer')))?$request->input('sic_transfer'):0;
		$record->pvt_transfer = (!empty($request->input('pvt_transfer')))?$request->input('pvt_transfer'):0;
		$record->vat = $request->input('vat');
        $record->save();
        $record->attachRole('3');
		$code = 'A00'.$record->id;
		$recordUser = User::find($record->id);
		$recordUser->code = $code;
		$recordUser->save();
		
		
		$userCount = User::where("role_id",3)->count();
		$codeNumber  = $userCount + 1;
		$code = 'TA-700'.$codeNumber;
		$recordUser = User::find($record->id);
		$recordUser->code = $code;
		$recordUser->save();
		
		$additionalContactInsert = [];
		$additionalContact = $request->input('a_name');
		$department = $request->input('a_department');
		$mobile = $request->input('a_mobile');
		$phone = $request->input('a_phone');
		$email = $request->input('a_email');
		if(!empty($additionalContact) > 0)
		{
			foreach($additionalContact as $k => $data)
			{
				if(!empty($data))
				{
				$additionalContactInsert[$k]=[
				'user_id' => $record->id,
				'name' => $data,
				'department' => $department[$k],
				'mobile' => $mobile[$k],
				'phone' => $phone[$k],
				'email' => $email[$k],
				];
				}
			}
			
			if(!empty($additionalContactInsert)){
				AgentAdditionalUser::insert($additionalContactInsert);
			}
		}
		
        return redirect('agents')->with('success', 'Agent Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(User $agent)
    {
		$activity_ids = explode(",",$agent->activity_id);
		
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$activity = Activity::find($aid);
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = AgentPriceMarkup::where('agent_id',  $agent->id)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
				if(!empty($m))
				{
					$markups[$activity->title][$variant['variant_code']] = [
						'ticket_only'=>$m->ticket_only,
						'sic_transfer'=>$m->sic_transfer,
						'pvt_transfer'=>$m->pvt_transfer,
					];
				}
			}
			
		}
		
		$agentAdditionalUsers = AgentAdditionalUser::where('user_id', $agent->id)->get();
		
        return view('agents.view', compact('agent','markups','agentAdditionalUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = User::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
		$agentAdditionalUsers = AgentAdditionalUser::where('user_id', $record->id)->get();
        return view('agents.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities,'agentAdditionalUsers' => $agentAdditionalUsers]);
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
		$options['allow_img_size'] = 10;
        $request->validate([
            'first_name' => 'required|max:255|sanitizeScripts|alpha',
            'last_name' => 'required|max:255|sanitizeScripts|alpha',
            'mobile' => 'required',
			'email'=>'required|max:255|sanitizeScripts|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' .$id,
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'postcode' => 'required',
			
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);
		
		$input = $request->all();
        $record = User::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/users/');
		//$newName = '';
        //pr($request->all()); die;
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['record'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/users/thumb/'.$newName));
			
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
				$oldImage = public_path('/uploads/users/'.$record->image);
				$oldImageThumb = public_path('/uploads/users/thumb/'.$record->image);
				if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
					unlink($oldImage);
					unlink($oldImageThumb);
				}
			}
            $record->image = $newName;
		}
		
		 if(!empty($request->input('password'))){
            request()->validate([
                'password' => 'required|alpha_num|between:6,20|confirmed',
            ]);
            $record->password = bcrypt(trim($request->input('password')));
        }
		
		$record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('postcode');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->is_active = $request->input('status');
		$record->agent_category = $request->input('agent_category');
		//$record->agent_credit_limit = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
		$record->sales_person = $request->input('sales_person');
		//$record->agent_amount_balance = (!empty($request->input('agent_amount_balance')))?$request->input('agent_amount_balance'):0;
		$record->ticket_only = (!empty($request->input('ticket_only')))?$request->input('ticket_only'):0;
		$record->sic_transfer = (!empty($request->input('sic_transfer')))?$request->input('sic_transfer'):0;
		$record->pvt_transfer = (!empty($request->input('pvt_transfer')))?$request->input('pvt_transfer'):0;
		$record->vat = $request->input('vat');
		$record->updated_by = Auth::user()->id;
		
		if(($request->input('credit_limit_type') == 1) && ($request->input('credit_amount') > 0))
		{
			$record->agent_credit_limit +=$request->input('credit_amount');
			$record->agent_amount_balance +=$request->input('credit_amount');
		}elseif(($request->input('credit_limit_type') == 2) && ($request->input('credit_amount') > 0))
		{
			$record->agent_credit_limit -=$request->input('credit_amount');
			$record->agent_amount_balance -=$request->input('credit_amount');
		}
		
        $record->save();
		
		$additionalContactInsert = [];
		$additionalContact = $request->input('a_name');
		$department = $request->input('a_department');
		$mobile = $request->input('a_mobile');
		$phone = $request->input('a_phone');
		$email = $request->input('a_email');
		if(!empty($additionalContact) > 0)
		{
			AgentAdditionalUser::where('user_id', $record->id)->delete();
			foreach($additionalContact as $k => $data)
			{
				if(!empty($data))
				{
				$additionalContactInsert[$k]=[
				'user_id' => $record->id,
				'name' => $data,
				'department' => $department[$k],
				'mobile' => $mobile[$k],
				'phone' => $phone[$k],
				'email' => $email[$k],
				];
				}
			}
			
			if(!empty($additionalContactInsert)){
				AgentAdditionalUser::insert($additionalContactInsert);
			}
		}
		
        return redirect('agents')->with('success', 'Agent Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::find($id);
        $record->delete();
        return redirect('agents')->with('success', 'Agent Deleted.');
    }
	
	public function priceMarkupActivityList($id)
    {
		$agentId = $id;
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $records = Activity::where('status', 1)->where('is_price', 1)->orderBy('title', 'ASC')->paginate($perPage);
		$agent = User::find($agentId);
		$activity_ids = explode(",",$agent->activity_id);
        return view('agents.priceActivities', compact('records','agentId','activity_ids'));
    }
	
	public function priceMarkupActivitySave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $agent = User::find($request->input('agent_id'));
		
		$activity_id = $request->input('activity_id');
		$data = [];
		if(!empty($activity_id))
		{
			foreach($activity_id as $k => $av)
			{
				$data[] = $av;
			}
			
			$jsonData = implode(",",$data);
			
			$agent->activity_id = $jsonData;
			$agent->save();
			return redirect()->route('agents.markup.price',[$request->input('agent_id')])->with('success', 'Activity Saved.');
		}
		else
		{
			return redirect()->back()->with('error', 'Please select at least one activity.');
		}
        
		
        
        
    }
	
	public function markupPriceList($id)
    {
		$agentId = $id;
		$agent = User::find($agentId);
		$activity_ids = explode(",",$agent->activity_id);
		$activities = Activity::whereIn('id', $activity_ids)->where(['status'=> 1,'is_price'=> 1])->get();
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = AgentPriceMarkup::where('agent_id',  $agentId)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
				if(!empty($m))
				{
					$markups[$variant['variant_code']] = [
						'ticket_only'=>$m->ticket_only,
						'sic_transfer'=>$m->sic_transfer,
						'pvt_transfer'=>$m->pvt_transfer,
					];
				}
			}
			
		}
		
		
		
		/* print_r($markups);
		exit; */
        return view('agents.agentPriceMarkup', compact('agentId','activities','variants','markups'));
    }
	
	public function markupPriceSave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $record = new AgentPriceMarkup();
		$agent_id = $request->input('agent_id');
		$ticket_only = $request->input('ticket_only');
		$sic_transfer = $request->input('sic_transfer');
		$pvt_transfer = $request->input('pvt_transfer');
		$data = [];
		if(!empty($ticket_only))
		{
			foreach($ticket_only as $activity_id => $acv)
			{
				foreach($acv as $variant_code => $ac)
				{
				$data[] = [
				'agent_id' => $agent_id,
				'activity_id' => $activity_id,
				'variant_code' => $variant_code,
				'ticket_only' => $ac,
				'sic_transfer' => $sic_transfer[$activity_id][$variant_code],
				'pvt_transfer' => $pvt_transfer[$activity_id][$variant_code],
				'created_by' => Auth::user()->id,
				'updated_by' => Auth::user()->id,
				];
				}
			}
		}
        
		if(count($data) > 0)
		{
			AgentPriceMarkup::where("agent_id",$agent_id)->delete();
			AgentPriceMarkup::insert($data);
			 return redirect('agents')->with('success', 'Markup saved successfully.');
		}
		else
		{
			 return redirect()->back()->with('error', 'Something went wrong.');
		}
		
    }
	
}