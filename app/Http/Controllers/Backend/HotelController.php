<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{

    public function index()
    {
        $hotels = Hotel::withCount('tourPackages')
            ->latest()
            ->paginate(10);

        return view('backend.pages.hotels.index', compact('hotels'));
    }


   
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'stars'  => 'required|integer|min:1|max:5',
            'status' => 'required',
        ]);

        Hotel::create($request->only('name','stars','note','status'));

        alert()->success('Success', 'Hotel created successfully!');
        return redirect()->back();
    }


    public function edit($id)
    {
        $hotel  = Hotel::findOrFail($id);
        $hotels = Hotel::withCount('tourPackages')
            ->latest()
            ->paginate(10);

        return view('backend.pages.hotels.index', compact('hotel','hotels'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required',
            'stars'  => 'required|integer|min:1|max:5',
            'status' => 'required',
        ]);

        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->only('name','stars','note','status'));

        alert()->success('Success', 'Hotel updated successfully!');
        return redirect()->route('hotels.index');
    }


    public function destroy($id)
    {
        $hotel = Hotel::withCount('tourPackages')->findOrFail($id);

        if ($hotel->tour_packages_count > 0) {
            alert()->error(
                'Action Blocked',
                'This hotel is already used in tour packages!'
            );
            return redirect()->back();
        }

        $hotel->delete();

        alert()->success('Success', 'Hotel deleted successfully!');
        return redirect()->back();
    }
}
