<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset; // Assuming you have this model
use App\Notifications\ResetPasswordNotification; // Modify as needed

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in the password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => now()]
        );

        $user = User::where('email', $request->email)->first();
        if ($user) {
            // Send OTP via email
            Notification::send($user, new ResetPasswordNotification($otp));
        }

        return response()->json([
            'message' => 'Password reset OTP sent.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|digits:6', // OTP is 6 digits
            'password' => 'required|confirmed|min:6',
        ]);

        // Find OTP record
        $record = PasswordReset::where([
            ['email', $request->email],
            ['token', $request->token],
        ])->first();

        if (!$record) {
            return response()->json(['message' => 'Invalid OTP or email.'], 400);
        }

        // Find user and update password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Remove the OTP record
            PasswordReset::where('email', $request->email)->delete();

            return response()->json(['message' => 'Password has been reset successfully.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
}
