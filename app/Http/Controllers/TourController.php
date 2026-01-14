<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\TourApplication;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // ===============================
    // Tour Listing Page
    // ===============================
    public function index()
    {
        $packages = TourPackage::where('status', 'active')
            ->where('available_seats', '>', 0)
            ->latest()
            ->paginate(9);

        return view('frontend.pages.tour-packages.index', compact('packages'));
    }

    // ===============================
    // Tour Details Page
    // ===============================


public function show($id)
{
    $package = TourPackage::with(['place','hotel','transportation'])
        ->where('status', 'active')
        ->findOrFail($id);

    $canApply = true;
  
    if ($package->available_seats <= 0) {
        $canApply = false;
    }

    return view(
        'frontend.pages.tour-packages.show',
        compact('package','canApply')
    );
}

}
