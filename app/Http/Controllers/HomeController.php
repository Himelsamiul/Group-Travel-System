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

            // Existing cards
            'totalPackages'  => TourPackage::count(),
            'totalHotels'    => Hotel::count(),
            'totalTransport' => Transportation::count(),
            'totalPlaces'    => Place::count(),

          
            'totalBookings'        => TourApplication::count(),
            'totalAcceptedBooking' => TourApplication::where('status', 'accepted')->count(),
            'totalPendingBooking'  => TourApplication::where('status', 'pending')->count(),
            'totalRejectedBooking' => TourApplication::where('status', 'rejected')->count(),

            
            'totalTourists'        => Tourist::count(),
        ]);
    }
}
