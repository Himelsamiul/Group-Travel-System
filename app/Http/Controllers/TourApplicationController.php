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

        return view('frontend.pages.apply', compact('package', 'tourist'));
    }

    // ===============================
    // Submit Apply Form
    // ===============================
    public function apply(Request $request, TourPackage $package)
    {
        $tourist = auth()->guard('touristGuard')->user();

        // ❌ Seat full safety
        if ($package->available_seats <= 0) {
            return redirect()
                ->route('tour.packages.show', $package->id)
                ->with('error', 'Seats are full for this tour.');
        }

        // ✅ Validation
        $request->validate([
            'phone' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'present_address' => 'required|string|min:5|max:255',
            'city' => 'required|string|max:100',
            'emergency_contact' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'total_persons' => 'required|integer|min:1',
        ]);

        // ✅ Amount calculation
        $amount = $package->price_per_person;
        $discount = $package->discount ?? 0;
        $discountAmount = ($amount * $discount) / 100;
        $perPersonAmount = $amount - $discountAmount;

        $totalPersons = $request->total_persons;
        $finalAmount = $perPersonAmount * $totalPersons;

        // ✅ CREATE APPLICATION BEFORE PAYMENT
        $application = TourApplication::create([
            'tourist_id'        => $tourist->id,
            'tour_package_id'   => $package->id,
            'phone'             => $request->phone,
            'address'           => $request->present_address,
            'city'              => $request->city,
            'note_name'         => $request->note_name,
            'special_note'      => $request->special_note,
            'total_persons'     => $totalPersons,
            'emergency_contact' => $request->emergency_contact,
            'status'            => 'pending',
            'final_amount'      => $finalAmount,
            'dues'              => $finalAmount,
            'payment_status'    => 'Unpaid',
        ]);

        $total_persons = $application->total_persons;
        // Decrease seat
        $application->tourPackage->available_seats -= (int) $total_persons;
        $application->tourPackage->booked += (int) $total_persons;
        $application->tourPackage->save();

        // ✅ NOW CALL PAYMENT ROUTE (NO LOGIC CHANGE)
        return redirect()->route('tour.payment.start', $application->id);
    }
}
