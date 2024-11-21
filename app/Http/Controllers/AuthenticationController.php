<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
            'phone_number' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors(), $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        try {
            $check_unique_phone = User::where('phone_number', $input['phone_number'])->first();
            $check_unique_email = User::where('email', $input['email'])->first();

            if($check_unique_phone) {
                return $this->sendError('Phone number already exists.', ['error' => 'Phone number already exists.']);
            }
            if($check_unique_email) {
                return $this->sendError('Email already exists.', ['error' => 'Email already exists.']);
            }

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
            return $this->sendError($e->getMessage(), ['error' => $e->getMessage()]);
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
//        $verificationCode['send_status'] = $this->sendOtp($request->mobile_no, $verificationCode->otp);
        return $this->sendResponse($verificationCode, 'OTP generated successfully.');
    }
    public function sendOtp($number, $otp)
    {
        if (substr($number, 0, 1) === '0') {
            $number = substr($number, 1);
        }
        $data = [
            'messages' => [
                [
                    'destinations' => [
                        [
                            'to' => '84'.$number
                        ]
                    ],
                    'from' => '447491163443', // Your sender's number
                    'text' => 'Your OTP to login into PinyCloud is '. $otp .' it will expire in 1 minutes.'
                ]
            ]
        ];

        // Make the HTTP request using Laravel's HTTP client
        try {
            $response = Http::withHeaders([
                'Authorization' => 'App 93c17591673d903f7730b44c3b4909fb-b0de3d80-4840-4458-b159-32ade0678c0f',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->post('https://m3xg96.api.infobip.com/sms/2/text/advanced', $data);

            // Check if the response is successful
            if ($response->successful()) {
                // If successful, return the response body (you can log or process it here)
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            } else {
                // If the response was not successful, handle the error
                return response()->json([
                    'success' => false,
                    'message' => 'Unexpected HTTP status: ' . $response->status()
                ], $response->status());
            }
        } catch (\Exception $e) {
            // If an exception occurs, catch it and return an error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
