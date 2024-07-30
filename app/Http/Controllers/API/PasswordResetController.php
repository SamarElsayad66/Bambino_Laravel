<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $otp = random_int(10000, 99999);  // Generate a 5-digit OTP
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);  // Set OTP expiry time
        $user->save();

        // Send OTP to user's email (you should configure mail settings)
        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent to your email',
        ], 200);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP or OTP has expired',
            ], 400);
        }

        $user->otp_verified = true;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully',
        ], 200);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('otp_verified', true)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP or OTP has expired',
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;  // Clear OTP after use
        $user->otp_verified = false;  // Reset OTP verification status
        $user->otp_expires_at = null;  // Clear OTP expiry time
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully',
        ], 200);
    }
}
