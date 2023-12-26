<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    //
    public function login(): View
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        // array with the form's validated fields
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
//            intended : initial route where the user came from before loggin in
            return redirect()->intended(route('celebrities.index'));
        }

        return to_route('auth.login')->withErrors([
            'email' => 'logins invalides'
        ])->onlyInput('email');
    }
}
