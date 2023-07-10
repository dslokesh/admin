<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use App\Mail\sendForgotPasswordToUserMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Session;
use App\Models\User;
use App\Models\Customer;
use App\Models\Hotel;
use App\Models\Supplier;
use App\Models\Activity;
use App\Models\Agent;
use Hash;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
	
	public function thankyou()
    {
        return view('auth.thankyou');
    } 
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        
            $credentials = $request->only('email', 'password');
            $credentials['is_active'] = 1;
           // pr($credentials); die;
            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard')
                            ->withSuccess('You have Successfully loggedin.');
            }else{
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect()->route('login')->with('error', 'Oops! Your account is inactive.');
                }
            }

		return redirect()->route('login')->with('error', 'Oops! You have entered invalid credentials.');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
        ],
        [
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        $ppePer = 0;
        $userPer = 0;
        $ppePerUnAssi = 0;
        $expiringCPer = 0;
        $expiredCPer = 0;
        $validCPer = 0;

       $currentDate = Carbon::now()->format('Y-m-d');
       $expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');

        if(Auth::check()){
            

				$userId = Auth::user()->id;
				$totalUserRecords = User::select('count(*) as allcount')->where('role_id',2)->count();
				$totalAgentRecords = User::select('count(*) as allcount')->where('role_id',3)->count();
				$totalSupplierRecords = Supplier::select('count(*) as allcount')->count();
				$totalCustomerRecords = Customer::select('count(*) as allcount')->count();
				$totalActivityRecords = Activity::select('count(*) as allcount')->count();
                $totalHotelRecords = Hotel::select('count(*) as allcount')->count();

                return view('dashboard', compact('totalUserRecords','totalAgentRecords','totalSupplierRecords','totalCustomerRecords','totalActivityRecords','totalHotelRecords'));
           
        }
  
        //return redirect("login")->withSuccess('Opps! You do not have access');
		return redirect()->route('login')->with('error', 'Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'is_active' => 1
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
       // return Redirect('login');
		return redirect()->route('login');
    }
	
	public function changepassword(Request $request){
		$user = User::where('id',\Auth::user()->id)->first();
		return view('changepassword',compact('user'));
	}

    public function saveProfile(Request $request){
		$data = $request->all();
		$request->validate([
            'OldPassword'=>['required',function ($attribute, $value, $fail) use ($data) {
					if (!\Hash::check($value, \Auth::user()->password)) {
						return $fail(__('The old password is incorrect.'));
					}
					}],
            'password'=>'required|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
			'confirmPassword' => 'required_with:password|same:password|min:8'
        ],
        [
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]
        );
				
		$id = \Auth::user()->id;
		$user = User::where('id',$id)->first();
		$redirect = '/change-password';
							
		// Check password change conditions //
		$user->password = bcrypt($data['password']);
		$success_msg = 'Password has been Updated Successfully, Please login again.';
		$error_msg = 'Password not changed successfully, Please try again.';
		
		if($user->save()){
			\Session::flash('success', $success_msg);
            Auth::logout();
            return redirect()->route('login');
			//return redirect($redirect);
		}
		else{
			\Session::flash('error', $error_msg);
			return redirect($redirect);
		}
	}


	/**
	* admin reset password
	*/
	public function showResetForm()
    { 
        return view('auth.passwords.email');
    }
	
	/**
	* admin reset password email
	*/
	public function resetPassword(PasswordRequest $request)
    { 	
        
		$data = $request->all();
        
		$admin_details = DB::table('users')->where('email', $data['email'])->get();
		//print_r($admin_details); die('test');
		if(isset($admin_details[0]->id) && !empty($admin_details[0]->id)) {

            $token = Str::random(60);

            //$update_pass = DB::table('users')->where('id', $admin_details[0]->id)->update(['remember_token' => $token, 'is_active' => 0]);
            $update_pass = DB::table('users')->where('id', $admin_details[0]->id)->update(['remember_token' => $token]);

			/*$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+?";
		    $new_password = substr( str_shuffle( $chars ), 0, 7 ); 
			$h_newspassword = Hash::make($new_password);
			$update_pass = DB::table('users')->where('id', $admin_details[0]->id)->update(['password' => $h_newspassword]); */
			//Mail::to($data['email'],'Password details')
					 //->send(new sendForgotPasswordToUserMailable($admin_details[0], $new_password));
            //die;
            Mail::to($data['email'],'Password Reset Link')->send(new sendForgotPasswordToUserMailable($admin_details[0], $token));         
			
            return redirect()->route('resetpassword')->with('success', 'Success! password reset link has been sent to your email.');
		} else {
			$request->session()->flash('error', 'Email does not exists.');
			return redirect()->route('resetpassword');
		}
		
		
    }

    /**
     * Validate token for forgot password
     * @param token
     * @return view
     */
    public function forgotPasswordValidate($token)
    {
        //$user = User::where('remember_token', $token)->where('is_active', 0)->first();
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            $email = $user->email;
            return view('auth.passwords.change-password', compact('email'));
        }
        \Session::flash('error', 'Password reset link is expired');
        return redirect()->route('resetpassword');
    }

    /**
     * Change password
     * @param request
     * @return response
     */
    public function updatePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
            'confirm_password' => 'required|same:password|min:8'
        ],
        [
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long"
        ]
    );

        $user = User::with('roles')->where('email', $request->email)->first();
        if ($user) {
           //$user['is_active'] = 0;
            $user['remember_token'] = '';
            $user['password'] = Hash::make($request->password);
            $user->save();
            if($user->roles[0]->id == '3'){
                return redirect()->route('thankyou')->with('success', 'Success! password has been changed. Please login from the app.');
            }else{
                return redirect()->route('login')->with('success', 'Success! password has been changed.');
            }
            
        }
        return redirect()->route('forgot-password')->with('failed', 'Failed! something went wrong');
    }


}
