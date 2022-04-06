<?php

namespace App\Http\Controllers;
use App\Mail\sendRegisterToUserMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;
use Image;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::orderBy('created_at', 'DESC')->get();
        //return view('users.index', compact('users'));
        return view('users.index'); 
    }

    /*
    AJAX request
    */
    public function getUsers(Request $request){
 
 
         //pr($request); die;
         ## Read value
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
        //pr($_GET);
        //die;

         // Fetch records

         if ($request->get('role') != '') {

            // Total records
            $totalRecords = User::select('count(*) as allcount')->where('role_id', $request->get('role'))->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('role_id', $request->get('role'))->where('name', 'like', '%' .$searchValue . '%')->count();

            $records = User::orderBy($columnName,$columnSortOrder)
            ->where('users.name', 'like', '%' .$searchValue . '%')
            ->where('role_id', $request->get('role'))
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

         }else{

            // Total records
            $totalRecords = User::select('count(*) as allcount')->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

            $records = User::orderBy($columnName,$columnSortOrder)
            ->where('users.name', 'like', '%' .$searchValue . '%')
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

         }

        
 
         $data_arr = array();
             foreach($records as $record){
                 $html = '';
                 $html.='<a class="btn btn-info btn-sm" href="'.route('users.edit',$record->id).'" title="Edit"> <i class="fas fa-pencil-alt"></i></a>';
                 if($record->role->name == 'Territory Manager')
                 {
                    $html.='&nbsp;<a class="btn btn-info btn-sm" href="'.route('userareas.index').'?userid='.$record->id.'" title="Area"> <i class="fas fa-map-marker"></i></a>';
                 }
                 $data_arr[] = array(
                     "id" => ++$start,
                     "name" => $record->name,
                     "email" => $record->email,
                     "role_id" => $record->role->name,
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
        $roles = Role::where(['status' => 1])->where('id', '!=' , '4bc88182-30b3-474e-b6c7-a02ff6885536')->orderBy('name', 'ASC')->get();
        //pr($roles); die;
        return view('users.create', compact('roles', 'hashed_random_password'));
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
            'name' => 'required|max:255|sanitizeScripts',
            'role_id' => 'required',
            'email' => 'required|max:255|email|sanitizeScripts|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8|max:255|sanitizeScripts|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
            //'c_password' => 'required|same:password',
        ],
        [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'role_id.required' => "The role field is required.",
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'email.regex' => 'The email must be a valid email address.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.',
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]);

        $data = $request->all();
        $user = new User();
        $user->name = $request->input('name'); 
        $user->role_id = $request->input('role_id'); 
        $user->email = $request->input('email');
        $user->is_active = 1;
        $user->password = bcrypt($request->input('password'));
        //pr($user); die;
        $user->save();

        Mail::to($data['email'],'Login details')->send(new sendRegisterToUserMailable($data));  

        return redirect('users')->with('success','Users Created Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::where(['status' => 1])->where('id', '!=' , '4bc88182-30b3-474e-b6c7-a02ff6885536')->orderBy('name', 'ASC')->get();
        $companies = Company::where(['status' => 1])->orderBy('name', 'ASC')->get();
        $user = User::find($id);
        //pr($user);
        return view('users.edit', compact('roles','user','companies'));
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
        $options['allow_img_size'] = 10;
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts',
            'phone' => 'nullable|max:20|sanitizeScripts',
            'job_title' => 'nullable|max:255|sanitizeScripts',
            'delivery_address' => 'nullable|sanitizeScripts',
            'postcode' => 'nullable|max:20|sanitizeScripts',
            'email'=>'required|max:255|sanitizeScripts|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' .$id,
            'position' => 'nullable|max:255|sanitizeScripts',  
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),     
            'is_active'=>'required',
        ],
        [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'phone.sanitize_scripts' => 'Invalid value entered for Mobile Number field.',
            'job_title.sanitize_scripts' => 'Invalid value entered for Job Title field.',
            'delivery_address.sanitize_scripts' => 'Invalid value entered for Delivery Address field.',
            'postcode.sanitize_scripts' => 'Invalid value entered for Postcode field.',
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'email.regex' => 'The email must be a valid email address.',
            'position.sanitize_scripts' => 'Invalid value entered for Position field.',
        ]);

        $user = User::find($id);

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
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/users/thumb/'.$newName));

            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/users/'.$user->image);
			$oldImageThumb = public_path('/uploads/users/thumb/'.$user->image);
			if(!empty($user->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
            $user->image = $newName;
		}

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->job_title = $request->input('job_title');
        $user->delivery_address = $request->input('delivery_address');
        $user->postcode = $request->input('postcode');
        $user->email = $request->input('email');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->position = $request->input('position');
        $user->is_active = $request->input('is_active');
        $user->company_id = $request->input('company_id');
        if($request->input('is_newsletter') == "on"){
            $user->is_newsletter = 1;
        }else{
            $user->is_newsletter = 0;
        }
        if($request->input('is_notification') == "on"){
            $user->is_notification = 1;
        }else{
            $user->is_notification = 0;
        }

        $user->save();
        return redirect('users')->with('success','User Updated.');
    }
    
    public function dummyData(){

        return ["name"=>"test", "email_address"=>"example@yopmail.com"];
    }
}
