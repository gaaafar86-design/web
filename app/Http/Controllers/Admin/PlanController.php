<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\AgentPlan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $plans = Plan::all();
        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.plan.create');
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
            'name' => 'required|string|min:3|unique:plans,name',
            'price' => 'required|integer|min:0',
            'allowed_days' => 'required|integer|min:-1',
            'allowed_properties' => 'required|integer|min:-1',
            'allowed_featured_properties' => 'required|integer|min:-1',
            'allowed_photos' => 'required|integer|min:-1',
            'allowed_videos' => 'required|integer|min:-1',
        ]);

        Plan::create([
            'name' => ucwords($request->name),
            'price' => $request->price,
            'allowed_days' => $request->allowed_days,
            'allowed_properties' => $request->allowed_properties,
            'allowed_featured_properties' => $request->allowed_featured_properties,
            'allowed_photos' => $request->allowed_photos,
            'allowed_videos' => $request->allowed_videos,
        ]);
        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Plan $plan
     * @return View
     */
    public function edit(Plan $plan): View
    {
        return view('admin.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Plan $plan
     * @return RedirectResponse
     */
    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $request->merge([
            'price' => (int) str_replace(',', '', $request->price),
        ]);
        $request->validate([
            'name' => 'required|string|min:3|unique:plans,name,' . $plan->id,
            'price' => 'required|integer|min:0',
            'allowed_days' => 'required|integer|min:-1',
            'allowed_properties' => 'required|integer|min:-1',
            'allowed_featured_properties' => 'required|integer|min:-1',
            'allowed_photos' => 'required|integer|min:-1',
            'allowed_videos' => 'required|integer|min:-1',
        ]);

        $plan->update([
            'name' => ucwords($request->name),
            'price' => $request->price,
            'allowed_days' => $request->allowed_days,
            'allowed_properties' => $request->allowed_properties,
            'allowed_featured_properties' => $request->allowed_featured_properties,
            'allowed_photos' => $request->allowed_photos,
            'allowed_videos' => $request->allowed_videos,
        ]);
        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

  public function destroy(Plan $plan): RedirectResponse
{
    AgentPlan::where('plan_id', $plan->id)->forceDelete();

    $plan->forceDelete();

    return redirect()
        ->route('admin.plans.index')
        ->with(
            'success',
            'تم حذف الخطة نهائياً مع جميع الاشتراكات المرتبطة بها.'
        );
}

}
