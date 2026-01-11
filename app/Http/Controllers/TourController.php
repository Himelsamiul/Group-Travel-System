<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;

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
            ->where('available_seats', '>', 0)
            ->findOrFail($id);

        return view('frontend.pages.tour-packages.show', compact('package'));
    }
}
