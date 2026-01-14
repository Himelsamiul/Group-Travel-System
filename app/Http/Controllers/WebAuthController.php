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
                'name' => 'required|string|max:100',
'email' => 'required|email|unique:tourists,email',
'password' => 'required|string|min:6',
'phone' => 'required|regex:/^01[3-9][0-9]{8}$/',
'address' => 'required|string|max:255',
'gender' => 'required|in:male,female,other',
'date_of_birth' => 'required|date|before:today',
'nationality' => 'required|string|max:100',
'nid_passport' => 'required|string|max:16',

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
            return redirect()->back()
                ->withErrors($checkValidation)
                ->withInput();
        }

        //  Check if tourist exists
        $tourist = \App\Models\Tourist::where('email', $request->email)->first();

        // ❌ Tourist exists but inactive
        if ($tourist && $tourist->status !== 'active') {
            alert()->error(
                'Account Inactive',
                'Your account is inactive. Please contact admin.'
            );
            return redirect()->back();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // ✅ Login attempt
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
    r
                */
                $totalPaid = 0;              // future: sum(payments.amount)
                $totalDue  = $finalAmount;   // future: finalAmount - totalPaid

                return [
                    // Tourist
                    'application_id' => $app->id,
                    'name'           => $tourist->name,

                    // Tour info
                    'place_name'     => $app->tourPackage->place->name ?? '-',
                    'package_name'   => $app->tourPackage->package_title ?? '-',

                    // Pricing
                    'price'          => $price,
                    'discount_pct'   => $discountPct,
                    'discount_amt'   => $discountAmt,
                    'final_amount'   => $app->final_amount,

                    'total_due'      => $app->dues,

                    // Status & date
                    'status'         => $app->status,
                    'payment_status'         => $app->payment_status,
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
        $tourists = Tourist::withCount('tourApplications')
                    ->latest()
                    ->get();

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
        $tourist = Tourist::withCount('tourApplications')->findOrFail($id);

        if ($tourist->tour_applications_count > 0) {
            alert()->error('Error', 'This tourist has bookings. Delete not allowed!');
            return back();
        }

        $tourist->delete();

        alert()->success('Success', 'Tourist deleted successfully!');
        return redirect()->back();
    } catch (Exception $e) {
        alert()->error('Error', 'Delete failed!');
        return redirect()->back();
    }
}
public function toggleTouristStatus($id)
{
    $tourist = Tourist::findOrFail($id);

    $tourist->status = $tourist->status === 'active'
                        ? 'inactive'
                        : 'active';

    $tourist->save();

    alert()->success('Success', 'Tourist status updated successfully!');
    return back();
}


}
