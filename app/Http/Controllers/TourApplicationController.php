<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\TourApplication;

class TourApplicationController extends Controller
{
    // ===============================
    // Show Apply Form
    // ===============================
    public function showApplyForm(TourPackage $package)
    {
        $tourist = auth()->guard('touristGuard')->user();

        // ❌ Seat full
        if ($package->available_seats <= 0) {
            return redirect()
                ->route('tour.packages.show', $package->id)
                ->with('error', 'Seats are full for this tour.');
        }

        // ❌ Already pending / accepted
        $alreadyApplied = TourApplication::where('tourist_id', $tourist->id)
            ->where('tour_package_id', $package->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('tour.packages.show', $package->id)
                ->with('error', 'You already applied for this tour.');
        }

        return view('frontend.pages.apply', compact('package', 'tourist'));
    }

    // ===============================
    // Submit Apply Form
    // ===============================
    public function apply(Request $request, TourPackage $package)
    {
        // dd($package);
        $tourist = auth()->guard('touristGuard')->user();

        // ❌ Seat full safety
        if ($package->available_seats <= 0) {
            return redirect()
                ->route('tour.packages.show', $package->id)
                ->with('error', 'Seats are full for this tour.');
        }

        // ❌ Duplicate apply safety
        $alreadyApplied = TourApplication::where('tourist_id', $tourist->id)
            ->where('tour_package_id', $package->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('tour.packages.show', $package->id)
                ->with('error', 'You already applied for this tour.');
        }

        // ✅ Validation
        $request->validate([
            'phone'             => 'required',
            'present_address'   => 'required',
            'city'              => 'required',
            'emergency_contact' => 'required',
        ]);

        $amount = $package->price_per_person;
        $discount = $package->discount;
        $discount_amount = ($amount * $discount) / 100;
        $final_amount = $amount - $discount_amount;
        // dd($final_amount);
        // ✅ Create application
        TourApplication::create([
            'tourist_id'        => $tourist->id,
            'tour_package_id'   => $package->id,
            'phone'             => $request->phone,
            'address'           => $request->present_address,
            'city'              => $request->city,
            'emergency_contact' => $request->emergency_contact,
            'status'            => 'pending',
            'final_amount'            => $final_amount,
            'dues'            => $final_amount,
            'payment_status'            => 'Pending',
        ]);

        return redirect()
            ->route('tour.packages.show', $package->id)
            ->with('success', 'Application submitted. Waiting for admin approval.After admin approval, if payment is not completed within 1 days, the make payment button will not be visible');
    }
}
