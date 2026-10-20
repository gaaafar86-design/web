<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Location;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $locations = Location::withCount('properties')->get();
        return view('admin.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'name' => 'required|string|min:3|unique:locations,name',
        ]);

        $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
        $request->photo->storeAs('location-images', $fileName);

        Location::create([
            'name' => ucwords($request->name),
            'slug' => Str::slug($request->name),
            'photo' => $fileName,
        ]);
        return redirect()->route('admin.locations.index')->with('success', 'Location created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @return View
     */
    public function edit(Location $location): View
    {
        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Location $location
     * @return RedirectResponse
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:locations,name,' . $location->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $fileName = $location->photo;
        if ($request->file('photo')) {
            Storage::delete('location-images/' . $location->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('location-images', $fileName);
        };

        $location->update([
            'name' => ucwords($request->name),
            'slug' => Str::slug($request->name),
            'photo' => $fileName,
        ]);
        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return RedirectResponse
     */
    public function destroy(Location $location): RedirectResponse
    {
        if ($location->properties->isNotEmpty()) {
            return back()->with('error', 'Cannot delete location with active properties.');
        };

        Storage::delete('location-images/' . $location->photo);
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully');
    }
}
