<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ─── Login ────────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'role'     => ['required', 'in:admin,alumni'],
        ]);

        // ── Throttle: max 5 attempts per email+IP per minute ──
        $throttleKey = Str::lower($credentials['email']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $loginCredentials = [
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($loginCredentials, $request->boolean('remember'))) {
            // Check that the user's actual role matches the selected role
            if (Auth::user()->role !== $credentials['role']) {
                Auth::logout();
                $request->session()->invalidate();
                RateLimiter::hit($throttleKey);
                return back()->withErrors([
                    'email' => 'These credentials do not match the selected role.',
                ])->onlyInput('email')->withInput(['role' => $credentials['role']]);
            }

            // Successful login — clear throttle
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Failed login — increment throttle counter
        RateLimiter::hit($throttleKey);
        $remaining = 5 - RateLimiter::attempts($throttleKey);

        return back()->withErrors([
            'email' => $remaining > 0
                ? "Invalid credentials. {$remaining} attempt(s) remaining before lockout."
                : 'Too many failed attempts. Please wait before trying again.',
        ])->onlyInput('email')->withInput(['role' => $credentials['role']]);
    }

    // ─── Register (Alumni Self-Registration) ──────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'graduation_year'       => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'degree'                => ['nullable', 'string', 'max:255'],
            'department'            => ['nullable', 'string', 'max:255'],
            'phone'                 => ['nullable', 'string', 'max:50'],
        ]);

        // Split name for alumni profile
        $nameParts  = explode(' ', trim($request->name), 2);
        $firstName  = $nameParts[0];
        $lastName   = $nameParts[1] ?? '';

        // Create alumni profile linked to this user
        $alumni = Alumni::create([
            'first_name'       => $firstName,
            'last_name'        => $lastName,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'graduation_year'  => $request->graduation_year,
            'degree'           => $request->degree,
            'department'       => $request->department,
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'alumni',
            'alumni_id' => $alumni->id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome! Your alumni profile has been created.');
    }

    // ─── Logout ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
