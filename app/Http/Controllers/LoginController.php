<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('login');
    }

    /**
     * Process the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'remember' => 'boolean'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended('dashboard')
                ->with('success', 'Login successful!');
        }

        // If login fails, redirect back with error
        return redirect()->back()
            ->withErrors([
                'username' => 'The provided credentials do not match our records.',
                'password' => 'The provided password is incorrect.',
            ])
            ->withInput($request->only('username', 'remember'));
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        
        Session::flash('success', 'You have been logged out successfully.');
        
        return redirect()->route('login');
    }
}
