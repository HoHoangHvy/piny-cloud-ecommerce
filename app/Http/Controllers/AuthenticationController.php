<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

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

        $message = "Your OTP To Login is - ".$verificationCode->otp;
        # Return With OTP
        $result['success'] = true;
        $result['otp'] = $verificationCode->otp;
        return $this->sendResponse($result, $message);
    }
    public function generateOtp($mobile_no)
    {
        $user = User::where('mobile_no', $mobile_no)->first();

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
}
