<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:120'],
            'password' => ['required', 'string'],
        ]);

        $login = trim($validated['login']);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $field === 'email' ? strtolower($login) : strtolower($login),
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'login' => 'Email/username atau password tidak valid.',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        $user = $request->user();
        $user->tokens()->delete();
        $apiToken = $user->createToken('web-gis-token')->plainTextToken;
        $request->session()->put('api_token', $apiToken);

        return redirect()->intended('/dashboard');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:60', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:users,username'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => strip_tags(trim($validated['name'])),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'role' => 'petugas',
            'password' => $validated['password'],
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Silakan login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
