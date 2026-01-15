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

    // ✅ Validation
    $request->validate([
        'phone' => 'required|regex:/^01[3-9][0-9]{8}$/',
        'present_address' => 'required|string|min:5|max:255',
        'city' => 'required|string|max:100',
        'emergency_contact' => 'required|regex:/^01[3-9][0-9]{8}$/',
        'total_persons' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // 🔒 Lock package row
        $package = TourPackage::lockForUpdate()->findOrFail($package->id);

        // ❌ Seat check (MAIN FIX)
        if ($request->total_persons > $package->available_seats) {
            DB::rollBack();
            return back()
                ->withErrors([
                    'total_persons' =>
                        'Only '.$package->available_seats.' seat(s) available'
                ])
                ->withInput();
        }

        // 💰 Price calculation
        $price = $package->price_per_person;
        $discount = $package->discount ?? 0;
        $perPerson = $price - (($price * $discount) / 100);

        $totalPersons = (int) $request->total_persons;
        $finalAmount = $perPerson * $totalPersons;

        // ✅ Create application
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

        // 🔥 Update seats safely
        $package->available_seats -= $totalPersons;
        $package->booked += $totalPersons;
        $package->save();

        DB::commit();

        // ➡️ Payment
        return redirect()->route('tour.payment.start', $application->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong. Please try again.');
    }
}
}