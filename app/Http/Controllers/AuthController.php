<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\User;
use App\Notifications\SignupActivate;
use Illuminate\Support\Str;
use App\Notifications\ForgetPasswordRequest;
use App\Responsibility;
use App\AccountType;
use DB;
use App\Job;
use App\Vehicle;
use App\Booking;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function signup(Request $request) {
    	if ($request->signup_type == "1") { //is email type
            $request->request->add(['email' => $request->username]);
    		$validator = Validator::make($request->all(), [
    			'email'        => 'required|string|email|unique:users',
    			'device_token' => 'required|string|unique:users',
                'password'     => 'required|string'
		    ]);
    	} else {  //is phone type
            $request->request->add(['phone_number' => $request->username]);
    		$validator = Validator::make($request->all(), [
    			'phone_number' => 'required|string|unique:users',
    			'device_token' => 'required|string|unique:users',
                'password'     => 'required|string'
		    ]);
    	}
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
		}

        if ($request->signup_type == "1") { //is email type
            $user = new User([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'device_token' => $request->device_token,
                'activation_token' => rand(100000,999999),
            ]);
            $user->save();
            $user->notify(new SignupActivate($user));
            return response()->json([
                'success' => true,
                'user'    => $user,
                'message' => 'Registration has been done successful and we sent you an activation code. Please check your email.'
            ], 201);
            
        } else { //is phone type
            if($this->verifyPhone($request->phone_number)) { //send OTP
                $user = new User([
                    'phone_number' => $request->phone_number,
                    'device_token' => $request->device_token,
                    'password'     => bcrypt($request->password),
                ]);
                $user->save();
                return response()->json(['success' => true, 'user' => $user, 'message' => 'Registration has been done successful and OTP sent!!.'], 201);
            } else { //Failed to send OTP
                return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 401);
            }

        }
    }


    public function verifyPhone($phoneNumber) { //verifying phone with twilio
		$token = getenv("TWILIO_AUTH_TOKEN");
		$twilio_sid = getenv("TWILIO_SID");
		$twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
		$twilio = new Client($twilio_sid, $token);

		try {
			$twilio->verify->v2->services($twilio_verify_sid)->verifications->create($phoneNumber, "sms");
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}

    public function byemailActivate(Request $request){ //verifying email
        $user = User::where('activation_token', $request->activation_token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->email_verify = true;
        $user->activation_token = '';
        $user->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(4);
        $token->save();
        return response()->json([
            'success' => true,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'message' => 'Logged In Successfully',
            'user' => $user
        ],201);
    }

	public function loginOtp(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'verification_code' => 'required|numeric|digits:6',
        ]);

		if ($validator->fails()) {
		   return response()->json($validator->errors(), 422);
		}

		$token = getenv("TWILIO_AUTH_TOKEN");
		$twilio_sid = getenv("TWILIO_SID");
		$twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
		$twilio = new Client($twilio_sid, $token);

		try {
			$verification = $twilio->verify->v2->services($twilio_verify_sid)->verificationChecks->create($request->verification_code, array('to' => $request->phone_number));
			if ($verification->valid) {
				$user = tap(User::where('phone_number', $request->phone_number))->update(['phone_verify' => true]);
				$user = User::where('phone_number', $request->phone_number)->first();
				if(empty($user)) {
					return response()->json(['success' => false, 'message' => 'User not found.'], 404);
				}
				$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(4);
				$token->save();

				return response()->json([
					'success' => true,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
					'message' => 'Logged In Successfully',
					'user' => $user
				],201);
			}
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'Invalid verification code entered.'], 404);
		}
    }

    public function generateOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);
        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }
        if(is_numeric($request->username)){
            $user = User::where('phone_number', $request->username)->first();
            try {
                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);
                $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($request->username, "sms");
                return response()->json(['status' => true,'otp_type' => '2', 'userId'=> $user->id, 'message' => 'New OTP has been sent on your registered Phone number: '.$user->phone_number], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 401);
            }
        } 
        elseif (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->username)->first();
            try {
                $user->activation_token = rand(100000,999999);
                $user->save();
                $user->notify(new ForgetPasswordRequest($user->activation_token));
                return response()->json(['status' => 'success', 'otp_type' => '1', 'userId'=> $user->id , 'message' => 'OTP has been sent on your registered e-mail: '.$user->email], 201);
                
            } catch (\Exception $e) {
                return response()->json(['message' => 'We can\'t find a user with that e-mail address.'], 404);
            }

        }
        
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request){
        
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);
       
        if(is_numeric($request->username)){
            $credentials['phone_number'] = $request->username;
            $credentials['password']     = $request->password;
            //$credentials['phone_verify'] = true;
            $credentials['deleted_at']   = null;
        }
        elseif (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email']        = $request->username;
            $credentials['password']     = $request->password;
            //$credentials['email_verify'] = true;
            $credentials['deleted_at']   = null;
        }
        
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            //$userData = User::where(['email' => $request->username])->orWhere(['phone_number' => $request->username])->first();
            if($user->phone_verify == 0 && $user->email_verify == 0){
                return response()->json([
                    'message' => "Your verification is pending!."
                ], 202);
            }
            $user->device_token = $request->input('device_token');
            $user->save();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();  
            }
                
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => $user,
                'message' => 'Logged In Successfully',
            ], 201);
        } else {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401); 
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    
    public function logout(Request $request) {
    	$accessToken = Auth::user()->token();
    	$user = User::where('id', $accessToken->user_id)->first();
        $user['device_token'] = null;
        $user->save();
        $request->user()->token()->revoke();
        return response()->json(['success' => true, 'message' => 'Successfully logged out'], 201);
    }
    
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function webSiteSignup(Request $request) {
       
        if(is_numeric($request->username)){
            $request->request->add(['phone_number' => $request->username]);
            $validator = Validator::make($request->all(), [
                'phone_number' => 'required|string|unique:users',
                'password' => 'required|string|min:6'
            ]);
        }elseif (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $request->request->add(['email' => $request->username]);
            $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

       }
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }

        if(is_numeric($request->username)){
            if($this->verifyPhone($request->phone_number)) { //send OTP
                $user = new User([
                    'phone_number' => $request->phone_number,
                    'password'     => bcrypt($request->password),
                ]);
                $user->save();
                return response()->json(['success' => true, 'user' => $user, 'message' => 'Registration has been done successful and OTP sent!!.'], 201);
            } else { //Failed to send OTP
                return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 401);
            }
        }
        elseif (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $user = new User([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'activation_token' => rand(100000,999999),
            ]);
            $user->save();
            $user->notify(new SignupActivate($user));
            return response()->json([
                'success' => true,
                'user'    => $user,
                'message' => 'Registration has been done successful and we sent you an activation code. Please check your email.'
            ], 201);

        }
    }

    public function getResponsbility(){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $responsibilities = Responsibility::all();
        return view('site.createprofile', compact('responsibilities','user'));
    }

    public function getAccountByresponsibityId(Request $request){
        try {
            $accountTypes = AccountType::where('responsibility_id', $request->id)->get(); 
            return $accountTypes;
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Account Type not found.'], 404);
        }
    }

    public function userDashboard(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        if ($user->responsibilty_type == 1) {
            $b1 = Booking::where('requested_by',$id)->where('vehicle_id', '!=', null)->where('approved', '!=', '3')->where('status', '!=', '2')->count();
            $b2 = Booking::where('posted_by',$id)->where('job_id', '!=', null)->where('approved', '!=', '3')->where('status', '!=', '2')->count();
        }else{
            $b1 = Booking::where('requested_by',$id)->where('job_id', '!=', null)->where('approved', '!=', '3')->where('status', '!=', '2')->count();
            $b2 = Booking::where('posted_by',$id)->where('vehicle_id', '!=', null)->where('approved', '!=', '3')->where('status', '!=', '2')->count();
        }
        $totalRequest = $b1+$b2;
        $job = Job::where('posted_by', $id)->count();
        $vehicle = Vehicle::where('posted_by', $id)->count();

        return view('userdashboard.index', compact('user','job','vehicle','totalRequest'));
    }
}