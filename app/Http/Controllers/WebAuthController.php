<?php

namespace App\Http\Controllers;

use App\Models\Tourist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\TourApplication;
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
        $remember = $request->has('remember');

        if (Auth::guard('touristGuard')->attempt($credentials, $remember)) {
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

// Frontend: show profile

public function profile()
{
    try {
        $tourist = Auth::guard('touristGuard')->user();

        // ===============================
        // Tour Application History
        // ===============================
        $applications = TourApplication::with([
                'tourPackage.place'
            ])
            ->where('tourist_id', $tourist->id)
            ->latest()
            ->get()
            ->map(function ($app) use ($tourist) {

                // Base price
                $price = $app->tourPackage->price_per_person ?? 0;

                // Discount
                $discountPct = $app->tourPackage->discount ?? 0;
                $discountAmt = ($price * $discountPct) / 100;

                // Final payable
                $finalAmount = $price - $discountAmt;

                /*
                |--------------------------------------------------------------------------
                | FUTURE PAYMENT STRUCTURE (inactive now)
                |--------------------------------------------------------------------------
                | These will be linked with payments table later
                */
                $totalPaid = 0;              // future: sum(payments.amount)
                $totalDue  = $finalAmount;   // future: finalAmount - totalPaid

                return [
                    // Tourist
                    'name'           => $tourist->name,

                    // Tour info
                    'place_name'     => $app->tourPackage->place->name ?? '-',
                    'package_name'   => $app->tourPackage->package_title ?? '-',

                    // Pricing
                    'price'          => $price,
                    'discount_pct'   => $discountPct,
                    'discount_amt'   => $discountAmt,
                    'final_amount'   => $finalAmount,

                    // Payment (future)
                    'total_paid'     => $totalPaid,
                    'total_due'      => $totalDue,

                    // Status & date
                    'status'         => $app->status,
                    'applied_at'     => $app->created_at,
                ];
            });

        return view(
            'frontend.pages.profile',
            compact('tourist', 'applications')
        );

    } catch (\Exception $e) {
        alert()->error('Error', 'Unable to load profile!');
        return redirect()->back();
    }
}
// Frontend: logout tourist
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



    public function touristIndex()
{
    try {
        $tourists = Tourist::latest()->get();
        return view('backend.pages.tourists.index', compact('tourists'));
    } catch (Exception $e) {
        alert()->error('Error', 'Unable to load tourists!');
        return redirect()->back();
    }
}

// Backend: delete tourist
public function touristDelete($id)
{
    try {
        $tourist = Tourist::findOrFail($id);
        $tourist->delete();

        alert()->success('Success', 'Tourist deleted successfully!');
        return redirect()->back();
    } catch (Exception $e) {
        alert()->error('Error', 'Delete failed!');
        return redirect()->back();
    }
}
}
