<?php

namespace App\Http\Controllers;

use App\Helpers\GraphMailer;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class EmployeeRegisterController extends Controller
{
    // Step 1: Show email form
    public function showEmailForm()
    {
        return view('frontend.pages.employee-signup');
    }

    // Step 2: Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower(trim($request->email));

        // Check if email already has an account
        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'An account with this email already exists. Please log in.'])->withInput();
        }

        // Rate limit: max 3 OTPs per email per 10 minutes
        $key = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Too many attempts. Please wait {$seconds} seconds before trying again."])->withInput();
        }
        RateLimiter::hit($key, 600);

        // Delete old unused OTPs for this email
        OtpVerification::where('email', $email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
            'used'       => false,
        ]);

        $html = view('emails.employee-otp', ['otp' => $otp])->render();
        $sent = GraphMailer::send($email, 'Your Sprout Academy Verification Code', $html);

        if (!$sent) {
            OtpVerification::where('email', $email)->delete();
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again later.'])->withInput();
        }

        session(['signup_email' => $email]);

        return redirect()->route('employee.signup.verify');
    }

    // Step 3: Show OTP verify form
    public function showVerifyForm()
    {
        if (!session('signup_email')) {
            return redirect()->route('employee.signup');
        }

        return view('frontend.pages.employee-signup-verify');
    }

    // Step 4: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('signup_email');
        if (!$email) {
            return redirect()->route('employee.signup');
        }

        $record = OtpVerification::where('email', $email)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$record || $record->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code. Please try again.']);
        }

        $record->update(['used' => true]);
        session(['signup_email_verified' => $email]);

        return redirect()->route('employee.signup.register');
    }

    // Step 5: Show registration form
    public function showRegisterForm()
    {
        if (!session('signup_email_verified')) {
            return redirect()->route('employee.signup');
        }

        return view('frontend.pages.employee-signup-register');
    }

    // Step 6: Create account
    public function register(Request $request)
    {
        $email = session('signup_email_verified');
        if (!$email) {
            return redirect()->route('employee.signup');
        }

        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Double-check email not taken (race condition guard)
        if (User::where('email', $email)->exists()) {
            session()->forget(['signup_email', 'signup_email_verified']);
            return redirect()->route('employee.signup')->withErrors(['email' => 'An account with this email already exists.']);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make($request->password),
            'role'     => 'employee',
        ]);

        session()->forget(['signup_email', 'signup_email_verified']);

        // Log them in
        auth()->login($user);

        return redirect()->route('frontend.employeeForms')->with('success', 'Welcome! Your account has been created.');
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $email = session('signup_email');
        if (!$email) {
            return redirect()->route('employee.signup');
        }

        $key = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['otp' => "Too many attempts. Please wait {$seconds} seconds."]);
        }
        RateLimiter::hit($key, 600);

        OtpVerification::where('email', $email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
            'used'       => false,
        ]);

        $html = view('emails.employee-otp', ['otp' => $otp])->render();
        $sent = GraphMailer::send($email, 'Your Sprout Academy Verification Code', $html);

        if (!$sent) {
            return back()->withErrors(['otp' => 'Failed to send verification email. Please try again.']);
        }

        return back()->with('resent', 'A new verification code has been sent to your email.');
    }
}
