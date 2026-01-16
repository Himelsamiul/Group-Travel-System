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

public function index(Request $request)
{
    $applications = TourApplication::with(['tourist', 'tourPackage'])
        ->when($request->name, function ($q) use ($request) {
            $q->whereHas('tourist', function ($qq) use ($request) {
                $qq->where('name', 'like', '%' . $request->name . '%');
            });
        })
        ->when($request->phone, function ($q) use ($request) {
            $q->where('phone', 'like', '%' . $request->phone . '%');
        })
        ->when($request->package_id, function ($q) use ($request) {
            $q->where('tour_package_id', $request->package_id);
        })
        ->when($request->from_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->latest()
        ->get();

    $packages = TourPackage::orderBy('package_title')->get();

    return view('backend.pages.tour-list', compact('applications', 'packages'));
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

    public function acceptRequest($id)
    {
        DB::transaction(function () use ($id) {

            $application = TourApplication::with('tourPackage')->findOrFail($id);

            // Only pending allowed
            if ($application->status !== 'cancel requested') {
                return;
            }
            
            // Update application status
            $application->status = 'cancel request accept';
            $application->save();
            
            $total_persons = $application-> total_persons;
            
            $application->tourPackage->available_seats += (int) $total_persons;
            $application->tourPackage->booked -= (int) $total_persons;
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
