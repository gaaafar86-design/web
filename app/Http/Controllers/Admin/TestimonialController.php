<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.testimonial.create');
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
            'name' => 'required|string',
            'designation' => 'required|string',
            'comment' => 'required|string|min:10',
        ]);

        $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
        $request->photo->storeAs('user-images', $fileName);

        Testimonial::create([
            'photo' => $fileName,
            'name' => ucwords($request->name),
            'designation' => ucwords($request->designation),
            'comment' => $request->comment,
        ]);
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Testimonial $testimonial
     * @return View
     */
    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Testimonial $testimonial
     * @return RedirectResponse
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string',
            'designation' => 'required|string',
            'comment' => 'required|string|min:10',
        ]);

        $fileName = $testimonial->photo;
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $testimonial->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
        };

        $testimonial->update([
            'photo' => $fileName,
            'name' => $request->name,
            'designation' => $request->designation,
            'comment' => $request->comment,
        ]);
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Testimonial $testimonial
     * @return RedirectResponse
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        Storage::delete('user-images/' . $testimonial->photo);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
