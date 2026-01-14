<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\TourApplication;
use Illuminate\Support\Facades\DB;

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

    // ===============================
    // VALIDATION
    // ===============================
    $request->validate([
        'phone'             => 'required|regex:/^01[3-9][0-9]{8}$/',
        'present_address'   => 'required|string|min:5|max:255',
        'city'              => 'required|string|max:100',
        'emergency_contact' => 'required|regex:/^01[3-9][0-9]{8}$/',
        'total_persons'     => 'required|integer|min:1',
    ]);

    // ===============================
    // TRANSACTION START
    // ===============================
    return DB::transaction(function () use ($request, $package, $tourist) {

        // 🔒 Always get latest seat info
        $package->refresh();

        // ❌ Seat availability check (MAIN FIX)
        if ($request->total_persons > $package->available_seats) {
            return back()
                ->withInput()
                ->with('error', 'Only '.$package->available_seats.' seats are available.');
        }

        // ===============================
        // AMOUNT CALCULATION
        // ===============================
        $price = $package->price_per_person;
        $discount = $package->discount ?? 0;
        $discountAmount = ($price * $discount) / 100;
        $perPersonAmount = $price - $discountAmount;

        $totalPersons = (int) $request->total_persons;
        $finalAmount = $perPersonAmount * $totalPersons;

        // ===============================
        // CREATE APPLICATION
        // ===============================
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

        // ===============================
        // UPDATE SEATS (ATOMIC)
        // ===============================
        $package->decrement('available_seats', $totalPersons);
        $package->increment('booked', $totalPersons);

        // ===============================
        // REDIRECT TO PAYMENT
        // ===============================
        return redirect()->route('tour.payment.start', $application->id);
    });
}

}
