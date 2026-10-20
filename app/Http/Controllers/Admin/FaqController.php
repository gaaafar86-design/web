<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    /**
     * عرض جميع الأسئلة الشائعة
     */
    public function index(): View
    {
        $faqs = Faq::latest()->get();

        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * صفحة إنشاء سؤال شائع
     */
    public function create(): View
    {
        return view('admin.faq.create');
    }

    /**
     * حفظ سؤال شائع جديد
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question' => [
                'required',
                'string',
                'min:3',
                'unique:faqs,question',
            ],

            'answer' => [
                'required',
                'string',
                'min:10',
            ],
        ], [
            'question.required' => 'يرجى إدخال السؤال.',
            'question.min' => 'السؤال يجب أن يكون 3 أحرف على الأقل.',
            'question.unique' => 'هذا السؤال موجود مسبقاً.',
            'answer.required' => 'يرجى إدخال الإجابة.',
            'answer.min' => 'الإجابة يجب أن تكون 10 أحرف على الأقل.',
        ]);

        Faq::create([
            'question' => $data['question'],
            'answer' => $data['answer'],
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'تم إنشاء السؤال بنجاح.');
    }

    /**
     * عرض سؤال محدد
     */
    public function show(Faq $faq): View
    {
        return view('admin.faq.show', compact('faq'));
    }

    /**
     * صفحة تعديل السؤال
     */
    public function edit(Faq $faq): View
    {
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * تحديث السؤال
     */
    public function update(
        Request $request,
        Faq $faq
    ): RedirectResponse {
        $data = $request->validate([
            'question' => [
                'required',
                'string',
                'min:3',
                'unique:faqs,question,' . $faq->id,
            ],

            'answer' => [
                'required',
                'string',
                'min:10',
            ],
        ], [
            'question.required' => 'يرجى إدخال السؤال.',
            'question.min' => 'السؤال يجب أن يكون 3 أحرف على الأقل.',
            'question.unique' => 'هذا السؤال موجود مسبقاً.',
            'answer.required' => 'يرجى إدخال الإجابة.',
            'answer.min' => 'الإجابة يجب أن تكون 10 أحرف على الأقل.',
        ]);

        $faq->update([
            'question' => $data['question'],
            'answer' => $data['answer'],
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'تم تحديث السؤال بنجاح.');
    }

    /**
     * حذف السؤال
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()
            ->with('success', 'تم حذف السؤال بنجاح.');
    }
}
