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

            $countries = [
                'Bangladesh','India','Pakistan','Nepal','Sri Lanka',
                'United States','United Kingdom','Canada','Australia',
                'Malaysia','Singapore','Thailand','Indonesia',
                'Japan','China','South Korea','Saudi Arabia',
                'United Arab Emirates','Qatar','Kuwait',
                'Turkey','Germany','France','Italy','Spain','Netherlands'
            ];

            sort($countries);

            // 🔥 IMPORTANT: withCount added
            $places = Place::withCount('tourPackages')
                ->latest()
                ->paginate(10);

            return view('backend.pages.places.index', compact(
                'places',
                'countries'
            ));

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
            'name'    => 'required',
            'note'    => 'nullable',
            'status'  => 'required|in:active,inactive'
        ]);

        $place = new Place();
        $place->country = $request->country;
        $place->name    = $request->name;
        $place->note    = $request->note;
        $place->status  = $request->status;
        $place->save();

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

        // 🔥 withCount here also
        $places = Place::withCount('tourPackages')
            ->latest()
            ->paginate(10);

        return view('backend.pages.places.index', compact(
            'place',
            'places',
            'countries'
        ));
    }

    // ===============================
    // Update
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required',
            'name'    => 'required',
            'note'    => 'nullable',
            'status'  => 'required|in:active,inactive'
        ]);

        $place = Place::findOrFail($id);
        $place->country = $request->country;
        $place->name    = $request->name;
        $place->note    = $request->note;
        $place->status  = $request->status;
        $place->save();

        alert()->success('Success', 'Place updated successfully!');
        return redirect()->route('places.index');
    }

    // ===============================
    // Delete (SAFE)
    // ===============================
    public function destroy($id)
    {
        $place = Place::withCount('tourPackages')->findOrFail($id);

        // 🔒 PREVENT DELETE IF USED
        if ($place->tour_packages_count > 0) {
            alert()->error(
                'Action Blocked',
                'This place is already used in tour packages!'
            );
            return redirect()->back();
        }

        $place->delete();

        alert()->success('Success', 'Place deleted successfully!');
        return redirect()->back();
    }
}
