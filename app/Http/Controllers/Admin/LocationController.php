<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * عرض جميع المناطق.
     */
    public function index(): View
    {
        $locations = Location::withCount('properties')
            ->latest()
            ->get();

        return view(
            'admin.location.index',
            compact('locations')
        );
    }

    /**
     * عرض صفحة إضافة منطقة.
     */
    public function create(): View
    {
        return view('admin.location.create');
    }

    /**
     * إنشاء slug فريد للمنطقة.
     *
     * يسمح بتكرار اسم المنطقة، لكن يمنع تكرار الرابط.
     */
   private function uniqueSlug(
    string $name,
    ?int $ignoreId = null
): string {
    $baseSlug = Str::slug($name);

    if ($baseSlug === '') {
        $baseSlug = 'location';
    }

    $slug = $baseSlug;
    $counter = 1;

    while (
        \Illuminate\Support\Facades\DB::table('locations')
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $ignoreId
                )
            )
            ->exists()
    ) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }

    return $slug;
}


    /**
     * إنشاء اسم آمن وفريد للصورة.
     */
    private function imageName($file): string
    {
        return Carbon::now()->format('YmdHisv')
            . '-'
            . Str::random(10)
            . '.'
            . strtolower(
                $file->getClientOriginalExtension()
            );
    }

    /**
     * إنشاء منطقة جديدة.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ], [
            'name.required' => 'يرجى إدخال اسم المنطقة.',
            'name.min' => 'اسم المنطقة قصير جداً.',
            'name.max' => 'اسم المنطقة طويل جداً.',

            'photo.required' => 'يرجى اختيار صورة للمنطقة.',
            'photo.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'photo.mimes' => 'صيغة الصورة يجب أن تكون JPG أو JPEG أو PNG أو WEBP.',
            'photo.max' => 'حجم الصورة يجب ألا يتجاوز 10 ميغابايت.',
        ]);

        $fileName = $this->imageName(
            $request->file('photo')
        );

        $request->file('photo')->storeAs(
            'location-images',
            $fileName
        );

        Location::create([
            'name' => trim($request->name),
            'slug' => $this->uniqueSlug(
                $request->name
            ),
            'photo' => $fileName,
        ]);

        return redirect()
            ->route('admin.locations.index')
            ->with(
                'success',
                'تم إنشاء المنطقة بنجاح.'
            );
    }

    /**
     * عرض صفحة تعديل المنطقة.
     */
    public function edit(Location $location): View
    {
        return view(
            'admin.location.edit',
            compact('location')
        );
    }

    /**
     * تعديل المنطقة.
     */
    public function update(
        Request $request,
        Location $location
    ): RedirectResponse {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ], [
            'name.required' => 'يرجى إدخال اسم المنطقة.',
            'name.min' => 'اسم المنطقة قصير جداً.',
            'name.max' => 'اسم المنطقة طويل جداً.',

            'photo.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'photo.mimes' => 'صيغة الصورة يجب أن تكون JPG أو JPEG أو PNG أو WEBP.',
            'photo.max' => 'حجم الصورة يجب ألا يتجاوز 10 ميغابايت.',
        ]);

        $fileName = $location->photo;

        /*
        |--------------------------------------------------------------------------
        | رفع صورة جديدة إن وجدت
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('photo')) {
            $newPhoto = $request->file('photo');

            $newFileName = $this->imageName($newPhoto);

            $newPhoto->storeAs(
                'location-images',
                $newFileName
            );

            if (
                $location->photo &&
                Storage::exists(
                    'location-images/' . $location->photo
                )
            ) {
                Storage::delete(
                    'location-images/' . $location->photo
                );
            }

            $fileName = $newFileName;
        }

        $location->update([
            'name' => trim($request->name),
            'slug' => $this->uniqueSlug(
                $request->name,
                $location->id
            ),
            'photo' => $fileName,
        ]);

        return redirect()
            ->route('admin.locations.index')
            ->with(
                'success',
                'تم تعديل المنطقة بنجاح.'
            );
    }

    /**
     * حذف المنطقة.
     */
    public function destroy(
        Location $location
    ): RedirectResponse {
        if ($location->properties()->exists()) {
            return back()->with(
                'error',
                'لا يمكن حذف المنطقة لأنها مرتبطة بعقارات.'
            );
        }

        if (
            $location->photo &&
            Storage::exists(
                'location-images/' . $location->photo
            )
        ) {
            Storage::delete(
                'location-images/' . $location->photo
            );
        }

        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with(
                'success',
                'تم حذف المنطقة بنجاح.'
            );
    }
}
