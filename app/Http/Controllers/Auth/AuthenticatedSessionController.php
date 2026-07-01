<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user && $user->is_restricted) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your account has been restricted. Please contact your administrator.'], 403);
            }

            return back()->withErrors([
                'email' => 'Your account has been restricted. Please contact your administrator.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($user && $user->role === 'employee') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('frontend.employeeForms'),
                ]);
            }

            return redirect()->intended(route('frontend.employeeForms'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('admin.dashboard'),
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
