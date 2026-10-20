<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Blog;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $blogs = Blog::all();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.blog.create');
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
            'photo' => 'required|image|max:2048',
            'title' => 'required|string|unique:blogs,title',
            'short_description' => 'required|string|min:10',
            'description' => 'required|string|min:40',
        ]);

        $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
        $request->photo->storeAs('blog-images', $fileName);

        Blog::create([
            'photo' => $fileName,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);
        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return View
     */
    public function show(Blog $blog): View
    {
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @return View
     */
    public function edit(Blog $blog): View
    {
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Blog $blog
     * @return RedirectResponse
     */
    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'title' => 'required|string|unique:blogs,title,' . $blog->id,
            'short_description' => 'required|string|min:10',
            'description' => 'required|string|min:40',
        ]);

        $fileName = $blog->photo;
        if ($request->file('photo')) {
            Storage::delete('blog-images/' . $blog->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('blog-images', $fileName);
        };

        $blog->update([
            'photo' => $fileName,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);
        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return RedirectResponse
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        Storage::delete('blog-images/' . $blog->photo);
        $blog->delete();
        return back()->with('success', 'Blog post deleted successfully.');
    }
}
