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
use App\Models\UserProductRelation;
use App\Models\Company;
use App\Models\Product;
use App\Models\Certificate;
use App\Models\TeamId;
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
        $credentials['role_id'] = 4;
        if (Auth::attempt($credentials)) {
            return redirect()->route('login')->with('error', 'Oops! Please login from the app.');
        }else{
            $credentials = $request->only('email', 'password');
            $credentials['is_active'] = 1;
            //pr($credentials); die;
            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard')
                            ->withSuccess('You have Successfully loggedin.');
            }else{
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect()->route('login')->with('error', 'Oops! Your account is inactive.');
                }
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
            
            if(Auth::user()->roles[0]->id == 3){
				$userId = Auth::user()->id;
                $comp = Company::where("owner",$userId)->pluck("id");
                $totalUserRecords = User::select('count(*) as allcount')->count();
                $queryuser = User::select('count(*) as allcount');
                
                $queryuser->where(function ($q) use($userId,$comp) {
                    $q->whereIn('company_id', $comp)->orWhere("created_by",$userId);
                });
               
            $totalActiveUserRecords = $queryuser->where("is_active",1)->count();

                
                if($totalActiveUserRecords> 0 && $totalUserRecords>0)
                {
                    $userPer =  round(($totalActiveUserRecords/$totalUserRecords)*100);
                }
                $totalPpes = Product::where('MyQuip_Owner', $userId)->count();
                //dd($totalPpes);
                $totalAssignedPpes = UserProductRelation::select('count(*) as allcount')->whereHas('product', function($query1) use($userId) {
                    $query1->where('MyQuip_Owner', $userId);
                    })->count();

                if($totalAssignedPpes> 0 && $totalPpes>0)
                {
                    $ppePer =  round(($totalAssignedPpes/$totalPpes)*100);
                }
                
                $totalUnAssignedPpes = $totalPpes-$totalAssignedPpes;
                if($totalUnAssignedPpes> 0 && $totalPpes>0)
                {
                    $ppePerUnAssi =  round(($totalUnAssignedPpes/$totalPpes)*100);
                }
				
                
                $totalCertificates = Certificate::where("certificate_type","User")->whereHas('user', function($query1) use($userId,$comp) {
                    $query1->whereIn('company_id', $comp)->orWhere('created_by', $userId);
                    })->orderBy('created_at',"DESC")->count();

                $expiringCertificates = Certificate::where('expiry_date','>=', $currentDate)->where('expiry_date','<=', $expiringDate)->where("certificate_type","User")->whereHas('user', function($query1) use($userId,$comp) {
                    $query1->whereIn('company_id', $comp)->orWhere('created_by', $userId);
                    })->orderBy('created_at',"DESC")->count();

                $expiredCertificates = Certificate::where('expiry_date','<', $currentDate)->where("certificate_type","User")->whereHas('user', function($query1) use($userId,$comp) {
                    $query1->whereIn('company_id', $comp)->orWhere('created_by', $userId);
                    })->orderBy('created_at',"DESC")->count();
                   
                $v = $expiringCertificates+$expiredCertificates;
                
                $validCertificates = $totalCertificates - $v;


                if($validCertificates > 0 && $totalCertificates>0)
                {
                    $validCPer =  round(($validCertificates/$totalCertificates)*100);
                }

                if($expiringCertificates> 0 && $totalCertificates>0)
                {
                    $expiringCPer =  round(($expiringCertificates/$totalCertificates)*100);
                }
               
                if($expiredCertificates> 0 && $totalCertificates>0)
                {
                    $expiredCPer =  round(($expiredCertificates/$totalCertificates)*100);
                }
               
                $projects = TeamId::with(['company','area','user'])->withCount(['workers',])->where("owner",$userId)->orderBy('created_at',"DESC")->limit(5)->get();
              //certificates code  
                $totalLimit = 5;
                $certificates_expd = [];
                $certificates_expig = [];
                $expiringCLimit = $totalLimit - $expiredCertificates;
                
            if ($expiredCertificates > 0) {
                $certificates_expd = Certificate::where('expiry_date', '<', $currentDate)->where("certificate_type", "User")->whereHas('user', function ($query1) use ($userId, $comp) {
                    $query1->whereIn('company_id', $comp)->orWhere('created_by', $userId);
                })->orderBy('created_at', "DESC")->limit($expiredCertificates)->get();
            }
           elseif ($expiredCertificates < $totalLimit && $expiringCLimit > 0) {     
            $certificates_expig = Certificate::where('expiry_date','>=', $currentDate)->where('expiry_date','<=', $expiringDate)->where("certificate_type","User")->whereHas('user', function($query1) use($userId,$comp) {
                $query1->whereIn('company_id', $comp)->orWhere('created_by', $userId);
                })->orderBy('created_at',"DESC")->limit($expiringCLimit)->get();

            }
                
        $certificates = [];
        foreach($certificates_expd as $certificates_expd1){
            $certificates[] = $certificates_expd1;
        }
        foreach($certificates_expig as $certificates1){
            $certificates[] = $certificates1;
        }

    //certificates code  end

     //products code  
        $productsAll = [];
    
      
    
        $product_expd = UserProductRelation::with("products","user")->where('assigned_by', $userId)->whereHas('products', function($query1) use($currentDate,$expiringDate) {
            $query1->where('expiry_date', '<', $currentDate);
        })->orderBy('created_at', "DESC")->limit($totalLimit)->get();

    
        foreach($product_expd as $product_expd1){
            $productsAll[] = $product_expd1;
        }

        $expied_procount_count = count($productsAll);
        $exping_procount_count_limit = $totalLimit - $expied_procount_count;

       
        if ($expied_procount_count < $totalLimit && $exping_procount_count_limit > 0) {  
            $product_expig = UserProductRelation::with("products","user")->where('assigned_by', $userId)->whereHas('products', function($query1) use($currentDate,$expiringDate) {
                $query1->where('expiry_date','>=', $currentDate)->where('expiry_date','<=', $expiringDate);
            })->orderBy('created_at', "DESC")->limit($exping_procount_count_limit)->get();

           
        }

        foreach($product_expig as $product_expig1){
            $productsAll[] = $product_expig1;
        }

  

//products code  end

                return view('dashboard-manager', compact('totalActiveUserRecords','userPer','ppePer','totalAssignedPpes','ppePerUnAssi','totalUnAssignedPpes','expiringCertificates','expiredCertificates','validCertificates','validCPer','expiringCPer','expiredCPer','projects','certificates','productsAll'));
            }
            else
            {
                $totalUserRecords = User::select('count(*) as allcount')->count();

                return view('dashboard', compact('totalUserRecords'));
            }
           
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
