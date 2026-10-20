<?php

namespace App\Http\Controllers\Admin;

use App\Models\Footer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FooterController extends Controller
{
    /**
     * Display the footer information in the admin panel.
     *
     * Retrieves the first footer record from the database and passes it to the
     * admin.footer.show view for display.
     *
     * @return View
     */
    public function show(): View
    {
        $footer = Footer::first();
        return view('admin.footer.show', compact('footer'));
    }

    /**
     * Show the edit form for footer information.
     *
     * Retrieves the first footer record and passes it to the admin.footer.edit view
     * for editing.
     *
     * @return View
     */
    public function edit(): View
    {
        $footer = Footer::first();
        return view('admin.footer.edit', compact('footer'));
    }

    /**
     * Update the footer information.
     *
     * Validates the submitted form data including contact details and optional social media URLs.
     * Updates the first footer record in the database with the new values.
     * Redirects back to the show view with a success flash message.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
       $request->validate([
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'copyright' => 'required|string',
       ]);
        $footer = Footer::first();
        $footer->update([
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'copyright' => $request->copyright,
        ]);
        return redirect()->route('admin.footer.show')->with('success', 'Footer information updated successfully.');
    }
}
