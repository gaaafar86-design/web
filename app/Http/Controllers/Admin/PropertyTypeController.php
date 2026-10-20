<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $types = PropertyType::latest()->get();
        return view('admin.property_type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.property_type.create');
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
            'name' => 'required|string|min:3|unique:property_types,name',
        ]);

        PropertyType::create([
            'name' => ucwords($request->name),
        ]);
        return redirect()->route('admin.property.types.index')->with('success', 'Property type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PropertyType $propertyType
     * @return View
     */
    public function edit(PropertyType $propertyType): View
    {
        return view('admin.property_type.edit', compact('propertyType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PropertyType $propertyType
     * @return RedirectResponse
     */
    public function update(Request $request, PropertyType $propertyType): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:property_types,name,' . $propertyType->id,
        ]);

        $propertyType->update([
            'name' => ucwords($request->name),
        ]);
        return redirect()->route('admin.property.types.index')->with('success', 'Property type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PropertyType $propertyType
     * @return RedirectResponse
     */
    public function destroy(PropertyType $propertyType): RedirectResponse
    {
        if ($propertyType->properties->isNotEmpty()) {
            return redirect()->back()->with('error', 'Cannot delete property type with active properties.');
        };

        $propertyType->delete();
        return redirect()->route('admin.property.types.index')->with('success', 'Property type deleted successfully');
    }
}
