<?php

namespace App\Http\Controllers\Admin\Blogs;


use App\Http\Controllers\Controller;
use App\DataTables\BlogDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Services\Blog\BlogService;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;

        $this->middleware(['permission:List Blog'])->only(['index']);
        $this->middleware(['permission:Add Blog'])->only(['create']);
        $this->middleware(['permission:Edit Blog'])->only(['edit']);
        $this->middleware(['permission:Delete Blog'])->only(['destroy']);
    }

    public function index(BlogDataTable $dataTable)
    {
        set_page_meta(__('custom.blog'));
        return $dataTable->render('admin.blogs.index');
    }

    public function create()
    {
        set_page_meta(__('custom.add_blog'));
        return view('admin.blogs.create');
    }
    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        if ($blog = $this->blogService->createOrUpdateWithFile($data, 'banner')) {
            flash(__('custom.blog_create_successful'))->success();
        } else {
            flash(__('custom.blog_create_failed'))->error();
        }

        return redirect()->route('admin.blogs.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $blog = $this->blogService->get($id);

        set_page_meta(__('custom.edit_blog'));
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(BlogRequest $request, $id)
    {
        $data = $request->validated();

        if ($this->blogService->createOrUpdateWithFile($data, 'banner', $id)) {
            flash(__('custom.blog_updated_successful'))->success();
        } else {
            flash(__('custom.blog_updated_failed'))->error();
        }

        return redirect()->route('admin.blogs.index');
    }

    public function destroy($id)
    {
        if ($this->blogService->delete($id)) {
            flash(__('custom.blog_deleted_successful'))->success();
        } else {
            flash(__('custom.blog_deleted_failed'))->error();
        }

        return redirect()->route('admin.blogs.index');
    }
}
