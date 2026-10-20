<?php

namespace App\Http\Controllers\Front\Agent;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Property;
use App\Models\AgentPlan;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $properties = Property::where('agent_id', Auth::guard('agent')->id())
            ->latest()
            ->paginate(8);
        return view('front.agent.dashboard.property.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        $agentId = Auth::guard('agent')->id();
        $currentPlan = AgentPlan::where('agent_id', $agentId)
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->first();
        if (!$currentPlan) {
            return back()->with('error', 'You do not have an active plan.');
        }

        $allowedFeaturedPropertiesCount = $currentPlan->plan->allowed_featured_properties;
        $allowedFeaturedProperties = $allowedFeaturedPropertiesCount == -1
        ? 100000
        : $allowedFeaturedPropertiesCount;

        $allowedPropertiesCount = $currentPlan->plan->allowed_properties;
        $allowedProperties = $allowedPropertiesCount == -1
        ? 100000
        : $allowedPropertiesCount;

        $agentProperties = Property::where('agent_id', $agentId)->where('is_featured', 0)->count();
        $agentFeaturedProperties = Property::where('agent_id', $agentId)->where('is_featured', 1)->count();

        if (
            $agentProperties >= $allowedProperties
            && $agentFeaturedProperties >= $allowedFeaturedProperties
        ) {
            return back()->with('error', 'You have reached your plan\'s limit for creating properties.');
        };

        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        return view(
            'front.agent.dashboard.property.create',
            compact(
                'locations',
                'propertyTypes',
                'amenities',
                'agentFeaturedProperties',
                'allowedFeaturedProperties',
                'agentProperties',
                'allowedProperties',
            ),
        );
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
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
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
            'is_featured' => 'required|min:0|max:1',
            'map' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'featured_photo' => 'required|image|max:2048',
        ]);

        $fileName = Carbon::now()->micro . '-' . $request->featured_photo->getClientOriginalName();
        $slug = Str::slug($request->name);
        $baseSlug = $slug;
        $counter = 1;
        while (Property::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        try {
            DB::transaction(function () use ($request, $fileName, $slug, &$property) {
                $property = Property::create([
                    'agent_id' => Auth::guard('agent')->id(),
                    'location_id' => $request->location_id,
                    'property_type_id' => $request->type_id,
                    'name' => ucwords($request->name),
                    'slug' => $slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'featured_photo' => $fileName,
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
                    'map' => $request->map,
                ]);
                $property->amenities()->attach($request->amenities);
            });
            $request->featured_photo->storeAs('property-images', $fileName);
            $admin = Admin::first();
            Mail::send('email.admin_property', [], function ($message) use ($admin) {
                $message->to($admin->email)
                ->subject('New Property Added');
            });
            return redirect()->route('agent.properties.index')->with('success', 'Property created successfully.');
        } catch (\Exception) {
            return back()->with('error', 'Property creation failed. Please try again.');
        };
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return View|RedirectResponse
     */
    public function show(Property $property): View|RedirectResponse
    {
        $currentPlan = AgentPlan::where('agent_id', Auth::guard('agent')->id())
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->exists();
        if (!$currentPlan) {
            return back()->with('error', 'You cannot access this page because your plan is expired.');
        }

        return view('front.agent.dashboard.property.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     * @return View|RedirectResponse
     */
    public function edit(Property $property): View|RedirectResponse
    {
        $currentPlan = AgentPlan::where('agent_id', Auth::guard('agent')->id())
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->exists();
        if (!$currentPlan) {
            return back()->with('error', 'You cannot access this page because your plan is expired.');
        }

        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        return view(
            'front.agent.dashboard.property.edit',
            compact(
                'property',
                'propertyTypes',
                'amenities',
                'locations',
            ),
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        $request->merge([
            'price' => str_replace(',', '', $request->price),
            'size' => str_replace(',', '', $request->size),
            'floor' => str_replace(',', '', $request->floor),
        ]);

        $request->validate([
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
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
            'is_featured' => 'required|min:0|max:1',
            'map' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'featured_photo' => 'nullable|image|max:2048',
        ]);

        $newPhoto = $request->file('featured_photo');
        $fileName = '';
        if ($newPhoto) {
            $currentFeaturedPhoto = $property->featured_photo;
            $fileName = Carbon::now()->micro . '-' . $request->featured_photo->getClientOriginalName();
        };

        try {
            DB::transaction(function () use ($request, $fileName, $property, $newPhoto) {
                $property->update([
                    'location_id' => $request->location_id,
                    'property_type_id' => $request->type_id,
                    'name' => ucwords($request->name),
                    'slug' => Str::slug($request->name),
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
                    'is_featured' => $request->is_featured,
                    'map' => $request->map,
                ]);
                $property->amenities()->sync($request->amenities);
            });
            if ($newPhoto) {
                Storage::delete('property-images/' . $currentFeaturedPhoto);
                $request->featured_photo->storeAs('property-images', $fileName);
            };
            return redirect()->route('agent.properties.index')->with('success', 'Property updated successfully.');
        } catch (\Exception) {
            return back()->with('error', 'Failed to update property. Please try again.');
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return RedirectResponse
     */
    public function destroy(Property $property): RedirectResponse
    {
        $currentPlan = AgentPlan::where('agent_id', Auth::guard('agent')->id())
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->exists();
        if (!$currentPlan) {
            return back()->with('error', 'You cannot access this page because your plan is expired.');
        }

        foreach ($property->photos as $photo) {
            Storage::delete('property-images/' . $photo->photo);
            $photo->delete();
        };

        $property->videos()->delete();
        Storage::delete('property-images/' . $property->featured_photo);
        $property->amenities()->detach();
        $property->delete();
        return back()->with('success', 'Property deleted successfully.');
    }

    /**
     * Display all photos of the resource.
     *
     * @param Property $property
     * @return View|RedirectResponse
     */
    public function photoGallery(Property $property): View|RedirectResponse
    {
        $currentPlan = AgentPlan::where('agent_id', Auth::guard('agent')->id())
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->exists();
        if (!$currentPlan) {
            return back()->with('error', 'You cannot access this page because your plan is expired.');
        }

        $existingPhotos = $property->photos;
        return view('front.agent.dashboard.property.photo_gallery', compact('property', 'existingPhotos'));
    }

    /**
     * Handle submission of photo gallery images for a property.
     *
     * Validates uploaded images, checks the agent's plan limits,
     * stores each image in the property-images directory,
     * and creates corresponding PropertyPhoto records.
     * Prevents uploads that exceed the allowed photo count for the agent's current plan.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function photoGallerySubmit(Request $request, Property $property): RedirectResponse
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|image|max:2048',
        ]);

        $agentId = Auth::guard('agent')->id();
        $propertyPhotosCount = $property->photos()->count();
        $agentPlan = AgentPlan::where('agent_id', $agentId)
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->first();
        $currentPlan = $agentPlan->plan;
        $allowedPropertyPhotos = $currentPlan->allowed_photos == -1
        ? 100000
        : $currentPlan->allowed_photos;

        if ($propertyPhotosCount + count($request->photos) > $allowedPropertyPhotos) {
            return back()->with(
                'error',
                'Your plan\'s limit doesn\'t allow to have this many photos for this property.'
            );
        };

        $images = [];
        foreach ($request->photos as $photo) {
            $fileName = Carbon::now()->micro . '-' . $photo->getClientOriginalName();
            $photo->storeAs('property-images', $fileName);
            array_push($images, $fileName);
        };

        foreach ($images as $image) {
            PropertyPhoto::create([
                'property_id' => $property->id,
                'photo' => $image,
            ]);
        };
        return back()->with('success', 'Photo(s) added successfully.');
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param PropertyPhoto $propertyPhoto
     * @return RedirectResponse
     */
    public function photoGalleryDestroy(PropertyPhoto $propertyPhoto): RedirectResponse
    {
        Storage::delete('property-images/' . $propertyPhoto->photo);
        $propertyPhoto->delete();
        return back()->with('success', 'Photo deleted successfully.');
    }

    /**
     * Display all videos of the resource.
     *
     * @param Property $property
     * @return View|RedirectResponse
     */
    public function videoGallery(Property $property): View|RedirectResponse
    {
        $currentPlan = AgentPlan::where('agent_id', Auth::guard('agent')->id())
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhereNull('expire_at');
            })
            ->exists();
        if (!$currentPlan) {
            return back()->with('error', 'You cannot access this page because your plan is expired.');
        }

        $existingVideos = $property->videos;
        return view('front.agent.dashboard.property.video_gallery', compact('property', 'existingVideos'));
    }

    /**
     * Handle submission of video gallery videos for a property.
     *
     * Validates uploaded youtube video link, checks the agent's plan limits
     * and creates corresponding PropertyVideo records.
     * Prevents uploads that exceed the allowed video count for the agent's current plan.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function videoGallerySubmit(Request $request, Property $property): RedirectResponse
    {
        $request->validate([
            'video' => 'required|string',
        ]);

        PropertyVideo::create([
            'property_id' => $property->id,
            'video' => $request->video,
        ]);
        return back()->with('success', 'Video added successfully.');
    }

    /**
     * Remove the specified video from storage.
     *
     * @param PropertyVideo $propertyVideo
     * @return RedirectResponse
     */
    public function videoGalleryDestroy(PropertyVideo $propertyVideo): RedirectResponse
    {
        $propertyVideo->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}
