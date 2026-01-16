<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Place;
use App\Models\Hotel;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TourPackageController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
public function index(Request $request)
{
    $packages = TourPackage::with(['place','hotel'])
        ->withCount('tourApplications')

        // 🔍 Title search
        ->when($request->title, function ($q) use ($request) {
            $q->where('package_title', 'like', '%' . $request->title . '%');
        })

        // 📍 Place filter
        ->when($request->place_id, function ($q) use ($request) {
            $q->where('place_id', $request->place_id);
        })

        // 🏨 Hotel filter
        ->when($request->hotel_id, function ($q) use ($request) {
            $q->where('hotel_id', $request->hotel_id);
        })

        // 🟢 Status filter
        ->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        })

        // 📅 Start date
        ->when($request->from_date, function ($q) use ($request) {
            $q->whereDate('start_date', '>=', $request->from_date);
        })

        // 📅 End date
        ->when($request->to_date, function ($q) use ($request) {
            $q->whereDate('end_date', '<=', $request->to_date);
        })

        ->latest()
        ->paginate(10)
        ->withQueryString();

    $places = Place::orderBy('name')->get();
    $hotels = Hotel::orderBy('name')->get();

    return view(
        'backend.pages.tour-packages.index',
        compact('packages','places','hotels')
    );
}

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $places = Place::where('status','active')->get();
        $hotels = Hotel::where('status','active')->get();
        $transportations = Transportation::where('status','active')->get();

        return view(
            'backend.pages.tour-packages.create',
            compact('places','hotels','transportations')
        );
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'package_title'       => 'required|string|max:255',
            'short_description'   => 'required|string|max:500',
            'full_description'    => 'required|string',

            'place_id'            => 'required|exists:places,id',

            'start_date'          => 'required|date|after_or_equal:today',
            'end_date'            => 'required|date|after_or_equal:start_date',

            'max_persons'         => 'required|integer|min:1',
            'min_persons'         => 'nullable|integer|min:1|lte:max_persons',

            'price_per_person'    => 'required|numeric|min:1',
            'discount'            => 'nullable|numeric|min:0|max:100',

            'hotel_id'            => 'required|exists:hotels,id',
            'transportation_id'   => 'required|exists:transportations,id',

            'included_items'      => 'required|string',
            'excluded_items'      => 'nullable|string',

            'thumbnail_image'     => 'required|image|mimes:jpg,jpeg,png,webp',

            'status'              => 'required|in:active,inactive',
        ]);

        // Image Upload
        $imageName = null;
        if ($request->hasFile('thumbnail_image')) {
            $imageName = time().'.'.$request->thumbnail_image->extension();
            $request->thumbnail_image->move(public_path('uploads/tour-packages'), $imageName);
        }

        $package = new TourPackage();
        $package->package_title      = $request->package_title;
        $package->short_description  = $request->short_description;
        $package->full_description   = $request->full_description;
        $package->place_id           = $request->place_id;
        $package->start_date         = $request->start_date;
        $package->end_date           = $request->end_date;
        $package->max_persons        = $request->max_persons;
        $package->min_persons        = $request->min_persons;
        $package->available_seats    = $request->max_persons;
        $package->price_per_person   = $request->price_per_person;
        $package->discount           = $request->discount;
        $package->hotel_id           = $request->hotel_id;
        $package->transportation_id  = $request->transportation_id;
        $package->included_items     = $request->included_items;
        $package->excluded_items     = $request->excluded_items;
        $package->thumbnail_image    = $imageName;
        $package->status             = $request->status;
        $package->booked             = 0;
        $package->save();

        alert()->success('Success', 'Tour package created successfully!');
        return redirect()->route('tour-packages.index');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $package = TourPackage::findOrFail($id);
        $places = Place::where('status','active')->get();
        $hotels = Hotel::where('status','active')->get();
        $transportations = Transportation::where('status','active')->get();

        return view(
            'backend.pages.tour-packages.edit',
            compact('package','places','hotels','transportations')
        );
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
{
    $request->validate([
        'package_title'       => 'required|string|max:255',
        'short_description'   => 'required|string|max:500',
        'full_description'    => 'required|string',

        'place_id'            => 'required|exists:places,id',

            'start_date'          => 'required|date|after_or_equal:today',
            'end_date'            => 'required|date|after_or_equal:start_date',

        'max_persons'         => 'required|integer|min:1',
        'min_persons'         => 'nullable|integer|min:1|lte:max_persons',

        'price_per_person'    => 'required|numeric|min:1',
        'discount'            => 'nullable|numeric|min:0|max:100',

        'hotel_id'            => 'required|exists:hotels,id',
        'transportation_id'   => 'required|exists:transportations,id',

        'included_items'      => 'required|string',
        'excluded_items'      => 'nullable|string',

        'thumbnail_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'status'              => 'required|in:active,inactive',
    ]);

    $package = TourPackage::findOrFail($id);


    $bookedSeats = $package->max_persons - $package->available_seats;

 
    if ($request->max_persons < $bookedSeats) {
        return back()
            ->withErrors([
                'max_persons' =>
                    "You already have {$bookedSeats} booked seats. Max persons cannot be less than booked seats."
            ])
            ->withInput();
    }

  
    $newAvailableSeats = $request->max_persons - $bookedSeats;

    // 🖼 Image update
    if ($request->hasFile('thumbnail_image')) {
        if ($package->thumbnail_image && File::exists(public_path('uploads/tour-packages/'.$package->thumbnail_image))) {
            File::delete(public_path('uploads/tour-packages/'.$package->thumbnail_image));
        }

        $imageName = time().'.'.$request->thumbnail_image->extension();
        $request->thumbnail_image->move(public_path('uploads/tour-packages'), $imageName);
        $package->thumbnail_image = $imageName;
    }

    // 📝 Update fields
    $package->package_title      = $request->package_title;
    $package->short_description  = $request->short_description;
    $package->full_description   = $request->full_description;
    $package->place_id           = $request->place_id;
    $package->start_date         = $request->start_date;
    $package->end_date           = $request->end_date;
    $package->max_persons        = $request->max_persons;
    $package->min_persons        = $request->min_persons;
    $package->available_seats    = $newAvailableSeats;
    $package->price_per_person   = $request->price_per_person;
    $package->discount           = $request->discount;
    $package->hotel_id           = $request->hotel_id;
    $package->transportation_id  = $request->transportation_id;
    $package->included_items     = $request->included_items;
    $package->excluded_items     = $request->excluded_items;
    $package->status             = $request->status;
    $package->booked             = 0;
    $package->save();

    alert()->success('Success', 'Tour package updated successfully!');
    return redirect()->route('tour-packages.index');
}

    

    // ===============================
    // DELETE
    // ===============================
    public function destroy($id)
    {
        $package = TourPackage::findOrFail($id);

        if ($package->thumbnail_image && File::exists(public_path('uploads/tour-packages/'.$package->thumbnail_image))) {
            File::delete(public_path('uploads/tour-packages/'.$package->thumbnail_image));
        }

        $package->delete();

        alert()->success('Success', 'Tour package deleted successfully!');
        return redirect()->back();
    }


    public function show($id)
{
    $package = TourPackage::with(['place','hotel','transportation'])
                ->findOrFail($id);

    return view('backend.pages.tour-packages.show', compact('package'));
}

}
