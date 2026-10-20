<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the website settings in the admin panel.
     *
     * Retrieves the first record from the settings table and passes it to the
     * admin.setting.show Blade view for display. Assumes a singleton settings model.
     *
     * @return View
     */
    public function show(): View
    {
        $setting = Setting::first();
        return view('admin.setting.show', compact('setting'));
    }

    /**
     * Update website branding and image assets.
     *
     * Validates optional image uploads for logo, favicon, banner, and section illustrations.
     * If a new file is uploaded, the old one is deleted from storage and the new one is saved
     * with a unique timestamped filename. Updates the settings record with new filenames or
     * retains existing ones if no new upload is provided.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'why_choose_us_image' => 'nullable|image|max:2048',
            'our_happy_clients_image' => 'nullable|image|max:2048',
        ]);

        $setting = Setting::first();
        if ($request->file('logo')) {
            Storage::delete('website-images/' . $setting->logo);
            $logo = Carbon::now()->micro . '-' . 'logo' . $request->logo->getClientOriginalName();
            $request->logo->storeAs('website-images', $logo);
        };
        if ($request->file('favicon')) {
            Storage::delete('website-images/' . $setting->favicon);
            $favicon = Carbon::now()->micro . '-' . 'favicon' . $request->favicon->getClientOriginalName();
            $request->favicon->storeAs('website-images', $favicon);
        };
        if ($request->file('banner')) {
            Storage::delete('website-images/' . $setting->banner);
            $banner = Carbon::now()->micro . '-' . 'banner' . $request->banner->getClientOriginalName();
            $request->banner->storeAs('website-images', $banner);
        };
        if ($request->file('why_choose_us_image')) {
            Storage::delete('website-images/' . $setting->why_choose_us_image);
            $whyChooseUsImage = Carbon::now()->micro . '-' . 'whyChooseUs' . $request->why_choose_us_image->getClientOriginalName();
            $request->why_choose_us_image->storeAs('website-images', $whyChooseUsImage);
        };
        if ($request->file('our_happy_clients_image')) {
            Storage::delete('website-images/' . $setting->our_happy_clients_image);
            $ourHappyClientsImage = Carbon::now()->micro . '-' . 'ourHappyClients' . $request->our_happy_clients_image->getClientOriginalName();
            $request->our_happy_clients_image->storeAs('website-images', $ourHappyClientsImage);
        };

        $setting->update([
            'logo' => $request->file('logo') ? $logo : $setting->logo,
            'favicon' => $request->file('favicon') ? $favicon : $setting->favicon,
            'banner' => $request->file('banner') ? $banner : $setting->banner,
            'why_choose_us_image' => $request->file('why_choose_us_image')
                ? $whyChooseUsImage
                : $setting->why_choose_us_image,
            'our_happy_clients_image' => $request->file('our_happy_clients_image')
                ? $ourHappyClientsImage
                : $setting->our_happy_clients_image,
        ]);
        return back()->with('success', 'Website settings updated successfully.');
    }
}
