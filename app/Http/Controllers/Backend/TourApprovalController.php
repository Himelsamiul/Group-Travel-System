<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TourApplication;
use Illuminate\Support\Facades\DB;

class TourApprovalController extends Controller
{
    /**
     * Show all tour applications (pending / accepted / rejected)
     */
    public function index()
    {
        $applications = TourApplication::with(['tourist', 'tourPackage'])
            ->latest()
            ->get();

        return view('backend.pages.tour-list', compact('applications'));
    }

    /**
     * Approve a tour application
     * - Only pending can be approved
     * - Seat will decrease by 1
     */
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

        if ($application->status === 'pending') {
            $application->status = 'rejected';
            $application->save();
        }

        return back()->with('success', 'Application rejected.');
    }
}
