<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhyChooseUsController extends Controller
{
    /**
     * عرض جميع العناصر.
     */
    public function index(): View
    {
        $items = WhyChooseUs::latest()->get();

        return view(
            'admin.why_choose_us.index',
            compact('items')
        );
    }

    /**
     * صفحة إضافة عنصر جديد.
     */
    public function create(): View
    {
        return view('admin.why_choose_us.create');
    }

    /**
     * حفظ عنصر جديد.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:why_choose_us,title',
            ],

            'text' => [
                'required',
                'string',
                'min:3',
            ],
        ], [
            'title.required' => 'يرجى كتابة العنوان.',
            'title.min' => 'يجب أن يكون العنوان 3 أحرف على الأقل.',
            'title.unique' => 'هذا العنوان موجود مسبقاً.',
            'text.required' => 'يرجى كتابة الوصف.',
            'text.min' => 'يجب أن يكون الوصف 3 أحرف على الأقل.',
        ]);

        WhyChooseUs::create([
            // لا يظهر الحقل للأدمن، لكنه يُحفظ تلقائياً
            'icon' => '-',
            'title' => $validated['title'],
            'text' => $validated['text'],
        ]);

        return redirect()
            ->route('admin.why-choose-us.index')
            ->with(
                'success',
                'تمت إضافة العنصر بنجاح.'
            );
    }

    /**
     * صفحة تعديل العنصر.
     */
    public function edit(WhyChooseUs $item): View
    {
        return view(
            'admin.why_choose_us.edit',
            compact('item')
        );
    }

    /**
     * تحديث العنصر.
     */
    public function update(
        Request $request,
        WhyChooseUs $item
    ): RedirectResponse {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:why_choose_us,title,' . $item->id,
            ],

            'text' => [
                'required',
                'string',
                'min:3',
            ],
        ], [
            'title.required' => 'يرجى كتابة العنوان.',
            'title.min' => 'يجب أن يكون العنوان 3 أحرف على الأقل.',
            'title.unique' => 'هذا العنوان موجود مسبقاً.',
            'text.required' => 'يرجى كتابة الوصف.',
            'text.min' => 'يجب أن يكون الوصف 3 أحرف على الأقل.',
        ]);

        $item->update([
            // إذا كانت القيمة القديمة فارغة يتم وضع -
            'icon' => $item->icon ?: '-',
            'title' => $validated['title'],
            'text' => $validated['text'],
        ]);

        return redirect()
            ->route('admin.why-choose-us.index')
            ->with(
                'success',
                'تم تحديث العنصر بنجاح.'
            );
    }

    /**
     * حذف العنصر.
     */
    public function destroy(
        WhyChooseUs $item
    ): RedirectResponse {
        $item->delete();

        return redirect()
            ->route('admin.why-choose-us.index')
            ->with(
                'success',
                'تم حذف العنصر بنجاح.'
            );
    }
}
