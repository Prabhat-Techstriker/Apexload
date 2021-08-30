<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\ForgetPasswordRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User;
use Twilio\Rest\Client;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgetPassword(Request $request) {
        $request->validate([
            'username' => 'required',
        ]);
        $user = array();
        if(is_numeric($request->username)){
            $user = User::where('phone_number', $request->username)->first();
            try {
                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);
                $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($user->phone_number, "sms");
                return response()->json(['status' => true,'otp_type' => '2', 'userId'=> $user->id, 'message' => 'New OTP has been sent on your registered Phone number: '.$user->phone_number], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => 'We can\'t find a user with that Phone Number.'], 404);
            }
        }
        elseif (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->username)->first();
            try {
                $user->activation_token = rand(100000,999999);
                $user->save();
                $user->notify(new ForgetPasswordRequest($user->activation_token));
                return response()->json(['status' => 'success', 'otp_type' => '1', 'userId'=> $user->id , 'message' => 'New OTP has been sent on your registered e-mail: '.$user->email], 201);
                
            } catch (\Exception $e) {
                return response()->json(['message' => 'We can\'t find a user with that e-mail address.'], 404);
            }
        }
    }


    public function checkOtp(Request $request) {
        $request->validate([
            'userId' => 'required',
            'otp_type'     => 'required',
            'verification_code' => 'required|string'
        ]);
        if($request->otp_type == "1" ){ // is email  

            try {
                $user = User::where('activation_token', $request->verification_code)->first();
                if (!$user) {
                    return response()->json([
                        'message' => 'This activation token is invalid.'
                    ], 404);
                }
                $user->activation_token = '';
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'OTP valid',
                    'userId' => $user->id
                ],201);
                
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'This activation token is invalid.'
                ], 404);
            }

        } elseif ($request->otp_type == "2") { // is phone number
            $user = User::where('id', $request->userId)->first();
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);  
            try {
                 $verification = $twilio->verify->v2->services($twilio_verify_sid)->verificationChecks->create($request->verification_code, array('to' => $user->phone_number));
                $user = User::where('phone_number', $user->phone_number)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'OTP valid',
                    'userId' => $user->id
                ],201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Invalid verification code entered.'], 404);
            }
        }

    } 

    public function changePassword(Request $request) {
        $request->validate([
            'userId' => 'required',
            'password'     => 'required|string|confirmed',
            'device_token' => 'required|string'
        ]);
        try {
            $user = User::where('id', $request->userId)->first();
            $user->password = bcrypt($request->password);
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
                'message' => 'Password change Successfully',
                'user' => $user
            ],201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'We can\'t find a the user'], 404);
        }
    } 
     
}

