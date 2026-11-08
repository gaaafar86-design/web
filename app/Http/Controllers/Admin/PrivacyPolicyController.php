<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PrivacyPolicyController extends Controller
{
    /**
     * Display the Privacy Policy content.
     *
     * Retrieves the first Privacy Policy record from the database and passes it to the
     * admin.privacy.show Blade view for display.
     *
     * @return View
     */
    public function show(): View
    {
        $policies = PrivacyPolicy::first();
        return view('admin.privacy.show', compact('policies'));
    }

    /**
     * Show the edit form for Privacy Policy.
     *
     * Retrieves the first Privacy Policy record and passes it to the admin.privacy.edit view
     * for editing. Assumes a single Privacy Policy record exists.
     *
     * @return View
     */
    public function edit(): View
    {
        $policies = PrivacyPolicy::first();
        return view('admin.privacy.edit', compact('policies'));
    }

    /**
     * Update the Privacy Policy content.
     *
     * Validates the submitted content and updates the Privacy Policy record in the database.
     * Redirects back to the show view with a success flash message.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $policies = PrivacyPolicy::first();
        $policies->update([
            'content' => $request->content,
        ]);
        return redirect()->route('admin.privacy-policy.show')->with('success', 'Privacy policies updated successfully.');
    }
}
