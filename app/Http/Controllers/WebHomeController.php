<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebHomeController extends Controller
{
    public function home()
    {
        return view('frontend.pages.home');
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
