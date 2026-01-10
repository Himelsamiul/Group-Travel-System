<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Create + List
    public function index()
    {
        $hotels = Hotel::latest()->get();
        return view('backend.pages.hotels.index', compact('hotels'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'stars' => 'required|integer|min:1|max:5',
            'status'=> 'required',
        ]);

        Hotel::create($request->only('name','stars','note','status'));

        alert()->success('Success', 'Hotel created successfully!');
        return redirect()->back();
    }

    // Edit (same page)
    public function edit($id)
    {
        $hotel  = Hotel::findOrFail($id);
        $hotels = Hotel::latest()->get();

        return view('backend.pages.hotels.index', compact('hotel','hotels'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'stars' => 'required|integer|min:1|max:5',
            'status'=> 'required',
        ]);

        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->only('name','stars','note','status'));

        alert()->success('Success', 'Hotel updated successfully!');
        return redirect()->route('hotels.index');
    }

    // Delete
    public function destroy($id)
    {
        Hotel::findOrFail($id)->delete();

        alert()->success('Success', 'Hotel deleted successfully!');
        return redirect()->back();
    }
}
