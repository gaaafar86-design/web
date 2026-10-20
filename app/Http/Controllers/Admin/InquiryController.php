<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inquiry;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function index(): View
    {
        $inquiries = Inquiry::with('property', 'user')->latest()->get();
        return view('admin.inquiry.index', compact('inquiries'));
    }

    public function toggleHandled(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->update(['is_handled' => !$inquiry->is_handled]);
        return back()->with('success', 'Inquiry updated successfully.');
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}