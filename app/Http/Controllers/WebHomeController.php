<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\ContactMessage;

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




public function contactSubmit(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name'  => 'required|string|max:100',
        'email'      => 'required|email',
        'message'    => 'required|string|max:1000',
    ]);

 ContactMessage::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'message'    => $request->message,
    ]);

    return back()->with('success', 'Your message has been sent successfully!');
}

public function contactMessages()
{
    $messages = ContactMessage::latest()->paginate(10);

    return view('backend.pages.contactus', compact('messages'));
}

    public function services()
    {
        return view('frontend.pages.services');
    }
}
