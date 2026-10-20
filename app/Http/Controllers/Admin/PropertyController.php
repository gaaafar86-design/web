<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Remove thousands separators; keep blank values as null
     * (an empty string would break integer columns like "floor").
     */
    private function cleanNumber($value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }
        return str_replace(',', '', (string) $value);
    }

    /**
     * Build a unique slug (Arabic-safe, includes soft-deleted rows).
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'property';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Property::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Safe file name for uploaded photos.
     */
    private function photoName($file): string
    {
        return Carbon::now()->format('YmdHisv') . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
    }


    

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $properties = Property::with('location', 'propertyType', 'agent')->latest()->get();
        return view('admin.property.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create(): View
    {
        $agents = Agent::where('status', '!=', 2)->orderBy('name')->get();
        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();

        return view('admin.property.create', compact(
            'agents',
            'locations',
            'propertyTypes',
            'amenities',
        ));
    }

    /**
     * Store a newly created property.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'price' => $this->cleanNumber($request->price),
            'size' => $this->cleanNumber($request->size),
            'floor' => $this->cleanNumber($request->floor),
        ]);

        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0|max:2147483647',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'type_id' => 'required|exists:property_types,id',
            'purpose' => 'required|string',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'size' => 'required|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'balcony' => 'nullable|integer|min:0',
            'address' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'is_featured' => 'required|in:0,1',
            'status' => 'required|in:0,1',
            'map' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'featured_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $slug = $this->uniqueSlug($request->name);
        $featuredPhotoName = $this->photoName($request->file('featured_photo'));
        $storedPhotoPaths = [];

        try {
            $request->file('featured_photo')->storeAs('property-images', $featuredPhotoName);
            $storedPhotoPaths[] = 'property-images/' . $featuredPhotoName;

            DB::transaction(function () use ($request, $featuredPhotoName, $slug, &$storedPhotoPaths) {
                $property = Property::create([
                    'agent_id' => $request->agent_id,
                    'location_id' => $request->location_id,
                    'property_type_id' => $request->type_id,
                    'name' => ucwords($request->name),
                    'slug' => $slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'featured_photo' => $featuredPhotoName,
                    'purpose' => ucwords($request->purpose),
                    'bedroom' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    'garage' => $request->garage,
                    'size' => $request->size,
                    'floor' => $request->floor,
                    'balcony' => $request->balcony,
                    'address' => $request->address,
                    'built_year' => $request->year,
                    'is_featured' => $request->is_featured,
                    'status' => $request->status,
                    'map' => $request->map,
                ]);

                if ($request->filled('amenities')) {
                    $property->amenities()->attach($request->amenities);
                }

                foreach ((array) $request->file('photos', []) as $photo) {
                    $additionalPhotoName = $this->photoName($photo);
                    $photo->storeAs('property-images', $additionalPhotoName);
                    $storedPhotoPaths[] = 'property-images/' . $additionalPhotoName;

                    PropertyPhoto::create([
                        'property_id' => $property->id,
                        'photo' => $additionalPhotoName,
                    ]);
                }
            });

            return redirect()->route('admin.properties.index')
                ->with('success', 'تم إنشاء العقار وحفظ الصور بنجاح.');
        } catch (\Throwable $e) {
            foreach ($storedPhotoPaths as $storedPhotoPath) {
                Storage::delete($storedPhotoPath);
            }

            Log::error('Admin property store failed: ' . $e->getMessage());

            $message = 'فشل إنشاء العقار. حاول مرة أخرى.';
            if (app()->environment('local')) {
                $message .= ' [' . $e->getMessage() . ']';
            }

            return back()->withInput()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property): View
    {
        $property->load('amenities');
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        $propertyVideos = PropertyVideo::where('property_id', $property->id)->get();
        return view('admin.property.show', compact('property', 'propertyPhotos', 'propertyVideos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property): View
    {
        $agents = Agent::orderBy('name')->get();
        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        $propertyVideos = PropertyVideo::where('property_id', $property->id)->get();
        return view(
            'admin.property.edit',
            compact(
                'property',
                'agents',
                'locations',
                'propertyTypes',
                'amenities',
                'propertyPhotos',
                'propertyVideos',
            ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        $request->merge([
            'price' => $this->cleanNumber($request->price),
            'size' => $this->cleanNumber($request->size),
            'floor' => $this->cleanNumber($request->floor),
        ]);

        $request->validate([
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0|max:2147483647',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'type_id' => 'required|exists:property_types,id',
            'purpose' => 'required|string',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'size' => 'required|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'balcony' => 'nullable|integer|min:0',
            'address' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'map' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'featured_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_featured' => 'nullable|in:0,1',
            'status' => 'nullable|in:0,1',
            'agent_id' => 'nullable|exists:agents,id',
        ]);

        $newPhoto = $request->file('featured_photo');
        $fileName = '';
        $currentFeaturedPhoto = $property->featured_photo;
        if ($newPhoto) {
            $fileName = $this->photoName($newPhoto);
        }

        $slug = $this->uniqueSlug($request->name, $property->id);

        try {
            DB::transaction(function () use ($request, $fileName, $property, $newPhoto, $slug) {
                $data = [
                    'location_id' => $request->location_id,
                    'property_type_id' => $request->type_id,
                    'name' => ucwords($request->name),
                    'slug' => $slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'featured_photo' => $newPhoto ? $fileName : $property->featured_photo,
                    'purpose' => ucwords($request->purpose),
                    'bedroom' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    'garage' => $request->garage,
                    'size' => $request->size,
                    'floor' => $request->floor,
                    'balcony' => $request->balcony,
                    'address' => $request->address,
                    'built_year' => $request->year,
                    'map' => $request->map,
                ];
                if ($request->filled('agent_id')) {
                    $data['agent_id'] = $request->agent_id;
                }
                if ($request->has('is_featured')) {
                    $data['is_featured'] = $request->is_featured;
                }
                if ($request->has('status')) {
                    $data['status'] = $request->status;
                }
                $property->update($data);
                $property->amenities()->sync($request->amenities ?? []);
            });

            if ($newPhoto) {
                Storage::delete('property-images/' . $currentFeaturedPhoto);
                $newPhoto->storeAs('property-images', $fileName);
            }

            return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Admin property update failed: ' . $e->getMessage());

            $message = 'Failed to update property. Please try again.';
            if (app()->environment('local')) {
                $message .= ' [' . $e->getMessage() . ']';
            }

            return back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        foreach ($propertyPhotos as $photo) {
            Storage::delete('property-images/' . $photo->photo);
            $photo->delete();
        };
        $property->videos()->delete();
        $property->amenities()->detach();
        Storage::delete('property-images/' . $property->featured_photo);
        $property->delete();
        return back()->with('success', 'Property deleted successfully.');
    }

    /**
     * Activate a property listing by setting its status to active.
     */
    public function makeActive(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 1,
        ]);
        return back()->with('success', 'Property activated successfully.');
    }

    /**
     * Remove the specified photo from storage.
     */
    public function destroyPhoto(PropertyPhoto $propertyPhoto): RedirectResponse
    {
        Storage::delete('property-images/' . $propertyPhoto->photo);
        $propertyPhoto->delete();
        return back()->with('success', 'Photo deleted successfully.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroyVideo(PropertyVideo $propertyVideo): RedirectResponse
    {
        $propertyVideo->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}