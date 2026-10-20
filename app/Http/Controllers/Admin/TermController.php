<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class TermController extends Controller
{
    /**
     * Display the Terms of Use content.
     *
     * Retrieves the first Terms record from the database and passes it to the
     * admin.term.show Blade view for display.
     *
     * @return View
     */
    public function show(): View
    {
        $terms = Term::first();
        return view('admin.term.show', compact('terms'));
    }

    /**
     * Show the edit form for Terms of Use.
     *
     * Retrieves the first Terms record and passes it to the admin.term.edit view
     * for editing. Assumes a single terms record exists.
     *
     * @return View
     */
    public function edit(): View
    {
        $terms = Term::first();
        return view('admin.term.edit', compact('terms'));
    }

    /**
     * Update the Terms of Use content.
     *
     * Validates the submitted content and updates the first Terms record in the database.
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

        $terms = Term::first();
        $terms->update([
            'content' => $request->content,
        ]);
        return redirect()->route('admin.terms.show')->with('success', 'Terms of Use updated successfully.');
    }
}
