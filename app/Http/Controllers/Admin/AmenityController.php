<?php

namespace App\Http\Controllers\Admin;

use App\Models\Amenity;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $amenities = Amenity::latest()->get();
        return view('admin.amenity.index', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.amenity.create');
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
            'name' => 'required|string|min:3|unique:amenities,name',
        ]);

        Amenity::create([
            'name' => ucwords($request->name),
        ]);
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Amenity $amenity
     * @return View
     */
    public function edit(Amenity $amenity): View
    {
        return view('admin.amenity.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Amenity $amenity
     * @return RedirectResponse
     */
    public function update(Request $request, Amenity $amenity): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:amenities,name,' . $amenity->id,
        ]);

        $amenity->update([
            'name' => ucwords($request->name),
        ]);
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Amenity $amenity
     * @return RedirectResponse
     */
    public function destroy(Amenity $amenity): RedirectResponse
    {
        $usedAmenity = DB::table('amenity_property')
            ->where('amenity_id', $amenity->id)
            ->exists();
        if ($usedAmenity) {
            return back()->with(
                'error',
                'This amenity is currently linked to one or more properties and cannot be deleted.'
            );
        };

        $amenity->delete();
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity deleted successfully');
    }
}
