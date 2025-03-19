<?php

namespace App\Http\Controllers\Admin\Blogs;


use App\Http\Controllers\Controller;
use App\DataTables\BlogDataTable;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }
    public function create()
    {
        return view('admin.blogs.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'feature_image' => 'nullable|image|max:2048',
        ]);

        $featureImagePath = null;
        if ($request->hasFile('feature_image')) {
            $featureImagePath = $request->file('feature_image')->store('blog_images', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'feature_image' => $featureImagePath,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        return response()->json($blog);
    }

    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'feature_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('feature_image')) {
            if ($blog->feature_image) {
                Storage::disk('public')->delete($blog->feature_image);
            }
            $blog->feature_image = $request->file('feature_image')->store('blog_images', 'public');
        }

        $blog->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->feature_image) {
            Storage::disk('public')->delete($blog->feature_image);
        }

        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
