<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class WebHomeController extends Controller
{
public function home()
{
    $packages = TourPackage::with('place')
        ->where('status', 'active')
        ->latest()
        ->take(2) 
        ->get();

    return view('frontend.pages.home', compact('packages'));
}
    
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function services()
    {
        return view('frontend.pages.services');
    }
}
