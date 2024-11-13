<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Helpers\SpeedSMSAPI;
use Twilio\Rest\Client;

class AuthenticationController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'user_type' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        try {
            $user = User::create($input);

            if ($user->user_type == 'customer') {
                $customer = new Customer();
                $customer->full_name = $user->name;
                $customer->phone_number = $user->phone_number;
                $customer->email = $user->email;
                $customer->gender = $input['gender'];
                $customer->date_of_birth = $input['date_of_birth'];
                $customer->user_id = $user->id;
                $customer->save();

                $user->assignRole('customer');
            } else {
                $user->assignRole('admin');
            }

            $success['token'] = $user->createToken('MyApp', ['check-status', 'place-orders'], now()->addMinutes(60))->plainTextToken;
            $success['name'] = $user->name;
        } catch (\Exception $e) {
            return $this->sendError('User Registration Failed.', ['error' => $e->getMessage()]);
        }

        return $this->sendResponse($success, 'User register successfully.');
    }
    // Generate OTP
    public function generate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|exists:users,phone_number',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        # Generate An OTP
        $verificationCode = $this->generateOtp($request->mobile_no);
        return $this->sendResponse($verificationCode, 'OTP generated successfully.');
    }
    public function sendOtp($number) {
        $basic  = new \Vonage\Client\Credentials\Basic("ee69cde3", "aXTc6yYiMshIdNA5");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("84398168226", "PinyCloud", 'A text message sent using the Nexmo SMS API')
        );

        return json_encode($response->current());
    }
    public function generateOtp($mobile_no)
    {
        $user = User::where('phone_number', $mobile_no)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }
    public function loginWithOtp(Request $request)
    {
        // Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        // Find the verification code associated with the user and OTP
        $verificationCode = VerificationCode::where('user_id', $request->user_id)
            ->where('otp', $request->otp)
            ->first();

        $now = Carbon::now();

        if (!$verificationCode) {
            return $this->sendError('Invalid OTP', ['error' => 'Invalid OTP']);
        } elseif ($now->isAfter($verificationCode->expire_at)) {
            return $this->sendError('OTP Expired', ['error' => 'OTP Expired']);
        }

        // Retrieve the user associated with the user_id
        $user = User::find($request->user_id);

        if ($user) {
            // Expire the OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
            return $this->sendResponse($this->authSuccess($user), 'User login successfully.');
        }

        return $this->sendError('Unauthorized', ['error' => 'User not found']);
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return $this->sendResponse($this->authSuccess(Auth::user()), 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        }
    }

    public function authSuccess($user) : array {
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['user'] =  $user;
        return $success;
    }

    public function me(Request $request): JsonResponse
    {
        try {
            return $this->sendResponse($request->user(), 'User retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('User Not Found.', ['error' => $e->getMessage()]);
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            return $this->sendResponse([], 'User logged out successfully.');
        } catch (\Exception $e) {
            return $this->sendError('User Logout Failed.', ['error' => $e->getMessage()]);
        }
    }

}
