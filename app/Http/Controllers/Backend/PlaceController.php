<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    // ===============================
    // Create + List Page
    // ===============================
    public function index()
    {
        try {
            // 🌍 Manual Country List (NO PACKAGE)
            $countries = [
                'Bangladesh',
                'India',
                'Pakistan',
                'Nepal',
                'Sri Lanka',
                'United States',
                'United Kingdom',
                'Canada',
                'Australia',
                'Malaysia',
                'Singapore',
                'Thailand',
                'Indonesia',
                'Japan',
                'China',
                'South Korea',
                'Saudi Arabia',
                'United Arab Emirates',
                'Qatar',
                'Kuwait',
                'Turkey',
                'Germany',
                'France',
                'Italy',
                'Spain',
                'Netherlands'
            ];

            sort($countries); // A–Z

            $places = Place::latest()->get();

            return view('backend.pages.places.index', compact('places', 'countries'));

        } catch (\Throwable $e) {
            alert()->error('Error', 'Unable to load page!');
            return redirect()->back();
        }
    }

    // ===============================
    // Store
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'name' => 'required',
        ]);

        Place::create([
            'country' => $request->country,
            'name'    => $request->name,
            'note'    => $request->note,
        ]);

        alert()->success('Success', 'Place created successfully!');
        return redirect()->back();
    }

    // ===============================
    // Edit (same page)
    // ===============================
    public function edit($id)
    {
        $countries = [
            'Bangladesh','India','Pakistan','Nepal','Sri Lanka',
            'United States','United Kingdom','Canada','Australia',
            'Malaysia','Singapore','Thailand','Indonesia',
            'Japan','China','South Korea','Saudi Arabia',
            'United Arab Emirates','Qatar','Kuwait',
            'Turkey','Germany','France','Italy','Spain','Netherlands'
        ];

        sort($countries);

        $place  = Place::findOrFail($id);
        $places = Place::latest()->get();

        return view('backend.pages.places.index', compact('place','places','countries'));
    }

    // ===============================
    // Update
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required',
            'name' => 'required',
        ]);

        $place = Place::findOrFail($id);
        $place->update([
            'country' => $request->country,
            'name'    => $request->name,
            'note'    => $request->note,
        ]);

        alert()->success('Success', 'Place updated successfully!');
        return redirect()->route('places.index');
    }

    // ===============================
    // Delete
    // ===============================
public function destroy($id)
{
    Place::findOrFail($id)->delete();

    alert()->success('Success', 'Place deleted successfully!');
    return redirect()->back();
}
}
