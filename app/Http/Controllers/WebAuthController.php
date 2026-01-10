<?php

namespace App\Http\Controllers;

use App\Models\Tourist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class WebAuthController extends Controller
{
    public function registration()
    {
        try {
            return view('frontend.pages.registration');
        } catch (Exception $e) {
            alert()->error('Error', 'Something went wrong!');
            return redirect()->back();
        }
    }

    public function doRegistration(Request $request)
    {
        try {
            $checkValidation = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:tourists,email',
                'password' => 'required|min:6',
                'phone' => 'required|max:11',
                'address' => 'required',
                'gender' => 'required|in:male,female,other',
                'date_of_birth' => 'required|date',
                'nationality' => 'required',
                'nid_passport' => 'required',
            ]);

            if ($checkValidation->fails()) {
                alert()->error('Error', 'Validation Failed!');
                return redirect()->back()->withErrors($checkValidation)->withInput();
            }

            Tourist::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'phone'    => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'nationality' => $request->nationality,
                'nid_passport' => $request->nid_passport
            ]);

            alert()->success('Success', 'Registration Successful!');
            return redirect()->route('web.login');
        } catch (Exception $e) {
            alert()->error('Error', 'Registration Failed!');
            return redirect()->back();
        }
    }

    public function login()
    {
        try {
            return view('frontend.pages.login');
        } catch (Exception $e) {
            alert()->error('Error', 'Something went wrong!');
            return redirect()->back();
        }
    }

    public function doLogin(Request $request)
    {
        try {
            $checkValidation = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($checkValidation->fails()) {
                alert()->error('Error', 'Validation Failed!');
                return redirect()->back()->withErrors($checkValidation)->withInput();
            }

            $credentials = $request->only('email', 'password');

            if (Auth::guard('touristGuard')->attempt($credentials)) {
                alert()->success('Success', 'Login Successful!');
                return redirect()->route('home');
            } else {
                alert()->error('Error', 'Invalid Email or Password!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Login Failed!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        try {
            Auth::guard('touristGuard')->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            alert()->success('Success', 'Logout Successful!');
        } catch (Exception $e) {
            alert()->error('Error', 'Logout Failed!');
        }

        return redirect()->route('home');
    }
}
