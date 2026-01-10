<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('backend.pages.login');
    }

    public function doLogin(Request $request)
    {
        $userLogin = $request->except('_token');

        $checkLogin = Auth::attempt($userLogin);
        if ($checkLogin) {
            alert()->success('Success', 'Login Successful!');
            return redirect()->route('dashboard');
        }

        alert()->error('Error', 'Login Failed!');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();

        alert()->success('Success', 'Logout Successful!');
        return redirect()->route('login');
    }
}
