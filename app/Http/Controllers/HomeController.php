<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Hotel;
use App\Models\Transportation;
use App\Models\Place;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('backend.pages.dashboard', [
            'totalPackages'      => TourPackage::count(),
            'totalHotels'        => Hotel::count(),
            'totalTransport'     => Transportation::count(),
            'totalPlaces'        => Place::count(),
        ]);
    }
}
