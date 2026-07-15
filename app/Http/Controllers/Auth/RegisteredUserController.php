<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::create($validated);
        auth()->login($user);
        session()->regenerate();

        return redirect('/')->with('success', 'Registration complete!');
    }

}
