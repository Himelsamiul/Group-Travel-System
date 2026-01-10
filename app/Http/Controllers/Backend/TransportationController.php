<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transportation;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function index()
    {
        $transportations = Transportation::latest()->paginate(1);
        return view('backend.pages.transportation.index', compact('transportations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transport_name' => 'required|string|max:255',
            'type' => 'required|in:bus,car,air,launch,micro',
            'status' => 'required|in:active,inactive',
        ]);

        Transportation::create($request->all());

        return back()->with('success','Transportation created successfully');
    }

    public function edit($id)
    {
        $transport = Transportation::findOrFail($id);
        $transportations = Transportation::latest()->paginate(1);

        return view('backend.pages.transportation.index',
            compact('transport','transportations'));
    }

    public function update(Request $request, $id)
    {
        $transport = Transportation::findOrFail($id);

        $request->validate([
            'transport_name' => 'required',
            'type' => 'required|in:bus,car,air,launch,micro',
            'status' => 'required|in:active,inactive',
        ]);

        $transport->update($request->all());

        return redirect()->route('transportations.index')
            ->with('success','Transportation updated successfully');
    }

    public function destroy($id)
    {
        Transportation::findOrFail($id)->delete();

        return back()->with('success','Transportation deleted successfully');
    }
}

