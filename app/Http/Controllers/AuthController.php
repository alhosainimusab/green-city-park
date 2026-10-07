<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            session(['locale' => $user->language]);
            app()->setLocale($user->language);
            return $this->redirectByRole($user->role);
        }

        return back()->withErrors(['email' => __('auth.failed')])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'language' => 'nullable|in:ar,en',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'visitor',
            'language' => $data['language'] ?? 'ar',
        ]);

        Auth::login($user);
        session(['locale' => $user->language]);

        try { Mail::to($user->email)->send(new WelcomeMail($user)); } catch (\Exception $e) {}

        return redirect()->route('visitor.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function redirectByRole(string $role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('visitor.dashboard'),
        };
    }

    public function setLanguage(Request $request, string $lang)
    {
        if (!in_array($lang, ['ar', 'en'])) {
            abort(400);
        }
        session(['locale' => $lang]);
        app()->setLocale($lang);

        if (Auth::check()) {
            Auth::user()->update(['language' => $lang]);
        }

        return back();
    }
}
