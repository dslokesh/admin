<?php

namespace App\Http\Controllers;
use App\Mail\sendRegisterToUserMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\SiteHelpers;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Image;
use DB;
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       

        $data = $request->all();
        $user = Auth::user();
        $query = User::where('role_id', '2');
        $query->select('users.*');
        
        if(isset($data['user_name']) && !empty($data['user_name']))
        {
            $query->where(DB::raw("concat(users.name, ' ', users.lname)"), 'LIKE', "%".$data['user_name']."%");
        }
        if(isset($data['user_email']) && !empty($data['user_email']))
        {
            $query->where('users.email','like', '%'.$data['user_email'].'%');
        }

        if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('is_active',1);
            if($data['status']==2)
            $query->where('is_active',0);
        }

          $records = $query->paginate(25);
        return view('users.index',compact('records')); 
    }

   

   

    /*
    AJAX request
    */
    public function getUsers(Request $request){
 
 
         //pr($request); die;
         ## Read value
         $user = Auth::user();
         $draw = $request->get('draw');
         $start = $request->get("start");
         $rowperpage = $request->get("length"); // Rows display per page
   
 
         $columnIndex_arr = $request->get('order');
         $columnName_arr = $request->get('columns');
         $order_arr = $request->get('order');
         $search_arr = $request->get('search');
 
         $columnIndex = $columnIndex_arr[0]['column']; // Column index
         $columnName = $columnName_arr[$columnIndex]['data']; // Column name
         $columnSortOrder = $order_arr[0]['dir']; // asc or desc
         $searchValue = $search_arr['value']; // Search value
 
        //echo $roleBy= $request->get('role_by'); 
       // pr($columnSortOrder);
        //die;

         // Fetch records
      
         if ($request->get('role') != '') {

            // Total records
            $totalRecords = User::select('count(*) as allcount')->where('role_id', $request->get('role'))->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('role_id', $request->get('role'))->where('name', 'like', '%' .$searchValue . '%')->count();
            if($columnName=='full_name')
            $columnName = "name";

          $query = User::orderBy($columnName,$columnSortOrder);
          $query->where('users.name', 'like', '%' .$searchValue . '%');
          $query->where('role_id', $request->get('role'));
          $query->select('users.*');
          if ($user->hasRole(3)) {
            $comp = Company::where("owner",$user->id)->pluck("id");
            $query->where(function ($q) use($user,$comp) {
                $q->whereIn('users.company_id', $comp)->orWhere("users.created_by",$user->id);
            });
            
        }
            $records = $query->skip($start)
            ->take($rowperpage)
            ->get();

         }else{

            // Total records
            $totalRecords = User::select('count(*) as allcount')->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

            $query = User::orderBy($columnName,$columnSortOrder);
            $query->where('users.name', 'like', '%' .$searchValue . '%');
            $query->select('users.*');
            if ($user->hasRole(3)) {
                $query->where("created_by",$user->id);
            }

            $records = $query->skip($start)
            ->take($rowperpage)
            ->get();
         }

        
 
         $data_arr = array();
             foreach($records as $record){
				// print_R($record->roles);
                 $assignProducts = UserProductRelation::where("user_id",$record->id)->count();
                 $html='&nbsp;<a class="btn btn-info btn-sm" href="'.route("users.show",$record->id).'" title="View User"> <i class="fa fa-eye"></i></a>&nbsp;';
				 $image = '';
                 $html.='<a class="btn btn-info btn-sm" href="'.route('users.edit',$record->id).'" title="Edit"> <i class="fas fa-pencil-alt"></i></a>';
				 if($record->hasRole(3))
                 {
                    $html.='&nbsp;<a class="btn btn-info btn-sm" href="'.route('userareas.index').'?userid='.$record->id.'" title="Area"> <i class="fas fa-map-marker"></i></a>';
                 }
                if($record->hasRole(4))
                 {
                    $html.='&nbsp;<a class="btn btn-info btn-sm" href="'.route("certificates.index",["associate_id"=>$record->id,"type"=>"User"]).'" title="Certificate view/add"> <i class="fa fa-file"></i></a>';
                    $html.='&nbsp;<a class="btn btn-info btn-sm" href="'.route("assignedProduct",["user_id"=>$record->id]).'" title="Assigned Products"> Assigned Products('.$assignProducts.')</a>';
                 }
                if($record->hasRole(3))
                 {
                    $html.='&nbsp;<a class="btn btn-info btn-sm" href="'.route("certificates.index",["associate_id"=>$record->id,"type"=>"User"]).'" title="Certificate view/add"> <i class="fa fa-file"></i></a>';

                   
                   
                 }
                 if($record->image!='')
                 {
                    $image = '<img src="'.asset('uploads/users/thumb/'.$record->image).'" width="50">';
                 }   
                 
				
                 $data_arr[] = array(
                     "image" => $image,
                     "name" => $record->name,
                     "full_name" => $record->full_name,
                     "email" => $record->email,
                     "role_id" => $record->roles[0]->name,
                     "company" => ($record->company)?$record->company->name:'',
                     "is_active" => $record->is_active ? 'Active' : 'Inactive',
                     "created_at" => $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null,
                     //"updated_at" => $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null,
                     "action" =>$html
                 );
             }
 
         $response = array(
         "draw" => intval($draw),
         "iTotalRecords" => $totalRecords,
         "iTotalDisplayRecords" => $totalRecordswithFilter,
         "aaData" => $data_arr
         );
 
         echo json_encode($response);
         exit;
   }


      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hashed_random_password = Str::random( 12 );
        $roles = Role::where('id', '!=' , '1')->orderBy('name', 'ASC')->get();
        //pr($roles); die;
        return view('users.create', compact('roles','hashed_random_password'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        //pr( $request->all()); die;
        $request->validate([
            'first_name' => 'required|max:255|sanitizeScripts|alpha',
            'last_name' => 'required|max:255|sanitizeScripts|alpha',
            'role_id' => 'required',
            'email' => 'required|max:255|email|sanitizeScripts|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
           // 'password' => 'required|min:6|max:255|sanitizeScripts',
            'password' => 'required|min:8|max:255|sanitizeScripts|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
            //'c_password' => 'required|same:password',
        ],
        [
            'first_name.sanitize_scripts' => 'Invalid value entered for First Name field.',
            'last_name.sanitize_scripts' => 'Invalid value entered for Last Name field.',
            'role_id.required' => "The role field is required.",
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'email.regex' => 'The email must be a valid email address.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.',
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]);

        
        $data = $request->all();
        $user = new User();
        $user->name = $request->input('first_name'); 
        $user->lname = $request->input('last_name'); 
        $user->role_id = $request->input('role_id'); 
        $user->email = $request->input('email');
        $user->is_active = 1;
        $user->created_by = Auth::user()->id;
        $user->password = bcrypt($request->input('password'));
        //pr($user); die;
        $user->save();
        $user->attachRole($request->input('role_id'));
       
           // Mail::to($data['email'],'Login details')->send(new sendRegisterToUserMailable($data)); 
        
       
            return redirect('users')->with('success','Users Created Successfully.');
        
    }

    public function show(User $user)
    {
        $ppes = [];
        $certificates = [];
        $project = [];
        if ($user->hasRole(4)) {
            $ppes = UserProductRelation::with(["product","user"])->where("user_id",$user->id)->get();
            $certificates = Certificate::where('associate_id', $user->id)->get();
         return view('users.view', compact('user','ppes','certificates'));
        
        }
        else
        {
            return view('users.view', compact('user','ppes','certificates'));
        }
        
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $roles = Role::where('id', '!=' , '1')->orderBy('name', 'ASC')->get();
        $user = User::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
       
        //pr($user);
		if(Auth::user()->id == $id)
		{
			return view('users.profile', compact('roles','user','countries','states','cities'));
		}
		else
		{
			return view('users.edit', compact('roles','user','countries','states','cities'));
		}
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
       
            $options['allow_img_size'] = 10;
            $request->validate([
                'first_name' => 'required|max:255|sanitizeScripts|alpha',
                'last_name' => 'required|max:255|sanitizeScripts|alpha',
				'city_id' => 'required',
				'state_id' => 'required',
				'country_id' => 'required',
                'postcode' => 'nullable|max:20|sanitizeScripts',
                'email'=>'required|max:255|sanitizeScripts|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' .$id,
                'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),     
                'is_active'=>'required',
            ],
            [
                'first_name.sanitize_scripts' => 'Invalid value entered for Name field.',
                'last_name.sanitize_scripts' => 'Invalid value entered for Name field.',
                'postcode.sanitize_scripts' => 'Invalid value entered for Postcode field.',
                'country.sanitize_scripts' => 'Invalid value entered for Country field.',
                'city.sanitize_scripts' => 'Invalid value entered for City field.',
                'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
                'email.regex' => 'The email must be a valid email address.',
            ]);
        

        

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
			$img = Image::make(public_path('/uploads/users/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/users/thumb/'.$newName));
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/users/'.$user->image);
			$oldImageThumb = public_path('/uploads/users/thumb/'.$user->image);
			if(!empty($user->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
            $user->image = $newName;
		}

        
        $user->name = $request->input('first_name');
        $user->lname = $request->input('last_name');
        $user->country_id = $request->input('country_id');
        $user->state_id = $request->input('state_id');
        $user->city_id = $request->input('city_id');
        $user->postcode = $request->input('postcode');
        $user->email = $request->input('email');
        $user->is_active = $request->input('is_active');
       
       

        $user->save();
		
        
       

		if(Auth::user()->id == $id)
		{
			return redirect('/dashboard')->with('success','User Updated.');
		}
		else
		{
            return redirect('users')->with('success','Users Updated Successfully.');
		}
		
        
    }
    
    public function dummyData(){

        return ["name"=>"test", "email_address"=>"example@yopmail.com"];
    }
	
	
}
