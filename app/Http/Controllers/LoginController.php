<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', ['mode' => 'login']);
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginField = $login['login'];
        $password = $login['password'];

        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $loginField, 'password' => $password];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        } else {
            $credentials = ['name' => $loginField, 'password' => $password];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        }

        return back()->withErrors([
            'login' => 'These credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login', ['mode' => 'register']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'unique:users,name', 'min:3', 'max:255'],
            'email'    => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $user = User::create([
            'name'     => $validated['username'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('login')->with('success', 'Account created! You can now log in.');
    }
}
