<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;



class ForgotPass extends Controller
{
    // Step 1: Send OTP to user's email
    public function sendResetLinkEmail(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }

        // Generate OTP
        $otp = (new Otp)->generate($request->email, 'numeric', 6, 15);

        // Store the OTP token and timestamp (for later validation)
        session(['otpToken' => $otp->token]);

        // Send OTP via email
        Mail::raw("Your OTP is: {$otp->token}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Your OTP for Password Reset');
        });

        return response()->json(['status' => 200, 'message' => 'OTP sent to your email']);
    }

    // Step 2: Validate OTP
    public function validateOtp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'otp' => 'required',
        ]);

        // Retrieve OTP from session
        $otpToken = session('otpToken');

        // Check if OTP matches
        if ($request->otp == $otpToken) {
            // Store a flag in the session to indicate OTP is validated
            session(['otpValidated' => true]);
            return response()->json(['status' => 200, 'message' => 'OTP is valid']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Invalid OTP']);
        }
    }
 
}
