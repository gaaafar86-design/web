<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Header;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    /**
     * Display the resource.
     *
     * @return View
     */
    public function show(): View
    {
        $header = Header::first();
        return view('admin.header.show', compact('header'));
    }

    /**
     * Show the form for editing the resource.
     *
     * @return View
     */
    public function edit(): View
    {
        $header = Header::first();
        return view('admin.header.edit', compact('header'));
    }

    /**
     * Update the resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'text' => 'required|string|min:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        $header = Header::first();
        if ($request->file('photo')) {
            Storage::delete('website-images/' . $header->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('website-images', $fileName);
        };

        $header->update([
            'title' => $request->title,
            'text' => $request->text,
            'photo' => $request->file('photo') ? $fileName : $header->photo,
        ]);
        return redirect()->route('admin.header.show')->with('success', 'Header info updated successfully.');
    }
}
