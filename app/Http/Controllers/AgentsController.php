<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\AgentDetails;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use DB;
use Image;
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
       
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
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
			'password' => 'required|min:8|max:255|sanitizeScripts|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),  
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'postcode' => 'required',
			'code' => 'required'
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
		$record->code = $request->input('code');
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
        $record->created_by = Auth::user()->id;
		$record->role_id = 3; 
        $record->password = bcrypt($request['password']);
        $record->save();
        $record->attachRole('3');
		
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
        return view('agents.view', compact('agent'));
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
        return view('agents.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
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
			'code' => 'required',
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

            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/users/'.$record->image);
			$oldImageThumb = public_path('/uploads/users/thumb/'.$record->image);
			if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
            $record->image = $newName;
		}
		
		$record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		$record->code = $request->input('code');
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
        $record->save();
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
	
	
}