<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginOtpSendRequest;
use App\Http\Requests\API\V1\Auth\LoginOtpVerifyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function loginOtpSend(LoginOtpSendRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        $name = strstr($request->email, '@', true);
        if (!$user) {
            User::create([
                'name' => $name,
                'email' => $request->email,
                'otp' => $otp,
            ]);
        } else {
            $user->update(['otp' => $otp]);
        }

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Login OTP');
        });
        return $this->success(null, 'OTP sent to your email.');
    }

    public function login(LoginOtpVerifyRequest $request)
    {
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if (!$user) {
            return $this->error('Invalid OTP.', 400);
        } else {
            $user->update(['otp' => null]);
        }
        $accessToken = $user->createToken('authToken')->plainTextToken;
        return $this->success([
            'access_token' => $accessToken,
        ], 'Login successful.');
    }
}
