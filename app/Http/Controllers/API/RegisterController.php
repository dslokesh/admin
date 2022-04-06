<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\sendAPIRegisterToTechnicianMailable;
use App\Mail\sendForgotPasswordToUserMailable;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Hash;
use DB;
use Image;
use App\Http\Resources\Company as CompanyResource;
   
class RegisterController extends BaseController
{
    
    /**
     * Companylist api
     *
     * @return \Illuminate\Http\Response
     */
    public function companylist()
    {
        //$companies = Company::all(); 
        $companies = Company::where(['status' => 1])->orderBy('name', 'ASC')->get(); 
        //pr($companies); die;  
        return $this->sendResponse(CompanyResource::collection($companies), 'Companies retrieved successfully.');

    }
    
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $options['allow_img_size'] = 10;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|sanitizeScripts',
            'phone' => 'nullable|max:20|sanitizeScripts',
            'job_title' => 'nullable|max:255|sanitizeScripts',
            'delivery_address' => 'nullable|sanitizeScripts',
            'postcode' => 'nullable|max:20|sanitizeScripts',
            'email' => 'required|max:255|sanitizeScripts|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|max:255|sanitizeScripts|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
            //'c_password' => 'required|same:password',
        ],
        [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'phone.sanitize_scripts' => 'Invalid value entered for Mobile Number field.',
            'job_title.sanitize_scripts' => 'Invalid value entered for Job Title field.',
            'delivery_address.sanitize_scripts' => 'Invalid value entered for Delivery Address field.',
            'postcode.sanitize_scripts' => 'Invalid value entered for Postcode field.',
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'email.regex' => 'The email must be a valid email address.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.',
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long."
        ]);
   
        if($validator->fails()){
           //return $this->sendError('Validation Error.', $validator->errors()); 
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('name'))
                $errorMsg = $errors->first('name');
           elseif($errors->first('phone'))
               $errorMsg = $errors->first('phone'); 
           elseif($errors->first('job_title'))
               $errorMsg = $errors->first('job_title'); 
           elseif($errors->first('delivery_address'))
               $errorMsg = $errors->first('delivery_address'); 
           elseif($errors->first('postcode'))
               $errorMsg = $errors->first('postcode'); 
           elseif($errors->first('email'))
               $errorMsg = $errors->first('email');               
           elseif($errors->first('password'))
               $errorMsg = $errors->first('password'); 
           elseif($errors->first('image'))
               $errorMsg = $errors->first('image');       

           return $this->sendError($errorMsg); 
           
        }

        $input = $request->all();
        /** Below code for save image **/
		$destinationPath = public_path('/uploads/users/');
		$newName = '';
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
		}

        $input['image'] = $newName;
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = '4e882d9e-ca6d-4cfe-bd65-73ad1de313c1';
        $input['is_active'] = 1;
        /*$input['phone'] = $input['phone'];
        $input['company_id'] = $input['company_id'];
        $input['job_title'] = $input['job_title'];
        $input['delivery_address'] = $input['delivery_address'];
        $input['postcode'] = $input['postcode'];*/

        //pr($input); die;
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['phone'] =  $user->name;
        $success['company'] =  $user->company->name;
        $success['job_title'] =  $user->job_title;
        $success['delivery_address'] =  $user->delivery_address;
        $success['postcode'] =  $user->postcode;
        $success['name'] =  $user->name;
        $success['image'] =  url('/uploads/users/'.$user->image);
        $success['email'] =  $user->email;
        
        Mail::to($input['email'],'Registration Email')->send(new sendAPIRegisterToTechnicianMailable($input));  
   
        return $this->sendResponse($success, 'User has been registered successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|sanitizeScripts|email',
            'password' => 'required|max:255|sanitizeScripts',

        ],
        [
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.'
        ]);
   
        if($validator->fails()){
           //return $this->sendError('Validation Error.', $validator->errors()); 
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('email'))
               $errorMsg = $errors->first('email');           
           elseif($errors->first('password'))
               $errorMsg = $errors->first('password');  

            //echo $errorMsg;
           //return $this->sendError('Please enter login details correctly.');  
           return $this->sendError($errorMsg);        
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
   
            return $this->sendResponse($success, 'User login successfully.');
        }elseif(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            return $this->sendError('Oops!  Your account is inactive.');
        }else{ 
            return $this->sendError('Invalid login details.');
        } 
    }

    /**
     * forgot password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotpassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|sanitizeScripts|email'
        ],
        [
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.'
        ]);
   
        if($validator->fails()){
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('email'))
               $errorMsg = $errors->first('email');           

           return $this->sendError($errorMsg);        
        }

        $data = $request->all();
        $admin_details = DB::table('users')->where('email', $data['email'])->get();
		//print_r($admin_details); die('test');
		if(isset($admin_details[0]->id) && !empty($admin_details[0]->id)) {

            $token = Str::random(60);
            $update_pass = DB::table('users')->where('id', $admin_details[0]->id)->update(['remember_token' => $token]);

            $success = (object)array();
            $success->email = $request->email;
            //if(Auth::attempt(['email' => $request->email]))
            /*if(Auth::attempt(['email' => $data['email']])){
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
            }*/
            Mail::to($data['email'],'Password Reset Link')->send(new sendForgotPasswordToUserMailable($admin_details[0], $token));

            return $this->sendResponse($success, 'Success! password reset link has been sent to your email.');
           
		} else {
            return $this->sendError('Email does not exists.');
		}
    }

    /**
     * change password api
     *
     * @return \Illuminate\Http\Response
     */
    public function changepassword(Request $request)
    {
        //die('xvcx');

        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $validator = Validator::make($input, [
            'OldPassword' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
            'confirmPassword' => 'required|same:password',
        ],
        [
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]);
        //$validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            //$arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
            $errors = $validator->errors();
            $errorMsg = '';
            if($errors->first('OldPassword'))
                $errorMsg = $errors->first('OldPassword'); 
            elseif($errors->first('password'))
                $errorMsg = $errors->first('password');  
            elseif($errors->first('confirmPassword'))
                $errorMsg = $errors->first('confirmPassword');           
 
            return $this->sendError($errorMsg);   
        } else {
            try {
                if ((Hash::check(request('OldPassword'), Auth::user()->password)) == false) {
                    return $this->sendError("The old password is incorrect.");  
                } else if ((Hash::check(request('password'), Auth::user()->password)) == true) {
                    return $this->sendError("Please enter a password which is not similar then current password.");  
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['password'])]);
                    //$arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                    $success['email'] =  Auth::user()->email;
                    return $this->sendResponse($success, 'Password has been Updated Successfully, Please login again.');
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                return $this->sendError($msg); 
            }
           // return \Response::json($arr);
        }
       
    }

}