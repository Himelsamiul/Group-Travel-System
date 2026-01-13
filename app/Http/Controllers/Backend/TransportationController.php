<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transportation;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    // ===============================
    // Create + List
    // ===============================
    public function index()
    {
        $transportations = Transportation::withCount('tourPackages')
            ->latest()
            ->paginate(10);

        return view('backend.pages.transportation.index', compact('transportations'));
    }

    // ===============================
    // Store
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'transport_name' => 'required|string|max:255',
            'type'           => 'required|in:bus,car,air,launch,micro',
            'status'         => 'required|in:active,inactive',
        ]);

        Transportation::create($request->only(
            'transport_name','type','note','status'
        ));

        alert()->success('Success', 'Transportation created successfully!');
        return redirect()->back();
    }

    // ===============================
    // Edit
    // ===============================
    public function edit($id)
    {
        $transport = Transportation::findOrFail($id);

        $transportations = Transportation::withCount('tourPackages')
            ->latest()
            ->paginate(10);

        return view('backend.pages.transportation.index', compact(
            'transport','transportations'
        ));
    }

    // ===============================
    // Update
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'transport_name' => 'required',
            'type'           => 'required|in:bus,car,air,launch,micro',
            'status'         => 'required|in:active,inactive',
        ]);

        $transport = Transportation::findOrFail($id);
        $transport->update($request->only(
            'transport_name','type','note','status'
        ));

        alert()->success('Success', 'Transportation updated successfully!');
        return redirect()->route('transportations.index');
    }

    // ===============================
    // Delete (SAFE)
    // ===============================
    public function destroy($id)
    {
        $transport = Transportation::withCount('tourPackages')
            ->findOrFail($id);

        if ($transport->tour_packages_count > 0) {
            alert()->error(
                'Action Blocked',
                'This transportation is already used in tour packages!'
            );
            return redirect()->back();
        }

        $transport->delete();

        alert()->success('Success', 'Transportation deleted successfully!');
        return redirect()->back();
    }
}
