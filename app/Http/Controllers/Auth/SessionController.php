<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }


    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/')->with('success', 'Logged In');
        }
        return back()->withErrors([
            'password' => 'invalid credentials.',
        ])->onlyInput('email');
    }

    public function destroy()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with('succes', 'Logged out');
    }
}
