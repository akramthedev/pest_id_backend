<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Validator;

class ForgotPass extends Controller
{


    

    public function sendResetLinkEmail(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
    
        // Generate OTP
        $otp = (new Otp)->generate($request->email, 'numeric', 6, 15);
    
        // Send OTP via email
        Mail::raw("Your OTP is: {$otp->token}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Your OTP for Password Reset');
        });
    
        return response()->json(['status' => true, 'message' => 'OTP sent to your email']);
    }

    
    



    // Step 2: Generate OTP
    public function generateOtp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = (new Otp)->generate($request->email, 'numeric', 6, 15);
        
        return response()->json([
            'status' => true,
            'token' => $otp->token,
            'message' => 'OTP generated'
        ]);
    }

    // Step 3: Validate OTP
    public function validateOtp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
        ]);

        $result = (new Otp)->validate($request->email, $request->token);

        if ($result->status) {
            return response()->json(['status' => true, 'message' => 'OTP is valid']);
        } else {
            return response()->json(['status' => false, 'message' => $result->message]);
        }
    }

    // Step 4: Reset Password
    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        // Validate the OTP first
        $otpResult = (new Otp)->validate($request->email, $request->token);
        if (!$otpResult->status) {
            return response()->json(['status' => false, 'message' => $otpResult->message]);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'Password has been reset successfully']);
    }
}
