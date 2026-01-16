<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Hotel;
use App\Models\Transportation;
use App\Models\Place;
use App\Models\TourApplication;
use App\Models\Tourist;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('backend.pages.dashboard', [

            // Basic cards
            'totalPackages'  => TourPackage::count(),
            'totalHotels'    => Hotel::count(),
            'totalTransport' => Transportation::count(),
            'totalPlaces'    => Place::count(),
            'totalTourists'  => Tourist::count(),

            // Booking counts
            'totalBookings' => TourApplication::count(),

            'pendingBookings'   => TourApplication::where('status', 'pending')->count(),
            'acceptedBookings'  => TourApplication::where('status', 'accepted')->count(),
            'rejectedBookings'  => TourApplication::where('status', 'rejected')->count(),
            'bookedBookings'    => TourApplication::where('status', 'booked')->count(),
            'cancelReqBookings' => TourApplication::where('status', 'cancel requested')->count(),
            'cancelAccBookings' => TourApplication::where('status', 'cancel request accept')->count(),
        ]);
    }
}
