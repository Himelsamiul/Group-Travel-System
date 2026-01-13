<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TourApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TourPackage;

class TourApprovalController extends Controller
{

    public function index()
    {
        $applications = TourApplication::with(['tourist', 'tourPackage'])
            ->latest()
            ->get();

        return view('backend.pages.tour-list', compact('applications'));
    }


    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $application = TourApplication::with('tourPackage')->findOrFail($id);

            // Only pending allowed
            if ($application->status !== 'pending') {
                return;
            }

            // Seat availability check
            if ($application->tourPackage->available_seats <= 0) {
                return;
            }

            // Update application status
            $application->status = 'accepted';
            $application->save();

            // Decrease seat
            $application->tourPackage->available_seats -= 1;
            $application->tourPackage->save();
        });

        return back()->with('success', 'Application approved and seat updated.');
    }

    public function complete_payment($id)
    {
        DB::transaction(function () use ($id) {

            $application = TourApplication::with('tourPackage')->findOrFail($id);

            if ($application->payment_status !== 'Paid') {

                // Update application status
                $application->payment_status = 'Paid';
                $application->dues = 0;
                $application->save();
            }
        });

        return back()->with('success', 'Payment Complete.');
    }

    /**
     * Reject a tour application
     * - Only pending can be rejected
     * - Seat will NOT change
     */
    public function reject($id)
    {
        $application = TourApplication::findOrFail($id);

            $application->status = 'rejected';
            $application->save();

        return back()->with('success', 'Application rejected.');
    }


 public function report(Request $request)
    {
        $query = TourApplication::with(['tourist', 'tourPackage']);

        // ---------------- FILTERS ----------------

        // Tourist name
        if ($request->tourist_name) {
            $query->whereHas('tourist', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->tourist_name . '%');
            });
        }

        // Package
        if ($request->tour_package_id) {
            $query->where('tour_package_id', $request->tour_package_id);
        }

        // Phone
        if ($request->phone) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        // Booking status
        if ($request->status) {
            $query->where('status', $request->status);
        }


        // Date range
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay(),
            ]);
        }

        // ---------------- DATA ----------------
        $applications = $query->latest()->get();
        $packages     = TourPackage::all();

        return view('backend.pages.reports', compact(
            'applications',
            'packages'
        ));
    }
}
